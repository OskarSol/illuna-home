# Playground bei Netcup / Plesk einrichten

Ziel: `https://playground.illunaai.de`. Diese Anleitung richtet ausschließlich die Testumgebung ein. Die Hauptdomain und deren `httpdocs` werden dabei nicht geändert.

## 1. Verzeichnisse und Upload

Ausgangspunkt laut Hosting-Einstellungen:

```text
/var/www/vhosts/hosting177161.ae897.netcup.net/playground.illunaai.de/httpdocs
```

Im Dateimanager **neben `httpdocs`** den Projektordner `illuna` anlegen. Alle Dateien aus diesem Repository dort hinein kopieren oder Git dorthin bereitstellen. `composer.json` und `artisan` müssen unmittelbar in diesem Ordner liegen, nicht noch eine Ebene tiefer in einem entpackten ZIP-Ordner.

| Zweck | Vollständiger Pfad |
| --- | --- |
| Projekt / Git-Bereitstellungsziel | `/var/www/vhosts/hosting177161.ae897.netcup.net/playground.illunaai.de/illuna` |
| Öffentlicher Dokumentenstamm | `/var/www/vhosts/hosting177161.ae897.netcup.net/playground.illunaai.de/illuna/public` |
| Serverkonfiguration | `/var/www/vhosts/hosting177161.ae897.netcup.net/playground.illunaai.de/illuna/.env` |

Auch versteckte Dateien wie `public/.htaccess` und die `.gitignore`-Dateien in leeren Speicherverzeichnissen übernehmen. Das Repository enthält keine fertigen `vendor`-Pakete; diese installiert Composer.

Wenn das Panel relative Pfade ab dem Webspace verlangt, entspricht der öffentliche Pfad normalerweise `playground.illunaai.de/illuna/public`. Entscheidend ist der oben angegebene **aufgelöste absolute Pfad**.

Den Dokumentenstamm erst nach den Einrichtungsschritten auf `public` umstellen. **Niemals den gesamten Projektordner oder das Repository in einem öffentlich ausgelieferten `httpdocs` betreiben.** Die alte `index.html` im Repository ist nur ein statischer Altbestand und gehört nicht nach `public`.

## 2. PHP und Dateizugriff

Für die Playground-Domain PHP **8.3** auswählen. Composer und die geplanten PHP-Aufgaben müssen ebenfalls PHP 8.3 verwenden. Die Web-PHP-Version stellt nicht automatisch die CLI-Version um.

Die bisherigen Werte (512 MB RAM, OPcache an, Fehleranzeige aus, Fehlerprotokollierung an) können bestehen bleiben. Benötigt werden die Laravel-Erweiterungen, insbesondere `mbstring`, `openssl`, `curl`, `dom`, `xml`, `fileinfo`, `ctype`, `tokenizer`, `PDO` und `pdo_mysql`. Composer prüft die Paketanforderungen; den MySQL-Treiber zusätzlich in PHP-Info kontrollieren.

In `open_basedir` den Projektordner **zusätzlich** erlauben. Auf Basis des vorher genannten Ausgangswerts lautet der geplante Wert:

```text
{DOCROOT}{/}{:}{TMP}{/}{:}{/}var{/}lib{/}php{/}sessions{:}{WEBSPACEROOT}{/}tmp{:}/var/www/vhosts/hosting177161.ae897.netcup.net/playground.illunaai.de/illuna/
```

Falls Plesk in deinem Feld bereits weitere erforderliche Verzeichnisse vorgibt, diese erhalten. `open_basedir` nicht vollständig deaktivieren. Es erlaubt PHP-Dateizugriffe, macht den Projektordner aber nicht öffentlich.

`storage/` einschließlich Unterverzeichnissen und `bootstrap/cache/` müssen vom PHP-Prozess beschreibbar sein. Eigentümer und Rechte im Dateimanager prüfen; keine pauschalen `777`-Rechte setzen.

## 3. `.env` auf dem Hosting erstellen

`.env.playground.example` im Projektordner zu `.env` kopieren. Nur auf dem Server bearbeiten:

| Einstellung | Wert |
| --- | --- |
| `APP_ENV` | `staging` |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://playground.illunaai.de` |
| `DB_HOST` | `10.35.232.152` |
| `DB_PORT` | `3306` |
| `DB_DATABASE` | `k192180_playground_illuna` |
| `DB_USERNAME` | Der separat angelegte Datenbankbenutzer |
| `DB_PASSWORD` | Dessen Passwort |

