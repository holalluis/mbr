<?php

	include ("/mbr/mysql.php");
	
	//INPUT
	$user = mysql_real_escape_string($_POST['user']);
	$pass = mysql_real_escape_string($_POST['pass']);
			
	//QUERY
	$res=mysql_query("SELECT id FROM users WHERE name='$user' AND pass='$pass'");
	
	//CHECK
	if(mysql_num_rows($res)!=1)die('password error');

	//FIND ID
	$id=current(mysql_fetch_array($res));

	//COOKIE
	setcookie("session", $id, time() + (86400 * 1),'/');  					// Lasts for 1 day

	//REDIRECT
	header("Location: ".$_SERVER['DOCUMENT_ROOT']."/mbr/index.php");		

?>
