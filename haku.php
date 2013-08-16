haku.php
<?php

// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// kyselyn suoritus     
$kysely = $yhteys->prepare("SELECT * FROM tuotteet");
$kysely->execute();

// haettujen rivien tulostus
echo "<table border>";
while ($rivi = $kysely->fetch()) {
    echo "<tr>";
    echo "<td>" . $rivi["nimi"] . "</td>";
    echo "<td>" . $rivi["hinta"] . "</td>";
    echo "</tr>";
}
echo "</table>";

?>
