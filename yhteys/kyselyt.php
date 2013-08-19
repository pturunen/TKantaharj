kyselyt.php
<?php

class Kyselyt {

  private $_pdo;
  
  public function __construct($pdo) {
    $this->_pdo = $pdo;
  }

  public function tunnista($tunnus, $salasana) {
    $kysely = $this->valmistele('SELECT id FROM rekisteri WHERE tunnus = ? AND password = ?');
    if ($kysely->execute(array($tunnus, $salasana))) {
      return $kysely->fetchObject();
    } else {
      return null;
    }
  }
/*
  public function oletus_lista($kayttaja_id) {
    $kysely = $this->valmistele('SELECT * FROM lists WHERE user_id = ? AND is_default IS TRUE');
    if ($kysely->execute(array($kayttaja_id))) {
      return $kysely->fetchObject();
    } else {
      return null;
    }
  }

  public function hae_lista($kayttaja_id, $lista_id) {
    $kysely = $this->valmistele('SELECT * FROM lists WHERE user_id = ? AND id = ?');
    if ($kysely->execute(array($kayttaja_id, $lista_id))) {
      return $kysely->fetchObject();
    } else {
      return null;
    }
  }

  public function listan_tuotteet($lista_id) {
    $kysely = $this->valmistele('SELECT * FROM items WHERE list_id = ?');
    if ($kysely->execute(array($lista_id))) {
      $alkiot = array();
      while($alkio = $kysely->fetchObject()) {
        $alkiot[] = $alkio;
      }
      return $alkiot;
    }
    return null;
  }

  public function hae_listat($kayttaja_id) {
    $kysely = $this->valmistele('SELECT * FROM lists WHERE user_id = ? ORDER BY name');
    if ($kysely->execute(array($kayttaja_id))) {
      $listat = array();
      while($lista = $kysely->fetchObject()) {
        $listat[] = $lista;
      }
      return $listat;
    }
    return null;
  }

  public function poista_listalta($kayttaja_id, $tuote_id) {
    if ($this->onko_tuote_kayttajan($kayttaja_id, $tuote_id)) {
      $kysely = $this->valmistele('DELETE FROM items WHERE id = ? RETURNING list_id');
      if ($kysely->execute(array($tuote_id))) {
        return $kysely->fetchObject()->list_id;
      }
    }
    return null;
  }

  public function lisaa_tuote($kayttaja_id, $lista_id, $tuotteen_nimi) {
    if ($this->hae_lista($kayttaja_id, $lista_id)) {
      $kysely = $this->valmistele('INSERT INTO items (list_id, name) VALUES (?, ?)');
      return $kysely->execute(array($lista_id, $tuotteen_nimi));
    }
    return false;
  }

  public function paivita_lista($kayttaja_id, $lista_id, $nimi, $oletus) {
    $kysely = $this->valmistele('UPDATE lists SET name = ? WHERE user_id = ? AND id = ?');
    $kysely->execute(array($nimi, $kayttaja_id, $lista_id));
    if ($oletus) {
      $this->paivita_kayttajan_oletus($kayttaja_id, $lista_id);
    }
    return $this->hae_lista($kayttaja_id, $lista_id);
  }

  public function luo_uusi_lista($kayttaja_id) {
    date_default_timezone_set('UTC');
    $pvm = date('Y-m-d');
    $listan_nimi = "Ostoslista ($pvm)";
    $kysely = $this->valmistele('INSERT INTO lists (user_id, name) VALUES (?, ?) RETURNING id');
    if ($kysely->execute(array($kayttaja_id, $listan_nimi))) {
      return $kysely->fetchObject()->id;
    }
    return false;
  }

  private function onko_tuote_kayttajan($kayttaja_id, $tuote_id) {
    $kysely = $this->valmistele('SELECT user_id FROM lists LEFT JOIN items ON lists.id = list_id WHERE items.id = ?');
    if ($kysely->execute(array($tuote_id))) {
      $id = $kysely->fetchObject()->user_id;
      return $kayttaja_id == $id;
    }
    return false;
  }

  private function paivita_kayttajan_oletus($kayttaja_id, $lista_id) {
    $this->valmistele('UPDATE lists SET is_default = false WHERE user_id = ?')->execute(array($kayttaja_id));
    $this->valmistele('UPDATE lists SET is_default = true WHERE user_id = ? AND id = ?')->execute(array($kayttaja_id, $lista_id));
  }
*/
  private function valmistele($sqllause) {
    return $this->_pdo->prepare($sqllause);
  }

}

//require dirname(__file__).'/../asetukset.php';

$kyselija = new Kyselyt($pdo);

?>

