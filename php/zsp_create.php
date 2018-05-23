<?php
require("connect.php");

$ujzspdatum = $_POST['ujzspdatum'];
$date_test = explode('-', $ujzspdatum);
$ujzsposszeg = (int) $_POST['ujzsposszeg'];

if ($ujzsposszeg > 0 && checkdate($date_test[1], $date_test[2], $date_test[0])) {
	$sql = "INSERT INTO kifizetesek (datum, osszeg) VALUES  ('{$ujzspdatum}', '{$ujzsposszeg}')";
    mysqli_query($dbconn, $sql);
}

mysqli_close($dbconn);