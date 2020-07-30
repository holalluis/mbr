<?php

//function to be used when creating a new device or a new calculation

function displayDistinct($field)
/* display different existing values from fields in devices table */
{
  global $mysqli;
	$options=[]; //Already existing options
	$res=$mysqli->query("SELECT DISTINCT($field) FROM devices") or die($mysqli->error());
	while($row=$res->fetch_array()) 
	{
		if($row["$field"]=='')continue;
		$options[]="<b onclick=document.getElementsByName('$field')[0].value=this.textContent style=cursor:pointer>".$row["$field"]."</b>";
	}
	echo implode(" | ",$options);
}

?>
