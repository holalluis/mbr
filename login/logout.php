<?php
	setcookie("session","", time()-3600, "/");
	header("Location: ".$_SERVER['DOCUMENT_ROOT']."");
?>
