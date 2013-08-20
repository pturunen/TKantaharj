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

// kyselyn suoritus     
$kysely = $yhteys->prepare("SELECT * FROM raakaaine WHERE nimi = ?");
if ($kysely){
$kysely->execute($_POST["nimi"]);
}
else {
echo "pieleen meni";
die();
}

// haettujen rivien tulostus
echo "<table border>";
while ($rivi = $kysely->fetch()) {
    echo "<tr>";
    echo "<td>" . " roskaa" . $rivi["nimi"] . "</td>";
    echo "<td>" . $rivi["valmistaja"] . "</td>";
	echo "<td>" . $rivi["luokka"] . "</td>";
	echo "<td>" . $rivi["selite"] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>

<p><a href="eka.html">Takaisin</a></p>