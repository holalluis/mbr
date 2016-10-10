<div style='margin:0.2em;padding:0.2em;text-align:right;'>
<?php
	//si la sessio està iniciada
	if(isset($_COOKIE['session']))
	{
		$id=$_COOKIE["session"];
		$nom=current(mysql_fetch_array(mysql_query("SELECT name FROM users WHERE id=$id")));
		echo " <b>Welcome $nom </b>";
		echo " | <a href='logout.php'>Logout</a>";
	}
	else //si la sessio no esta iniciada
	{
		echo "<form action='login.php' method=POST>
					USER: 
						<input name='user' placeholder='User name'>
					PASSWORD:
						<input name='pass' type='password' placeholder='Password'>
					<button type=submit>Login</button>
			</form>";
	}
?>
</div>
