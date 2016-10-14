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
<!--NEW DEVICE--><div style="border:1px solid blue;width:10%"><a href="newDevice.php">+Create New Device</a></div>
<!--TITLE--><h2 onclick=window.location.reload() style=cursor:pointer>List Devices by Type/Ubication</h2>

<div style="">
	<form action=device.php method=GET>
		Or write device id (if you know it) 
		<input name=id placeholder="device id" size=2 value=1 autocomplete=off> 
		<button>Go</button>
	</form>
</div>

<!--NAVTABLE-->
<table cellpadding=5>
	<tr><td rowspan=2 colspan=2 onclick=window.location='devices.php' title="All devices">
	<a href=#>View All (<?php echo mysql_num_rows(mysql_query("SELECT 1 FROM devices"))?>)</a>
	<th colspan=<?php echo count($ubics)?>>Ubication</th>
	<tr>
	<?php 
		foreach($ubics as $ubic) 
		{
			//count devices in this ubication
			$count=mysql_num_rows(mysql_query("SELECT 1 FROM devices WHERE ubication='$ubic'"));
			echo "	<td ubic='$ubic' 
						onclick=\"window.location='devices.php?ubication=$ubic'\"
						title='Devices in $ubic'>
						<a href=#>$ubic ($count)</a>";
		}
	?>
	<?php
		//iterate device types
		foreach($types as $type)
		{
			echo "<tr>"; //new row

			//for first row only
			if($type==$types[0])echo "<th rowspan=".count($types).">Type";

			//count devices of this type
			$count=mysql_num_rows(mysql_query("SELECT 1 FROM devices WHERE type='$type'"));

			//all devices of this type
			echo "	<td type='$type' 
						onclick=\"window.location='devices.php?type=$type'\"
						title='All $type"."s'>
						<a href=#>$type"."s ($count)"."</a>";

			//iterate ubications
			foreach($ubics as $ubic) 
			{
				//count devices of this type and ubication
				$count=mysql_num_rows(mysql_query("SELECT 1 FROM devices WHERE type='$type' AND ubication='$ubic'"));
				echo "	<td	onclick=\"window.location='/mbr/devices.php?type=$type&ubication=$ubic'\" 
							onmouseover=\"highLight('$ubic','$type','#F5F6CE')\" 
							onmouseout=\"highLight('$ubic','$type','')\" 
							title='$type"."s in $ubic'
						>View ($count)";
			}
		}
	?>
</table>

<!--time--><?php printf("Page generated in %f seconds",microtime(true)-$start)?>
