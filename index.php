<?php
	include("zaglavlje.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<article>
	<div id="opis">
		<h2>Parkiraliste</h2>
		<p>Na ovoj web stranici cemo biti upoznati sa nekim od sudionika parkinga za odredenu tvrtku.<br/>
		   Ova web aplikacija sluzi za rezerviranje automobila na odredenom parkiralistu.</p>
	</div>
	<br/>
	<table>
		<caption>Datoteke sustava</caption>
		<thead>
			<tr>
				<th class="lijevi">Popis datoteka</th>
				<th>Opis datoteka</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>baza.php</td>
				<td>Skripta za rad s bazom podataka</td>
			</tr>
			<tr>
				<td>index.php</td>
				<td>Pregled za anonimnog korisnika</td>
			</tr>
			<tr>
				<td>zaglavlje.php</td>
				<td>Zaglavlje, sve ostale datoteke je ukljucuju, sadrzi meni i ukljucuje css</td>
			</tr>
			<tr>
				<td>auto.php</td>
				<td>Tablica automobila koji se nalaze na nekom parkingu</td>
			</tr>
			<tr>
				<td>automobil.php</td>
				<td>Obrazac za azuriranje automobila i dodavanje novih putem registracijske oznake</td>
			</tr>
			<tr>
				<td>dizajn.css</td>
				<td>Dizajn web aplikacije</td>
			</tr>
			<tr>
				<td>korisnici.php</td>
				<td>Tablica koja izlistava korisnike, ako je tip korisnika administrator ili zaposlenik postoji mogucnost dodavanja novog korisnika</td>
			</tr>
			<tr>
				<td>parking.php</td>
				<td>Tablica koja izlistava sadrzaje koji se mogu posuditi, obicni korisnik ima mogucnost posudbe</td>
			</tr>
			<tr>
				<td>parkiraliste.php</td>
				<td>Tablica koja izlistava posudbe svih korisnika ako je tip administrator ili zaposlenik, mogucnost unosa nove posudbe i filtriranja prema korisniku ili datumu; za obicnog korisnika izlistava njegove posudbe</td>
			</tr>
			<tr>
				<td>korisnik.php</td>
				<td>Obrazac za unos novog ili uredivanje postojeceg korisnika</td>
			</tr>
			<tr>
				<td>tvrtka.php</td>
				<td>Obrazac za unos tvrtke i moderatora te azuriranje postojece tvrtke i moderatora</td>
			</tr>
			<tr>
				<td>tvrtke.php</td>
				<td>Tablica tvrtki i moderatora zaduzenih za jednu tvrtku</td>
			</tr>
			<tr>
				<td>podnozje.php</td>
				<td>Podnozje, sve ostale datoteke je ukljucuju, ukljucuje css</td>
			</tr>
			<tr>
				<td>administrator.php</td>
				<td>Obrazac za prijavu u sustav kao Administrator</td>
			</tr>
			<tr>
				<td>o_autoru.html</td>
				<td>Podaci o autoru projekta</td>
			</tr>
			<tr>
				<td>lista.php</td>
				<td>Lista automobila na parkiralistu s formom trazenja</td>
			</tr>
			<tr>
				<td>partner_korisnika.php</td>
				<td>Skripta dodavanja partnera korisnika</td>
			</tr>
			<tr>
				<td>tvrtka_parkiralista.php</td>
				<td>Skripta tvrtke za odredeno parkiraliste</td>
			</tr>
			<tr>
				<td>statistika.php</td>
				<td>Statisticki podaci za tvrtke i parkiralista</td>
			</tr>
			<tr>
				<td>partneri.php</td>
				<td>Tablica u kojoj se nalaze partner tvrtke i preko koje korisnik rezervira mjesto na parkingu</td>
			</tr>
			<tr>
				<td>korisnik_tvrtka.php</td>
				<td>Tablica u kojoj se nalazi naziv tvrtke te moderator zaduzen za jednu tvrtku</td>
			</tr>
			<tr>
				<td>dodaj_parking.php</td>
				<td>Obrazac za dodavanje parkiralista</td>
			</tr>
			<tr>
				<td>dodaj_tvrtku.php</td>
				<td>Obrazac za dodavanje tvrtke i za dodavanje moderatora za jednu tvrtku</td>
			</tr>
		</tbody>
	</table>
</article>
</html>
<?php
	include("podnozje.php");
?>
