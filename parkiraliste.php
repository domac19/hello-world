<?php
include("zaglavlje.php");
$bp = spojiSeNaBazu();
?>
<?php
if (!isset($_SESSION['aktivni_korisnik'])) header("Location:index.php");
if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1) {
}

if (isset($_SESSION['aktivni_korisnik'])) {
    $active_user_id = $_SESSION["aktivni_korisnik_id"];
    $active_user_type = $_SESSION['aktivni_korisnik_tip'];
}

if (isset($_POST['name']) && isset($_POST['adress']) && isset($_POST['picture'])) { {
        foreach ($_POST as $key => $value)
            $parkingName = $_POST['name'];
        $parkingAdress = $_POST['adress'];
        $parkingPicture = $_POST['picture'];
        $parkingVideo = $_POST['video'];
        $parkingId = $_POST['id'];

        $sql = "UPDATE parkiraliste SET
					naziv='$parkingName',
					adresa='$parkingAdress',
					slika='$parkingPicture',
					video='$parkingVideo'
                    WHERE parkiraliste_id=" . $parkingId;
    }
    izvrsiUpit($bp, $sql);
    header("Location:parking.php");
}


?>
<form action="parkiraliste.php" method="post">
    <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
    <table>
        <tbody>
            <tr>
                <td class="lijevi">
                    <label for="naziv"><strong>Naziv parkirališta:</strong></label>
                </td>
                <td>
                    <input type="text" name="name" value="<?php echo $_GET['naziv']; ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="adresa"><strong>Adresa parkirališta:</strong></label>
                </td>
                <td>
                    <input type="text" name="adress" value="<?php echo $_GET['adresa']; ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="slika"><strong>Slika:</strong></label>
                </td>
                <td>
                    <input type="url" name="picture" value="<?php echo $_GET['slika']; ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="video"><strong>Video:</strong></label>
                </td>
                <td>
                    <input type="url" name="video" value="<?php echo $_GET['video']; ?>">
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