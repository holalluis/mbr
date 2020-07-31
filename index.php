<?php
  include 'mysql.php';
  $start = microtime(true); //record starting time
?>
<!doctype html><html><head>
  <meta charset=utf-8>
  <title>Quart Pilot Plant</title>
  <link rel=stylesheet href=estils.css>
  <style>
    #navbar div[page=index] a {color:black}
  </style>
</head><body><center>
<!--NAVBAR--><?php include("navbar.php")?>
<!--TITLE--><h1 onclick=window.location.reload() style=cursor:pointer>HOME &mdash; PLC READER</h1>

<div style=padding-bottom:1em>
  <b> Project under development. Version 0.1 </b>
</div>

<!--DB SIZE TABLE-->
<div class=inline style=max-width:49%>
  <table cellpadding=3>
    <tr><th colspan=3>Database:
    <tr><th>Tablename<th>Rows<th>Size (MB)
    <?php
      $sql="
          SELECT table_name,round(((data_length + index_length)/1024/1024),3) as 'size'
          FROM INFORMATION_SCHEMA.TABLES
          WHERE table_schema='mbr'
          ORDER BY TABLE_ROWS DESC
        ";
      $res=$mysqli->query($sql) or die($mysqli->error());
      $totalMB=0;
      $totalRows=0;
      while($row=$res->fetch_array())
      {
        $table_name=$row['table_name'];
        $size=$row['size'];

        $ress=$mysqli->query("SELECT COUNT(*) FROM $table_name");
        $rows=current($ress->fetch_array());

        $totalMB+=$size;
        $totalRows+=$rows;
        echo "<tr>
          <td>$table_name
          <td align=right>$rows
          <td align=right>$size";
      }
      echo "<tr align=right><td><b>Total</b><td><b>$totalRows</b><td><b>$totalMB</b>";
    ?>
  </table>
</div>

<!--LOGOS-->
<div>
  <a target=_blank href="http://www.icra.cat/"><img style="width:90px;height:70px;border:1px solid #eee" src=img/icra.png></a>
  <a target=_blank href="http://lequia.udg.es/"><img style="width:90px;height:70px;border:1px solid #eee" src=img/lequia.png></a>
</div>

<!--time-->
<?php printf("Page generated in %f seconds",microtime(true)-$start)?>
