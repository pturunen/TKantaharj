<?php
$tunnus = $_POST["tunnus"];
$salasana = $_POST["salasana"];
if ($tunnus == "pallero" && $salasana == "opensource") {
	echo "Tervetuloa kirjaamaan!";
} else {
	echo "Tarkista salasanasi!";
}
?>