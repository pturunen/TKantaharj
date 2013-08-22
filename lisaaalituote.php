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
    $onnistuikop = $kysely->execute(array($_POST["ravintotekijap"], $_POST["nimip"],$_POST["maarap"],$_POST["mittayksikkop"]));
	if ($onnistuikop) {
		$kysely = $yhteys->prepare('SELECT * FROM perusravintoaineet WHERE nimi =  ?');
		$tulos = $kysely->execute(array($_POST['nimip']));
		$rivip = $kysely->fetch();
		echo "<table border>";
		while ($rivip) {
			echo "<tr>";
			echo "<td>" . $rivip["ravintotekijap"] . "</td>";
			echo "<td>" . $rivip["nimip"] . "</td>";
			echo "<td>" . $rivip["maarap"] . "</td>";
			echo "<td>" . $rivip["mittayksikkop"] . "</td>";
			echo "</tr>";
			$rivip = $kysely->fetch();
		}
		echo "</table>";
		} 
}
 if (isset($_POST['nimik'])) {
    $kysely = $yhteys->prepare('INSERT INTO kivhivenaineet (ravintotekija,nimi,maara,mittayksikko) VALUES (?,?,?,?)');
    $onnistuikok = $kysely->execute(array($_POST["ravintotekijak"], $_POST["nimik"],$_POST["maarak"],$_POST["mittayksikkok"]));
	if ($onnistuikok) {
		$kyselyk = $yhteys->prepare('SELECT * FROM perusravintoaineet WHERE nimi =  ?');
		$tulos = $kyselyk->execute(array($_POST['nimik']));
		$rivik = $kyselyk->fetch();
		echo "<table border>";
		while ($rivik) {
			echo "<tr>";
			echo "<td>" . $rivik["ravintotekijak"] . "</td>";
			echo "<td>" . $rivik["nimik"] . "</td>";
			echo "<td>" . $rivik["maarak"] . "</td>";
			echo "<td>" . $rivik["mittayksikkok"] . "</td>";
			echo "</tr>";
			$rivik = $kyselyk->fetch();
		}
		echo "</table>";
		} 
}
?>
<p><a href="lisaaalituote.html">Lisaa uusia lisätietoja</a></p>
<p><a href="lisaatuote.html">Lisaa uusi tuote</a></p>
<p><a href="haku.html">Tuotehakuun</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>