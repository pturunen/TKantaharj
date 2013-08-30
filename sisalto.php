<?php
session_start();
if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
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
	<img src="mustaherukka.jpg" title="LightenYourLife" width="320" height="220" alt="LightenYourLife" />
	<p>Tervetuloa, <?php echo $_SESSION["kayttaja"]; ?>!</p>
	<p><a href="paivakirja.php">Siirry päiväkirjaan</a></p>
	<p><a href="haku.php">Siirry raaka-aine hakuun</a></p>
	<p><a href="lisaatuote.html">Lisaa uusi raaka-aine</a></p>
	<p><a href="unrekisteroidy.php">Poista tunnuksesi tietokannasta</a></p>
	<p><a href="ulos.php">Kirjaudu ulos</a></p>
  </body>
  </head>
  </html>


