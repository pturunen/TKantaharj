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
	<h1> P‰iv‰kirja valikko</h1>
	<p></p>
    <form action="haetapahtumia.php" method="POST">
      <fieldset>
        <legend>P‰iv‰kirja tapahtumien haku</legend>
		<input type="radio" name=<?php $_SESSION['aikajana'] ?> value="all" checked> kaikki tapahtumat <br>
		<input type="radio" name=<?php $_SESSION['aikajana'] ?> value="val" > tietty ajanjakso  2013-08-24 - 2013-09-24 <br>
		<input type="radio" name=<?php $_SESSION['aikajana'] ?> value="one" > tietty p‰iv‰      2013-08-24 -             <br>
		<br>
		Paivam‰‰r‰:
		<input type="text" name="paivastart" value="2013-08-24"/> - <input type="text" name="paivaend" value="2013-08-24"/>
		<br>
        <input type="submit" value="Hae tapahtumia" />
      </fieldset>
    </form>
    <footer>
	<p><a href="paivakirja.php">Peruuta</a></p>
    <p><a href="eka.html">Takaisin etusivulle</a></p>
    </footer>
  </body>
  </head>
  </html>


