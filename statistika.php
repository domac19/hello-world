<?php
include("zaglavlje.php");
$bp = spojiSeNaBazu();
?>

<head>
    <meta charset="utf-8">
</head>
<h2>Statistički podaci za parkiralište: <?php echo $_GET['naziv'] ?></h2>
<?php

if ($_SESSION['aktivni_korisnik_tip'] != 0) {
    header("Location:index.php");
}

$parking_id = $_GET['id'];

$sql = "SELECT tvrtka.parkiraliste_id, parkiraliste.naziv, (TO_SECONDS(datum_vrijeme_odlaska)-TO_SECONDS(datum_vrijeme_dolaska))/60/COUNT(*) AS prosjek 
        FROM automobil, tvrtka, partner, parkiraliste 
        WHERE tvrtka.tvrtka_id = partner.tvrtka_id AND partner.partner_id = automobil.partner_id 
        AND tvrtka.parkiraliste_id = parkiraliste.parkiraliste_id 
        AND parkiraliste.parkiraliste_id = $parking_id
        AND automobil.datum_vrijeme_odlaska <> '0000-00-00 00:00:00' 
        GROUP BY tvrtka.parkiraliste_id";
$rs = izvrsiUpit($bp, $sql);

echo "<table>";
echo "<caption>Parkiralište statistika</caption>";
echo "<thead><tr>
		<th>Parkiralište</th>
		<th>Rezultat zadržavanja automobila na parkiralištu</th>";
echo "</tr></thead>";


echo "<tbody>";
while (list($parkiraliste_id, $ime, $statistika) = mysqli_fetch_array($rs)) {
    echo "<tr>";
    echo "<td>" . $ime . "</td>
            <td>" . $statistika . "</td>";
}
echo "</tbody>";
echo "</table><p></p>";

$sqli = "SELECT tvrtka.tvrtka_id, tvrtka.naziv, (TO_SECONDS(datum_vrijeme_odlaska)-TO_SECONDS(datum_vrijeme_dolaska))/60/COUNT(*) AS prosjek FROM automobil, tvrtka, partner 
        WHERE tvrtka.tvrtka_id = partner.tvrtka_id 
        AND tvrtka.parkiraliste_id = $parking_id
        AND partner.partner_id = automobil.partner_id  
        AND automobil.datum_vrijeme_odlaska <> '0000-00-00 00:00:00' 
        GROUP BY naziv";
$rs = izvrsiUpit($bp, $sqli);

echo "<table>";
echo "<caption>Statistika tvrtke</caption>";
echo "<thead><tr>
		<th>Tvrtka</th>
		<th>Rezultat zadržavanja tvrtke na parkiralištu</th>";
echo "</tr></thead>";

echo "<tbody>";
while (list($tvrtka_id, $ime_tvrtke, $statistika) = mysqli_fetch_array($rs)) {
    echo "<tr>";
    echo "<td>" . $ime_tvrtke . "</td>
            <td>" . $statistika . "</td>";
}
echo "</tbody>";
echo "</table>";
?>
<?php
zatvoriVezuNaBazu($bp);
include("podnozje.php");
?>