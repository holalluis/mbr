<?php 
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
	$sql="
		SELECT * 
		FROM (SELECT * FROM readings ORDER BY date DESC) AS r,devices 
		WHERE devices.id=r.id_device
		GROUP BY r.id_device
	";
	$res=mysql_query($sql) or die(mysql_error());
	$dbSize=current(mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM readings")));
	$results=mysql_num_rows($res);
?>

<!--READINGS-->
<table cellpadding=4 style=margin-top:2em>
	<tr>
		<th>PLC address
		<th>Value
		<th>Unit
		<th>When
	<?php
		while ($row=mysql_fetch_assoc($res))
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
		if(mysql_num_rows($res)==0)
		{
			echo "<tr><td colspan=7>~No readings inserted yet";
		}
	?>
	<tr><th colspan=7>[...<?php echo ($dbSize-$results)." more"?>...]
</table>

<!--TIME--><?php printf("Page generated in %f seconds",microtime(true)-$start)?>
