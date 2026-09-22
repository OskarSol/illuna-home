# Geschlossene Beta und eigene 404-Seite

Nach dem Upload dieses Updates die **bestehende Server-`.env` ergänzen**, nicht mit einer Beispieldatei überschreiben:

```dotenv
ILLUNA_REGISTRATION_ENABLED=true
ILLUNA_BETA_INVITE_CODE="HIER_EINEN_EIGENEN_ZUFAELLIGEN_CODE_EINTRAGEN"
```

Den Platzhalter unbedingt durch einen privat generierten Code mit mindestens 20 und höchstens 128 Zeichen ersetzen. Keine Leerzeichen am Anfang/Ende verwenden. Groß-/Kleinschreibung zählt. Registrierung erst aktivieren, wenn SMTP funktioniert. Den echten Code nicht in GitHub eintragen.

Anschließend über den bereits eingerichteten PHP-8.3-Aufgabenweg `artisan` mit diesen Argumenten **einzeln und einmalig** ausführen:

1. `optimize:clear`
2. `optimize`

Keine neuen Composer-Pakete und keine Datenbankmigration sind nötig.

## Verhalten

- Ohne korrekt konfigurierten Code kann niemand ein neues Konto erstellen.
- Der Code wird auf dem Server vor dem Anlegen eines Kontos geprüft.
- Registrierung ist auf fünf Versuche pro Minute und IP begrenzt.
- Der Einladungscode wird weder in Formular-HTML noch in Benutzerkonten oder zurückgegebenen Formulareingaben gespeichert.
- E-Mail-Bestätigung bleibt erforderlich; bestehende Konten können sich weiter anmelden.
- Ein gemeinsamer Code ist mehrfach nutzbar und kann weitergegeben werden. Er ist keine Freigabeliste für einzelne Personen.
- Zum Sperren des alten Codes einen neuen Wert setzen und die beiden Cache-Befehle wiederholen. Bestehende Konten werden dadurch nicht gesperrt.

## 404-Seite

Die Vorlage `resources/views/errors/404.blade.php` wird bei unbekannten Laravel-Seiten automatisch verwendet. Zum Prüfen eine nicht vorhandene Adresse wie `/this-page-went-exploring` öffnen. Die Antwort muss Status 404 behalten.

Wenn stattdessen eine Plesk-/Webserver-Fehlerseite erscheint, prüfen, ob die Anfrage über `public/.htaccess` an Laravel weitergeleitet wird. Fehler, die der Webserver bereits vor Laravel beantwortet, werden von dieser Vorlage nicht erfasst.
