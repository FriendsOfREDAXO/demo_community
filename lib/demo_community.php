<?php

class rex_demo_community
{
    /** @var string[] */
    private const EXPDIR = [
        'media', 'resources',
    ];

    /**
     * @return array<string>
     */
    public static function dump_files(): array
    {

        $addon = rex_addon::get('demo_community');
        $exportPath = $addon->getPath('backups') . DIRECTORY_SEPARATOR  . 'demo_community.tar.gz';

        rex_backup::exportFiles(self::EXPDIR, $exportPath);

        return [];
    }

    /**
     * @return array<string>
     */
    public static function dump_tables(): array
    {
        $addon = rex_addon::get('demo_community');
        $exportPath = $addon->getPath('backups') . DIRECTORY_SEPARATOR  . 'demo_community.sql';
        $error = [];

        $EXPTABLES = [
            rex::getTable('article'),
            rex::getTable('article_slice'),
            rex::getTable('clang'),
            rex::getTable('config'),
            rex::getTable('markitup_profiles'),
            rex::getTable('media'),
            rex::getTable('media_category'),
            rex::getTable('media_manager_type'),
            rex::getTable('media_manager_type_effect'),
            rex::getTable('metainfo_field'),
            rex::getTable('metainfo_type'),
            rex::getTable('module'),
            rex::getTable('template'),
            rex::getTable('ycom_group'),
            rex::getTable('ycom_user'),
            rex::getTable('ycom_user_session'),
            rex::getTable('yform_email_template'),
            rex::getTable('yform_field'),
            rex::getTable('yform_table'),
        ];

        $hasContent = rex_backup::exportDb($exportPath, $EXPTABLES);
        if (false === $hasContent) {
            $error[] = rex_i18n::msg('backup_file_could_not_be_generated') . ' ' . $exportPath;
        }

        return $error;
    }

    public static function install()
    {
        $addon = rex_addon::get('demo_community');

        // in some cases rex_addon has the old package.yml in cache. But we need our new merged package.yml
        $addon->loadProperties();

        $errors = [];

        // step 1: select missing packages we need to download
        $missingPackages = [];
        $packages = [];
        if (isset($addon->getProperty('setup')['packages'])) {
            $packages = $addon->getProperty('setup')['packages'];
        }

        if (count($packages) > 0) {

            // fetch list of available packages from to redaxo webservice
            try {
                $packagesFromInstaller = rex_install_packages::getAddPackages();
            } catch (rex_functional_exception $e) {
                $errors[] = $e->getMessage();
                rex_logger::logException($e);
            }

            if (0 == count($errors)) {
                foreach ($packages as $id => $fileId) {

                    $localPackage = rex_package::get($id);
                    if ($localPackage->isSystemPackage()) {
                        continue; // skip system packages, they don’t need to be downloaded
                    }

                    $installerPackage = $packagesFromInstaller[$id]['files'][$fileId] ?? false;
                    if (!$installerPackage) {
                        $errors[] = $addon->i18n('package_not_available', $id);
                    }

                    if ($localPackage->getVersion() !== $installerPackage['version']) {
                        $missingPackages[$id] = $fileId; // add to download list if package is not yet installed
                    }
                }
            }
        }

        // step 2: download required packages
        if (count($missingPackages) > 0 && 0 == count($errors)) {
            foreach ($missingPackages as $id => $fileId) {

                $installerPackage = $packagesFromInstaller[$id]['files'][$fileId];
                if ($installerPackage) {

                    // fetch package
                    try {
                        $archivefile = rex_install_webservice::getArchive($installerPackage['path']);
                    } catch (rex_functional_exception $e) {
                        rex_logger::logException($e);
                        $errors[] = $addon->i18n('package_failed_to_download', $id);
                        break;
                    }

                    // validate checksum
                    if ($installerPackage['checksum'] != md5_file($archivefile)) {
                        $errors[] = $addon->i18n('package_failed_to_validate', $id);
                        break;
                    }

                    // extract package (overrides local package if existent)
                    if (!rex_install_archive::extract($archivefile, rex_path::addon($id), $id)) {
                        rex_dir::delete(rex_path::addon($id));
                        $errors[] = $addon->i18n('package_failed_to_extract', $id);
                        break;
                    }

                    rex_package_manager::synchronizeWithFileSystem();
                }
            }
        }

        // step 3: install and activate packages based on install sequence from config
        if (count($addon->getProperty('setup')['installSequence']) > 0 && 0 == count($errors)) {
            foreach ($addon->getProperty('setup')['installSequence'] as $id) {

                $package = rex_package::get($id);
                if ($package instanceof rex_null_package) {
                    $errors[] = $addon->i18n('package_not_exists', $id);
                    break;
                }

                $manager = rex_package_manager::factory($package);

                try {
                    $manager->install();
                } catch (rex_functional_exception $e) {
                    rex_logger::logException($e);
                    $errors[] = $addon->i18n('package_failed_to_install', $id);
                    break;
                }

                try {
                    $manager->activate();
                } catch (rex_functional_exception $e) {
                    rex_logger::logException($e);
                    $errors[] = $addon->i18n('package_failed_to_activate', $id);
                    break;
                }
            }
        }

        // step 4: import database
        if (count($addon->getProperty('setup')['dbimport']) > 0 && 0 == count($errors)) {
            foreach ($addon->getProperty('setup')['dbimport'] as $import) {
                $file = rex_backup::getDir() . '/' . $import;
                $success = rex_backup::importDb($file);
                if (!$success['state']) {
                    $errors[] = $addon->i18n('package_failed_to_import', $import);
                }
            }
        }

        // step 5: import files
        if (count($addon->getProperty('setup')['fileimport']) > 0 && 0 == count($errors)) {
            foreach ($addon->getProperty('setup')['fileimport'] as $import) {
                $file = rex_backup::getDir() . '/' . $import;
                $success = rex_backup::importFiles($file);
                if (!$success['state']) {
                    $errors[] = $addon->i18n('package_failed_to_import', $import);
                }
            }
        }

        // step 6: make yrewrite copy its htaccess file
        if (class_exists('rex_yrewrite')) {
            rex_yrewrite::copyHtaccess();
        }

        // step 7: clear developer addon data
        if (rex_addon::get('developer')->isAvailable()) {
            rex_dir::delete(rex_addon::get('developer')->getDataPath());
        }

        return $errors;
    }
}
