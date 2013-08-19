yhteys.php
<?php
// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

require_once 'kyselyt.php';
require_once 'sessio.php';


function ohjaa($osoite) {
  header("Location: $osoite");
  exit;
}

function on_kirjautunut() {
  global $sessio;
  return isset($sessio->kayttaja_id);
}

function varmista_kirjautuminen() {
  if (!on_kirjautunut()) {
    ohjaa('kirjautuminen.php');
  }
}



?>

