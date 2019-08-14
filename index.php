<?php
// Start the session
session_start();
?>
<html>
<head>
<meta charset="utf-8">
<title>PRODUCT</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style>
body{
  padding:15%;
}
a{
  width:15%;
}
</style>
</head>
<body>
<center>
<form action="">
<h1>PRODUCT SKU</h1>
<h2>ยอดรวม</h2>
</form>
<?php
  include('../webPJ/DB/config.php');
  
  if(isset($_GET['user'])){   
    $user = $_GET['user'];
    echo $_SESSION['user'] = $user;
  }else{
    echo $user = $_SESSION['user'];
  }
  
  $sql0 = "SELECT DISTINCT `sku` FROM $user WHERE `status` = '0' ORDER BY sku ASC";
  $result0 = mysqli_query($conn, $sql0) or die(mysqli_error($result0));
  $numrows0 = mysqli_num_rows($result0);

  $sql1 = "SELECT DISTINCT `sku` FROM `$user` WHERE `status` = '1' ORDER BY sku ASC";
  $result1 = mysqli_query($conn, $sql1) or die(mysqli_error($result1));
  $numrows1 = mysqli_num_rows($result1);

  echo "<h3>$numrows1/$numrows0</h3>";
?>
    <table>
      <tr>
      <th><a role="button" class="btn btn-outline-success" href="temp.php?status=1" style='margin-right:1% ; width: 100%; '> SKU ที่ทำแล้ว</a></th>
      <th><a role="button" class="btn btn-outline-primary" href="temp.php?status=0" style='margin-left:1% ; width: 100%; '> SKU ที่ยังไม่ได้ทำ</a></th>
      </tr>
    </table>
</center>

</body>
</html>