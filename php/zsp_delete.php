<?php
require("connect.php");

$id = (int) $_POST['id'];

$sql = "DELETE FROM kifizetesek WHERE id='{$id}'";

mysqli_query($dbconn, $sql);

mysqli_close($dbconn);