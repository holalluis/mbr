<?php
	//create a link if the current web page is not the one in the link's href 
	function nlink($direccio,$nom)
	{
		if($direccio==$_SERVER['PHP_SELF']) 
			echo "<a href='$direccio' style=background:#ddd;color:black>$nom</a>";
		else 
			echo "<a href='$direccio'>$nom</a>";
	}	
?>
<div id=navbar> 
	<?php
		//simbol de menú (3 barres horitzontals)
		echo "&#9776; ";
		nlink("/mbr/index.php"        ,"HOME");
		nlink("/mbr/viewDevices.php"  ,"Devices");
		nlink("/mbr/readings.php"     ,"Readings");
		nlink("/mbr/calculations.php" ,"Calculations"); 
		nlink("/mbr/offline.php"      ,"Offline"); 
		nlink("/mbr/setpoints.php"    ,"Setpoints");
		nlink("/mbr/export.php"       ,"Export");
		nlink("/mbr/rules/rules.php"  ,"Rules"); 
		nlink("/mbr/problems.php"     ,"Find Problems");
		nlink("/mbr/about.php"        ,"About");
		nlink("/mbr/sql.php"          ,"SQL");
	?>
</div>

<style>
	#navbar {
		border-bottom:1px solid #ccc;
		padding:0;
		margin:0;
		font-size:18px;
		background:white;
	}
	#navbar a {
		display:inline-block;
		border-right:1px solid #ccc;
		padding:0.5em 0.3em;
		color:#666;
	}
	#navbar a:hover {
		background:#ccc;	
		transition:all 0.5s;
	}
</style>
