<?php
/*
	run python script "updateSetpoint.py" with specified address and value
*/

//GET plcPosition (plc address)
if(!isset($_GET['plcPosition'])) 
	die("ERROR: no plc position specified");
else
	$plcPosition=$_GET['plcPosition'];

//GET value
if(!isset($_GET['value'])) 
	$value=0;
else
	$value=$_GET['value'];

//build shell command
$command="python updateSetpoint.py $plcPosition $value";

echo "<h2>Executing: '$command'</h2>";

?>
<hr><div><code><?php passthru($command)?></code></div>
