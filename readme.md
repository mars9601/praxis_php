## Praxis-Geraete-Verwaltung

Erstellt von: Baensch M, Decker P, Schloßmacher M   
Am: 01.09.2022    
Letzte Revision: 22.09.2022   
Version: 0.7v


### Funktion

Webanwendung zur Dokumentation der benutzten Geräte in einer Physiotherapie Praxis, spezifisch für die häufigkeit der Nutzung der einzelnen Geräte




### Installation

1. Erstellen Sie einen Order mit beliebigen namen unter C:\xampp\htdocs\\(Ihr_Ordner_Name)
2. Kopieren Sie alle Dateien in diesen Ordner
3. Erstellen Sie in der SQL-Datenbank eine neue Datenbank mit dem Namen "praxis login" (In XAMPP auf unter MySQL auf Admin, links auf neu klicken. Dann Datenbank name eintragen und auf anlegen klicken).
4. Kopieren Sie den Gesammten Inhalt aus "database.sql" und fügen diesen der Datenbank hinzu. (In XAMPP auf unter MySQL auf Admin, dort auf die Datenbank "praxis login" klciken. Hier unter SQL den inhalt aus "database.sql" einfügen und unten rechts auf OK klicken.)
5. Dies ebenfalls mit der Datei "survey_table.sql" durchführen.
6. In XAMPP kann die Website über folgende Adresse erreicht werden http://localhost/(Ihr_Ordner_Name)/internal.php

### Dateien

- .vscode: enthält für debugging benötigte Dateien   
- css: Enthält den Großteil der Stylesheets der Website   
- fonts: Enthält die einen Großteil der verwendeten Schriftarten
- inc: Enthält Funktions- und Konfigurationsdateien
- js: Enthält die Canvas.js Library die für das darstellen der Graphen verwendet wird
- templates: Enthält die Kopf-, Fuß- und Fehlerzeilen
- data.php: Verbunden mit "Internal.php" und nimmt actions von dieser an. Ist für den austausch der einträge mit der Datenbank.
- database.sql: Zum erstellen der Datenbank benötigt.
- geraete.json: für select funktion von "internal.php" benötigt
- index.php: Startseite der Website
- internal.php: Auf dieser Seite werden die Graphen dargestellt.
- login.php: Login Seite für bereits registrierte Nutzer
- logout.php: löscht cookies um sicheres Ausloggen zu garantieren.
- passwortvergessen.php: Schickt einen zu "passwortzuruecksetzen.php"
- passwortzuruecksetzen.php: Verwendet um neues Passwort zu beantragen
- phpxdebug.php: Für debugging benötigt
- register.php: Für Erstregistrierung verwendet
- settings.php: Konfigurationsdatei für SQL-Anbindung
survey_table.sql: Zum erstellen der Datenbank benötigt.
- temp.json: Für debugging benötigt