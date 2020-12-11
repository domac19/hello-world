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

	$sql="SELECT COUNT(*) FROM tip_korisnika";
	$rs=izvrsiUpit($bp,$sql);
	$red=mysqli_fetch_array($rs);
	$broj_redaka=$red[0];
	$broj_stranica=ceil($broj_redaka/$vel_str);


	$sql="SELECT * FROM tip_korisnika ORDER BY tip_id LIMIT ".$vel_str;
	if(isset($_GET['stranica'])){
		$sql=$sql." OFFSET ".(($_GET['stranica']-1)*$vel_str);
		$aktivna=$_GET['stranica'];
	}
	else $aktivna = 1;

	$rs=izvrsiUpit($bp,$sql);
	echo "<table>";
	echo "<caption>Tipovi korisnika</caption>";
	echo "<thead><tr>
		<th>Broj</th>
		<th>Naziv</th>
		<th></th>";
	echo "</tr></thead>";
	echo "<tbody>";
	while(list($id,$naziv)=mysqli_fetch_array($rs)){
		echo "<tr>
			<td>$id</td>
			<td>$naziv</td>";
			 echo "<td></td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";


	echo '<div id="paginacija">';
	if($aktivna!=1){
		$prethodna=$aktivna-1;
		echo "<a class='link' href=\"tip_korisnika.php?stranica=".$prethodna."\">&lt;</a>";
	}
	for($i=1;$i<=$broj_stranica;$i++){
		echo "<a class='link";
		if($aktivna==$i)echo " aktivna"; 
		echo "' href=\"tip_korisnika.php?stranica=".$i."\">$i</a>";
	}
	if($aktivna<$broj_stranica){
		$sljedeca=$aktivna+1;
		echo "<a class='link' href=\"tip_korisnika.php?stranica=".$sljedeca."\">&gt;</a>";
	}
	echo "<br/>";
	echo '</div>';
?>

<?php
	zatvoriVezuNaBazu($bp);
	include("podnozje.php");
?>
