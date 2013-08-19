kirjautuminen.php
<?php
require_once 'avusteet.php';

if (isset($_GET['sisaan'])) {
  $kayttaja = $kyselija->tunnista($_POST['tunnus'], $_POST['salasana']);
  if ($kayttaja) {
    $sessio->kayttaja_id = $kayttaja->id;
    header('haku.php');
  } else {
    header('etusivu.php');
  }
} elseif (isset($_GET['ulos'])) {
  unset($sessio->kayttaja_id);
  header('haku.php');
} else {
  die('Laiton toiminto!');
}
?>
