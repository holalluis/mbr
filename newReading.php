<?php

include 'mysql.php';

//input nou reading: device, data, hora, valor
$id_device = $_POST['id_device'];
$date      = $_POST['date'];
$time      = $_POST['time'];
$value     = $_POST['value'];

//sql query
$sql="INSERT INTO readings (id_device,date,value) VALUES ($id_device,'$date $time',$value)";
mysql_query($sql) or die(mysql_error());

//go back
header("Location: device.php?id=$id_device");

?>