SMTP-Daten ergänzen: Host, Port, Benutzer, Passwort, Absenderadresse. Für Port 587 `MAIL_SCHEME=smtp` (STARTTLS), für Port 465 `MAIL_SCHEME=smtps`. Die Konfiguration verlangt eine verschlüsselte SMTP-Verbindung; verwende die Einstellungen deines Mailanbieters. Passwörter mit Leerzeichen oder `#` in korrekt escapete Anführungszeichen setzen.

`ILLUNA_REGISTRATION_ENABLED` zunächst auf `false` lassen. Nach korrekter SMTP-Konfiguration auf `true` setzen und die Konfigurations-/Routencaches wie unten erneuern.

`APP_KEY` vorerst leer lassen; er wird im nächsten Schritt **einmalig** auf dem Server erzeugt. Später nicht bei jedem Deployment neu erzeugen. `.env` und `APP_KEY` in die private Datensicherung einbeziehen. Der Schlüssel und die Zugangsdaten gehören nicht in GitHub.

Die vorhandene Datenbank bleibt bis zur Migration leer. Es werden anschließend `users`, `password_reset_tokens`, `sessions`, `cache`, `cache_locks` und die Framework-Jobtabellen angelegt. Keine vorgegebenen Benutzer oder Passwörter werden erzeugt.

## 4. Composer installieren lassen

Im Composer-Bereich der **Playground-Domain** auf „Suchen“ klicken. Das Panel sollte `illuna/composer.json` finden. Falls es nur im Elternordner des derzeitigen Dokumentenstamms sucht, liegt `illuna` genau innerhalb dieses Suchbereichs.

PHP 8.3 auswählen und **Installieren / install** mit diesen Optionen verwenden:

```sh
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
```

`composer.lock` ist die verbindliche Paketliste. Für ein Deployment kein ungezieltes `composer update` verwenden. Keine `--ignore-platform-reqs`-Option einsetzen: fehlende Erweiterungen oder eine falsche PHP-Version müssen behoben werden.

## 5. Einmalige Laravel-Befehle über geplante Aufgaben

Bevor du migrierst, den Aufgaben-Ausführungsweg prüfen. Plesk-Aufgaben können in einer eingeschränkten/chroot-Umgebung laufen; dort sind absolute Pfade eventuell anders sichtbar.

**Bevorzugt, wenn das Panel Argumente unterstützt:** Aufgabentyp „PHP-Skript ausführen“, PHP 8.3 auswählen, als Skript die Datei `playground.illunaai.de/illuna/artisan` über den Dateiauswahldialog wählen. Zunächst als Argument `--version` verwenden. Die Ausgabe muss Laravel 13 anzeigen.

**Alternative „Befehl ausführen“:** Zunächst `php -v` testen. Nur wenn dort PHP 8.3 steht, kann `php` direkt benutzt werden. Andernfalls den vom Hoster angebotenen PHP-8.3-CLI-Pfad verwenden. Der Web-PHP-Handler allein reicht dafür nicht. Beispiel bei sichtbaren vollen Serverpfaden:

```sh
php /var/www/vhosts/hosting177161.ae897.netcup.net/playground.illunaai.de/illuna/artisan --version
```

Danach folgende **Argumente für `artisan` einzeln in dieser Reihenfolge** ausführen:

| Argument | Zweck |
| --- | --- |
| `key:generate --force` | Einmalig den fehlenden Anwendungsschlüssel in `.env` erzeugen |
| `migrate:status` | Verbindung und Migrationsstand prüfen; vor der ersten Migration ist „Migration table not found“ normal |
| `migrate --force` | Tabellen in der konfigurierten Playground-Datenbank anlegen |
| `optimize:clear` | Alte Konfiguration/Routen entfernen |
| `optimize` | Aktuelle Konfiguration/Routen/Views für den Betrieb cachen |

Für jede Aufgabe „Jetzt ausführen“ verwenden, falls vorhanden, und die Ausgabe kontrollieren. Danach die Aufgabe deaktivieren/löschen, damit Einrichtungsbefehle nicht stündlich wiederholt werden. Es ist **kein dauerhafter Cronjob** nötig.

Nie `migrate:fresh`, `db:wipe` oder `migrate:reset` auf einer befüllten Datenbank ausführen. Der erste normale `migrate` erstellt lediglich die noch fehlenden Tabellen.

## 6. HTTPS und Dokumentenstamm umstellen

