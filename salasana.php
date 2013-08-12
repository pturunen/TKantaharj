<?php
$tunnus = $_POST["tunnus"];
$salasana = $_POST["salasana"];
if ($tunnus == "pallero" && $salasana == "opensource") {
	echo "Tervetuloa kirjaamaan!";
	echo "<img src="mustaherukka.jpg"  alt="LightenYourLife" >";
} else {
	echo "Tarkista salasanasi!";
}
?>