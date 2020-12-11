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

	$sql="SELECT COUNT(*) FROM partner";
	$rs=izvrsiUpit($bp,$sql);
	$red=mysqli_fetch_array($rs);
	$broj_redaka=$red[0];
	$broj_stranica=ceil($broj_redaka/$vel_str);


	$sql="SELECT * FROM partner ORDER BY partner_id LIMIT ".$vel_str;
	if(isset($_GET['stranica'])){
		$sql=$sql." OFFSET ".(($_GET['stranica']-1)*$vel_str);
		$aktivna=$_GET['stranica'];
	}
	else $aktivna = 1;

	$rs=izvrsiUpit($bp,$sql);
	echo "<table>";
	echo "<caption>Lista partnera tvrtki i korisnika sastavljena prema brojevima</caption>";
	echo "<thead><tr>
		<th>Broj partnera</th>
		<th>Broj korisnika</th>
		<th>Broj tvrtke</th>
		<th></th>";
	echo "</tr></thead>";
	echo "<tbody>";
	while(list($broj_partnera, $broj_korisnika, $broj_tvrtke)=mysqli_fetch_array($rs)){
		echo "<tr>
			<td>$broj_partnera</td>
			<td>$broj_korisnika</td>
			<td>$broj_tvrtke</td>";
			echo "</tr>";
		}
	echo "</tbody>";
	echo "</table>";


	echo '<div id="paginacija">';
	if($aktivna!=1){
		$prethodna=$aktivna-1;
		echo "<a class='link' href=\"partner.php?stranica=".$prethodna."\">&lt;</a>";
	}
	for($i=1;$i<=$broj_stranica;$i++){
		echo "<a class='link";
		if($aktivna==$i)echo " aktivna"; 
		echo "' href=\"partner.php?stranica=".$i."\">$i</a>";
	}
	if($aktivna<$broj_stranica){
		$sljedeca=$aktivna+1;
		echo "<a class='link' href=\"partner.php?stranica=".$sljedeca."\">&gt;</a>";
	}
?>

<?php
	zatvoriVezuNaBazu($bp);
	include("podnozje.php");
?>
