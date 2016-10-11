<?php include("mysql.php")?>
<!doctype html><html><head>
	<meta charset="utf-8">
	<title>Control Rules</title>
	<link rel=stylesheet href="estils.css">
	<style>td{text-align:center}</style>
</head><body><center>
<!--NAVBAR-->      <?php include "navbar.php"?>
<!--TITLE-->       <h2 onclick=window.location.reload() style=cursor:pointer>View Control Rules</h2>
<!--SHOW FOLDER--> <div>Viewing: <b>C://xampp/htdocs/mbr/rules/</b></div>

<div>NOT IMPLEMENTED, WORK IN PROGRESS</div>

<!--RULES-->
<table cellpadding=5>
	<tr><th>File<th>Source Code
	<?php
		$path=".";
		$files=scandir($path); //SCAN DIRECTORY
		foreach($files as $f)
		{
			$filepath="$path/$f";
			//print only files, not starting by "."
			//and also not folders
			if($f[0]=="." || is_dir($filepath)) continue;
			//display
			echo "<tr><td>$f<td><a href='fileView.php?path=$path&file=$f' target=_blank >View</a>";
		}
	?>
</table>
