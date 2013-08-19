<?php
//require_once 'avusteet.php';
//varmista_kirjautuminen();
// kyselyn suoritus     

session_start();

// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}


$kysely = $yhteys->prepare("SELECT tunnus, paino,pituus FROM rekisteri WHERE id = $_SESSION["kayttaja_id"]);
$kysely->execute(array($_POST["id"]));

// haettujen rivien tulostus
echo "<table border>";
while ($rivi = $kysely->fetch()) {
    echo "<tr>";
    echo "<td>" . $rivi["nimi"] . "</td>";
    echo "<td>" . $rivi["valmistaja"] . "</td>";
	echo "<td>" . $rivi["luokka"] . "</td>";
	echo "<td>" . $rivi["selite"] . "</td>";
    echo "</tr>";
}
echo "</table>";

?>
