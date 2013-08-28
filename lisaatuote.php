<?php
session_start();
if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
    die();
}
// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['nimi'])) {
$nimi = htmlspecialchars($_POST['nimi']);
try {
    $kysely = $yhteys->prepare('INSERT INTO raakaaine (nimi,valmistaja,luokka,selite) VALUES (?,?,?,?)');
    $onnistuiko = $kysely->execute(array($_POST["nimi"], $_POST["valmistaja"],$_POST["luokka"],$_POST["selite"]));
	$kysely2 = $yhteys->prepare('INSERT INTO perusravintoaineet (ravintotekija,nimi,mittayksikko,maara) VALUES (?,?,?,?)');
    $onnistuiko2 = $kysely2->execute(array('energia', "{$nimi}",'Kj/100g',$_POST["maara"]));
}
catch (PDOException $e) {
    echo "<script>alert('Raaka-aineen lisäys ei onnistunut, tarkista löytyykö raaka-aine jo tietokannasta!');</script>";
    //die("VIRHE: " . $e->getMessage());
}
	if ($onnistuiko) {
		$kysely = $yhteys->prepare('SELECT * FROM raakaaine WHERE nimi =  ?');
		$tulos = $kysely->execute(array($_POST['nimi']));
		$rivi = $kysely->fetch();
		echo "<table border>";
		while ($rivi) {
			echo "<tr>";
			//echo "<td>" . $rivi["nimi"] . "</td>";
			$muuttuja = $rivi["nimi"] ;
			echo "<td>" . "<a border-style:\"solid\" style=\"color: blue\"  href=\"alitaulut.php?nimiparametri=$muuttuja\">$muuttuja</a>" . "</td>";
			echo "<td>" . $rivi["valmistaja"] . "</td>";
			echo "<td>" . $rivi["luokka"] . "</td>";
			echo "<td>" . $rivi["selite"] . "</td>";
			echo "</tr>";
			$rivi = $kysely->fetch();
		}
		echo "</table>";
    $muuttuja = 'Lisätietoja ravintoaineelle: ' . $rivi["nimi"] . "<br>";
	$nimiparametri = $rivi["nimi"];
	$_SESSION["tuotenimi"] = $_POST['nimi'];
	} 
	else {
	echo "Tuotteen lisääminen ei onnistunut";
	}
} 
?>

<p><a href="lisaaalituote2.php">Lisaa ravintoaineelle lisätietoja</a></p>

<p><a href="lisaatuote.html">Lisaa uusi tuote</a></p>

<p><a href="haku.php">Tuotehakuun</a></p>

<p><a href="paivakirja.php">Päiväkirjan sivuille</a></p>

<p><a href="eka.html">Takaisin etusivulle</a></p>

<p><a href="ulos.php">Kirjaudu ulos</a></p>