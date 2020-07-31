<?php
	$start = microtime(true); //record starting time
	include 'mysql.php';
	include 'timeAgo.php';

	//INPUT device id
	$id=$_GET['id'];
	if($id=="")die('No device selected');

	$device=new stdclass;
	$device->id=$id;
	//TODO

	//it could be that the device id is submitted but device id does not exist. check this
  $mysqli->query("SELECT 1 FROM devices WHERE id=$id")->num_rows or die("Device id $id does not exist");

	//query
	$res=$mysqli->query("SELECT * FROM devices WHERE id=$id") or die($mysqli->error());
	$row=$res->fetch_assoc();

	//process query
	$name=$row['name'];
	$plcP=$row['plcPosition'];
	$type=$row['type'];
	$unit=$row['unit'];
	$ubic=$row['ubication'];

	//unitless?
	if($unit==""){$unit="no unit";}
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Information</title>
	<link rel=stylesheet href="estils.css">
	<style>
		#navbar div[page=devices] a {color:black}
	</style>
</head><body><center>
<!--NAVBAR-->	<?php include("navbar.php") ?>
<!--TITLE-->	<h2 style=cursor:pointer onclick="window.location='<?php echo "device.php?id=$id"?>'"><?php echo $name?></h2>

<!--DEVICE INFO-->
<table id=deviceInfo cellpadding=10 style="display:inline-block;vertical-align:top">
		<script>
			function editDevice(id,field)
			{
				var currValue=document.querySelector('#deviceInfo span[field='+field+']').textContent
				var value=prompt("New value for '"+field+"' field:",currValue);
				if(value)
				{
					window.location="editDevice.php?id="+id+"&"+field+"="+value
				}
			}
		</script>
		<style>
			#deviceInfo button {float:right}
		</style>
	<tr><th colspan=3 style="text-align:left">Information
	<!--
	<tr><th align=left>Device Id	<td colspan=2><?php echo $id ?>
	-->
	<tr><th align=left>PLC address<td><span field=plcPosition><?php echo $plcP?></span>
		<td><button onclick=editDevice(<?php echo $id?>,'plcPosition')>Edit</button>

	<tr><th align=left>Type 		<td><span field=type><?php echo "<a href=devices.php?type=$type>$type</a>" ?></span>
		<td> <button onclick=editDevice(<?php echo $id?>,'type')>Edit</button>

	<tr><th align=left>Ubication	<td><span field=ubication><?php echo "<a href=devices.php?ubication=$ubic>$ubic</a>"?></span>
		<td><button onclick=editDevice(<?php echo $id?>,'ubication')>Edit</button>

	<tr><th align=left>Unit			<td><span field=unit><?php echo $unit ?></span>
		<td><button onclick=editDevice(<?php echo $id?>,'unit')>Edit</button>

	<!--DELETE DEVICE-->
	<tr><td colspan=3 style=background:#FA5858>DANGER ZONE
		<button onclick="if(confirm('Are you sure that you want to delete address id <?php echo $id?>? ALL READINGS FROM THIS ADDRESS WILL BE DELETED'))
				window.location='deleteDevice.php?id=<?php echo $id?>'"
			style="background:red">
        Delete device
		</button>
</table>

<!--READINGS-->
<table id=readings cellpadding=3 style="display:inline-block;vertical-align:top">
	<style>
		#readings tbody tr:last-child() {background:red}
	</style>
	<?php
		//get size of whole database for this device
		$dbSize=current($mysqli->query("SELECT COUNT(*) FROM readings WHERE id_device=$id")->fetch_array());

		//date filter in sql query depending on get parameters in url
		if(isset($_GET['from']) && isset($_GET['to']))
		{
			$from=$_GET['from'];
			$to=$_GET['to'];
			if($to=="")$to="CURRENT_TIMESTAMP";
			$dateFilter="AND date>='$from' AND date<='$to'";
		}
		else $dateFilter="";

		//set limit for readings displayed depending on $dateFilter
		$limit = $dateFilter=="" ? "LIMIT 10" : "LIMIT 500";

		//final sql query
		$sql="	SELECT * FROM
				(
					SELECT * FROM readings WHERE id_device=$id $dateFilter ORDER BY date DESC $limit
				) 	alias
				ORDER BY date ASC";
		$res=$mysqli->query($sql) or die('error in query');

		//how many readings
		$results=$res->num_rows;

	?>
	<tr><th colspan=3 style=font-size:18px>
		Readings <span style=font-size:14px;font-weight:normal> &mdash; <?php echo "Showing last $results (of $dbSize)"?></span>

	<!--filter by date form-->
	<tr><th colspan=3 style=font-size:12px>
		<form method=GET style="display:inline-block;vertical-align:top;font-weight:normal" action="/mbr/device.php">
					<input name=id type=hidden value="<?php echo $id?>">
			From 	<input name=from type=date size=3 value="2000-01-01">
			To		<input name=to 	 type=date size=3 value="<?php echo date("Y-m-d",time()+86400)?>">
					<button type=submit>View</button>
		</form>

	<!--selected data header-->
	<tr><th>Date &darr;<th colspan=2>Value (<?php echo $unit?>)

	<script>
		function deleteReading(id)
		{
			window.location="deleteReading.php?id="+id
		}
	</script>

	<!--results-->
	<?php
		if($res->num_rows==0)echo "<tr><td colspan=2 style=background:#ccc align=center>No readings";
		while($row=$res->fetch_array())
		{
			$date  = $row['date'];
			$value = $row['value'];
			$id    = $row['id'];
			$value=round($value,4);
			echo "<tr style='font-size:12px'> <td align=center>$date <td align=center>$value";
			echo "<td><button style=color:red;float:right onclick=deleteReading($id)>Delete</button>";
		}
		echo "<tfoot>";
		if(isset($date)) //this means that this device has readings
		{
			$lastReading=timeAgo($date);
			echo "<tr><th colspan=3>Last reading: $lastReading";
		}
	?>
	<tr><td colspan=3 style=text-align:center><button onclick=deleteAllReadingsFromDevice(<?php echo $device->id?>)>Delete all readings</button>
	<script>
		function deleteAllReadingsFromDevice(id)
		{
			if(confirm("Are you sure? This cannot be undone"))
			{
				window.location="deleteReadings.php?id="+id
			}
		}
	</script>
</table><br>

<!--TIME--><?php printf("Page generated in %f seconds",microtime(true)-$start)?>

