<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
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
		echo "<table border>";
		//echo "<ul style=\"color: blue\" >";
		echo "<tr>";
		echo "<td>" . "  ". "RAAKA_AINE" . " " ."</td>";
		echo "<td>" . "  ". "VALMISTAJA" . " " ."</td>";
		echo "<td>" . "  ". "RAAKA_AINE LUOKKA" . " " ."</td>";
		echo "<td>" . "  ". "SELITE" . " " ."</td>";
		echo "</tr>";
		while ($rivi ) {
			echo "<tr>";
			$muuttuja = $rivi["nimi"] ;
			echo "<td>" . "<a border-style:\"solid\" style=\"color: blue\"  href=\"alitaulut.php?nimiparametri=$muuttuja\">$muuttuja</a>" . "</td>";
			echo "<td>" . $rivik["valmistaja"] . "</td>";
			echo "<td>" . $rivik["luokka"] . "</td>";
			echo "<td>" . $rivik["selite"] . "</td>";
			//$nimiparametri = $rivi["nimi"];
			//linkki raakaaineen lisatietoihin
			//echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"alitaulut.php?nimiparametri=$muuttuja\">$muuttuja</a>";
			echo "</tr>";
			$rivi = $kysely->fetch();
		}
		//echo "</ul>";
		echo "</table>";
	}
}
if (isset($_SESSION["kayttaja"])) {
    echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"lisaatuote.html\">Lisaa uusi tuote <br></a>";
	echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"ulos.php\">Kirjaudu ulos <br></a>";
}
?>
<p><a href="satunnainen.html">Tuotehakuun takaisin</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>