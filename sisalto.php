<?php
session_start();
if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
    die();
}
?>
<head>
    <style type="text/css">
	body {background-color:#d0e4fe;}
	h1 {
	color:orange;
	text-align:center;
	}
	p {color:blue;
	font-size:15px
	}
	fieldset { font-size:12px }
	</style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Tervetuloa, <?php echo $_SESSION["kayttaja"]; ?>!</title>
  </head>

<p><a href="haku.php">Siirry tuotehakuun</a></p>
<p><a href="lisaatuote.html">Lisaa uusi raaka-aine</a></p>
<p><a href="ulos.php">Kirjaudu ulos</a></p>