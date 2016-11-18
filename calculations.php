<?php include'mysql.php'?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Calculations</title>
	<link rel=stylesheet href="estils.css">
	<style>
		table{display:inline-block;vertical-align:top;}
	</style>
</head><body><center>
<!--NAVBAR-->	<?php include "navbar.php"?>
<!--TITLE-->	<h2 onclick=window.location.reload() style=cursor:pointer>User-Defined Calculations</h2>

<div class=inline style="border:1px solid blue;width:13%"> <a href="newCalculation.php">+Create New Calculation</a></div>
<h3 class=inline>Create calculations using sensor readings</h3>

<!--CREATED CALCULATIONS-->
<div>
<table cellpadding=10><tr><th>Calculation Name<th>Formula<th>Devices involved<th>Unit<th>Options
<?php
	include 'calculations_library.php'; //to use idsPerFormula()
	$sql="SELECT * FROM calculations";
	$res=mysql_query($sql) or die(mysql_error());
	while($row=mysql_fetch_array($res))
	{
		$id			= $row['id'];
		$name		= $row['name'];
		$unit		= $row['unit'];
		$formula	= $row['formula'];
		//get devices ids array from formula
		$devicesInvolved=count(idsPerFormula($formula));
		echo "<tr>
				<td><a href=calculation.php?id=$id>$name</a>
				<td>$formula
				<td align=center>$devicesInvolved
				<td>$unit
				<td><button onclick=\"if(confirm('Are you sure that you want to delete calculation id $id?'))
									{window.location='deleteCalculation.php?id=$id'}\"
							style='background:red'>
							Delete Calculation</button>";
	}
	if(mysql_num_rows($res)==0)
	{
		echo "<tr style=color:#666><td colspan=5>~No calculations created yet";
	}
?>
</table>
</div>
