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
$sql = "SELECT COUNT(*) FROM korisnik";
$rs = izvrsiUpit($bp, $sql);
$red = mysqli_fetch_array($rs);
$broj_redaka = $red[0];
$broj_stranica = ceil($broj_redaka / $vel_str);


$sql = "SELECT * FROM korisnik ORDER BY korisnik_id LIMIT " . $vel_str;
if (isset($_GET['stranica'])) {
    $sql = $sql . " OFFSET " . (($_GET['stranica'] - 1) * $vel_str);
    $aktivni = $_GET['stranica'];
} else $aktivni = 1;

$rs = izvrsiUpit($bp, $sql);
echo "<table>";
echo "<caption>Popis korisnika sustava</caption>";
echo "<thead><tr>
		<th>Korisničko ime</th>
		<th>Ime</th>
		<th>Prezime</th>
		<th>E-mail</th>
		<th>Lozinka</th>
		<th>Slika</th>
		<th></th>";
echo "</tr></thead>";
echo "<tbody>";
while (list($id, $tip, $kor_ime, $lozinka, $ime, $prezime, $email, $slika) = mysqli_fetch_array($rs)) {
    echo "<tr>
			<td>$kor_ime</td>
			<td>$ime</td>";
    echo "<td>" . (empty($prezime) ? "&nbsp;" : "$prezime") . "</td>
			<td>" . (empty($email) ? "&nbsp;" : "$email") . "</td>
			<td>$lozinka</td>
			<td><figure><img src='$slika' width='70' height='100' alt='Slika korisnika $ime $prezime'/></figure></td>";

    $aktivni = $_SESSION['aktivni_korisnik_id'];

    if ($aktivni_korisnik_tip == 0) echo "<td><a class='link' href='korisnik.php?korisnik=$id'>UREDI</a></td>";
    else if (isset($_SESSION["aktivni_korisnik_id"]) && $_SESSION["aktivni_korisnik_id"] == $id) echo '<td><a class="link" href="korisnik.php?korisnik=' . $_SESSION["aktivni_korisnik_id"] . '">UREDI</a></td>';

    if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1) {
        // partneri tvrke od moderatora
        $sql2 = "SELECT korisnik_id FROM partner, tvrtka 
        WHERE partner.tvrtka_id = tvrtka.tvrtka_id 
        AND tvrtka.moderator_id = $aktivni
        AND partner.korisnik_id = $id";
        $rs2 = izvrsiUpit($bp, $sql2);

        list($partner_id) = mysqli_fetch_array($rs2);

        // ne ispisivati jer bi se onda više puta dodao isti korisnik kao partner
        if ($partner_id != $id) echo "<td><a class='link' href='partner_korisnika.php?korisnik_id=$id&aktivna=$aktivni'>PARTNER</a></td>";
    } else echo "<td></td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";


echo '<div>';
if ($aktivni != 1) {
    $prethodna = $aktivni - 1;
    echo "<a class='link' href=\"korisnici.php?stranica=" . $prethodna . "\">&lt;</a>";
}
for ($i = 1; $i <= $broj_stranica; $i++) {
    echo "<a class='link";
    if ($aktivni == $i) echo " aktivna";
    echo "' href=\"korisnici.php?stranica=" . $i . "\">$i</a>";
}
if ($aktivni < $broj_stranica) {
    $sljedeca = $aktivni + 1;
    echo "<a class='link' href=\"korisnici.php?stranica=" . $sljedeca . "\">&gt;</a>";
}
echo "<br/>";
if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1) echo '<a class="link" href="korisnik.php">DODAJ KORISNIKA</a>';
if (isset($_SESSION["aktivni_korisnik_id"])) echo '<a class="link" href="korisnik.php?korisnik=' . $_SESSION["aktivni_korisnik_id"] . '">UREDI MOJE PODATKE</a>';
echo '</div>';
?>

<?php
zatvoriVezuNaBazu($bp);
include("podnozje.php");
?>