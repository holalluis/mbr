<?php
	function nlink($direccio,$nom)
	//void: echo a link if the current web page is not the one in the link's href 
	{
		if($direccio==$_SERVER['PHP_SELF']) 
				echo "<a href='$direccio' style=color:black>$nom</a>";
		else 	echo "<a href='$direccio'>$nom</a>";
		echo " &#9474 ";
	}	
?>

<div style="margin:0;font-size:19px"> 
	<?php
		//simbol de menú (3 barres)
		echo "&#9776; ";
		//navbar
		nlink("/mbr/index.php"			,"&#127968; HOME");
		nlink("/mbr/viewDevices.php"	,"&#127975; Devices");
		nlink("/mbr/readings.php"		,"&#128214; Readings");
		nlink("/mbr/calculations.php"	,"&sum; 	Calculations"); 
		nlink("/mbr/offline.php"		,"&#9998; 	Offline"); 
		nlink("/mbr/setpoints.php"		,"&#128073; Setpoints");
		nlink("/mbr/export.php"			,"&rAarr; 	Export");
		nlink("/mbr/rules.php"			,"&#128278; Rules"); 
		nlink("/mbr/problems.php"		,"&#10060;	Find Problems");
		nlink("/mbr/about.php"			,"&#128129;	About");
		nlink("/mbr/sql.php"			,"&#128187;	SQL");
	?>
</div>

<hr>
