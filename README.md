Demo-Community für REDAXO 5
===========================

In dieser Demo kannst Du sehen, wie man mit dem Community-AddOn Loginbereiche erstellen kann, wo sich User registrieren und in geschützte Bereiche einloggen können.

![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/demo_community/assets/demo_community_01.jpg)


Features
--------

**Folgende Funktionen sind in der Demo enthalten:**

### Registrierung

- User können sich registrieren (Double-Opt-In)
- Der Admin schaltet den User frei
- User können Gruppen zugewiesen werden. Diese Gruppen dienen zur Steuerung der Zugriffsrechte bei Kategorien. Auch bei künftigen Community-Erweiterungen wie z.B. einem Newsletter kommen diese Gruppen zum Einsatz
- Passwort vergessen-Funktion

### Loginbereich

- Authentifizierung mit Loginname oder E-Mail und verschlüsseltem Passwort
- Rechte für Seiten und Kategorien können (auch rekursiv vererbend) definiert werden
- Jeder User kann seine Profildaten verändern
- einfache Beispiele für die Anzeige der neuesten User und eine Kommentarfunktion


![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/demo_community/assets/demo_community_03.png)


Installation
------------

1. Das AddOn-Verzeichnis muss den Namen demo_community haben; nach dem Auspacken in das AddOn-Verzeichnis kopieren: `redaxo/src/addons`
2. Das AddOn installieren und dem Link zum Backup-AddOn folgen
3. Datenbank und komprimierte Datei importieren

Die Demo setzt folgende externe AddOns voraus (diese können alle innerhalb von REDAXO über den Installer installiert werden):

- Markitup
- PHP-Mailer
- YForm inkl. Geo-Plugin
- YCom


![Screenshot](https://raw.githubusercontent.com/FriendsOfREDAXO/demo_community/assets/demo_community_02.jpg)


