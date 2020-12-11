<?php
include("zaglavlje.php");
$bp = spojiSeNaBazu();
?>

<?php
if (!isset($_SESSION['aktivni_korisnik'])) header("Location:index.php");
if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1) {
}
if (isset($_SESSION['aktivni_korisnik'])) {
    $aktivni_korisnik_id = $_SESSION["aktivni_korisnik_id"];
    $aktivni_korisnik_tip = $_SESSION['aktivni_korisnik_tip'];
} else {
    header("Location:index.php");
}

$korisnik_id = $_SESSION['aktivni_korisnik_id'];

$sqli = "SELECT t.tvrtka_id, t.naziv, t.opis, p.naziv, p.adresa
             FROM tvrtka t
             INNER JOIN parkiraliste p ON p.parkiraliste_id = t.parkiraliste_id
             INNER JOIN partner pa ON pa.korisnik_id=$korisnik_id
            AND t.tvrtka_id=pa.tvrtka_id";

// if ($aktivni_korisnik_tip == 2) {
//     $sqli = $sqli . " INNER JOIN partner pa ON pa.korisnik_id=$korisnik_id
//                             AND t.tvrtka_id=pa.tvrtka_id";
// } else if ($aktivni_korisnik_tip == 1) {
//     $sqli = $sqli . " WHERE t.moderator_id=$korisnik_id";
// }


$result = izvrsiUpit($bp, $sqli);

if (mysqli_num_rows($result) == 0) echo "Niste partner u nijednoj tvrtki.";
else {
    echo "<table>";
    echo "<caption>Popis tvrtki gdje ste partner</caption>";
    echo "<thead><tr>
		<th>Naziv</th>
		<th>Opis</th>
        <th>Naziv parkiralista</th>
        <th>Adresa</th>";
    echo "</tr></thead>";

    echo "<tbody>";
    while (list($tvrtka_id, $company_name, $description, $parking_spot_name, $parking_spot_adress) = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $company_name . "</td>
            <td>" . $description . "</td>
            <td>$parking_spot_name</td>
            <td>" . $parking_spot_adress . "</td>
            <td><a class='link' href='auto.php?tvrtka_id=$tvrtka_id'>PRIJAVI AUTOMOBIL</a>";

        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
?>
<?php
zatvoriVezuNaBazu($bp);
include("podnozje.php");
?>
