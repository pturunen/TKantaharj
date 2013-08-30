<?php
require 'yhteyss.php';
if (isset($_POST['tunnus']) && !empty($_POST['tunnus']) && !empty($_POST['salasana'])) {
    if (strlen($_POST['tunnus']) > 0 && strlen($_POST['salasana']) > 0){
try {	
    $kysely = $yhteys->prepare('SELECT * FROM rekisteri WHERE tunnus = ? and salasana = ?');
    $kysely->execute(array($_POST["tunnus"], $_POST["salasana"]));
	$kayttaja = $kysely->fetchObject();
}
catch (PDOException $e) {
    echo "<script>alert('Virheelline tunnus/salasana!');</script>";
}
	if ($kayttaja) {
		$_SESSION["kayttaja_id"] = $kayttaja->id;
		$_SESSION["kayttaja"] = $_POST["tunnus"];
		header("Location: sisalto.php");
		die();
		} 
	}
} 

?>
<p>Tunnus tai salasana on väärin!</p>
<p><a href="eka.html">Takaisin</a></p>