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
}
else if (isset($_POST['aika']) && $_POST['aika'] == 'val'){
		$haevali = true;
}	
try {
	if ($haekaikki){
	$kysely = $yhteys->prepare('SELECT tapahtumapaiva.id,tapahtumapaiva.paiva AS paiva,tapahtumapaiva.paino AS paino,tapahtumapaiva.selite AS seli,
	energiansaanti.ruoka AS ruoka, energiansaanti.maara AS emaara, perusravintoaineet.maara as pmaara
	FROM tapahtumapaiva,energiansaanti, perusravintoaineet
	WHERE tapahtumapaiva.tunnus = ? and tapahtumapaiva.id = energiansaanti.tapid  and energiansaanti.ruoka = perusravintoaineet.nimi and 
	perusravintoaineet.ravintotekija = ?');
    $kysely->execute(array($_SESSION['kayttaja'],'energia' ));
	}
	else if ($haevali){
	$kysely = $yhteys->prepare('SELECT tapahtumapaiva.id,tapahtumapaiva.paiva AS paiva,tapahtumapaiva.paino AS paino,tapahtumapaiva.selite AS seli,
	energiansaanti.ruoka AS ruoka, energiansaanti.maara AS emaara, perusravintoaineet.maara as pmaara
	FROM tapahtumapaiva,energiansaanti, perusravintoaineet
	WHERE tapahtumapaiva.tunnus = ? and tapahtumapaiva.id = energiansaanti.tapid  and energiansaanti.ruoka = perusravintoaineet.nimi and 
	perusravintoaineet.ravintotekija = ? and tapahtumapaiva.paiva BETWEEN ? and ?');
    $kysely->execute(array($_SESSION['kayttaja'],'energia',$_POST['paivastart'],$_POST['paivaend'] ));
	}
	else {
	$kysely = $yhteys->prepare('SELECT tapahtumapaiva.id,tapahtumapaiva.paiva AS paiva,tapahtumapaiva.paino AS paino,tapahtumapaiva.selite AS seli,
	energiansaanti.ruoka AS ruoka, energiansaanti.maara AS emaara, perusravintoaineet.maara as pmaara
	FROM tapahtumapaiva,energiansaanti, perusravintoaineet
	WHERE tapahtumapaiva.tunnus = ? and tapahtumapaiva.id = energiansaanti.tapid  and energiansaanti.ruoka = perusravintoaineet.nimi and 
	perusravintoaineet.ravintotekija = ? and tapahtumapaiva.paiva = ?');
    $kysely->execute(array($_SESSION['kayttaja'],'energia',$_POST['paivastart'] ));
	}
	$rivi = $kysely->fetch();
}
catch (PDOException $e) {
    echo "VIRHE: " . $e->getMessage();
}
	if (empty($rivi)){
	echo "<script>alert('Päiväkirjassa ei ole tapahtumia annettuna ajanjaksona!');</script>";
	//echo "Päiväkirjassa ei ole tapahtumia annettuna ajanjaksona! <br>";
	}
	else {
		/*echo "<table border>";
		echo "<tr>";
		echo "<td>" . "  ". "PÄIVÄKIRJA TAPAHTUMAT" . " " ."</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>" . "  ". "PÄIVÄMÄÄRÄ" . " " ."</td>";
		echo "<td>" . "  ". "PAINO" . " " ."</td>";
		echo "<td>" . "  ". "SELITE" . " " ."</td>";
		echo "<td>" . "  ". "RUOKA-AINE" . " " ."</td>";
		echo "<td>" . "  ". "MÄÄRÄ" . " " ."</td>";
		echo "<td>" . "  ". "PERUSRAVINTOAINE" . " " ."</td>";
		echo "<td>" . "  ". "ENERGIAN SAANTI KJ" . " " ."</td>";
		echo "</tr>";
		while ($rivi) {
		   $saatuenergia = ($rivi["pmaara"]/100)*$rivi["emaara"];
			echo "<tr>";
			echo "<td>" . $rivi["paiva"] . "</td>";
			echo "<td>" . $rivi["paino"] . "</td>";
			echo "<td>" . $rivi["seli"] . "</td>"; 
			echo "<td>" . $rivi["ruoka"] . "</td>";
			echo "<td>" . $rivi["emaara"] . "</td>"; 
			echo "<td>" . "energia" . "</td>";
			echo "<td>" . $saatuenergia . "</td>";
			echo "</tr>";
			$rivi = $kysely->fetch();
		}
		echo "</table>";
		*/
		?>
<!DOCTYPE html>
<html>
  <head>
    <style type="text/css">
	body {background-color:#d0e4fe;}
	title {
	color:orange;
	text-align:center;
	}
	p {color:blue;
	font-size:15px
	}
	fieldset { font-size:12px }
	</style>
    <title>LightenYourLife paivakirja taphtumat</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  </head>
  <body>
    <img src="paivakirja.jpg" title="LightenYourLife" width="120" height="80" alt="LightenYourLife" />
	<h1> Päiväkirja tapahtumat</h1>
	<p></p>
      <fieldset>
        <legend>Päiväkirja tapahtumat</legend>
		<table border>";
		<tr>
		<td>PÄIVÄKIRJA TAPAHTUMAT</td>
		</tr>
		<tr>
		<td>PÄIVÄMÄÄRÄ</td>
		<td>PAINO</td>
		<td>SELITE</td>
		<td>RUOKA-AINE</td>
		<td>MÄÄRÄ</td>
		<td>PERUSRAVINTOAINE</td>
		<td>ENERGIAN SAANTI KJ</td>
		</tr>
		while ( <?php $rivi ?> ) {
		   <?php $saatuenergia = ($rivi["pmaara"]/100)*$rivi["emaara"];?>
			<tr>
			<td><?php $rivi["paiva"]?></td>
			<td><?php $rivi["paino"]?> </td>
			<td><?php $rivi["seli"]?></td>
			<td><?php $rivi["ruoka"]?></td>
			<td><?php $rivi["emaara"]?></td> 
			<td>energia</td>
			<td><?php $saatuenergia?></td>
			</tr>
			<?php $rivi = $kysely->fetch();?>
		}
		</table>
		<br>
      </fieldset>
  </body>
  </head>
  </html>		
<?php
	}
	
	$nimiparametri = $rivi["nimi"];
	if (isset($_SESSION["kayttaja"])) {
    //echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"lisaaalituote2.php\">Lisaa ravintoaineelle lisätietoja <br></a>";
	echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"paivakirja.php\">edellinen sivu <br></a>";
    //echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"lisaatuote.html\">Lisaa uusi tuote<br></a>";
	echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"ulos.php\">Kirjaudu ulos<br></a>";
	}



?>
<p><a href="satunnainen.html">Tuotehakuun takaisin</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>


