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
    $tulos = $kysely->execute(array("%". $_POST['nimi'] . "%"));
	$rivi = $kysely->fetch();
	if (empty($rivi)){
	header("Location: satunnainenvirheilmoitus.html");
	die();
	}
	else {
		echo "<ul>";
		while ($rivi ) {
			$muuttuja = 'Nimi: ' . $rivi["nimi"] . ' Valmistaja: ' . $rivi["valmistaja"] . '  Raaka-aine luokka: ' . $rivi["luokka"] . ' Selite: ' . $rivi["selite"] . "<br>";
			echo "<li>";
			//ei toimi echo "<a href=\"alitaulut.php\">$rivi["nimi"]</a>";
			echo "<a style="color: blue" href=\"alitaulut.php\">$muuttuja</a>";
			$rivi = $kysely->fetch();
		}
		echo "</ul>";
	}
}
?>
<p><a href="satunnainen.html">Tuotehakuun takaisin</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>

