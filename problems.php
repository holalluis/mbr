<?php include('mysql.php')?>
<!doctype html><html><head> 
	<meta charset=utf-8>
	<title>Problems</title>
	<link rel=stylesheet href=estils.css>
	<script>
		function init()
		{
			document.getElementById('loading').style.display='none'
		}
		function collapse(tableid,button)
		/* toggle visibility of a table */
		{
			var t=document.getElementById(tableid)
			var currentState = t.getAttribute('visible')
			var newState = currentState=='true'? 'false' : 'true'
			t.setAttribute('visible',newState)
			var styleDisplay = newState=='true'? '':'none'
			var rows = t.rows.length
			//leave the first row unchanged (not start by i=0)
			for(var i=1;i<rows;i++)t.rows[i].style.display=styleDisplay
			button.innerHTML=button.innerHTML=='Show'?'Hide':'Show'
		}
	</script>
	<style>tr{font-size:16px}</style>
	<style>
		#navbar div[page=problems] a {color:black}
	</style>
</head><body onload=init()><center>	
<!--NAVBAR--><?php include"navbar.php"?>
<!--TITLE--><h2 onclick=window.location.reload() style=cursor:pointer>Data Base Problems</h2>
<!--LOADING ICON--><div id=loading><?php include 'loading.php'?></div>
<!--ADVICE--><h2 style=color:red>Please fix these problems (if any) before operating</h2>

<!--NO plc address-->
<table class=inline cellpadding=5 id=noPlcAddress>
	<?php
		$sql="SELECT * FROM devices WHERE plcPosition='' AND type!='Offline'";
		$res=mysql_query($sql) or die(mysql_error());
	?>
	<tr><th colspan=3>
		&empty; Devices with NO PLC address (<?php echo mysql_num_rows($res)?>) 
		<b title="These devices will never have readings">[?]</b>
		<button onclick=collapse('noPlcAddress',this)>Show</button> 
	<tr><th>Id<th>Device<th>Solution (SQL query)
	<?php
		while($row=mysql_fetch_array($res))
		{
			$id=$row['id'];
			$name=$row['name'];
			$type=$row['type'];
			$ubication=$row['ubication'];
			echo "<tr>
					<td>$id
					<td><a href=device.php?id=$id title='$type, $ubication'>$name</a>
					<td>UPDATE devices SET plcPosition='device$id' WHERE id=$id
				";
		}
		//if all is correct
		if(mysql_num_rows($res)==0)echo "<tr style=background:#af0><td colspan=3>&#10004; All devices have a PLC address";
	?>
</table>

<!--duplicated PLC addresses-->
<table class=inline cellpadding=5 id=duplicatedPlcAddress>
	<?php
		$sql="
			SELECT * 
				FROM 
					(
						SELECT plcPosition 
						FROM devices 
						WHERE plcPosition!='' AND type!='Offline'
						GROUP BY plcPosition 
						HAVING COUNT(*)>1
					) alias,
					devices 
				WHERE 
					devices.plcPosition=alias.plcPosition
				ORDER BY devices.plcPosition
			";
		$res=mysql_query($sql) or die(mysql_error());
	?>
	<tr><th colspan=4>&#127926; Duplicated PLC addresses (<?php echo mysql_num_rows($res)?>) 
	<b title="These devices will have either no readings or a duplicated number of readings">[?]</b>
	<button onclick=collapse('duplicatedPlcAddress',this)>Show</button> 
	<tr><th>Address<th>Id<th>Device<th>Solution (SQL query)
	<?php
		while($row=mysql_fetch_array($res))
		{
			$id			 = $row['id'];
			$name		 = $row['name'];
			$type		 = $row['type'];
			$ubication	 = $row['ubication'];
			$plcPosition = $row['plcPosition'];
			echo "<tr><td>$plcPosition
				<td>$id
				<td style='text-align:left'><a href=device.php?id=$id title='$type, $ubication'>$name</a>
				<td>UPDATE devices SET plcPosition='device$id' WHERE id=$id";
		}
		//if all is correct
		if(mysql_num_rows($res)==0)echo "<tr style=background:#af0><td colspan=4>&#10004; All devices have different PLC addresses";
	?>
</table>

<!--devices without readings-->
<table class=inline cellpadding=5 id=noReadings>
	<?php
		//display setpoints not present in readings
		$sql="SELECT * FROM devices LEFT JOIN 
				(
					SELECT COUNT(*) as count,id_device FROM readings GROUP BY id_device
				) cc ON cc.id_device=devices.id 
				WHERE 
					type!='Offline'
					AND
					count is NULL
			";
		$res=mysql_query($sql) or die(mysql_error());
	?>
	<tr><th colspan=5>&#8999; Devices without readings (<?php echo mysql_num_rows($res)?>) 
	<b title="The system is not inserting readings for these devices, maybe the plc address is missing or wrong">[?]</b>
	<button onclick=collapse('noReadings',this)>Show</button> 
	<tr><th>Id<th>Device<th>Readings
	<?php
		while($row=mysql_fetch_array($res))
		{
			$id			 	= $row['id'];
			$name		 	= $row['name'];
			$type		 	= $row['type'];
			$ubication	 	= $row['ubication'];
			$plcPosition 	= $row['plcPosition'];
			echo "<tr> 	
					<td>$id
					<td><a href='device.php?id=$id' title='$type,$ubication, $plcPosition'>$name</a>
					<td>0";
		}
		//if all is correct
		if(mysql_num_rows($res)==0)echo "<tr style=background:#af0><td colspan=3>&#10004; All devices have readings";
	?>
</table>

<!--device ids in readings without device in devices table-->
<table class=inline cellpadding=5 id=devicelessReadings>
	<?php
		$sql="SELECT id_device,COUNT(id_device) as count FROM readings LEFT JOIN devices ON readings.id_device=devices.id WHERE devices.id is NULL GROUP BY id_device";
		$res=mysql_query($sql) or die(mysql_error());
	?>
	<tr><th colspan=3>&#128125; Deviceless Readings (<?php echo mysql_num_rows($res)?>)
	<b title="These readings have no real device associated (no device has these ids)">[?]</b>
	<button onclick=collapse('devicelessReadings',this)>Show</button> 
	<tr><th>Device Id<th>Readings<th>Solution (SQL query)
	<?php
		while($row=mysql_fetch_array($res))
		{
			$id_device	= $row['id_device'];
			$count	 	= $row['count'];
			echo "<tr>
					<td>$id_device
					<td>$count
					<td>DELETE FROM readings WHERE id_device=$id_device
					";
		}
		//if all is correct
		if(mysql_num_rows($res)==0)echo "<tr style=background:#af0><td colspan=3>&#10004; All readings have a device";
	?>
</table>
