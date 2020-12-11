<?php
include("zaglavlje.php");
$bp = spojiSeNaBazu();
?>

<head>
    <meta charset="utf-8">
</head>
<?php

$sql = "SELECT * FROM parkiraliste";
$rs = izvrsiUpit($bp, $sql);

echo "<table>";
echo "<caption>Popis parkiralista</caption>";
echo "<thead><tr>
		<th>Naziv</th>
		<th>Adresa</th>
		<th></th>
        <th></th>";
echo "</tr></thead>";

echo "<tbody>";
while (list($id, $naziv, $adresa, $slika, $video) = mysqli_fetch_array($rs)) {
    echo "<tr>
			<td><a class='link' href='tvrtka_parkiralista.php?id=$id'>$naziv</a></td>
			<td>$adresa</td>";

    if ($aktivni_korisnik_tip == 0) {
        echo "<td><a class='link' 
            href=
            'parkiraliste.php?id=$id&naziv=" . rtrim($naziv) . "&adresa=" . rtrim($adresa) . "&slika=" . rtrim($slika) . "&video=" . rtrim($video) . "'>UREDI</a></td>";
        echo "<td><a class='link' href='statistika.php?id=$id&naziv=" . rtrim($naziv) . "'>STATISTIKA</a></td>";
    }
}
echo "</tbody>";
echo "</table>";


echo "<br/>";
if ($aktivni_korisnik_tip == 0) echo '<a class="link" href="dodaj_parking.php">DODAJ PARKING</a>';
?>

<?php
zatvoriVezuNaBazu($bp);
include("podnozje.php");
?>