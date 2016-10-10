<?php 
/*
	DELETE a device from devices
*/

include("mysql.php");

//input: setpoint id & new value
$id		= $_GET['id'];

//Table readings
$sql="DELETE FROM devices WHERE id=$id";
mysql_query($sql) or die('error');

//Table devices
$sql="DELETE FROM readings WHERE id_device=$id";
mysql_query($sql) or die('error');

?>	
<!doctype html><html><head> 
	<meta charset=utf-8>
	<link rel=stylesheet href=estils.css>
</head><body><center>	

<!--NAVBAR--><?php include("navbar.php")?>

<?php die("<div><b style=color:red>Device id $id removed correctly</b></div>")?>
