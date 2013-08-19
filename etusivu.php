<?php include ("reunat/yreuna.php"); 
$otsikko = 'LightenYourLife etusivu';
?>
<h2>LightenYourLife Tervetuloa</h2>
<p>Ole hyvä ja kirjaudu sisään, jos olet rekisteröitynyt käyttäjä.</p>
<form action="kirjautuminen.php" method="POST">
  <fieldset>
    <legend>Kirjaudu sisään</legend>
    <label for="tunnus">Käyttäjätunnus:</label>
    <input type="text" name="tunnus" id="tunnus" />
    <label for="salasana">Salasana:</label>
    <input type="password" name="salasana" id="salasana" />
    <input type="submit" value="Kirjaudu" />
  </fieldset>
</form>
<?php include("reunat/areuna.php"); ?>

 
 