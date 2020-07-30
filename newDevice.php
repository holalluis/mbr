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
	<script>
		function init()
		{
			document.querySelector('input[name=name]').select()
		}
	</script>
</head><body onload=init()><center>
<!--NAVBAR-->	<?php include("navbar.php") ?>
<!--TITLE-->	<h2 onclick=window.location.reload() style=cursor:pointer>Add New PLC address</h2>
<!--NEW DEVICE FORM-->
<form method=POST>
	<table cellpadding=10>
		<tr><th>Description <td><input name=name        autocomplete=off required placeholder="e.g. CH4 Sensor" value="no description">
		<tr><th>PLC address <td><input name=plcPosition autocomplete=off required placeholder="e.g. AutoGen_XXYYZZ">
		<tr><th>Type        <td><input name=type        autocomplete=off required placeholder="e.g. Sensor" list=deviceTypes>   <?php displayDistinct('type')?>
			<datalist id=deviceTypes>
				<option>Sensor
				<option>Alarm
				<option>Equipment
				<option>Setpoint
				<option>Offline
			</datalist>
			<br>
			<br>
			Important: type has to be "Sensor", "Alarm", "Equipment" or "Setpoint" in order to be read from the PLC. <br>
			If type is "Offline", its readings will be user-entered instead.
		<tr><th>Ubication   <td><input name=ubication   autocomplete=off required placeholder="e.g. Influent"> <?php displayDistinct('ubication')?>
		<tr><th>Unit        <td><input name=unit        autocomplete=off required placeholder="e.g. mg/l">     <?php displayDistinct('unit')?>
		<tr><th><td><button>Insert</button>
	</table>
</form>

<?php
	/* NEW DEVICE INSERT TO DB */

	//check input. name, type, ubication, unit and plcPosition are mandatory
	if(!isset($_POST['name'],$_POST['type'],$_POST['ubication'],$_POST['unit'],$_POST['plcPosition'])) 
		die();

	//process input
	$name=$mysqli->real_escape_string($_POST['name']);
	$type=$mysqli->real_escape_string($_POST['type']);
	$ubic=$mysqli->real_escape_string($_POST['ubication']);
	$unit=$mysqli->real_escape_string($_POST['unit']);
	$plcP=$mysqli->real_escape_string($_POST['plcPosition']);

	//check for duplicates in name and plcPosition
	$duplicates=current($mysqli->query("SELECT COUNT(*) FROM devices WHERE name='$name'")->fetch_array());
	if($duplicates>0)die("ERROR! This device name already exists!");
	$duplicates=current($mysqli->query("SELECT COUNT(*) FROM devices WHERE plcPosition='$plcP'")->fetch_array());
	if($duplicates>0)die("ERROR! This device's PLC Position already exists!");

	//all is ok, let's insert new device
	$sql="INSERT INTO devices (name,type,ubication,unit,plcPosition) VALUES ('$name','$type','$ubic','$unit','$plcP')";
	$mysqli->query($sql) or die($mysqli->error());

	//success & go to new device
	echo "<b>New Device '$name' Inserted Correctly!</b> ";
	$id=current($mysqli->query("SELECT MAX(id) FROM devices")->fetch_array());
	echo "<a href=device.php?id=$id>View it</a>";
?>
