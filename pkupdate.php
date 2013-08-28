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

 try{
	$kysely = $yhteys->prepare('UPDATE energiansaanti SET ruoka = ?, maara = ? WHERE id = ?');
    $kysely->execute(array($_POST['ruoka'],$_POST['maara'],$_SESSION['muokattavaid']));
	}
catch (PDOException $e) {
   echo "<script>alert('No nyt pomppas energian saannin update ei onnistu');</script>";
}
try {
$paino = $_POST['paino'];
$selite = $_POST['selite'];
if (empty($_POST['paino'])){
$paino=0;
}
if (empty($_POST['selite'])){
$selite=' ';
}
	$kysely = $yhteys->prepare('UPDATE tapahtumapaiva SET paino = ?, selite = ? WHERE  paiva= ? and tunnus = ?');
    $kysely->execute(array($paino,$selite,$_SESSION['muokattavapaiva'],$_SESSION["kayttaja"]));
	}
catch (PDOException $e) {
   echo "<script>alert('No nyt pomppas tapahtumapaivan update ei onnistu');</script>";
}
//hae kyselyllä muutettu rivi
try {
	$kysely = $yhteys->prepare('SELECT tapahtumapaiva.id,tapahtumapaiva.paiva AS paiva,tapahtumapaiva.paino AS paino,tapahtumapaiva.selite AS seli,
	energiansaanti.ruoka AS ruoka, energiansaanti.maara AS emaara,energiansaanti.id as eid, perusravintoaineet.maara as pmaara
	FROM tapahtumapaiva,energiansaanti, perusravintoaineet
	WHERE energiansaanti.id = ? and tapahtumapaiva.id = energiansaanti.tapid  and energiansaanti.ruoka = perusravintoaineet.nimi and 
	perusravintoaineet.ravintotekija = ? ORDER BY paiva');
    $kysely->execute(array($_SESSION['muokattavaid'],'energia' ));
	$rivi = $kysely->fetch();
}
catch (PDOException $e) {
    echo "VIRHE: " . $e->getMessage();
}
	if (empty($rivi)){
	echo "<script>alert('Päiväkirjassa ei ole tapahtumia annettuna ajanjaksona!');</script>";
	}
	else { 
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
		<table border>
		<tr>
		<td>MUOKATTU TAPAHTUMA</td>
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
		<?php while (  $rivi  ) { ?>
			<tr>
			<td><?php echo $rivi["paiva"]?></td>
			<td> <?php echo $rivi["paino"]?> </td>
			<td> <?php echo $rivi["seli"]?> </td>
			<td> <?php echo $rivi["ruoka"]?> </td>
			<td> <?php echo $rivi["emaara"]?> </td> 
			<td>energia</td>
			<?php $saatuenergia = ($rivi["pmaara"]/100)*$rivi["emaara"] ?> 
			<td><?php echo $saatuenergia?></td>
			</tr>
			<?php $rivi = $kysely->fetch();?>
		<?}?>
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
	echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"paivakirja.php\">Paivakirja pääsivu <br></a>";
    //echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"lisaatuote.html\">Lisaa uusi tuote<br></a>";
	echo "<a border-style:\"solid\" style=\"color: blue\"  href=\"ulos.php\">Kirjaudu ulos<br></a>";
	}
?>
<p><a href="haku.php">siirry raaka-aine hakuun</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>


