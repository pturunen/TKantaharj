<?php
require 'yhteyss.php';

if (isset($_GET['nimiparametri']) || isset($_SESSION['hakualikey'])){
	if (isset($_GET['nimiparametri'])){
		$_SESSION['hakualikey'] = $_GET['nimiparametri'];
	}
	else {
		$_GET['nimiparametri'] = $_SESSION['hakualikey'];
	}
try {
    $kysely = $yhteys->prepare('SELECT * FROM perusravintoaineet WHERE nimi = ?');
    $kysely->execute(array($_GET['nimiparametri']));
	$rivi = $kysely->fetch();
	$kysely2 = $yhteys->prepare('SELECT * FROM kivhivenaineet WHERE nimi = ?');
    $kysely2->execute(array($_GET['nimiparametri']));
	$rivi2 = $kysely2->fetch();
}
catch (PDOException $e) {
    //echo "VIRHE: " . $e->getMessage());
}
	if (empty($rivi)){
	echo "Ravintoaineella ei lisätietoja perusravintoaineista <br>";
	}
	else {
		echo "<table border>";
		echo "<tr>";
		echo "<td>" . "  ". "PERUSRAVINTOAINEET" . " " ."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>" . "  ". "RAVINTOTEKIJÄ" . " " ."</td>";
		echo "<td>" . "  ". "NIMI" . " " ."</td>";
		echo "<td>" . "  ". "MÄÄRÄ" . " " ."</td>";
		echo "<td>" . "  ". "MITTAYKSIKKÖ" . " " ."</td>";
		echo "</tr>";
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
	if (empty($rivi2)){
	echo "Ravintoaineella ei lisätietoja kivennäis ja hivenaineista <br>";
	}
	else {
		echo "<table border>";
		echo "<tr>";
		echo "<td>" . "  ". "KIVENNÄIS-JA HIVENAINEET" . " " ."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>" . "  ". "RAVINTOTEKIJÄ" . " " ."</td>";
		echo "<td>" . "  ". "NIMI" . " " ."</td>";
		echo "<td>" . "  ". "MÄÄRÄ" . " " ."</td>";
		echo "<td>" . "  ". "MITTAYKSIKKÖ" . " " ."</td>";
		echo "</tr>";
		while ($rivi2) {
			echo "<tr>";
			echo "<td>" . $rivi2["nimi"] . "</td>";
			echo "<td>" . $rivi2["ravintotekija"] . "</td>";
			echo "<td>" . $rivi2["maara"] . "</td>";
			echo "<td>" . $rivi2["mittayksikko"] . "</td>";
			echo "</tr>";
			$rivi2 = $kysely2->fetch();
		}
		echo "</table>";
	}
	$nimiparametri = $rivi["nimi"];
	if (isset($_SESSION["kayttaja"])) {
	$_SESSION["tuotenimi"] = $_GET['nimiparametri'];
    echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"lisaaalituote2.php\">Lisaa ravintoaineelle lisätietoja <br></a>";
	echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"satunnainenkavija.php\">edellinen sivu <br></a>";
    echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"lisaatuote.html\">Lisaa uusi tuote<br></a>";
	echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"ulos.php\">Kirjaudu ulos<br></a>";
	}
} 
else {
echo "Virhe:Ravintoainetta ei annettu!";
}

?>
<p><a href="satunnainenkavija.php">Edellinen sivu</a></p>
<p><a href="satunnainen.html">Tuotehakuun takaisin</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>


