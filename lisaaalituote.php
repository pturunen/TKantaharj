<?php
session_start();
/*if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
    die();
}
*/
// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_POST['nimip'])) {
    $kysely = $yhteys->prepare('INSERT INTO perusravintoaineet (ravintotekija,nimi,maara,mittayksikko) VALUES (?,?,?,?)');
    $onnistuiko = $kysely->execute(array($_POST["ravintotekijap"], $_POST["nimip"],$_POST["maarap"],$_POST["mittayksikkop"]));
	if ($onnistuiko) {
		$kysely = $yhteys->prepare('SELECT * FROM perusravintoaineet WHERE nimi =  ?');
		$tulos = $kysely->execute(array($_POST['nimip']));
		$rivi = $kysely->fetch();
		echo "<table border>";
		while ($rivi) {
			echo "<tr>";
			echo "<td>" . $rivi["ravintotekijap"] . "</td>";
			echo "<td>" . $rivi["nimip"] . "</td>";
			echo "<td>" . $rivi["maarap"] . "</td>";
			echo "<td>" . $rivi["mittayksikkop"] . "</td>";
			echo "</tr>";
			$rivi = $kysely->fetch();
		}
		echo "</table>";
		} 
}
 if (isset($_POST['nimik'])) {
    $kysely = $yhteys->prepare('INSERT INTO kivhivenaineet (ravintotekija,nimi,maara,mittayksikko) VALUES (?,?,?,?)');
    $onnistuiko = $kysely->execute(array($_POST["ravintotekijak"], $_POST["nimik"],$_POST["maarak"],$_POST["mittayksikkok"]));
	if ($onnistuiko) {
		$kysely = $yhteys->prepare('SELECT * FROM perusravintoaineet WHERE nimi =  ?');
		$tulos = $kysely->execute(array($_POST['nimik']));
		$rivi = $kysely->fetch();
		echo "<table border>";
		while ($rivi) {
			echo "<tr>";
			echo "<td>" . $rivi["ravintotekijak"] . "</td>";
			echo "<td>" . $rivi["nimik"] . "</td>";
			echo "<td>" . $rivi["maarak"] . "</td>";
			echo "<td>" . $rivi["mittayksikkok"] . "</td>";
			echo "</tr>";
			$rivi = $kysely->fetch();
		}
		echo "</table>";
		} 
}
?>
<p><a href="lisaaalituote.html">Lisaa uusia lisätietoja</a></p>
<p><a href="lisaatuote.html">Lisaa uusi tuote</a></p>
<p><a href="haku.html">Tuotehakuun</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>