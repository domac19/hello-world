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
    $korisnik_id = $_GET['korisnik_id'];
    $aktivan_id = $_GET['aktivna'];
}

if ($_SESSION['aktivni_korisnik_tip'] != 0 && $_SESSION['aktivni_korisnik_tip'] != 1) {
    header("Location:index.php");
}

if (isset($_POST['korisnik']) && isset($_POST['tvrtka'])) {
    $korisnik_id = $_POST['korisnik'];
    $tvrtka_id = $_POST['tvrtka'];

    $sql = "SELECT * FROM partner";
    $partner_id = mysqli_num_rows(izvrsiUpit($bp, $sql));
    $partner_id++;

    $sql = "INSERT INTO partner 
                (partner_id, korisnik_id, tvrtka_id)
                VALUES 
                ('$partner_id', '$korisnik_id', '$tvrtka_id')";

    izvrsiUpit($bp, $sql);
    header("Location:korisnici.php");
}
?>
<form action="partner_korisnika.php" method="post">
    <input type="hidden" name="korisnik" value="<?php echo $_GET['korisnik_id'] ?>">
    <input type="hidden" name="aktivni" value="<?php echo $_GET['aktivna'] ?>">
    <h4><b>Tvrtka</b></h4><select name="tvrtka"><br>
        <?php
        $sqlu = "SELECT moderator_id, tvrtka_id, parkiraliste_id, naziv, opis 
                    FROM tvrtka";
        if ($_SESSION['aktivni_korisnik_tip'] == 1) {
            $sqlu = $sqlu . " WHERE moderator_id=" . $_GET['aktivna'];
        }
        $rezultat = izvrsiUpit($bp, $sqlu);
        while (list($moderator_id, $tvrtka_id, $parkiraliste_id, $ime, $opis) = mysqli_fetch_array($rezultat)) {
            // provjeravamo da li je korisnik kojeg gledamo partner u nekoj tvrtci, ta se tvrtka neće ispisati u listi
            $sql2 = "SELECT tvrtka_id FROM partner WHERE korisnik_id = $korisnik_id AND tvrtka_id = $tvrtka_id";
            $rs = izvrsiUpit($bp, $sql2);

            if (mysqli_num_rows($rs) == 0) echo "<option value=" . $tvrtka_id . ">" . $ime . " " . $opis . "</option>";
        }
        ?>
    </select>
    <br>
    <input type="submit">
    <?php
    zatvoriVezuNaBazu($bp);
    include("podnozje.php");
    ?>