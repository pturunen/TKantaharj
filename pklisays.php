<?php
require 'yhteyss.php';

//lisayksen tarkistaminen ensin, sitten tapahtumat tulostetaan esille
//1 tarkista onko ruoka ruokaaine taulussa
if (isset($_POST['ruoka'])){
	try {
		$kysely2 = $yhteys->prepare('SELECT nimi FROM raakaaine WHERE nimi = ?');
		$kysely2->execute(array($_POST['ruoka'] ));
		$rivi2 = $kysely2->fetch();
	}
	catch (PDOException $e) {
		echo "<script>alert('Antamaasi ruoka-ainetta ei löytynyt,ole hyvä ja lisää ruoka-aine ennen tapahtuman kirjaamista');</script>";
	}
	
if($rivi2) {
//2 tarkista joko tapatumapaiva on lisatty eli onko ensimmäinen kirjaus päivälle
   try {
		$kysely3 = $yhteys->prepare('SELECT * FROM tapahtumapaiva WHERE tunnus = ? and paiva = ?');
		$kysely3->execute(array($_SESSION["kayttaja"],$_SESSION['lisayspaiva']));
		$rivi3 = $kysely3->fetchObject();
		if ($rivi3){
		$_SESSION['tapahtumaid'] = $rivi3->id;
		}
	}
	catch (PDOException $e) {
		//echo "<script>alert('Tapahtuman haku tietokannasta epäonnistui');</script>";
	}
	
	if (!$rivi3) {
	//eli lisaa tapahtumapaiva rivi ensin koska ensimmäinen kirjaus päivälle
	try {
	$kysely4 = $yhteys->prepare('INSERT INTO tapahtumapaiva (paiva,tunnus,paino,selite) VALUES (?,?,?,?)');
    $kysely4->execute(array($_SESSION['lisayspaiva'],$_SESSION["kayttaja"],$_SESSION["paino"],$_SESSION["selite"]));
	$_SESSION['tapahtumaid'] = $yhteys->lastInsertId("tapahtumapaiva_id_seq");
	}
	catch (PDOException $e) {
	 echo "<script>alert('Tapahtuman lisääminen tietokantaan ei onnistu tälle päivälle');</script>";
	}
	}
//3 lisää riveja energiansaanti tauluun
	try {
	$kysely5 = $yhteys->prepare('INSERT INTO energiansaanti (tapid,ruoka,maara) VALUES (?,?,?)');
    $kysely5->execute(array($_SESSION['tapahtumaid'],$_POST['ruoka'],$_POST['maara']));
	}
	catch (PDOException $e) {
	 echo "<script>alert('Tapahtumarivin lisääminen tietokantaan ei onnistu');</script>";
	}
}
else {
echo "<script>alert('Antamaasi ruoka-ainetta ei löytynyt tietokannasta,ole hyvä ja lisää ruoka-aine ennen tapahtuman kirjaamista');</script>";
}	
}

//tapahtumapaivan rivien paivitys naytolle joka kerta
if (isset($_POST['paiva']) || isset($_SESSION['lisayspaiva'])){
	if (!empty($_POST['paiva'])){
		$_SESSION['lisayspaiva'] = $_POST['paiva'];
	if (isset($_POST['paino']) && !empty($_POST['paino'])){
		$_SESSION['paino'] = $_POST['paino'];
	}
	if (isset($_POST['selite']) && !empty($_POST['selite'])){
		$_SESSION['selite'] = $_POST['selite'];
	}
	}
	try {
$kysely = $yhteys->prepare('SELECT tapahtumapaiva.id,tapahtumapaiva.paiva AS paiva,tapahtumapaiva.paino AS paino,tapahtumapaiva.selite AS seli,
	energiansaanti.ruoka AS ruoka, energiansaanti.maara AS emaara, perusravintoaineet.maara as pmaara
	FROM tapahtumapaiva,energiansaanti, perusravintoaineet
	WHERE tapahtumapaiva.tunnus = ? and tapahtumapaiva.id = energiansaanti.tapid  and energiansaanti.ruoka = perusravintoaineet.nimi and 
	perusravintoaineet.ravintotekija = ? and tapahtumapaiva.paiva = ? ORDER BY paiva');
    $kysely->execute(array($_SESSION['kayttaja'],'energia',$_SESSION['lisayspaiva'] ));
	$rivi = $kysely->fetch();
	}
	 catch (PDOException $e) {
	 //echo "<script>alert('Annetulla päivällä ei vielä tapahtumia');</script>";
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
		   $saatuenergia = ($rivi["pmaara"]/100)*$rivi["emaara"]; 
		   $yhteensa = $saatuenergia+$yhteensa ;?>
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
		<tr> Kj yhteensä:<?php echo $yhteensa ?> </tr>
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
	<p><a href="paivakirja.php">Edellinen sivu</a></p>
	<p><a href="haku.php">Siirry raaka-aine haun sivulle</a></p>
    <p><a href="eka.html">Takaisin etusivulle</a></p>
    </footer>
  </body>
  </head>
  </html>
