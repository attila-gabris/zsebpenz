<?php
require("connect.php");

$filter = $_POST['filter'];

$sql = "SELECT id, targy_nev FROM tantargyak ORDER BY targy_nev";
$eredmeny = mysqli_query($dbconn, $sql);

if ($filter == "targyfilter") {
    $kimenet = "<option value=\"\">minden tantárgy</option>";
} else {
    $kimenet = "";
}

while ($sor = mysqli_fetch_assoc($eredmeny)) {
    $kimenet.= "<option value='{$sor['id']}'>{$sor['targy_nev']}</option>";
}

print $kimenet;

mysqli_close($dbconn);
