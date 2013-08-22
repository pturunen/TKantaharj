<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_GET['nimiparametri'])) {
    $kysely = $yhteys->prepare('SELECT * FROM perusravintoaineet WHERE nimi = ?');
    $kysely->execute(array($_GET['nimiparametri']));
	$rivi = $kysely->fetch();
	if (empty($rivi)){
	//header("Location: satunnainenvirheilmoitus.html");
	//die();
	echo "Ravintoaineella ei lisätietoja";
	}
	else {
		echo "<table border>";
		while ($rivi) {
			echo "<tr>";
			echo "<td>" . $rivi["nimi"] . "</td>";
			echo "<td>" . $rivi["ravintotekija"] . "</td>";
			echo "<td>" . $rivi["maara"] . "</td>";
			echo "<td>" . $rivi["mittayksikko"] . "</td>";
			echo "</tr>";
			$rivi = $kysely->fetch();
		}
		echo "</table>";
	}
	if (isset($_SESSION["kayttaja"])) {
    echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"lisaaalituote.html?nimiparametri=$rivi[\"nimi\"]\">Lisaa ravintoaineelle lisätietoja</a>";
    echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"lisaatuote.html\">Lisaa uusi tuote</a>";
	echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"ulos.php\">Kirjaudu ulos</a>";
	}
} 
else {
echo "Virhe:Ravintoainetta ei annettu!";
}

?>
<p><a href="satunnainen.html">Tuotehakuun takaisin</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>


