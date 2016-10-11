<?php
/* DELETE a calculation*/
include 'mysql.php';
//input: calculation id
$id=$_GET['id'];
//delete calculation id
mysql_query("DELETE FROM calculations WHERE id=$id") or die(mysql_error());
//go back
header("Location: calculations.php");
?>
