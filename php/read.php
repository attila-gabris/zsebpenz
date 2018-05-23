<?php
require("connect.php");

$targy_id = (isset($_POST['targy'])) ? $_POST['targy'] : "";
if ($targy_id != "") {
    $targy_id = (int) $targy_id;
}
$oszlop = (isset($_POST['oszlop'])) ? $_POST['oszlop'] : "datum";
$sorrend = (isset($_POST['sorrend'])) ? $_POST['sorrend'] : "DESC";

if ($sorrend == "ASC" || $sorrend == "DESC" && $oszlop == "datum" || $oszlop == "ttargy" ||
$oszlop == "osztalyzat" || $oszlop == "tipus") {

    if ($oszlop != "datum") {
        $sorrend.= ", datum DESC";
    }


    $sql = "SELECT osztalyzatok.id AS id, 
        osztalyzatok.datum AS datum, 
        osztalyzatok.targy AS targyid,
        tantargyak.targy_nev AS ttargy, 
        osztalyzatok.osztalyzat AS osztalyzat, 
        osztalyzatok.osztalyzat_tipus AS tipusid,
        osztalyzat_tipusok.osztalyzat_tipus_nev AS tipus
        FROM osztalyzatok
        JOIN tantargyak ON osztalyzatok.targy=tantargyak.id
        JOIN osztalyzat_tipusok ON osztalyzatok.osztalyzat_tipus=osztalyzat_tipusok.id ";

    if ($targy_id != "") {
        $sql.= "WHERE osztalyzatok.targy = '{$targy_id}' ";
    }

    $sql.= "ORDER BY {$oszlop} {$sorrend}";

    $eredmeny = mysqli_query($dbconn, $sql);

    $kimenet = "";

    while ($sor = mysqli_fetch_assoc($eredmeny)) {
        $kimenet.= "<tr>
                    <td class='id'>{$sor['id']}</td>
                    <td class='datum'>{$sor['datum']}</td>
                    <td class='ttargy' data-id='{$sor['targyid']}'>{$sor['ttargy']}</td>
                    <td class='osztalyzat'>{$sor['osztalyzat']}</td>
                    <td class='tipus' data-id='{$sor['tipusid']}'>{$sor['tipus']}</td>
                    <td><button class='btn btn-outline-dark btn-sm edit'>Módosítás</button>
                    <button class='btn btn-outline-danger btn-sm delete'>Törlés</button></td>
                </tr>\n";
    }

    print $kimenet;
}

mysqli_close($dbconn);
