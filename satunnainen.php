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
    
    $kysely = $yhteys->prepare('SELECT * FROM raakaaine WHERE nimi LIKE  ?');
    $kysely->execute(array("%". $_POST['nimi'] . "%"));
	
		echo "<table border>";
		//<form action ="alitaulut.php" method="post">
		while ($rivi = $kysely->fetch()) {
		//   <input type="submit" value=""<td>" . $rivi["nimi"] . "</td>" . "<td>" . $rivi["valmistaja"] . "</td>" . "<td>" . $rivi["luokka"] . "</td>" . "<td>" . $rivi["selite"] . "</td>"";
			
			echo "<tr>";
			echo "<td>" . $rivi["nimi"] . "</td>";
			echo "<td>" . $rivi["valmistaja"] . "</td>";
			echo "<td>" . $rivi["luokka"] . "</td>";
			echo "<td>" . $rivi["selite"] . "</td>";
			echo "</tr>";
			$muuttuja = $rivi["nimi"];
			$muuttuja2 = $rivi["valmistaja"];
			//$kokorivi = "{$muuttuja} {$muuttuja2}";
			//echo "<a href=alitaulut.php>$kokorivi</a>";
			echo "<a href=\"alitaulut.php\">$rivi["nimi"]</a>";

			//<p><a href="alitaulut.php"> <?" " . $rivi["nimi"] . " " . $rivi["valmistaja"] . " " . $rivi["luokka"] . " " . $rivi["selite"] . " "</a></p>
	
		}
		//</form>
		echo "</table>";
} 

?>
<p><a href="satunnainen.html">Tuotehakuun takaisin</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>


