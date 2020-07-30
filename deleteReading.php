<?php
/* DELETE a reading*/
include 'mysql.php';
//input: reading id
$id=$_GET['id'];
//delete reading id
$mysqli->query("DELETE FROM readings WHERE id=$id") or die($mysqli->error());
//go back
header("Location: ".$_SERVER['HTTP_REFERER']);
?>
