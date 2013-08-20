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
echo "ennen kyselya";
if (isset($_POST['nimi'])) {
echo "kysely ";
    $kysely = $yhteys->prepare('SELECT * FROM raakaaine WHERE nimi = ?');
    $kysely->execute(array($_POST["nimi"]));
   //$kysely->execute();
	//$kayttaja = $kysely->fetchObject();
	echo "alkaa tulostus rivi kerrallaan";
		echo "<table border>";
		while ($rivi = $kysely->fetch()) {
		echo "while lauseen sisalla";
			echo "<tr>";
			echo "<td>" . $rivi["nimi"] . "</td>";
			echo "<td>" . $rivi["valmistaja"] . "</td>";
			echo "<td>" . $rivi["luokka"] . "</td>";
			echo "<td>" . $rivi["selite"] . "</td>";
			echo "</tr>";
		}
		echo "while lauseen ulkona lopussa";
		echo "</table>";
	//die();
} 

?>
<p><a href="satunnainen.html">Tuotehakuun takaisin</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>


