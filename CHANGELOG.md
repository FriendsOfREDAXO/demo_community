# REDAXO Community Demo - Changelog

## 4.1.3 - xx.xx.2023

### Bugfixes

* Fix Typo in Meta-Infos für art_legend_icon, Danke @Koala
* Fix #12 - Photo-Swipe für kleine Displays anpassen
  * `base.css` - .wrapper.transitions auskommentiert
* Fix #41 - Source-Map-Fehler: Error: request failed with status 404
  * Source-Map in ` bootstrap.min.css` entfernt
* `demo_community.tar.gz` neu erstellt @aeberhard
* Fix missing double quote in Template 05, @Koala

## 4.1.2 – 16.07.2023

### Neu

* Hinweis auf YRewrite / .htaccess beim Setup @Koala #40
  * lang-Datei erweitert
  * Button zum direkten Aufruf des YRewrite-Setup
* `update.php` hinzugefügt, für Updates aus dem Installer

### Bugfixes

* Im Export der Tabellen waren Test-User zur Behebung der Sicherheitslücke enthalten, diese wurden auf der Startseite angezeigt. Test-User entfernt.
* Das Registrierungsformular stand noch auf Debug, Debug entfernt
* EMail-Templates angepasst
  * bei den Links fehlte die Domain, rex::getServer() hinzugefügt @ischfr #36
* Table-Export bereinigt neu erstellt @aeberhard

## 4.1.1 – 18.06.2023

**Achtung** Security-Fix für die Community-Demo

Die Schwachstelle wurde uns von Tim Conrad gemeldet @Tim-Conrad. Vielen Dank dafür!

### Bugfixes

* Die Benutzerdaten wurden bei der Ausgabe auf der Website nicht escaped! Dadurch ist ein XSS-Angriff möglich!
  * Template `05 . TEMPLATE` - Ausgabe der Benutzerdaten mit rex_escape()
  * Modul `05 . Neueste User` - Ausgabe der Benutzerdaten mit rex_escape()

## 4.1.0 – 17.06.2023

### Neu

* Verwendete AddOns aktualisiert
  * markitup 3.7.3 -> 3.7.4
  * ycom 4.0.11 -> 4.2.0
  * yform 4.0.4 -> 4.1.1
  * yrewrite 2.9.1 -> 2.10.0
  * Neues Addon yform_media_file hinzugefügt (Profilfoto)
* Neue Console-Commands zur Erstellung der Demo-Exporte @aeberhard
  * `demo_community:dump_tables`, erstellt Datenbank-Backup `backups/demo_community.sql`
  * beim Datenbank-Backup werden nur die benötigten Tabellen exportiert
  * `demo_community:dump_files`, erstellt Datei-Backup `backups/demo_community.tar.gz`
* Content-Änderungen
  * Profil - Gruppe von checkbox_sql auf choice geändert
  * YFORM - Link zu Object-Params auf aktuelle YFORM-Dokumentation auf github
  * YFORM - Beispiel-Formular an YFORM Version 4 angepasst
  * YFORM - Beispiel-Formular wird nach absenden wieder angezeigt
* Demo-Backups mit den Console-Commands neu erstellt
* Ordner `media` bei Deinstallation leeren
* Ordner `resources` bei Deinstallation löschen
* PHP-Version in package.yml >=7.4, <8.3

### Bugfixes

* Bei Deinstallation Backup-Daten aus dem Backup-Ordner löschen - https://github.com/FriendsOfREDAXO/demo_community/issues/38


## 4.0.2 – 02.01.2023

### Bugfixes

* Verwendete AddOns aktualisiert


## 4.0.1 – 15.12.2022

### Bugfixes

* Login für Demo-User zurückgesetzt auf frühere Version (E-Mails, Passwort)
* Infos in der README aktualisiert


## 4.0.0 – 14.12.2022

### Neu

* Demo auf aktuelles YForm 4 migriert (enthält Breaking Changes)
* Verwendete AddOns aktualisiert, Kompatibilität mit neuem PHP 8.2 hergestellt


## 3.3.1 – 06.10.2021

### Bugfixes

* Fehler bei der Installation behoben, wenn zuvor das Developer-AddOn aktiviert war


## 3.3.0 – 01.10.2021

### Features

* Anpassung für den Dark Mode (REDAXO 5.13) 🦇
* Verwendete AddOns aktualisiert


## 3.2.0 – 27.02.2021

### Features

* Hinweis auf die Demo-Seite nach Installation des AddOns
* Mehrsprachige Seitentitel
* Verwendete AddOns aktualisiert
* Datenbank-Importdatei nach Update der Y-AddOns aktualisiert


## 3.1.1 – 18.03.2020

### Bugfixes

* Importdatei korrigiert


## 3.1.0 – 18.03.2020

### Features

* Installation über die Konsole mittels `demo_community:install` ([#32](https://github.com/FriendsOfREDAXO/demo_community/pull/32), [@bloep](https://github.com/bloep))

### Bugfixes

* Anpassungen für REDAXO 5.10 ([#33](https://github.com/FriendsOfREDAXO/demo_community/pull/33), [@bloep](https://github.com/bloep))


## 3.0.0 – 23.02.2020

### Neu

* __Demo grundlegend für REDAXO 5.9 mit aktuellem YCom 4 angepasst__ ([@polarpixel](https://github.com/polarpixel))

### Features

* Svensk översättning ([#21](https://github.com/FriendsOfREDAXO/demo_community/pull/21), [@interweave-media](https://github.com/interweave-media))
* Traducción en castellano ([#25](https://github.com/FriendsOfREDAXO/demo_community/pull/25), [@nandes2062](https://github.com/nandes2062))
* Umstellung auf 'includeCurrentPageSubPath' ([#26](https://github.com/FriendsOfREDAXO/demo_community/pull/26), [@christophboecker](https://github.com/christophboecker))

### Bugfixes

* Notices entfernt (Thx [@aeberhard](https://github.com/aeberhard))


## 2.1.0 – 14.09.2017

* Automatisches Setup der Demo-Website ([#15](https://github.com/FriendsOfREDAXO/demo_community/issues/15))

