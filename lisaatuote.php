<?php
session_start();
/*if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
    die();
}*/
// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['nimi'])) {
    $kysely = $yhteys->prepare('INSERT INTO raakaaine (nimi,valmistaja,luokka,selite) VALUES (?,?,?,?)');
    $onnistuiko = $kysely->execute(array($_POST["nimi"], $_POST["valmistaja"],$_POST["luokka"],$_POST["selite"]));
	if ($onnistuiko) {
		$kysely = $yhteys->prepare('SELECT * FROM raakaaine WHERE nimi =  ?');
		$tulos = $kysely->execute(array($_POST['nimi']));
		$rivi = $kysely->fetch();
		echo "<table border>";
		while ($rivi) {
			echo "<tr>";
			echo "<td>" . $rivi["nimi"] . "</td>";
			echo "<td>" . $rivi["valmistaja"] . "</td>";
			echo "<td>" . $rivi["luokka"] . "</td>";
			echo "<td>" . $rivi["selite"] . "</td>";
			echo "</tr>";
			$rivi = $kysely->fetch();
		}
		echo "</table>";
		} 
} 
?>
<p>Tunnus tai salasana on väärin!</p>
<p><a href="eka.html">Takaisin</a></p>