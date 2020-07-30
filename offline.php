<?php
  $start=microtime(true);
  include'mysql.php';
?>
<!doctype html><html><head>
  <meta charset=utf-8>
  <title>Offline</title>
  <link rel=stylesheet href="estils.css">
  <style>
    #navbar div[page=offline] a {color:black}
  </style>
</head><body><center>
<!--NAVBAR--><?php include"navbar.php"?>
<!--TITLE--><h2 onclick=window.location.reload() style=cursor:pointer>Offline Records</h2>

<h3 style=margin-bottom:2em>The readings of the addresses type="Offline" have no PLC address, they are inserted here manually</h3>

<!--OFFLINE DEVICES-->
<table cellpadding=5>
  <tr><!--<th>Id-->
  <th>Description<th>Readings<th>Insert New Offline Reading<th>Unit<th>Ubication</tr>
  <?php
    $sql="
    SELECT id,name,unit,ubication,count FROM devices LEFT JOIN
    (
      SELECT id_device,COUNT(*) as count
      FROM readings
      GROUP BY id_device
    ) cc ON devices.id=cc.id_device
    WHERE type='Offline'";
    $res=$mysqli->query($sql);
    $results=$res->num_rows;
    echo "<b>$results addresses type='Offline' found</b>"; //value oustide a <th> element will show at the top of the table
    while($row=$res->fetch_array())
    {
      $id     = $row['id'];
      $name   = $row['name'];
      $ubic   = $row['ubication'];
      $unit   = $row['unit'];
      $count  = $row['count'];

      //if count is null
      if(!$count)$count=0;

      //display
      echo "<tr>
          <!--<td>$id-->
          <td><a href=device.php?id=$id>$name</a>
          <td align=center>$count
          <td><form action='newReading.php' method=POST>
            <input name=id_device type=hidden  value=$id                    required>
            Date
            <input name=date    autocomplete=off type=date value='".date("Y-m-d",time())."' required>
            <input name=time    autocomplete=off type=time value='".date("H:i",time())."'   required>
            Value
            <input name=value     placeholder='$unit' autocomplete=off required style='width:40px' type=number>
            <button>Insert</button>
          </form>
          <td>$unit
          <td><a href=devices.php?ubication=$ubic>$ubic</a>
      ";
    }
    if($res->num_rows==0)
    {
      echo "<tr><td colspan=7>~No devices type Offline created yet";
    }
  ?>
</table>

<!--TIME--><?php printf("Page generated in %f seconds",microtime(true)-$start)?>
