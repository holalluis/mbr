<?php 
	include 'mysql.php';
	$start = microtime(true); //record starting time
?>
<!doctype html><html><head> 
	<meta charset=utf-8>
	<title>Quart Pilot Plant</title>
	<link rel=stylesheet href=estils.css>
</head><body><center>	
<!--NAVBAR--><?php include("navbar.php")?>
<!--TITLE--><h1 onclick=window.location.reload() style=cursor:pointer>HOME - QUART PILOT PLANT</h1>

<!--PICTURE-->
<div style="height:350px;background:white;border:1px solid #ccc;display:inline-block">
	<a href="img/Plant.png" style=cursor:-webkit-zoom-in><img src="img/Plant.png" alt="Pilot plant" style=height:95%></a>
</div>

<!--DB SIZE-->
<table cellpadding=3 style="display:inline-block;vertical-align:top">
	<tr><th colspan=3>Database:
	<tr><th>Tablename<th>Rows<th>Size (MB)
	<?php
		$sql="	
				SELECT table_name,round(((data_length + index_length)/1024/1024),3) as 'size'
				FROM INFORMATION_SCHEMA.TABLES 
				WHERE table_schema='mbr' 
				ORDER BY TABLE_ROWS DESC
			";
		$res=mysql_query($sql) or die(mysql_error());
		$totalMB=0;
		$totalRows=0;
		while($row=mysql_fetch_array($res))
		{
			$table_name=$row['table_name'];
			$size=$row['size'];
			$rows=current(mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM $table_name")));
			$totalMB+=$size;
			$totalRows+=$rows;
			echo "<tr>
				<td>$table_name
				<td align=right>$rows
				<td align=right>$size";
		}
		echo "<tr align=right><td><b>Total</b><td><b>$totalRows</b><td><b>$totalMB</b>";
	?>
</table>

<!--LOGOS-->
<div>
	<a target=_blank href="http://www.icra.cat/"><img style="width:90px;height:70px;border:1px solid #eee" src=img/icra.png></a>
	<a target=_blank href="http://lequia.udg.es/"><img style="width:90px;height:70px;border:1px solid #eee" src=img/lequia.png></a>
</div>

<!--time-->
<?php printf("Page generated in %f seconds",microtime(true)-$start)?>
