<?php
require_once 'avusteet.php';

if (isset($_POST['tunnus']) && isset($_POST['salasana']) {
  $kayttaja = $kyselija->tunnista($_POST['tunnus'], $_POST['salasana']);
  if ($kayttaja) {
    $sessio->kayttaja_id = $kayttaja->id;
    header("Location: haku.php");
  } else {
    header("Location: etusivu.php");
  }
} else {
  unset($sessio->kayttaja_id);
  header("Location: etusivu.php");
} else {
  die('Laiton toiminto!');
}
?>
