<?php
require("connect.php");

$sql = "SELECT id, datum, osszeg FROM kifizetesek ORDER BY datum DESC";

$eredmeny = mysqli_query($dbconn, $sql);

$kimenet = "";

while ($sor = mysqli_fetch_assoc($eredmeny)) {
    $kimenet.= "<tr>
                    <td class='id'>{$sor['id']}</td>
                    <td class='datum'>{$sor['datum']}</td>
                    <td class='osszeg'>{$sor['osszeg']}</td>
                    <td><button class='btn btn-outline-dark btn-sm zspedit'>Módosítás</button>
                    <button class='btn btn-outline-danger btn-sm zspdelete'>Törlés</button></td>
                </tr>\n";
}

print $kimenet;

mysqli_close($dbconn);
