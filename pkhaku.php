<?php
session_start();
if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
    die();
}
header("Content-Type: text/html; charset=UTF-8");
// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['aika']) && $_POST['aika'] == 'all'){
$haekaikki = true;
	if (isset($_POST['aika']) && $_POST['aika'] == 'val'){
		$haevali = true;
	}
}	
try {
   /* $kysely = $yhteys->prepare('SELECT tapahtumapaiva.id,tapahtumapaiva.paiva,tapahtumapaiva.paino,tapahtumapaiva.selite,
	energiansaanti.ruoka, energiansaanti.maara, perusravintoaineet.maara
	FROM tapahtumapaiva,raakaaine,energiansaanti,perusravintoaineet 
	WHERE tunnus = ? && tunnus == tapahtumapaiva.tunnus && tapahtumapaiva.id == energiansaanti.tapid && 
	energiansaanti.ruoka == perusravintoaineet.nimi');
	*/
	$kysely = $yhteys->prepare('SELECT tapahtumapaiva.id,tapahtumapaiva.paiva,tapahtumapaiva.paino,tapahtumapaiva.selite,
	energiansaanti.ruoka, energiansaanti.maara
	FROM tapahtumapaiva,energiansaanti
	WHERE tapahtumapaiva.tunnus = ? and tapahtumapaiva.id = energiansaanti.tapid ');
    $kysely->execute(array($_SESSION['kayttaja']));
	$rivi = $kysely->fetch();
}
catch (PDOException $e) {
    echo "VIRHE: " . $e->getMessage();
}
	if (empty($rivi)){
	echo "Päiväkirjassa ei ole tapahtumia annettuna ajanjaksona! <br>";
	}
	else {
		echo "<table border>";
		echo "<tr>";
		echo "<td>" . "  ". "PÄIVÄKIRJA TAPAHTUMAT" . " " ."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>" . "  ". "PÄIVÄMÄÄRÄ" . " " ."</td>";
		echo "<td>" . "  ". "PAINO" . " " ."</td>";
		echo "<td>" . "  ". "SELITE" . " " ."</td>";
		echo "<td>" . "  ". "RUOKA-AINE" . " " ."</td>";
		echo "<td>" . "  ". "MÄÄRÄ" . " " ."</td>";
		echo "<td>" . "  ". "ENERGIA KJ/100g" . " " ."</td>";
		echo "</tr>";
		while ($rivi) {
			echo "<tr>";
			echo "<td>" . $rivi["tapahtumapaiva.paiva"] . "</td>";//tapahtumapaiva paiva where tunnus == $_SESSION['kayttaja'] and paiva == paivastart -paivaend
			echo "<td>" . $rivi["tapahtumapaiva.paino"] . "</td>";//tapahtumapaiva selite where tunnus == $_SESSION['kayttaja']
			echo "<td>" . $rivi["tapahtumapaiva.selite"] . "</td>"; //tapahtumapaiva selite where tunnus == $_SESSION['kayttaja']
			echo "<td>" . $rivi["energiansaanti.ruoka"] . "</td>";//energiansaanti ruoka where tapid == tapahtumapaiva.id
			echo "<td>" . $rivi["energiansaanti.maara"] . "</td>"; //energiansaanti maara where tapid == tapahtumapaiva.id
			//echo "<td>" . $rivi["perusravintoaineet.ravintotekija"] . "</td>"; //perusravintoaineet ravintotekija where ravintotekija== energia and nimi == energiansaanti.ruoka
			//echo "<td>" . $rivi["perusravintoaineet.maara"] . "</td>";//perusravintoaineet maara where ravintotekija == energia and nimi == energiansaanti.ruoka
			echo "</tr>";
			$rivi = $kysely->fetch();
		}
		echo "</table>";
	}
	$nimiparametri = $rivi["nimi"];
	if (isset($_SESSION["kayttaja"])) {
    echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"lisaaalituote2.php\">Lisaa ravintoaineelle lisätietoja <br></a>";
	echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"satunnainenkavija.php\">edellinen sivu <br></a>";
    echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"lisaatuote.html\">Lisaa uusi tuote<br></a>";
	echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"ulos.php\">Kirjaudu ulos<br></a>";
	}



?>
<p><a href="satunnainen.html">Tuotehakuun takaisin</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>


