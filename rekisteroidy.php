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
$paivays = date('Y-M-D');
//$paivays = date("j.n.Y");
//$aika = $yhteys->prepare('SELECT CURRENT_DATE;');
//$aika->execute();
//$kannanpvm = $aika->fetch();

if (isset($_POST['tunnus']) && isset($_POST['salasana'])) {
    $kysely = $yhteys->prepare('INSERT INTO rekisteri (tunnus,salasana,luontipvm,sukupuoli,pituus,paino,ika) VALUES (?,?,?,?,?,?,?)');
    $onnistuiko = $kysely->execute(array($_POST["tunnus"], $_POST["salasana"],$paivays,$_POST["sukupuoli"],$_POST["pituus"],$_POST["paino"],$_POST["ika"]));
	if ($onnistuiko) {
		$kysely = $yhteys->prepare('SELECT id FROM rekisteri WHERE tunnus = ? and salasana = ?');
		$kysely->execute(array($_POST["tunnus"], $_POST["salasana"]));
		$kayttaja = $kysely->fetchObject();
		if ($kayttaja) {
			$_SESSION["kayttaja_id"] = $kayttaja->id;
			$_SESSION["kayttaja"] = $_POST["tunnus"];
			header("Location: sisalto.php");
			die();
		} 
	} 
}
else {
header("Location: eka.html");
die();
}
?>