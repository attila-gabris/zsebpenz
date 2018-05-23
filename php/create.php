<?php
require("connect.php");

$ujdatum = $_POST['ujdatum'];
$date_test = explode('-', $ujdatum);
$ujtargy = (int) $_POST['ujtargy'];
$ujosztalyzat = (int) $_POST['ujosztalyzat'];
$ujtipus = (int) $_POST['ujtipus'];


$sql1 = "SELECT zsebpenz FROM osztalyzat_zsebpenz WHERE osztalyzat = '{$ujosztalyzat}'";
$eredmeny = mysqli_query($dbconn, $sql1);
$sor = mysqli_fetch_assoc($eredmeny);
$ertek = $sor['zsebpenz'];

if (checkdate($date_test[1], $date_test[2], $date_test[0])) {
    $sql = "INSERT INTO osztalyzatok (datum, targy, osztalyzat, osztalyzat_tipus, ertek)
        VALUES ('{$ujdatum}', '{$ujtargy}', '{$ujosztalyzat}', '{$ujtipus}', '{$ertek}')";
    mysqli_query($dbconn, $sql);
}

mysqli_close($dbconn);