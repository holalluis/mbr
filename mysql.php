<?php
  $mysqli=mysqli_connect("127.0.0.1","root","") OR die(mysqli_error());
  $mysqli->select_db("mbr") OR die($mysqli->error());
  //TO DO $sql="Crea la base de dades si no existeix"
?>
