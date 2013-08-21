<?php
session_start();
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_POST['nimi'])){
    $kysely = $yhteys->prepare('SELECT * FROM raakaaine WHERE nimi LIKE  ?');
    $kysely->execute(array("%". $_POST['nimi'] . "%"));
	header("Location: satunnainen.html");
	if (!$kysely){
	header("Location: satunnainen.html");
	die();
	}
	else {
	//echo "<table border>";
		echo "<ul>";
		while ($rivi = $kysely->fetch()) {
			/*echo "<tr>";
			echo "<td>" . $rivi["nimi"] . "</td>";
			echo "<td>" . $rivi["valmistaja"] . "</td>";
			echo "<td>" . $rivi["luokka"] . "</td>";
			echo "<td>" . $rivi["selite"] . "</td>";
			echo "</tr>";
			*/
			$muuttuja = 'Nimi: ' . $rivi["nimi"] . ' Valmistaja: ' . $rivi["valmistaja"] . '  Raaka-aine luokka: ' . $rivi["luokka"] . ' Selite: ' . $rivi["selite"] . "<br>";
			echo "<li>";
			//ei toimi echo "<a href=\"alitaulut.php\">$rivi["nimi"]</a>";
			echo "<a href=\"alitaulut.php\">$muuttuja</a>";
		}
		echo "</ul>";
		//echo "</table>";
	}
}
?>
<p><a href="satunnainen.html">Tuotehakuun takaisin</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>


