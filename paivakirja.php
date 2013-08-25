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
    <img src="paivakirja.jpg" title="LightenYourLife" width="320" height="220" alt="LightenYourLife" />
	<h1> Päiväkirja valikko</h1>
	<p></p>
    <form action="pkhaku.php" method="POST">
      <fieldset>
        <legend>Päiväkirja tapahtumien haku</legend>
		<input type="radio" name="aika" value="all" checked> kaikki tapahtumat <br>
		<input type="radio" name="aika" value="val" > tietty ajanjakso  2013-08-24 - 2013-09-24 <br>
		<input type="radio" name="aika" value="one" > tietty päivä      2013-08-24 -             <br>
		<br>
		Päivamäärä:
		<input type="text" name="paivastart" value="2013-08-24"/> - <input type="text" name="paivaend" value="2013-08-24"/>
		<br>
        <input type="submit" value="Hae tapahtumia" />
      </fieldset>
    </form>
	<form action="pklisays.php" method="POST">
      <fieldset>
        <legend>Päiväkirja tapahtumien lisäys</legend>
		Päivamäärä:
		<input type="text" name="paiva" value="2013-08-29" />
		Paino:
		<input type="text" name="paino"  />
		Selite:
		<input type="text" name="selite"  />
		<br>
		
		<br>
        <input type="submit" value="Lisää tapahtumia" />
      </fieldset>
    </form>
	
	
    <footer>
	<p><a href="paivakirja.php">Peruuta</a></p>
    <p><a href="eka.html">Takaisin etusivulle</a></p>
    </footer>
  </body>
  </head>
  </html>


