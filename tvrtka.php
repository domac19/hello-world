<?php
include("zaglavlje.php");
$bp = spojiSeNaBazu();
?>
<?php
if (!isset($_SESSION['aktivni_korisnik'])) header("Location:index.php");
if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1) {
}

if ($_SESSION['aktivni_korisnik_tip'] != 0 && $_SESSION["aktivni_korisnik_id"] != $_GET['mod_id']) {
    header("Location:index.php");
}

if (!isset($_POST['submit'])) {
    $tvrtka_id = $_GET['company_id'];
    $sql = "SELECT * FROM tvrtka WHERE tvrtka_id=" . $tvrtka_id;
    $result = izvrsiUpit($bp, $sql);
    list($tvrtka_id, $moderator_id, $parking_id, $naziv, $opis) = mysqli_fetch_array($result);
}

if (isset($_POST['name']) && isset($_POST['company_id'])) {
    $companyId = $_POST['company_id'];
    $companyName = $_POST['name'];
    $companyDescription = $_POST['description'];
    $parkingId = $_POST['parking'];
    $moderatorId = $_POST['mod'];

    $sql = "UPDATE tvrtka SET
              naziv='$companyName',
              opis='$companyDescription',
              moderator_id='$moderatorId',
              parkiraliste_id='$parkingId'
              WHERE tvrtka_id=" . $companyId;
    izvrsiUpit($bp, $sql);
    header("Location:tvrtke.php");
}


?>

<form action="tvrtka.php" method="post">
    <input type="hidden" name="company_id" value="<?php echo $_GET['company_id']; ?>">
    <table>
        <tbody>
            <tr>
                <td class="lijevi">
                    <label for="naziv"><strong>Naziv tvrtke:</strong></label>
                </td>
                <td>
                    <input type="text" name="name" value="<?php echo $naziv; ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="opis"><strong>Opis tvrtke:</strong></label>
                </td>
                <td>
                    <input type="text" name="description" value="<?php echo $opis; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="parkiraliste"><strong>Parkiraliste:</strong></label>
                </td>
                <td>
                    <select name="parking"><br>
                        <?php
                        $sqlu = "SELECT parkiraliste_id, naziv, adresa
                    				FROM parkiraliste";

                        $result = izvrsiUpit($bp, $sqlu);
                        while (list($parking, $parking_name, $adress) = mysqli_fetch_array($result)) {
                            $option = "<option value=" . $parking;
                            if ($parking_id == $parking) {
                                $option = $option . " selected='selected'";
                            }
                            echo $option . ">" . $parking_name . " " . $adress . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="moderator"><strong>Moderator:</strong></label>
                </td>
                <td>
                    <?php
                    $query = "SELECT korisnik_id, ime, prezime
                    				FROM korisnik
                    				WHERE tip_id=1 and korisnik_id NOT IN (SELECT moderator_id FROM tvrtka)";

                    $result = izvrsiUpit($bp, $query);
                    if (mysqli_num_rows($result) == 0) echo '<strong>nema slobodnih moderatora, na <a href="korisnici.php" style="text-decoration: underline;">listi korisnika</a> dodajte novog</strong>';
                    else {
                    ?>
                        <select name="mod">
                            <?php
                            while (list($user_id, $name, $surname) = mysqli_fetch_array($result)) {
                                $option = "<option value=" . $user_id;
                                if ($user_id == $mod_id) {
                                    $option = $option . " selected='selected'";
                                }
                                echo $option . ">" . $name . " " . $surname . "</option>";
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