<?php
require("connect.php");

//Kezdő dátum és heti alap
$sql_alap = "SELECT * FROM alap_adatok WHERE id = 1";
$eredmeny_alap = mysqli_query($dbconn, $sql_alap);
$alap_tomb = mysqli_fetch_assoc($eredmeny_alap);
$kezdo_datum = $alap_tomb['kezdo_datum'];
$heti_alap = $alap_tomb['heti_alap'];

//Az osztályzatok értékének összesítése
$sql_ertek = "SELECT SUM(ertek) FROM osztalyzatok WHERE datum >= '{$kezdo_datum}'";
$eredmeny_sum_ertek = mysqli_query($dbconn, $sql_ertek);
$jegy_total_tomb = mysqli_fetch_assoc($eredmeny_sum_ertek);
$jegy_total = $jegy_total_tomb['SUM(ertek)']; 

//Heti alap a kezdő dátum óta
$datum_tomb = explode('-', $kezdo_datum);
$start_date = mktime(0,0,0,$datum_tomb[1],$datum_tomb[2],$datum_tomb[0]);
$today = time();
$weeks = ceil(abs($today - $start_date) / 60 / 60 / 24 / 7);
$alap = $weeks * $heti_alap;

//Összeg
$total = $jegy_total + $alap;

//Kifizetések
$sql_kifiz = "SELECT SUM(osszeg) FROM kifizetesek WHERE datum >= '{$kezdo_datum}'";
$eredmeny_kifiz = mysqli_query($dbconn, $sql_kifiz);
$kifiz_tomb = mysqli_fetch_assoc($eredmeny_kifiz);
$kifiz_total = $kifiz_tomb['SUM(osszeg)'];

//Egyenleg
$kimenet = $total - $kifiz_total;

print $kimenet;

mysqli_close($dbconn);