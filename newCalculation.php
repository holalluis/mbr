<?php 
	$start=microtime(true);
	include "mysql.php";
	include "displayDistinct.php";
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<link rel=stylesheet href="estils.css">
	<style> input{padding:0.5em} </style>
	<script>
		function writeDeviceToFormula(id)
		{
			var input=document.getElementsByName('formula')[0]
			input.value+="[#id"+id+"]"
			input.focus()
		}
	</script>
</head><body><center>
<!--NAVBAR--><?php include "navbar.php"?>
<!--TITLE--><h2 onclick=window.location.reload() style=cursor:pointer>Create New Calculation</h2>

<!--NEW CALCULATION FORM-->
<form method=POST><table cellpadding=10>
	<tr><th>Name		<td><input name=name 		autocomplete=off	required placeholder="e.g. Device1+Device2">
	<tr><th>Formula		<td><input name=formula 	autocomplete=off	required placeholder="e.g. [#id1]+[#id2]">
		<select onchange=writeDeviceToFormula(this.value)>
			<option>--select device
			<?php
				$sql="SELECT id,name FROM devices";
				$res=mysql_query($sql) or die();
				while($row=mysql_fetch_array($res))
				{
					$id=$row['id'];
					$name=$row['name'];
					echo "<option value=$id>id:$id - $name";
				}
			?>
		</select>
	<tr><th>Unit		<td><input name=unit		autocomplete=off	required placeholder="e.g. mg/l"> <?php displayDistinct('unit')?>
	<tr><th><td><button>Insert</button>
</table></form>

<?php
	/* NEW CALCULATION INSERT TO DB */

	//check input
	if(!isset($_POST['name'],$_POST['formula'],$_POST['unit']))die();

	//process input
	$name=mysql_real_escape_string($_POST['name']);
	$form=mysql_real_escape_string($_POST['formula']);
	$unit=mysql_real_escape_string($_POST['unit']);

	//check for duplicates in name and formula
	$duplicates=current(mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM calculations WHERE name='$name'")));
	if($duplicates>0)die("ERROR! This calculation name already exists!");
	$duplicates=current(mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM calculations WHERE formula='$form'")));
	if($duplicates>0)die("ERROR! This calculation formula already exists!");

	//check if formula is valid
	include "calculations_library.php";
	$ids=idsPerFormula($form);
	$result=applyFormula($form,$ids); //if it's incorrect, this function will die()

	//all is ok! insert calculation query
	$sql="INSERT INTO calculations (name,formula,unit) VALUES ('$name','$form','$unit')";
	mysql_query($sql) or die(mysql_error());

	//success & go to new device
	echo "<b>New Calculation '$name' Inserted Correctly!</b> ";
	$id=current(mysql_fetch_array(mysql_query("SELECT MAX(id) FROM calculations")));
	echo "<a href=calculation.php?id=$id>VIEW</a>";
?>
