<?php
require_once 'yhteys/kyselyt.php';
require_once 'yhteys/sessio.php';


if (isset($_GET['sisaan'])) {
  $kayttaja = $kyselija->tunnista($_POST['tunnus'], $_POST['salasana']);
  if ($kayttaja) {
    $sessio->kayttaja_id = $kayttaja->id;
	echo "<p> tunnarit tunnistettu</p> "
    ohjaa('haku.php');
  } else {
    ohjaa('etusivu.php');
  }
} elseif (isset($_GET['ulos'])) {
  unset($sessio->kayttaja_id);
  ohjaa('haku.php');
} else {
  die('Laiton toiminto!');
}

