<?php 
	/*create new device in the database*/
	include'mysql.php';
	include'displayDistinct.php';
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<link rel=stylesheet href="estils.css">
	<style>
		input{padding:0.5em}
	</style>
</head><body><center>
<!--NAVBAR-->	<?php include("navbar.php") ?>
<!--TITLE-->	<h2 onclick=window.location.reload() style=cursor:pointer>Create New Device</h2>
<!--NEW DEVICE FORM-->
<form method=POST>
	<table cellpadding=10>
		<tr><th>Name        <td><input name=name        autocomplete=off required placeholder="e.g. CH4 Sensor">
		<tr><th>Type        <td><input name=type        autocomplete=off required placeholder="e.g. Sensor">   <?php displayDistinct('type')?>
		<tr><th>Ubication   <td><input name=ubication   autocomplete=off required placeholder="e.g. Influent"> <?php displayDistinct('ubication')?>
		<tr><th>Unit        <td><input name=unit        autocomplete=off required placeholder="e.g. mg/l">     <?php displayDistinct('unit')?>
		<tr><th>PLC Position<td><input name=plcPosition autocomplete=off required placeholder="e.g. AutoGen_XXYYZZ">
		<tr><th><td><button>Insert</button>
	</table>
</form>

<?php
	/* NEW DEVICE INSERT TO DB */

	//check input. name, type, ubication, unit and plcPosition are mandatory
	if(!isset($_POST['name'],$_POST['type'],$_POST['ubication'],$_POST['unit'],$_POST['plcPosition'])) 
		die();

	//process input
	$name=mysql_real_escape_string($_POST['name']);
	$type=mysql_real_escape_string($_POST['type']);
	$ubic=mysql_real_escape_string($_POST['ubication']);
	$unit=mysql_real_escape_string($_POST['unit']);
	$plcP=mysql_real_escape_string($_POST['plcPosition']);

	//check for duplicates in name and plcPosition
	$duplicates=current(mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM devices WHERE name='$name'")));
	if($duplicates>0)die("ERROR! This device name already exists!");
	$duplicates=current(mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM devices WHERE plcPosition='$plcP'")));
	if($duplicates>0)die("ERROR! This device's PLC Position already exists!");

	//all is ok, let's insert new device
	$sql="INSERT INTO devices (name,type,ubication,unit,plcPosition) VALUES ('$name','$type','$ubic','$unit','$plcP')";
	mysql_query($sql) or die(mysql_error());

	//success & go to new device
	echo "<b>New Device '$name' Inserted Correctly!</b> ";
	$id=current(mysql_fetch_array(mysql_query("SELECT MAX(id) FROM devices")));
	echo "<a href=device.php?id=$id>View it</a>";
?>
