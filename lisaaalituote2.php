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
    <title>Raakaaineen lisätietojen lisäys</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  </head>
  <body>
    <img src="mustaherukka.jpg" title="LightenYourLife" width="320" height="220" alt="LightenYourLife" />
    <form action="lisaaalituote.php" method="post">
	  <h1> Perusravintoaine </h1>
	  <label for="ravintotekijap">Ravintotekijä:</label>
      <input type="text" name="ravintotekijap"> <br>
	  <label for="nimip">Raakaineen nimi :</label>
	  <input type="text" name="nimip" value= <?php echo $_SESSION['tuotenimi']; ?> > <br>
	  <label for="maarap">Määrä :</label>
	  <input type="text" name="maarap"> <br>
	  <label for="mittayksikkop">Mittayksikkö :</label>
	  <input type="text" name="mittayksikkop"> <br>
	  <h2> Kivennäis ja hivenaineet </h2>
	  <label for="ravintotekijak">Ravintotekijä:</label>
      <input type="text" name="ravintotekijak"> <br>
	  <label for="nimik">Raakaineen nimi :</label>
	  <input type="text" name="nimik"> <br>
	  <label for="maarak">Määrä :</label>
	  <input type="text" name="maarak"> <br>
	  <label for="mittayksikkok">Mittayksikkö :</label>
	  <input type="text" name="mittayksikkok"> <br>
	  
      <input type="submit" value="Lisää">
    </form>
    <p><a href="lisaatuote.html">Peruuta</a></p>
	<p><a href="eka.html">Takaisin etusivulle</a></p>
	<p><a href="haku.php">Siirry tuotehaku sivulle</a></p>
  </body>
</html>