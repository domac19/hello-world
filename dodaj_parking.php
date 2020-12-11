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
if (isset($_POST['name']) && isset($_POST['adress']) && isset($_POST['picture'])) {
    $naziv = $_POST['name'];
    $adresa = $_POST['adress'];
    $slika = $_POST['picture'];
    $video = $_POST['video'];
    $sql = "INSERT INTO parkiraliste
				(naziv,adresa,slika,video)
				VALUES
				('$naziv','$adresa','$slika','$video')";

    izvrsiUpit($bp, $sql);
    header("Location:parking.php");
}

?>
<form action="dodaj_parking.php" method="post">
    <table>
        <tbody>
            <tr>
                <td class="lijevi">
                    <label for="naslov"><strong>Naziv parkirališta:</strong></label>
                </td>
                <td>
                    <input type="text" required="required" name="name">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="adresa"><strong>Adresa parkirališta:</strong></label>
                </td>
                <td>
                    <input type="text" required="required" name="adress">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="slika"><strong>Slika:</strong></label>
                </td>
                <td>
                    <input type="url" required="required" name="picture">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="video"><strong>Video:</strong></label>
                </td>
                <td>
                    <input type="url" name="video">
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <input type="submit">
                </td>
            </tr>
        </tbody>
    </table>
</form>
<?php
zatvoriVezuNaBazu($bp);
include("podnozje.php");
?>