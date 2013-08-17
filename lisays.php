lisays.php
<?php

// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// kyselyn suoritus
$kysely = $yhteys->prepare("INSERT INTO raakaaine (nimi, valmistaja,luokka,selite) VALUES (?, ?,?,?)");
$kysely->execute(array($_POST["nimi"], $_POST["valmistaja"], $_POST["luokka"], $_POST["selite"]));

// lisätyn rivin id:n selvitys
//$id = $yhteys->lastInsertId("tuotteet_id_seq");
//echo "Uuden tuotteen id: $id";


?>
