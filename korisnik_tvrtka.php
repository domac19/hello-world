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

if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1) {
    $korisnik_id = $_SESSION['aktivni_korisnik_id'];

    $sql = "SELECT naziv FROM tvrtka WHERE moderator_id = $korisnik_id";
    $rs = izvrsiUpit($bp, $sql);
    list($naziv_tvrtke) = mysqli_fetch_array($rs);

    $sqli = "SELECT ime, prezime FROM korisnik, partner, tvrtka
WHERE korisnik.korisnik_id = partner.korisnik_id AND partner.tvrtka_id = tvrtka.tvrtka_id AND partner.tvrtka_id IN (SELECT tvrtka_id FROM tvrtka WHERE moderator_id = $korisnik_id);";

    $result = izvrsiUpit($bp, $sqli);
}

echo "<h2>Vaša tvrtka: $naziv_tvrtke</h2>";

if (mysqli_num_rows($result) == 0) echo "Vaša tvrtka nema nijednog partnera.";
else {
    echo "<table>";
    echo "<caption>Partneri vaše tvrtke</caption>";
    echo "<thead><tr>
            <th>Ime i prezime partnera</th>
            <th></th>
            <th></th>";
    echo "</tr></thead>";

    echo "<tbody>";
    while (list($ime, $prezime) = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $ime . " " . $prezime . "</td>";
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
