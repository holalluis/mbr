<?php
	$start = microtime(true); //record starting time
	include('mysql.php');

	//check input
	if(!isset($_GET['id'])) die('no calculation id selected');

	//input: id & date
	$id=$_GET['id'];
	if(isset($_GET['from']) && isset($_GET['to'])) //date selected for readings
	{
		$from=$_GET['from'];
		$to=$_GET['to'];
		if($to=="")$to="CURRENT_TIMESTAMP";
		$dateFilter="WHERE date>='$from' AND date<='$to'";
	}
	else $dateFilter=""; //$dateFilter will be used in sql query 

	//query calculation properties from calculations table 
	$res	 = mysql_query("SELECT * FROM calculations WHERE id=$id") or die(mysql_error());
	$row	 = mysql_fetch_array($res);
	$id		 = $row['id'];
	$name	 = $row['name'];
	$formula = $row['formula'];
	$unit	 = $row['unit'];

	//get devices ids involved in formula
	include 'calculations_library.php';
	$ids=idsPerFormula($formula);
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Calculation</title>
	<script src=export.js></script>
	<link rel=stylesheet href=estils.css>
	<style>td{text-align:right}</style>
</head><body><center>
<!--NAVBAR--><?php include "navbar.php"?>
<!--TITLE--><h2 style=cursor:pointer onclick="window.location='<?php echo "calculation.php?id=$id"?>'"><?php echo $name?></h2>
<!--RESULTS--><div><b><span id=results></span> results</b> (note: only timesteps where all devices have readings are considered)</div>

<!--LEFT OF THE PAGE: INFO AND SELECT DATE-->
<div style="display:inline-block;vertical-align:top">
	<!--INFO-->
	<table cellpadding=5>
		<tr><th colspan=2>Calculation Info
		<tr><th align=left>Formula 	<td style=background:#af0><?php echo $formula ?>
		<tr><th align=left>Unit		<td><?php echo $unit ?>
		<tr><td style="text-align:center" colspan=2>
			<button onclick="if(confirm('Are you sure that you want to delete calculation id <?php echo $id?>? '))
					window.location='deleteCalculation.php?id=<?php echo $id?>'"
				style="background:red">Delete Calculation</button>
	</table>
	<!--SELECT DATE-->
	<div>
		<form method=GET>
			<input name=id type=hidden value="<?php echo $id?>">
			From 	<input name=from type=date size=3 value="2000-01-01">
			To		<input name=to 	 type=date size=3 value="<?php echo date("Y-m-d",time()+86400)?>">
			<button type=submit>View</button>	
		</form>
		<!--EXPORT--><div style=padding:1.5em><button onclick=export2CSV('export')>Generate File...</button></div>
	</div>
</div>

<!--RIGHT OF THE PAGE: RESULTS-->
<table cellpadding=4 id=export style="display:inline-block;vertical-align:top">
	<tr><th>Date</th><?php 
		//header (device names)
		$device_ids = "(".implode(",",$ids).")"; //e.g. from [1,2] (array) to "(1,2)" (string)
		$sql="SELECT id,name,unit,type,ubication FROM devices WHERE id in $device_ids";
		$res=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_array($res))
		{
			$device_id		= $row['id'];
			$device_name	= $row['name'];
			$device_unit	= $row['unit'];
			$device_type	= $row['type'];
			$device_ubic	= $row['ubication'];
			//this should be in one line to prevent export to csv issues
			echo "<th><a href=device.php?id=$device_id title='$device_name, $device_type, $device_ubic'>Device [#id$device_id]</a> ($device_unit)</th>";
		}
		echo "<th title='This calculation'>$name ($unit)</th></tr>";
		//cols array to pivote the readings table (each element will be column)
		$cols=[];foreach($ids as $id_device)$cols[]="GROUP_CONCAT(IF(id_device=$id_device,value,NULL)) AS device_$id_device";

		//WHERE device_$id is NOT NULL
		$notNull=[];foreach($ids as $id_device)$notNull[]="al.device_$id_device IS NOT NULL";
		$notNull=implode(" AND ",$notNull);

		//final SQL
		$sql=" 	
				SELECT * FROM (
					SELECT date,".implode(",",$cols)."
					FROM readings 
					$dateFilter
					GROUP BY date 
					ORDER BY date DESC
				) al 
				WHERE ($notNull)
				ORDER BY date ASC
			";

		//execute
		$res=mysql_query($sql) or die(mysql_error());
		$results=mysql_num_rows($res);
		echo "<script>document.getElementById('results').innerHTML='$results'</script>";
		while($row=mysql_fetch_array($res))
		{
			$date=$row['date'];
			echo "<tr><td>$date";
			$values=[]; //values in this iteration
			foreach($ids as $id_device)
			{
				$value=$row["device_$id_device"];
				$values[]=$value;
				echo "<td>$value";
			}
			echo "<td style=background:#af0>".applyFormula($formula,$values);
		}
	?>
</table>

<!--TIME--><br><?php printf("Page generated in %f seconds",microtime(true)-$start)?>
