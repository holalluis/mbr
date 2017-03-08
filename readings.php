<?php 
	$start = microtime(true); //start time
	include "mysql.php";
	include "timeAgo.php";
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Readings</title>
	<link rel=stylesheet href="estils.css">
</head><body><center>
<!--NAVBAR--><?php include "navbar.php"?>

<!--TITLE AND QUERY-->
<?php
	$limit=10;
	$sql="SELECT 
			readings.id, 
			readings.id_device, 
			readings.date, 
			readings.value, 
			devices.name, 
			devices.plcPosition, 
			devices.type,
			devices.unit, 
			devices.ubication
		FROM readings,devices 
		WHERE readings.id_device=devices.id 
		ORDER BY date DESC 
		LIMIT $limit
	";
	$res=mysql_query($sql) or die(mysql_error());
	$dbSize=current(mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM readings")));
	$results=mysql_num_rows($res);
	echo "<h2 onclick=window.location.reload() style=cursor:pointer>Last $results readings inserted (of $dbSize)</h2>";
?>

<!--READINGS-->
<table cellpadding=4 style=margin-top:2em>
	<tr><th style=display:none>Id
		<th>PLC address
		<th>Value (Unit)
		<th>When
	<?php
		while ($row=mysql_fetch_assoc($res))
		{
			$id				= $row['id'];
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
				<td style=display:none>$id
				<td><a href=device.php?id=$id_device title='$type, $ubication'>$name</a>
				<td>$value ($unit)
				<td title='$date'>$ago
			";
		}
		if(mysql_num_rows($res)==0)
		{
			echo "<tr><td colspan=7>~No readings inserted yet";
		}
	?>
	<tr><th colspan=7>[...<?php echo ($dbSize-$results)." more"?>...]
</table>

<!--TIME--><?php printf("Page generated in %f seconds",microtime(true)-$start)?>
