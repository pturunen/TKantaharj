<?php
session_start();
if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
    die();
}
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//lisayksen tarkistaminen ensin, sitten tapahtumat tulostetaan esille
if (isset($_POST['ruoka'])){
	try {
	$kysely2 = $yhteys->prepare('SELECT nimi from raakaaine where nimi = ?');
    $kysely2->execute(array($_POST['ruoka'] ));
	$rivi2 = $kysely2->fetch();
	}
	catch (PDOException $e) {
	 echo "<script>alert('Antamaasi ruoka-ainetta ei löytynyt,ole hyvä ja lisää ruoka-aine ennen tapahtuman kirjaamista');</script>";
	}
if($rivi2) {
   try {
	$kysely3 = $yhteys->prepare('SELECT id FROM tapahtumapaiva WHERE tunnus = ? and paiva = ?');
    $kysely3->execute(array($_SESSION["kayttaja"],$_SESSION['lisayspaiva']));
	$rivi3 = $kysely3->fetch();
	}
	catch (PDOException $e) {
	 echo "<script>alert('No nyt pomppas');</script>";
	}
	if (!$rivi3) {
	//eli lisaa tapahtumapaiva rivi ensin
	try {
	$kysely4 = $yhteys->prepare('INSERT INTO tapahtumapaiva (paiva,tunnus,paino,selite) VALUES (?,?,?,?)');
    $kysely4->execute(array($_POST['paiva'],$_SESSION["kayttaja"],$_POST['paino'],$_POST['selite']));
	$id = $yhteys->lastInsertId("tapahtumapaiva_id_seq");
	}
	catch (PDOException $e) {
	//tarkista etta tasta tullaan ulos jos ei onnistunut
	 echo "<script>alert('Tapahtuman lisääminen tietokantaan ei onnistu tälle päivälle');</script>";
	}
	}
	else {
	$id = $rivi3['id'];
	}
	//eli paiva on olemassa lisaa riveja
	try {
	$kysely5 = $yhteys->prepare('INSERT INTO energiansaanti (tapid,ruoka,maara) VALUES (?,?,?)');
    $kysely5->execute(array($id,$_POST['ruoka'],$_POST['maara']));
	}
	catch (PDOException $e) {
	//tarkista etta tasta tullaan ulos jos ei onnistunut
	 echo "<script>alert('Tapahtumarivin lisääminen tietokantaan ei onnistu');</script>";
	}
}	
}

if (isset($_POST['paiva']) || isset($_SESSION['lisayspaiva'])){
	if (!isset($_POST['paiva'])){
	$_POST['paiva'] = $_SESSION['lisayspaiva'];
	}
	$_SESSION['lisayspaiva'] = $_POST['paiva'];
	try {
$kysely = $yhteys->prepare('SELECT tapahtumapaiva.id,tapahtumapaiva.paiva AS paiva,tapahtumapaiva.paino AS paino,tapahtumapaiva.selite AS seli,
	energiansaanti.ruoka AS ruoka, energiansaanti.maara AS emaara, perusravintoaineet.maara as pmaara
	FROM tapahtumapaiva,energiansaanti, perusravintoaineet
	WHERE tapahtumapaiva.tunnus = ? and tapahtumapaiva.id = energiansaanti.tapid  and energiansaanti.ruoka = perusravintoaineet.nimi and 
	perusravintoaineet.ravintotekija = ? and tapahtumapaiva.paiva = ?');
    $kysely->execute(array($_SESSION['kayttaja'],'energia',$_SESSION['lisayspaiva'] ));
	$rivi = $kysely->fetch();
	}
	 catch (PDOException $e) {
   // die("VIRHE: " . $e->getMessage());
}
}
else {
	header("Location: paivakirja.php");
    die();
}

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
    <title>LightenYourLife</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  </head>
  <body>
    <img src="paivakirja.jpg" title="LightenYourLife" width="320" height="220" alt="LightenYourLife" />
	<p></p>
	<form action="pklisays.php" method="POST">
	<fieldset>
        <legend>Päiväkirja tapahtumat</legend>
		<table border>
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
		<?php while (  $rivi  ) {
		   $saatuenergia = ($rivi["pmaara"]/100)*$rivi["emaara"] ?>
			<tr>
			<td><?php echo $rivi["paiva"]?></td>
			<td><?php echo $rivi["paino"]?> </td>
			<td><?php echo $rivi["seli"]?></td>
			<td><?php echo $rivi["ruoka"]?></td>
			<td><?php echo $rivi["emaara"]?></td> 
			<td>energia</td>
			<td><?php echo $saatuenergia?></td>
			</tr>
			<?php $rivi = $kysely->fetch();?>
		<?}?>
		</table>
		<br>
      </fieldset>
	
      <fieldset>
        <legend>Päiväkirja tapahtumien lisäys</legend>
		Ruoka-aine:
		<input type="text" name="ruoka"  />
		Määrä g:
		<input type="text" name="maara"  />
		<br>
		<br>
        <input type="submit" value="Lisää tapahtuma paivalle" />
      </fieldset>
    </form>
	
    <footer>
	<p><a href="paivakirja.php">Peruuta</a></p>
    <p><a href="eka.html">Takaisin etusivulle</a></p>
    </footer>
  </body>
  </head>
  </html>
