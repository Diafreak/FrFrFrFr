# FrFrFrFr <br> Freddie Frettchens Freche Früchte
Im Rahmen des Moduls Dynamische Webprogrammierung wir, <br>
**[Lucas Hengelhaupt](https://github.com/Diafreak)** <br>
**[Annkathrin Hirt](https://github.com/AnkaMulm)**   <br>
**[Leon Müller](https://github.com/DerNoobzockt)**   <br>
den Online-Fruchtshop „Freddie Frettchens Freche Früchte“ ins Leben gerufen. <br>
<br><br>


## Installation
1. **XAMPP** installieren

2. Bei dem Apache-Server in der **php.ini "short_open_tag"** auf **"On"** setzen

3. FrFrFrFr.zip **herunterladen** und in den XAMPP-Ordner (standard: xampp/htdocs) entpacken
<br>oder das Repository von Git in den XAMPP-Ordner **clonen** (https://github.com/Diafreak/FrFrFrFr.git)

4. In XAMPP **"MySQL"** starten und über **"Admin"** die Seite "phpMyAdmin" aufrufen

5. Über **"Importieren"** die Datenbank **"FrFrFrFr.sql"** aus dem Ordner "src/database" importieren

6. Wenn die Datenbank erfolgreich importiert wurde, erneut über **"Importieren"** die Testdatensätze **"frfrfrfr-demo-data.sql"** aus dem Ordner "src/database" importieren.

7. In XAMPP **"Apache"** starten und über **"Admin"** zum Projektordner **"FrFrFrFr"** navigieren und diesen öffnen

8. Fertig! Nun kann die Website benutzt werden
<br><br>


## Zugangsdaten
<b>Admin</b><br>
E-Mail: admin   <br>
Passwort: 12345 <br>

Alle neu erstellten Accounts haben keinen Admin-Rang und können keine Produkte zum Shop hinzufügen.
<br><br>


## Produkt hinzufügen
1. Falls das Hinzufügen von neuen Produkten getestet werden möchte, muss beim Apache in der **php.ini "file_uploads"** auf **"On"** gesetzt sein

2. Nur ein **Admin** kann über sein Profil ein Produkt hinzufügen

3. Hochgeladene Bilder **müssen** quadratisch sein, da ansonsten das Shoplayout verschoben wird

4. Bilder dürfen höchstens 200kb groß sein

4. Im Ordner "documentation/_testPictures" sind vorgefertigte Testbilder zum hochladen