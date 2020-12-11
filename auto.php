<?php
	include("zaglavlje.php");
	$bp=spojiSeNaBazu();
?>
<head>
<meta charset="utf-8">
</head>
<?php
	if(!isset($_SESSION['aktivni_korisnik']))header("Location:index.php");
	if($aktivni_korisnik_tip==0||$aktivni_korisnik_tip==1){
		}

	if(isset($_SESSION['aktivni_korisnik'])){
    $aktivni_korisnik_id=$_SESSION["aktivni_korisnik_id"];
    $aktivni_korisnik_tip=$_SESSION['aktivni_korisnik_tip'];
	} else {
        header("Location:index.php");
    }
	if(isset($_GET['automobil_id'])) {
    $sqlu = "UPDATE automobil SET
                datum_vrijeme_odlaska = now() 
                WHERE automobil_id=".$_GET['automobil_id'];
    izvrsiUpit($bp, $sqlu);
    } 	
    
    $tvrtka_id=$_GET['tvrtka_id'];

    $sqli = "SELECT partner_id 
                    FROM partner 
                    WHERE tvrtka_id = ".$tvrtka_id." AND korisnik_id = ".$_SESSION['aktivni_korisnik_id'];

    list($partner_id) = mysqli_fetch_array(izvrsiUpit($bp, $sqli));

    $sql = "SELECT a.automobil_id, a.registracija, a.datum_vrijeme_dolaska, a.datum_vrijeme_odlaska
            FROM partner p 
            INNER JOIN automobil a ON a.partner_id = p.partner_id 
            WHERE p.tvrtka_id = ".$tvrtka_id;

    if($_SESSION['aktivni_korisnik_tip'] == 2) {
        $sql = $sql." AND a.partner_id = ".$partner_id;
    }
    $rs = izvrsiUpit($bp, $sql);

 	echo "<table>";
	echo "<caption>Popis automobila</caption>";
	echo "<thead><tr>
		<th>Registracija</th>
		<th>Datum_dolaska</th>
		<th>Datum_odlaska</th>
		<th></th>";
	echo "</tr></thead>";
	echo "<tbody>";
	while(list($automobil_id,$registracija,$dolazak,$odlazak)=mysqli_fetch_array($rs)){
        $izmjenjeni_dolazak = date("d.m.Y. H:i:s", strtotime($dolazak));
        
 		if ($odlazak != "0000-00-00 00:00:00"){
            $izmjenjeni_odlazak = date("d.m.Y. H:i:s", strtotime($odlazak));    
        } else {
            $izmjenjeni_odlazak = "0000-00-00 00:00:00";
        }
		echo "<tr>";
			echo "<td>".$registracija."</td>
				  <td>".$izmjenjeni_dolazak."</td>
				  <td>".$izmjenjeni_odlazak."</td>";
			if($izmjenjeni_odlazak == "0000-00-00 00:00:00"){
                echo "<td><a class='link' href='auto.php?automobil_id=$automobil_id&tvrtka_id=$tvrtka_id'>ODJAVA</a>";
            }

		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
	echo "<a class='link' href='automobil.php?tvrtka_id=$tvrtka_id'>DODAJ</a>";
?>

<?php
	zatvoriVezuNaBazu($bp);
	include("podnozje.php");
?>
