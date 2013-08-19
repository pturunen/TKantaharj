haku.php
<?php
require_once 'yhteys/yhteys';
varmista_kirjautuminen();
// kyselyn suoritus     
$kysely = $yhteys->prepare("SELECT * FROM raakaaine");
$kysely->execute();

// haettujen rivien tulostus
echo "<table border>";
while ($rivi = $kysely->fetch()) {
    echo "<tr>";
    echo "<td>" . $rivi["nimi"] . "</td>";
    echo "<td>" . $rivi["valmistaja"] . "</td>";
	echo "<td>" . $rivi["luokka"] . "</td>";
	echo "<td>" . $rivi["selite"] . "</td>";
    echo "</tr>";
}
echo "</table>";

?>
