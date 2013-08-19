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

if (isset($_POST['tunnus'])) {
    $kysely = $yhteys->prepare('SELECT * FROM rekisteri WHERE tunnus = ? and password = ?');
    $kysely->execute(array($_POST["tunnus"], $_POST["password"]));
	$kayttaja = $kysely->fetchObject();
	if ($kayttaja) {
		$_SESSION["kayttaja_id"] = $kayttaja->id;
		$_SESSION["kayttaja"] = $_POST["tunnus"];
		header("Location: sisalto.php");
		die();
		} 
} 

?>
<p>Tunnus tai salasana on väärin!</p>
<p><a href="eka.html">Takaisin</a></p>