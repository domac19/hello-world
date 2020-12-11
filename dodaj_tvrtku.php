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

if ($_SESSION['aktivni_korisnik_tip'] != 0) {
    header("Location:index.php");
}


if (isset($_POST['naziv']) && isset($_POST['parking']) && isset($_POST['mod'])) {
    $naziv = $_POST['naziv'];
    $opis = $_POST['opis'];
    $parkingId = $_POST['parking'];
    $moderator = $_POST['mod'];
    $sql = "INSERT INTO tvrtka
				(naziv, opis, parkiraliste_id, moderator_id)
				VALUES
				('$naziv','$opis','$parkingId','$moderator')";

    izvrsiUpit($bp, $sql);
    header("Location:tvrtke.php");
}

?>

<form action="dodaj_tvrtku.php" method="post">
    <table>
        <tbody>
            <tr>
                <td class="lijevi">
                    <label for="naslov"><strong>Naziv tvrtke:</strong></label>
                </td>
                <td>
                    <input type="text" required="required" name="naziv">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="adresa"><strong>Opis tvrtke:</strong></label>
                </td>
                <td>
                    <input type="text" name="opis">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="slika"><strong>Parkiraliste: </strong></label>
                </td>
                <td>
                    <select name="parking" required="required">
                        <?php
                        $sqlu = "SELECT parkiraliste_id, naziv
                    		FROM parkiraliste";

                        $result = izvrsiUpit($bp, $sqlu);
                        while (list($parking_id, $parking_name) = mysqli_fetch_array($result)) {
                            echo "<option value=" . $parking_id . ">" . $parking_name . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="video"><strong>Moderator:</strong></label>
                </td>
                <td>
                    <?php
                    $query = "SELECT korisnik_id, ime, prezime
                    			FROM korisnik
                   				 WHERE tip_id=1 and korisnik_id NOT IN (SELECT moderator_id FROM tvrtka)";

                    $rs = izvrsiUpit($bp, $query);
                    if (mysqli_num_rows($rs) == 0) echo '<strong>nema slobodnih moderatora, na <a href="korisnici.php" style="text-decoration: underline;">listi korisnika</a> dodajte novog</strong>';
                    else {
                    ?>
                        <select name="mod" required="required"><br>
                            <?php
                            while (list($user_id, $name, $surname) = mysqli_fetch_array($rs)) {
                                echo "<option value=" . $user_id . ">" . $name . " " . $surname . "</option>";
                            }
                            ?>
                        </select>
                    <?php
                    }
                    ?>
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