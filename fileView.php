<?php
	//view the source code of path/file

	//INPUT
	$path=$_GET['path'];
	$file=$_GET['file'];

	//read file contents and display it
	$content="
		<head> <title>$file</title> </head>
		<body>
		<h2>$file</h2>
			<code>
				<pre>".htmlspecialchars(file_get_contents("$path/$file"))."</pre>
			</code>";
	
	echo $content;
?>
