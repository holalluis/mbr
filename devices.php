<?php 
	include("mysql.php");
	$start = microtime(true); //start time

	//input
	$type=isset($_GET['type']) 		? $_GET['type'] 	 : "" ;
	$ubic=isset($_GET['ubication']) ? $_GET['ubication'] : "" ;

	//define a where clause (string) for the sql query
	if($type!="") 				$where = "type='$type'";
	if($ubic!="") 				$where = "ubication='$ubic'";
	if($type!="" && $ubic!="")  $where = "(type='$type' AND ubication='$ubic')";
	if($type=="" && $ubic=="")  $where = "1";

	//construct query: devices and number of readings
	$sql="SELECT id,name,plcPosition,type,unit,ubication,count
			FROM devices LEFT JOIN 
			(
				SELECT id_device,COUNT(*) as count
				FROM readings 
				GROUP BY id_device
			) cc ON devices.id=cc.id_device 
			WHERE $where";
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title><?php 
		//set title
		if($type!="") 				$title = $type."s ";
		if($ubic!="") 				$title = "Devices @ $ubic";
		if($type!="" && $ubic!="")  $title = $type."s @  $ubic";
		if($type=="" && $ubic=="")  $title = "All Devices";
		echo $title;
	?></title>
	<link rel=stylesheet href="estils.css">
	<style>td{text-align:center}</style>
</head><body><center>
<!--NAVBAR-->	<?php include("navbar.php") ?>
<!--TITLE-->	<h2 onclick=window.location.reload() style=cursor:pointer>Devices - View <?php echo $title ?></h2>

<!--QUERY & Nº of results-->
<div><b><?php
	$res=mysql_query($sql) or die(mysql_error());
	echo mysql_num_rows($res)." results";
?></b></div>

<!--DEVICES-->
<table cellpadding=3>
	<tr><th>Id<th>Device<th>Type<th>Ubication<th>Unit<th>PLC Position<th>Readings
	<?php
		while ($row=mysql_fetch_assoc($res))
		{
			$id			 	= $row['id'];
			$name		 	= $row['name'];
			$type		 	= $row['type'];
			$ubication	 	= $row['ubication'];
			$unit		 	= $row['unit'];
			$plcPosition 	= $row['plcPosition'];
			$readings 		= $row['count'];

			if($readings==null)$readings=0;
			$colorRRR = $readings==0 ? "red" : ""; 		//red if number of readings is zero
			$colorPLC = $plcPosition=="" ? "red" : "";	//red if plc position is blank

			//display
			echo "<tr>
					<td>$id
					<td style=text-align:left><a href='device.php?id=$id'>$name</a>
					<td>$type
					<td>$ubication
					<td>$unit 
					<td style=background:$colorPLC>$plcPosition
					<td style=background:$colorRRR>$readings";
		}
	?>
</table>

<!--time-->
<?php printf("Page generated in %f seconds",microtime(true)-$start)?>
