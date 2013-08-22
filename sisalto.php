<?php
session_start();
if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
    die();
}
?>
<p>Tervetuloa, <?php echo $_SESSION["kayttaja"]; ?>!</p>
<p><a href="haku.php">Siirry tuotehakuun</a></p>
<p><a href="lisaatuote.html">Lisaa uusi raaka-aine</a></p>
<p><a href="ulos.php">Kirjaudu ulos</a></p>