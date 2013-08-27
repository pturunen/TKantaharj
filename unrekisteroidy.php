<?php
session_start();
if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
    die();
}
if (isset($_POST["varmistus"])) {
    if ($_POST["varmistus"] == 'e'){
	header("Location: ulos.php");
    die();
	}
	$_SESSION['varmistus'] = 'poista';
}
// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}

$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_SESSION['varmistus']) && $_SESSION['varmistus'] == 'poista'){
try {
    $kysely2 = $yhteys->prepare('DELETE from rekisteri where tunnus = ?');
    $onnistuiko = $kysely2->execute(array($_SESSION["kayttaja"]));
}
catch (PDOException $e) {
   header("Location: eka.html");
   die();
}	
	unset($_SESSION["kayttaja"]);
	unset($_SESSION["kayttaja_id"]);
	unset($_SESSION["varmistus"]);
	header("Location: eka.html");
	die();
}


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
?>