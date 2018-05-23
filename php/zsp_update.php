<?php
require("connect.php");

$id = (int) $_POST['id'];
$ujzspdatum = $_POST['ujzspdatum'];
$date_test = explode('-', $ujzspdatum);
$ujzsposszeg = (int) $_POST['ujzsposszeg'];

if ($ujzsposszeg > 0 && checkdate($date_test[1], $date_test[2], $date_test[0])) {
	$sql = "UPDATE kifizetesek SET datum='{$ujzspdatum}', osszeg='{$ujzsposszeg}' WHERE id='{$id}'";
}


mysqli_query($dbconn, $sql);

mysqli_close($dbconn);