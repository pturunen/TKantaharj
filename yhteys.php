<?php
session_start();

header("Content-Type: text/html; charset=UTF-8");
//yhteyden luonti tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=Tietokanta",
                      "K�ytt�j�tunnus", "Salasana");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
