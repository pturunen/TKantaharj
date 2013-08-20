<?php
session_start();

// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<form action="haku.php?htmlspecialchars(SID)" method="post">
<p>Tuotteen nimi: <br>
<input type="text" name="nimi"></p>
<input type="submit" value="Hae">
</form>

<p><a href="eka.html">Takaisin</a></p>