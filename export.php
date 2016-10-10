<?php 
	include 'mysql.php';
	$start=microtime(true);
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Export Data</title>
	<link rel=stylesheet href="estils.css">
	<style>td{text-align:right}</style>
	<script src=export.js></script>
</head><body><center>
<!--NAVBAR--><?php include('navbar.php')?>
<!--TITLE--><h2 onclick=window.location="export.php" style=cursor:pointer>Export Raw Readings to Excel</h2>

<!--SELECT DEVICES-->
<?php
	//if no input, show form and die()
	if(!isset($_GET['ids']))
	{?>
		<form style="border:1px solid #ccc;max-width:80%;padding:1em;font-size:14px">
			<div>Hold Ctrl (Windows) or &#8984 (Mac) to select multiple devices</div>
			<select name="ids[]" multiple size=15>
				<?php
					$sql="SELECT * FROM devices";
					$res=mysql_query($sql) or die('error');
					while($row=mysql_fetch_array($res))
					{
						$id	  = $row['id'];
						$name = $row['name'];
						$type = $row['type'];
						$ubic = $row['ubication'];
						echo "<option value=$id>$id: $name ($type,$ubic)</option>";
					}
				?>
			</select>
			<!--date filter form-->
			<div style="vertical-align:top;display:inline-block;">
				From 	<input name=from type=date size=3 value="2000-01-01">
				To		<input name=to 	 type=date size=3 value="<?php echo date("Y-m-d",time()+86400)?>">
				<button type=submit style=padding:1em>Ok</button>
			</div>
		</form>
		<?php die();
	}
?>

<!--GET INPUT-->
<?php
	/* 	
		show multi device time series from table "readings"
		+------+----------+----------+-----+----------+
		| date | device 1 | device 2 | ... | device n |
		+------+----------+----------+-----+----------+
		|      |          |          |     |          |
		|      |          |          |     |          |
		+------+----------+----------+-----+----------+
		stackoverflow: http://stackoverflow.com/questions/33350524/pivot-a-table-and-display-n-ordered-time-series

		input: 	-ids (array of integers), e.g. [4,5,6]
				-from (datestring)
				-to (datestring)
	*/
	$ids=$_GET['ids'];
	$from=$_GET['from'];
	$to=$_GET['to'];
?>

<!--EXPORT--><div><button onclick=export2CSV('result')>Generate File...</button></div>

<!--RESULTS-->
<table id=result cellpadding=2><tr><th>Date</th>
	<?php 
		//header (device names)
		$device_ids = "(".implode(",",$ids).")"; //e.g. from [1,2] (array) to "(1,2)" (string)
		$sql="SELECT id,name,unit,type,ubication FROM devices WHERE id in $device_ids";
		$res=mysql_query($sql) or die(mysql_error());
		while($row=mysql_fetch_array($res))
		{
			$id		= $row['id'];
			$name	= $row['name'];
			$unit	= $row['unit'];
			$type	= $row['type'];
			$ubic	= $row['ubication'];
			echo "<th><a href=device.php?id=$id title='$type, $ubic'>$name</a> ($unit)</th>";
		}

		//set "$to" to current time if blank
		if($to=="")$to="CURRENT_TIMESTAMP";

		//New array to pivote the readings table (each element will be column)
		$cols=[];foreach($ids as $id)$cols[]="GROUP_CONCAT(IF(id_device=$id,value,NULL)) AS device_$id";

		//WHERE device_$id is NOT NULL
		$notNull=[]; foreach($ids as $id)$notNull[]="al.device_$id IS NOT NULL";
		$notNull=implode(" OR ",$notNull);

		$sql=" 	
				SELECT * FROM (
					SELECT date,".implode(",",$cols)."
					FROM readings 
					WHERE date>='$from' AND date<='$to'
					GROUP BY date ORDER BY date ASC
				) al 
				WHERE ($notNull)
			";

		$res=mysql_query($sql) or die(mysql_error());
		$results=mysql_num_rows($res);
		echo "<div><b>$results results</b></div>";
		while($row=mysql_fetch_array($res))
		{
			$date=$row['date'];
			echo "<tr><td>$date";
			foreach($ids as $id)
			{
				$value=$row["device_$id"];
				echo "<td>$value";
			}
		}
	?>
</table>

<!--TIME--><?php printf("Page generated in %f seconds",microtime(true)-$start)?>
