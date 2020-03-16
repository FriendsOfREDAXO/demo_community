<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class rex_command_demo_community_install extends rex_console_command {
    protected function configure()
    {
        $this->setDescription('Installs the REDAXO community demo')
            ->addOption('yes', 'y', InputOption::VALUE_NONE, 'runs the installation without confirmation');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = $this->getStyle($input, $output);

        $skipConfirmation = true === $input->getOption('yes');

        $io->title('Community Demo Installation');

        if (!$input->isInteractive() && !$skipConfirmation) {
            return 1;
        }

        if (!$skipConfirmation && !$io->confirm('Current data will be deleted. Would you like to proceed?')) {
            return 1;
        }


        $io->writeln('Run installation ...');

        $errors = rex_demo_community::install();

        if (count($errors) > 0) {
            $io->error($this->decodeMessage("Failed to install demo:\n- " . join("\n- ", $errors)));
            return 1;
        }
        $io->success('Successfully installed demo!');
        return 0;
    }
}