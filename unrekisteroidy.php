<?php
session_start();
if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
    die();
}
if (isset($_POST["varmistus"])) {
    if ($_POST["varmistus"] = 'e'){
	header("Location: sisalto.php");
    die();
	}
	$_SESSION['varmistus'] = true;
}
// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (!isset($_SESSION['varmistus'])){
	try{
	$kysely = $yhteys->prepare('SELECT id FROM rekisteri WHERE tunnus = ?');
		$kysely->execute(array($_SESSION["kayttaja"]));
		$kayttaja = $kysely->fetchObject();
	}
	catch (PDOException $e) {
    header("Location: eka.html");
}
	if ($kayttaja) {
			?> 
			<form action="unrekisteroidy.php" method="POST">
			Haluatko varmasti poistaa käyttäjä tunnuksesi?
			<input type="radio" name="varmistus" value="e" checked> en <br>
		    <input type="radio" name="varmistus" value="k" > kyllä <br>
			<input type="submit" value="Vahvista" />
			</form>
			<?php
		} 
}
if (isset($_SESSION['varmistus'])){
try {
    $kysely = $yhteys->prepare('DELETE from rekisteri where tunnus = ?');
    $onnistuiko = $kysely->execute(array($_SESSION["kayttaja"]));
}
catch (PDOException $e) {
   header("Location: eka.html");
   die();
}	
	if ($onnistuiko) {
		if ($kayttaja) {
		    unset($_SESSION["kayttaja"]);
			unset($_SESSION["kayttaja_id"]);
			unset($_SESSION["varmistus"]);
		} 
	}
	header("Location: eka.html");
	die();
}

?>