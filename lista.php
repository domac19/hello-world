<?php
include("zaglavlje.php");
$bp = spojiSeNaBazu();
?>

<head>
    <meta charset="utf-8">
</head>
<h2>Napomena</h2>
<p>Datumi se unose u formatu dd.mm.yyyy., npr. 10.10.2020.,
    za pretragu unesite pravilan datum i vrijeme !</p>
<br />

<?php
$query = "SELECT partner_id FROM partner, tvrtka
            WHERE partner.tvrtka_id = tvrtka.tvrtka_id
            AND tvrtka.moderator_id = " . $_SESSION['aktivni_korisnik_id'];
$result = izvrsiUpit($bp, $query);

if (mysqli_num_rows($result) == 0 and $aktivni_korisnik_tip == 1) echo "Vaša tvrtka nema nijednog partnera pa nema ni evidencije dolazaka/odlazaka automobila. Dodajte partnera na listi <a href='korisnici.php'>registriranih korisnika.</a>";
else {
?>

    <body>
        <form name="lista" action="lista.php" method="post">
            <p>
                <h3>Dolazak automobila</h3>
            </p>
            Upisi datum:<br>
            <input type="text" name="date_from" onclick="setDate(this)">
            <th> </th>
            <br>
            Upisi vrijeme:<br>
            <input type="text" name="time_from" onclick="setTime(this)">
            <th></th>
            <p>
                <h3>Odlazak automobila</h3>
            </p>
            Upisi datum:<br>
            <input type="text" name="date_to" onclick="setDate(this)">
            <th></th>
            <br>
            Upisi vrijeme:<br>
            <input type="text" name="time_to" onclick="setTime(this)">
            <th></th>
            <p></p>
            <input type="submit">
            <input type="reset">
        </form>

    </body>
    <?php
    if (!isset($_SESSION['aktivni_korisnik'])) header("Location:index.php");
    if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1) {
    }
    if ($_SESSION['aktivni_korisnik_tip'] != 0 && $_SESSION['aktivni_korisnik_tip'] != 1) {
        header("Location:index.php");
    }

    $sql = "SELECT partner_id, registracija, datum_vrijeme_dolaska, datum_vrijeme_odlaska FROM automobil";

    if ($_SESSION['aktivni_korisnik_tip'] == 1) {
        $sqli = "SELECT p.partner_id
               FROM tvrtka t
               INNER JOIN partner p ON p.tvrtka_id=t.tvrtka_id
               WHERE t.moderator_id=" . $_SESSION['aktivni_korisnik_id'];
        $rezultat = izvrsiUpit($bp, $sqli);
        $partneri = "";
        $i = 0;
        $size = mysqli_num_rows($rezultat);
        while ($partner = mysqli_fetch_array($rezultat)) {
            $partneri = $partneri . $partner[0];
            if ($i != $size - 1) {
                $partneri = $partneri . ",";
            }
            $i++;
        }

        $sql = $sql . " WHERE partner_id IN (" . $partneri . ")";
    }
    if (isset($_POST['date_from']) && isset($_POST['date_to'])) {

        $date_from = $_POST['date_from'];
        $date_to = $_POST['date_to'];
        $time_from = $_POST['time_from'];
        $time_to = $_POST['time_to'];

        $date_from = date("Y-m-d", strtotime($date_from));
        $date_to = date("Y-m-d", strtotime($date_to));

        $od = $date_from . " " . $time_from;
        $do = $date_to . " " . $time_to;

        if ($_SESSION['aktivni_korisnik_tip'] == 1) {
            $sql = $sql . " AND datum_vrijeme_odlaska BETWEEN '$od' AND '$do'";
        } else if ($_SESSION['aktivni_korisnik_tip'] == 0) {
            $sql = $sql . " WHERE datum_vrijeme_odlaska BETWEEN '$od' AND '$do'";
        }
    }
    $rs = izvrsiUpit($bp, $sql);
    echo "<table>";
    if ($aktivni_korisnik_tip == 0) echo "<caption>Popis dolazaka i odlazaka automobila svih partnera</caption>";
    if ($aktivni_korisnik_tip == 1) echo "<caption>Popis dolazaka i odlazaka partnera vaše tvrtke</caption>";
    echo "<thead><tr>
		<th>Ime i prezime partnera</th>
		<th>Registracija</th>
		<th>Dolazak</th>
        <th>Odlazak</th>";
    echo "</tr></thead>";


    echo "<tbody>";
    while (list($partner_id, $registracija, $dolazak, $odlazak) = mysqli_fetch_array($rs)) {

        $sql2 = "SELECT ime, prezime FROM korisnik, partner
            WHERE korisnik.korisnik_id = partner.korisnik_id
            AND partner.partner_id = $partner_id";
        $rs2 = izvrsiUpit($bp, $sql2);
        list($ime, $prezime) = mysqli_fetch_array($rs2);

        $izmjenjeni_dolazak = date("d.m.Y. h:i:s", strtotime($dolazak));

        if ($odlazak != "0000-00-00 00:00:00") {
            $izmjenjeni_odlazak = date("d.m.Y. h:i:s", strtotime($odlazak));
        } else {
            $izmjenjeni_odlazak = "00.00.0000. 00:00:00";
        }
        echo "<tr>";
        echo "<td>" . $ime . " " . $prezime . "</td>
            <td>" . $registracija . "</td>
            <td>" . $izmjenjeni_dolazak . "</td>
            <td>" . $izmjenjeni_odlazak . "</td>";
    }
    echo "</tbody>";
    echo "</table>";
    ?>
<?php
}
zatvoriVezuNaBazu($bp);
include("podnozje.php");
?>