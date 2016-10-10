<?php 
	$start=microtime(true);
	include'mysql.php';
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Offline</title>
	<link rel=stylesheet href="estils.css">
</head><body><center>
<!--NAVBAR--><?php include"navbar.php"?>
<!--TITLE--><h2 onclick=window.location.reload() style=cursor:pointer>Offline Devices (NO automatic readings)</h2>

<!--OFFLINE DEVICES-->
<table cellpadding=5>
	<tr><th>Id<th>Device<th>Readings<th>Insert New Offline Reading<th>Unit<th>Ubication</tr>
	<?php
		$sql="
		SELECT id,name,unit,ubication,count FROM devices LEFT JOIN
		(
			SELECT id_device,COUNT(*) as count
			FROM readings 
			GROUP BY id_device
		) cc ON devices.id=cc.id_device 
		WHERE type='Offline'";
		$res=mysql_query($sql);
		$results=mysql_num_rows($res);
		echo "<b>$results devices</b>"; //value oustide a <th> element will show at the top of the table
		while($row=mysql_fetch_array($res))
		{
			$id   	= $row['id'];
			$name 	= $row['name'];
			$ubic 	= $row['ubication'];
			$unit 	= $row['unit'];
			$count	= $row['count'];

			//if count is null
			if(!$count)$count=0;

			//display
			echo "<tr>
					<td>$id
					<td><a href=device.php?id=$id>$name</a>
					<td align=center>$count
					<td><form action=newReading.php method=POST>
						<input name=id_device	type=hidden  value=$id										required>
						Datetime
						<input name=date 		autocomplete=off type=date value='".date("Y-m-d",time())."' required>
						<input name=time 		autocomplete=off type=time value='00:00' 					required>
						Value 
						<input name=value 		placeholder='$unit' autocomplete=off size=2 				required>
						<button>Insert</button>
					</form>
					<td>$unit
					<td><a href=devices.php?ubication=$ubic>$ubic</a>
			";
		}	
	?>
</table>

<!--TIME--><?php printf("Page generated in %f seconds",microtime(true)-$start)?>
