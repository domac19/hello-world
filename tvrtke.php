<?php
include("zaglavlje.php");
$bp = spojiSeNaBazu();
?>

<head>
    <meta charset="utf-8">
</head>
<?php
if (!isset($_SESSION['aktivni_korisnik'])) header("Location:index.php");
if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1) {
}

if (isset($_SESSION['aktivni_korisnik'])) {
    $aktivni_korisnik_id = $_SESSION["aktivni_korisnik_id"];
    $aktivni_korisnik_tip = $_SESSION['aktivni_korisnik_tip'];
}

if ($aktivni_korisnik_tip == 0) {
    $korisnikId = $_SESSION['aktivni_korisnik_id'];
    $sqli = "SELECT t.naziv, t.opis, p.naziv, p.adresa, k.ime, k.prezime, t.tvrtka_id, t.moderator_id, t.parkiraliste_id
                FROM tvrtka t
                INNER JOIN korisnik k ON t.moderator_id=k.korisnik_id
                INNER JOIN parkiraliste p ON t.parkiraliste_id=p.parkiraliste_id
                GROUP BY t.tvrtka_id";

    $result = izvrsiUpit($bp, $sqli);
}
echo "<table>";
echo "<caption>Popis tvrtki</caption>";
echo "<thead><tr>
		<th>Naziv</th>
		<th>Opis</th>
        <th>Naziv parkiralista</th>
        <th>Adresa</th>
        <th>Moderator</th>";
echo "</tr></thead>";


echo "<tbody>";
while (list($naziv, $opis, $parking_ime, $parking_adresa, $modime, $modprezime, $tvrtka_id, $moderator_id, $parking_id) = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $naziv . "</td>
            <td>" . $opis . "</td>
            <td>" . $parking_ime . "</td>
            <td>" . $parking_adresa . "</td>
            <td>" . $modime . " " . $modprezime . "</td>";
    if ($_SESSION['aktivni_korisnik_id'] == $moderator_id || $_SESSION['aktivni_korisnik_tip'] == 0) {
        echo "<td><a class='link' href='tvrtka.php?company_id=$tvrtka_id&mod_id=$moderator_id'>UREDI</a></td>";
    }
}
echo "</tbody>";
echo "</table>";
if ($aktivni_korisnik_tip == 0) {
    echo '<div><a class="link" href="dodaj_tvrtku.php">DODAJ TVRTKU</a></div>';
}
?>

<?php
zatvoriVezuNaBazu($bp);
include("podnozje.php");
?>