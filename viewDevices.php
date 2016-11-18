<?php 
	include 'mysql.php';
	$start = microtime(true); //record starting time

	//FIND ALL DIFFERENT DEVICE TYPES AND UBICATIONS
	$types=[];
	$ubics=[];
	/* e.g.:
		$types=['Sensor','Alarm','Equipment','Setpoint'];
		$ubics=['Influent','Bioreactor','Recirculation','Membranes','RO'];
	*/
	$res=mysql_query("SELECT DISTINCT(type) FROM devices") or die(mysql_error());
	while($row=mysql_fetch_array($res)) $types[]=$row['type'];
	$res=mysql_query("SELECT DISTINCT(ubication) FROM devices") or die(mysql_error());
	while($row=mysql_fetch_array($res)) $ubics[]=$row['ubication'];
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>View Devices</title>
	<link rel=stylesheet href="estils.css">
	<style>
		table{font-size:16px}
		td{text-align:center; width:150px; height:50px; cursor:pointer}
		td:hover{background:#D0F5A9;}
		th{background:white}
	</style>
	<script>
		function highLight(ubic,type,color)
		//highlight parent ubications and type in navtable
		{
			var all=document.getElementsByTagName('*');
			for(var i=0,n=all.length;i<n;i++)
			{
				if(all[i].getAttribute('ubic')==ubic || all[i].getAttribute('type')==type) 
				{
					all[i].style.backgroundColor=color 
					all[i].style.color='blue'
				}
			}
		}
	</script>
</head><body><center>
<!--NAVBAR--><?php include "navbar.php"?>
<!--TITLE--><h2 onclick=window.location.reload() style=cursor:pointer>Devices connected to PLC</h2>

<!--3 options-->
<div>
	<!--NEW DEVICE-->
	<div class=inline style="border:1px solid blue;">
		<a href="newDevice.php">+Create New Device</a>
	</div>

	<!--view all-->
	<div class=inline style="border:1px solid green">
		<a href=devices.php>View All Devices (<?php echo mysql_num_rows(mysql_query("SELECT 1 FROM devices"))?>)</a>
	</div>

	<!--direct input id-->
	<div class=inline style='border:1px solid #ccc'>
		<form action=device.php method=GET>
			View device number 
			<input name=id placeholder="device id" size=2 
				value="<?php 
					echo current(mysql_fetch_assoc(mysql_query("SELECT MIN(id) FROM devices")));
				?>"
			autocomplete=off> 
			<button>Go</button>
		</form>
	</div>
</div>

<!--filter-->
<div id=filter class=inline style='border:1px solid #ccc'>
	<style>
		#filter select {float:right;margin-left:0.5em}
	</Style>
	<form action=devices.php>
		<div class=inline style="border:1px solid">
			View devices by: 
		</div>

		<div class=inline style=text-align:left>
			<div>
				Type 
				<select name=type>
					<option value=''>--all device types--
					<?php foreach($types as $type) { echo "<option>$type"; } ?>
				</select>
			</div>
			<div>
				Ubication
				<select name=ubication>
					<option value=''>--all device ubications--
					<?php foreach($ubics as $ubic) { echo "<option>$ubic"; } ?>
				</select>
			</div>
		</div>
		<div class=inline>
			<button style=padding:2em;>View devices</button>
		</div>
	</form>
</div>

<br>

</div>
<!--time--><?php printf("Page generated in %f seconds",microtime(true)-$start)?>
