<?php
include("zaglavlje.php");
$bp = spojiSeNaBazu();
?>

<head>
    <meta charset="utf-8">
</head>
<?php
$id = $_GET['id'];

$sql = "SELECT slika, video
          FROM parkiraliste
          WHERE parkiraliste_id=" . $id;

$rs = izvrsiUpit($bp, $sql);

list($slika, $video) = mysqli_fetch_array($rs);
echo "<table>
        <thead><tr>
		<th>Slika</th>
		<th>Video</th>
        </tr></thread>
        <tbody>
        <tr>
            <td><img style='width: 300px;' src=" . $slika . " /></td>
            <td><video style='width: 500px;' src=" . $video . " controls></video></td>
        </tr>
        </tbody>
        </table>";

$sql = "SELECT t.naziv, t.opis 
        FROM tvrtka t 
        WHERE t.parkiraliste_id=" . $id;

$rezultat = izvrsiUpit($bp, $sql);
echo "<table>";
echo "<caption>TVRTKE PARKIRALISTA</caption>";
echo "<thead><tr>
		<th>Naziv</th>
		<th>Opis</th>";
echo "</tr></thead>";

echo "<tbody>";
while (list($naziv, $opis) = mysqli_fetch_array($rezultat)) {
    echo "<tr>";
    echo "<td>" . $naziv . "</td>
            <td>" . $opis . "</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
?>
<?php
zatvoriVezuNaBazu($bp);
include("podnozje.php");
?>