<?php
/* DELETE all readings from device=id*/
include 'mysql.php';
//input: device id
$id=$_GET['id'];
//delete reading id
mysql_query("DELETE FROM readings WHERE id_device=$id") or die(mysql_error());
//go back
header("Location: ".$_SERVER['HTTP_REFERER']);
?>
