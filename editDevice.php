<?php
/* EDIT a device from devices */
include("mysql.php");

//input: device id and all fields
$id=$_GET['id']; //mandatory
$name=isset($_GET['name'])        ? "'".$_GET['name']."'"        : 'name';        //optional
$plcP=isset($_GET['plcPosition']) ? "'".$_GET['plcPosition']."'" : 'plcPosition'; //optional
$type=isset($_GET['type'])        ? "'".$_GET['type']."'"        : 'type';        //optional
$unit=isset($_GET['unit'])        ? "'".$_GET['unit']."'"        : 'unit';        //optional
$ubic=isset($_GET['ubication'])   ? "'".$_GET['ubication']."'"   : 'ubication';   //optional

//command edit device
$sql="UPDATE devices SET
		name=$name,
		plcPosition=$plcP,
		type=$type,
		unit=$unit,
		ubication=$ubic
	WHERE id=$id";
$mysqli->query($sql) or die($mysqli->error());

?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<link rel=stylesheet href=estils.css>
</head><body><center>
<!--NAVBAR--><?php include("navbar.php")?>
<?php
	echo("<div><b style=color:lightgreen>Device id $id edited correctly</b></div>");
	header("Location: device.php?id=$id");
?>
