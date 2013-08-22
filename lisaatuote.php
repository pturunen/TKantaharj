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
		header("Location: satunnainenkavija.php");
		die();
		} 
} 

?>
<p>Tunnus tai salasana on väärin!</p>
<p><a href="eka.html">Takaisin</a></p>