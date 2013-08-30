<?php
session_start();
if (!isset($_SESSION["kayttaja"])) {
    header("Location: eka.html");
    die();
}
// yhteyden muodostus tietokantaan
try {
    $yhteys = new PDO("pgsql:host=localhost;dbname=pcturune",
                      "pcturune", "42c747d22fbafe6e");
} catch (PDOException $e) {
    die("VIRHE: " . $e->getMessage());
}
$yhteys->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Ensimmäinen valinnaisista lisättävistä
if (isset($_POST['nimip'])  && isset($_POST['ravintotekijap']) && !empty($_POST['nimip']) && !empty($_POST['ravintotekijap'])) {
	try{
    $kysely = $yhteys->prepare('INSERT INTO perusravintoaineet (ravintotekija,nimi,maara,mittayksikko) VALUES (?,?,?,?)');
    $onnistuikop = $kysely->execute(array($_POST["ravintotekijap"], $_POST["nimip"],$_POST["maarap"],$_POST["mittayksikkop"]));
	}
	catch (PDOException $e) {
	echo "<script>alert('Lisays ei onnistunut perusravintoaineen kohdalla!');</script>";
	}
}
try {
	$kysely = $yhteys->prepare('SELECT * FROM perusravintoaineet WHERE nimi =  ?');
	$tulos = $kysely->execute(array($_POST['nimip']));
	$rivip = $kysely->fetch();
	}
	catch (PDOException $e) {
    //echo "VIRHE: " . $e->getMessage();
	}
	echo "<table border>";
	echo "<tr>";
	echo "<td>" . "  ". "PERUSRAVINTOAINEET" . " " ."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>" . "  ". "RAVINTOTEKIJÄ" . " " ."</td>";
	echo "<td>" . "  ". "NIMI" . " " ."</td>";
	echo "<td>" . "  ". "MÄÄRÄ" . " " ."</td>";
	echo "<td>" . "  ". "MITTAYKSIKKÖ" . " " ."</td>";
	echo "</tr>";
	while ($rivip) {
		echo "<tr>";
		echo "<td>" . $rivip["ravintotekija"] . "</td>";
		echo "<td>" . $rivip["nimi"] . "</td>";
		echo "<td>" . $rivip["maara"] . "</td>";
		echo "<td>" . $rivip["mittayksikko"] . "</td>";
		echo "</tr>";
		$rivip = $kysely->fetch();
		}
		echo "</table>";
		
//Toinen valinnaisista 	lisättävistä	
 if (isset($_POST['nimik']) && isset($_POST['ravintotekijak'])  && !empty($_POST['nimip']) && !empty($_POST['ravintotekijak'])) {
    try{
    $kyselyk = $yhteys->prepare('INSERT INTO kivhivenaineet (ravintotekija,nimi,maara,mittayksikko) VALUES (?,?,?,?)');
    $onnistuikok = $kyselyk->execute(array($_POST["ravintotekijak"], $_POST["nimik"],$_POST["maarak"],$_POST["mittayksikkok"]));
	}
	catch (PDOException $e) {
     echo "<script>alert('Lisays ei onnistunut kivennäis ja hivenaineen kohdalla!');</script>";
    }
}

try{
	$kyselyk = $yhteys->prepare('SELECT * FROM kivhivenaineet WHERE nimi =  ?');
	$tulos = $kyselyk->execute(array($_POST['nimik']));
	$rivik = $kyselyk->fetch();
	}
catch(PDOException $e) {
    //echo "VIRHE: " . $e->getMessage();
}
	echo "<table border>";
	echo "<tr>";
	echo "<td>" . "  ". "KIVENNÄIS-JA HIVENAINEET" . " " ."</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>" . "  ". "RAVINTOTEKIJÄ" . " " ."</td>";
	echo "<td>" . "  ". "NIMI" . " " ."</td>";
	echo "<td>" . "  ". "MÄÄRÄ" . " " ."</td>";
	echo "<td>" . "  ". "MITTAYKSIKKÖ" . " " ."</td>";
	echo "</tr>";
	while ($rivik) {
		echo "<tr>";
		echo "<td>" . $rivik["ravintotekija"] . "</td>";
		echo "<td>" . $rivik["nimi"] . "</td>";
		echo "<td>" . $rivik["maara"] . "</td>";
		echo "<td>" . $rivik["mittayksikko"] . "</td>";
		echo "</tr>";
		$rivik = $kyselyk->fetch();
	}
	echo "</table>";
?>
<p><a href="lisaaalituote2.php">Lisaa ravintoaineita</a></p>
<p><a href="lisaatuote.html">Lisaa uusi raaka-aine</a></p>
<p><a href="haku.php">Siirry raaka-aine hakuun</a></p>
<p><a href="eka.html">Takaisin etusivulle</a></p>
<p><a href="ulos.php">Kirjaudu ulos</a></p>