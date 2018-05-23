<?php
require("connect.php");

$sql = "SELECT id, osztalyzat_tipus_nev AS nev FROM osztalyzat_tipusok ORDER BY nev";
$eredmeny = mysqli_query($dbconn, $sql);

$kimenet = "";
while ($sor = mysqli_fetch_assoc($eredmeny)) {
    $kimenet.= "<option value='{$sor['id']}''>{$sor['nev']}</option>";
}

print $kimenet;

mysqli_close($dbconn);
