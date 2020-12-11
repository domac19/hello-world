<?php

include("baza.php");

if (session_id() == "") session_start();

$trenutna = basename($_SERVER["PHP_SELF"]);
$putanja = $_SERVER['REQUEST_URI'];
$aktivni_korisnik = 0;
$aktivni_korisnik_tip = -1;
$vel_str = 5;
$vel_str_video = 20;
if (isset($_SESSION['aktivni_korisnik'])) {
    $aktivni_korisnik = $_SESSION['aktivni_korisnik'];
    $aktivni_korisnik_ime = $_SESSION['aktivni_korisnik_ime'];
    $aktivni_korisnik_tip = $_SESSION['aktivni_korisnik_tip'];
    $aktivni_korisnik_id = $_SESSION["aktivni_korisnik_id"];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Projekt_za_rok</title>
    <meta name="autor" content="IWA Webmaster" />
    <meta name="datum" content="03.02.2020." />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="dizajn.css" type="text/css">

    <script type="text/javascript">
        function setDate(text) {
            var currentTime = new Date();
            var month = currentTime.getMonth() + 1;
            var day = currentTime.getDate();
            var year = currentTime.getFullYear();

            text.value = day + "." + month + "." + year + ".";
        }

        function setTime(text) {
            var currentTime = new Date();
            var hour = currentTime.getHours();
            var minute = currentTime.getMinutes();
            var seconds = currentTime.getSeconds();

            text.value = hour + ":" + minute + ":" + seconds;
        }
    </script>

</head>

<body onload="forma();">
    <header>
        <span>
            <a href="o_autoru.html">Autor projekta</a><br>
            <strong>Izgradnja Web aplikacija - Parkiraliste</strong>
            <br />
            <?php
            echo "<strong>Trenutna lokacija: </strong>" . $trenutna . "<br/>";
            if ($aktivni_korisnik === 0) {
                echo "<span><strong>Status: </strong>Neprijavljeni korisnik</span><br/>";
                echo "<a class='link' href='administrator.php'>prijava </a>";
            } else {
                echo "<span><strong>Status: </strong>Dobrodosli, $aktivni_korisnik_ime</span><br/>";
                echo "<a class='link' href='administrator.php?logout=1'>odjava</a>";
            }
            ?>
        </span>
    </header>
    <nav id="navigacija" class="menu">
        <?php
        switch (true) {
            case $trenutna:
                switch ($aktivni_korisnik_tip >= 0) {
                    case 'true':
                        echo '<a href="index.php">';
                        if ($trenutna == "index.php");
                        echo "POCETAK</a>";
                        echo '<a href="parking.php"';
                        if ($trenutna == "parking.php");
                        echo ">PARKIRALISTA</a>";
                        echo "<a href='partneri.php'>PARTNERI</a>";
                        break;

                    default:
                        echo '<a href="index.php">';
                        if ($trenutna == "index.php");
                        echo "POCETAK</a>";
                        echo '<a href="parking.php"';
                        if ($trenutna == "parking.php");
                        echo ">PARKIRALISTA</a>";
                        break;
                }

            default:
                break;
        }
        if ($aktivni_korisnik_tip == 0 || $aktivni_korisnik_tip == 1) {
            echo '<a href="korisnici.php"';
            if ($trenutna == "korisnici.php");
            echo ">REGISTRIRANI KORISNICI</a>";
            echo '<a href="lista.php"';
            if ($trenutna == "lista.php");
            echo ">LISTA</a>";
        }
        if ($aktivni_korisnik_tip == 0) {
            echo '<a href="tvrtke.php"';
            if ($trenutna == "tvrtke.php");
            echo ">TVRTKE</a>";
        }
        if ($aktivni_korisnik_tip == 1) {
            echo '<a href="korisnik_tvrtka.php"';
            if ($trenutna == "korisnik_tvrtka.php");
            echo ">KORISNIK TVRTKE</a>";
        }
        ?>
    </nav>
    <section id="sadrzaj">