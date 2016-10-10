<?php
include 'mysql.php';
//input
$id=$_GET['id'];
//delete check
mysql_query("DELETE FROM calculations WHERE id=$id") or die(mysql_error());
//go back
header("Location: calculations.php");
?>
