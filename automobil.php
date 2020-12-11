<?php
include("zaglavlje.php");
$bp = spojiSeNaBazu();
?>
<?php
if (!isset($_SESSION['aktivni_korisnik'])) header("Location:index.php");
if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1) {
}

if (isset($_POST['registracija']) && strlen($_POST['registracija']) != 0 && !isset($_POST['partner'])) {
    $auto_registracija = $_POST['registracija'];
    $sql = "SELECT partner_id 
                    FROM partner 
                    WHERE korisnik_id=" . $_SESSION['aktivni_korisnik_id'] . " AND tvrtka_id =" . $_POST['tvrtka_id'];
    list($partner) = mysqli_fetch_array(izvrsiUpit($bp, $sql));

    $sqli = "INSERT INTO automobil
                 (partner_id,registracija,datum_vrijeme_dolaska,datum_vrijeme_odlaska)
                 VALUES
                 ('$partner','$auto_registracija', NOW(), '0000-00-00 00:00:00')";
    izvrsiUpit($bp, $sqli);
    header("Location:auto.php?tvrtka_id=" . $_POST['tvrtka_id']);
}

?>

<head>
    <meta charset="utf-8">
</head>
<h4>Dodaj registraciju</h4>
<form name="automobil" action="automobil.php" method="POST">
    <input type="hidden" name="tvrtka_id" value="<?php echo $_GET['tvrtka_id']; ?>">
    Registracija: <input type="text" name="registracija"><br>
    <input type="submit">
</form>
<?php
zatvoriVezuNaBazu($bp);
include("podnozje.php");
?>