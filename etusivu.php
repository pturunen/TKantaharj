<?php
$otsikko = 'LightenYourLife etusivu';
require 'reunat/yreuna.php';
?>
<h2>LightenYourLife Tervetuloa</h2>
<p>Ole hyvä ja kirjaudu sisäänn, jos olet rekisteröitynyt käyttäjä.</p>
<form action="kirjaudu.php?sisaan" method="POST">
  <fieldset>
    <legend>Kirjaudu sisään</legend>
    <label for="tunnus">Käyttäjätunnus:</label>
    <input type="text" name="tunnus" id="tunnus" />
    <label for="salasana">Salasana:</label>
    <input type="password" name="salasana" id="salasana" />
    <input type="submit" value="Kirjaudu" />
  </fieldset>
</form>
<?php require 'reunat/areuna.php'; ?>

 
 