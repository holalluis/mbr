<?php
	include("mysql.php");
	$start = microtime(true); //start time
?>
<!doctype html><html><head>
	<meta charset=utf-8>
	<title>MySQL Query</title>
	<link rel=stylesheet href="estils.css">
</head><body onload="document.getElementsByName('query')[0].select()"><center>
<!--NAVBAR--><?php include("navbar.php") ?>
<!--TITLE--><h2 onclick=window.location="sql.php" style=cursor:pointer>Execute SQL query (advanced use)</h2>

<div>
	"DELETE" commands are not allowed for security
</div>

<!--WRITE QUERY FORM-->
<form method=POST>
	<?php $defaultQuery = isset($_POST['query']) ? $_POST['query'] : "SELECT * FROM devices"; ?>
	<table cellpadding=5>
		<tr><td><textarea name=query rows=3 cols=70><?php echo $defaultQuery?></textarea>
		<td><button>Continue</button>
	</table>
</form>

<?php
	if(!isset($_POST['query'])) die();

	//input: query
	$sql=$_POST['query'];

	//query does not allow delete commands
	if(strpos(strtoupper($sql),'DELETE')!==false) die("<b>Operation not allowed ($sql)</b>");
?>

<!--QUERY-->
<div><b><?php
	$res=$mysqli->query($sql) or die($mysqli->error());
	//in case that the query is an UPDATE
	if(strpos(strtoupper($sql),'UPDATE')!==false)
		die("Registers affected: ".$res->affected_rows());
	echo $res->num_rows." results";
?></b></div>

<!--result-->
<table cellpadding=3>
<?php
	//PROCESS QUERY RESULT ($res)
	$i=0;
	while($row=$res->fetch_array())
	{
		if($i==0) //Headers
		{
			echo "<tr>";
			foreach($row as $key=>$value)
				if(gettype($key)=="string")echo "<th>$key";
		}
		echo "<tr>";
		foreach($row as $key=>$value)
			if(gettype($key)=="string")echo "<td>$value";

		$i++;
	}
?>
</table>

<div style=color:green><b>QUERY EXECUTED CORRECTLY</b></div>

<!--time--><?php printf("Page generated in %f seconds",microtime(true)-$start)?>
