<?php
session_start();
if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
    die();
}
?>
<p>Tervetuloa, <?php echo $_SESSION["kayttaja"]; ?>!</p>
<p><a href="ulos.php">Kirjaudu ulos</a></p>