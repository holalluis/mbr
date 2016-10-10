<?php
/*
	run python script "updateSetpoint.py" with specified id and value
*/

//input
$plcPosition=$_GET['plcPosition'];
$value=$_GET['value'];

//check input
if($plcPosition=="")die("ERROR: no device id specified");
if($value=="")$value=0;

//build shell command
$command="python updateSetpoint.py $plcPosition $value";

echo "<h2>Executing: '$command'</h2>";

?>
<hr><div><code><?php passthru($command)?></code></div>
