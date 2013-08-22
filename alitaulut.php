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
if (isset($_POST['nimi'])) {
    
    $kysely = $yhteys->prepare('SELECT * FROM perusravintoaineet WHERE nimi = ?');
    $kysely->execute(array($_POST['nimi']));
		echo "<table border>";
		while ($rivi = $kysely->fetch()) {
			echo "<tr>";
			echo "<td>" . $rivi["nimi"] . "</td>";
			echo "<td>" . $rivi["ravintotekija"] . "</td>";
			echo "<td>" . $rivi["maara"] . "</td>";
			echo "<td>" . $rivi["mittayksikko"] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
} 
?>
<p><a href="satunnainen.php">Takaisin listaukseen</a></p>
<p><a href="satunnainen.html">Tuotehakuun takaisin</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>


