<?php 
	//refresh each 10 seconds
	header("refresh: 10");

	$start = microtime(true); //start time
	include "mysql.php";
	include "timeAgo.php";
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Readings</title>
	<link rel=stylesheet href="estils.css">
	<style>
		#navbar div[page=readings] a {color:black}
	</style>
</head><body><center>
<!--NAVBAR--><?php include "navbar.php"?>

<h2 onclick=window.location.reload() style=cursor:pointer>Last reading inserted</h2>

<!--TITLE AND QUERY-->
<?php
?>

<!--READINGS-->
<table cellpadding=4 style=margin-top:2em>
	<tr>
		<th>PLC address
		<th>Value
		<th>Unit
		<th>When
		<?php
			$sql="
				SELECT * 
				FROM devices, (SELECT * FROM readings ORDER BY readings.date DESC) as r
				WHERE devices.id=r.id_device
				GROUP BY r.id_device
			";
			$res=$mysqli->query($sql) or die($mysqli->error());
			while($row=$res->fetch_assoc())
			{
				$id_device		= $row['id_device'];
				$date			= $row['date'];
				$value			= $row['value'];
				$name			= $row['name'];
				$plcPosition	= $row['plcPosition'];
				$type			= $row['type'];
				$unit			= $row['unit'];
				$ubication		= $row['ubication'];
				//time ago
				$ago=timeAgo($date);
				//display
				$value=round($value,4);
				if($unit==""){$unit="<span style=color:#ccc>no unit</span>";}
				echo "<tr>
					<td><a href=device.php?id=$id_device title='$type, $ubication'>$name</a>
					<td>$value
					<td>$unit
					<td title='$date'>$ago
				";
			}
			if($res->num_rows==0)
			{
				echo "<tr><td colspan=7>~No readings inserted yet";
			}
		?>
</table>

<!--TIME--><?php printf("Page generated in %f seconds",microtime(true)-$start)?>
