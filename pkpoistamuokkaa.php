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

if (!empty($_POST['listapois'])){
$listapoistettava = $_POST['listapois'];
$poista = true;
}
if (!empty($_POST['listamuokkaa'])){
$listamuokattava = $_POST['listamuokkaa'];
$muokkaa = true;
}	
if (!$poista && !$muokkaa){
echo "<script>alert('Et valinnut poistettavaa tai muokkattavaa riviä!');</script>";
}
foreach($listapoistettava as $erivi){
 try{
	$kysely = $yhteys->prepare('DELETE FROM energiansaanti WHERE id = ?');
    $kysely->execute(array("{$erivi}"));
	}
catch (PDOException $e) {
   echo "<script>alert('No nyt pomppas');</script>";
}
}
foreach($listamuokattava as $mrivi){
}
//hae kyselyllä muutettava rivi, korjaa ruksi valintaa siten etta vain yksi ruksi muokattavaksi kerrallaan
try {
	$kysely = $yhteys->prepare('SELECT tapahtumapaiva.id,tapahtumapaiva.paiva AS paiva,tapahtumapaiva.paino AS paino,tapahtumapaiva.selite AS seli,
	energiansaanti.ruoka AS ruoka, energiansaanti.maara AS emaara, perusravintoaineet.maara as pmaara
	FROM tapahtumapaiva,energiansaanti, perusravintoaineet
	WHERE energiansaanti.id = ? and tapahtumapaiva.id = energiansaanti.tapid  and energiansaanti.ruoka = perusravintoaineet.nimi and 
	perusravintoaineet.ravintotekija = ? ORDER BY paiva');
    $kysely->execute(array("{$mrivi}",'energia' ));
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
	  <form action="pkpoista.php" method="POST">
      <fieldset>
        <legend>Päiväkirja tapahtumat</legend>
		<table border>
		<tr>
		<td>MUOKATTAVA TAPAHTUMA</td>
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
			<td> <input type="text" name="paino" value=<?php echo $rivi["paino"]?> > </td>
			<td> <input type="text" name="selite" value=<?php echo $rivi["seli"]?> > </td>
			<td> <input type="text" name="ruoka" value=<?php echo $rivi["ruoka"]?> > </td>
			<td> <input type="text" name="maara" value=<?php echo $rivi["emaara"]?> > </td> 
			<td>energia</td>
			$saatuenergia = ($rivi["pmaara"]/100)*$rivi["emaara"] ?>
			<td><?php echo $saatuenergia?></td>
			</tr>
			<?php $rivi = $kysely->fetch();?>
		<?}?>
		</table>
		<input type="submit" value="Muuta" />
		<br>
      </fieldset>
	  </form>
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
<p><a href="haku.php">siirry raaka-aine hakuun</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>


