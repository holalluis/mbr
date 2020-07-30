<?php
/* DELETE all readings from device=id*/
include 'mysql.php';
//input: device id
$id=$_GET['id'];
//delete reading id
$mysqli->query("DELETE FROM readings WHERE id_device=$id") or die($mysqli->error());
//go back
header("Location: ".$_SERVER['HTTP_REFERER']);
?>
