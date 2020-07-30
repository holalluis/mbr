<?php include'mysql.php'?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Calculations</title>
	<link rel=stylesheet href="estils.css">
</head><body><center>
<!--NAVBAR-->	<?php include "navbar.php"?>
<!--TITLE-->	<h2 onclick=window.location.reload() style=cursor:pointer>User-Defined Calculations</h2>

<!--new-->
<div id=newCalc
	class=inline onclick=window.location='newCalculation.php'> 
	<style>
		#newCalc {border:1px solid blue;cursor:pointer}
		#newCalc:hover {background:lightgreen;transition:all 0.5s}
		#navbar div[page=calculations] a {color:black}
		#newCalc b {
			height: 40px;
			font-size: 14px;
			line-height: 40px;
			vertical-align: middle;
			padding: 0.1em 0.5em;
			margin-right: 0.5em;
		}
	</style>
	<b>+ Create New Calculation</b>
</div>

<!--CREATED CALCULATIONS-->
<div style=margin-top:2em>
<table cellpadding=10>
	<tr><th>Calculation Name<th>Formula<th>Addresses involved<th>Unit<th>Options</tr>
<?php
	include 'calculations_library.php'; //to use idsPerFormula()
	$sql="SELECT * FROM calculations";
	$res=$mysqli->query($sql) or die($mysqli->error());
	echo "<b>".$res->num_rows." calculations found</b>";
	while($row=$res->fetch_array())
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
	if($res->num_rows==0)
	{
		echo "<tr style=color:#666><td colspan=5>~No calculations created yet";
	}
?>
</table>
</div>
