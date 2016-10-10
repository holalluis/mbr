<?php

function displayDistinct($field)
/* display different existing values from fields in devices table */
{
	$options=[]; //Already existing options
	$res=mysql_query("SELECT DISTINCT($field) FROM devices") or die(mysql_error());
	while($row=mysql_fetch_array($res)) 
	{
		if($row["$field"]=='')continue;
		$options[]="<b onclick=document.getElementsByName('$field')[0].value=this.textContent style=cursor:pointer>".$row["$field"]."</b>";
	}
	echo implode(" | ",$options);
}

?>