Ein gültiges Zertifikat für `playground.illunaai.de` aktivieren und HTTP auf HTTPS umleiten. Danach den Dokumentenstamm der **Playground-Domain** auf den oben genannten `illuna/public`-Pfad setzen.

Alle Anwendungsrouten müssen `public/index.php` erreichen. Auf Apache übernimmt das mitgelieferte `public/.htaccess` die Weiterleitung. Falls `/` funktioniert, aber `/login` einen Webserver-404 liefert, Rewrite-/Apache-Unterstützung im Hosting prüfen. Keine zusätzliche `public/index.html` ablegen, die den PHP-Einstieg überdeckt.

Das Deployment benötigt keinen `storage:link`: Es gibt noch keine öffentlich bereitzustellenden Benutzerdateien.

## 7. Erster Funktionstest

1. `/` aufrufen: Landingpage, Themes und Demos müssen funktionieren.
2. `/login` aufrufen; unangemeldet muss `/dashboard` zur Anmeldung führen.
3. SMTP konfigurieren, `ILLUNA_REGISTRATION_ENABLED=true` setzen und `optimize:clear`, danach `optimize` ausführen.
4. Eigenes Testkonto registrieren. Vor E-Mail-Bestätigung bleibt das Dashboard gesperrt.
5. E-Mail-Link öffnen, Dashboard und Einstellungen prüfen. Name ändern, ab- und wieder anmelden.
6. Passwort-Reset per E-Mail testen. Für einen E-Mail-Wechsel in den Einstellungen wird das aktuelle Passwort verlangt und die neue Adresse erneut verifiziert.
7. `/billing` zeigt bewusst eine Vorschau; Verbrauch/Kontingent zeigen noch keine Daten.
8. Kontrollieren, dass `/.env`, `/composer.json` und `/storage/logs/laravel.log` nicht heruntergeladen werden können. Mit dem richtigen Dokumentenstamm liegen sie außerhalb des öffentlichen Verzeichnisses.

`/up` bestätigt nur, dass Laravel startet. Echte DB-Verbindung und E-Mail-Zustellung werden erst durch die Schritte oben geprüft. Bei SMTP-Problemen kann ein Konto bereits erstellt sein: Nach Korrektur des SMTP-Zugangs einloggen und „Resend verification email“ verwenden.

## Weitere Deployments und Rückweg

Code nur in das Playground-Projekt aktualisieren. `.env`, `storage/`-Laufzeitdaten und Datenbank erhalten. Dateien und Datenbank vor Schemaänderungen sichern. Danach Composer **install**, `migrate --force`, `optimize:clear` und `optimize` ausführen. Die Git-Integration allein übernimmt diese Schritte nicht automatisch.

Ein `migrate --force` ohne neue Migrationsdateien verändert das Schema nicht. Bei Code-Rollbacks mögliche Schemaabhängigkeiten beachten; Datenbank-Backups nicht unüberlegt zurückspielen. Das bisherige `httpdocs` bleibt als separater Rückweg für die statische Testseite erhalten. Die Hauptdomain wird erst in einem eigenen späteren Schritt migriert.

## Fehler schnell einordnen

| Fehler | Prüfen |
| --- | --- |
| `open_basedir restriction in effect` | Privaten `illuna`-Projektpfad zusätzlich in `open_basedir` erlauben |
| `vendor/autoload.php` fehlt | Composer im richtigen Projektordner installiert? |
| `No application encryption key` | `.env` vorhanden und `key:generate --force` einmalig ausgeführt? |
| `could not find driver` | `pdo_mysql` für Web-PHP und CLI-PHP aktiviert? |
| `Access denied` / DB-Verbindungsfehler | DB-Benutzer, Passwort, DB-Host und dessen Rechte auf die Testdatenbank |
| `419 Page Expired` | Durchgehend HTTPS verwenden, Cookies erlauben; `SESSION_DOMAIN=null` und eindeutigen Session-Cookie-Namen behalten |
| `Permission denied` beim Loggen/Cachen | Schreibzugriff auf `storage/` und `bootstrap/cache/` |
| Registrierung nicht verfügbar | Flag auf `true` setzen, Konfigurations- und Routencaches erneuern |
| SMTP-Fehler | Host, Authentifizierung, Absender und Kombination aus Port/`MAIL_SCHEME`; Logs privat prüfen |

Offizielle Grundlagen: [Laravel deployment](https://laravel.com/docs/13.x/deployment), [Fortify](https://laravel.com/docs/13.x/fortify), [PHP open_basedir](https://www.php.net/manual/en/ini.core.php#ini.open-basedir).
