<?php
session_start();
include('../webPJ/DB/config.php');
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
</head>
<style>
body{
  padding:1%;
}
table {
  border-radius:25px;
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  background-color: #505050;
}

td, th {
  border: 2px solid #FFFFFF;
  text-align: center;
  color: #FFFFFF;
  padding: 8px;
  width: 33.33%;
}

</style>
<body>
<h1 id='demo'></h1>
<form action="../webPJ/DB/update.php" method="post" id="form_id">
  <table>
    <tr>
      <th>รูป</th>
      <th>เรียงลำดับ<br>ลำดับน้อยที่สุดคือสวยที่สุด (แต่ละภาพห้ามลำดับซ้ำกัน)</th>
      <th>คะแนน<br>คะแนนยิ่งสูงยิ่งสวยมาก ใส่คะแนนเป็นจำนวนเต็ม(1-5)</th>
    </tr>
  <?php 
    $user = $_SESSION['user'];
    $sku = $_GET['sku'];
    $next = $_GET['next'];
    $home = $_GET['home'];

    echo "<h1>SKU ".$sku."</h1>";
    $sql = "SELECT `sku` , `pic` FROM `$user` WHERE `sku` = '$sku' ORDER BY `pic` ASC";
    // echo $sql ;
    $result = mysqli_query($conn, $sql) or die(mysqli_error($result));
    $numrow = mysqli_num_rows($result);

    if($numrow > 0){

    // }else{
    //   echo "result 0";
    // }
    $spic='';
      $i=0; $arrRank = [];$arrScore = [];
      while($row =  mysqli_fetch_assoc($result)){
        $i++;
        $sku = $row['sku'];
        $pic = $row['pic'];
        $spic .= $pic.'|';
        $score = $pic."-".$i;
        $rank = $pic.",".$i;
        array_push($arrRank, $rank);
        array_push($arrScore, $score);
  ?>


    <?php 

    echo '<tr><center>
    <td><img src="SKU/'.$sku.'/'.$pic.'"alt ="'.$pic.'"  style="width:50%"></td>';

      echo "<td>";
      
      for($start_num=1; $start_num<= $numrow; $start_num++){
          echo '<label> <input type="radio"name="'.$rank.'" value="'.$start_num.'" required> '.$start_num.' &nbsp </label>';
      }      
  
  echo "</td>";
  echo '<td><input type="text" name="score" id="'.$score.'" style="width:50%" required><br></td>';
  echo '</tr></center>';
    };
  }
  ?>

    
  </table>
  <input type="hidden" name="pic" id="pic">
  <input type="hidden" name="ranks" id="ranks">
  <input type="hidden" name="score" id="score">
  <div style="float:right">

  <!-- <a role="button" class="btn btn-outline-primary" href="temp.php?page=<?php //echo $home; ?>" >home</a>&nbsp -->
    <a role="button" class="btn btn-outline-primary" href="temp.php?page=<?php echo $home; ?>">back</a>&nbsp
    <button type="submit" onclick="update()" class="btn btn-outline-success" style="float:right" id="alertNext">submit</button>
    <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
    <!-- <a role="button" type="submit" class="btn btn-outline-success" href="index.php" id="alertNext">submit</a> -->

    <!-- <button type="button" class="btn btn-outline-success">next</button> -->

  </div>
</form>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type='text/javascript' src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="js/jquery.unduplicated.js"></script>
<?php
echo "<script>
var x = '';
var score = '';
var rank = '';

  function update(){
    //alert('กรอกข้อมูลให้ครบทุกช่อง');
    
    ";
    
    foreach ($arrScore as $index => $value) {
      // echo " x = $('#$value').val() ;";
      echo "score += document.getElementById('$value').value+'|';";
      // echo "rank += document.getElementById('".$arrRank[$index]."').value+'|';";
      echo "var radioValue = $('input[name=\"".$arrRank[$index]."\"]:checked').val();
          if(radioValue){
            rank += radioValue + '|';
              // alert('Your are a - ' + radioValue);
          }               
      
      ";     
    }

  echo "
  document.getElementById('pic').value='$spic';
  document.getElementById('ranks').value=rank;
  document.getElementById('score').value=score;
 
  }
  </script>
  <script>  
$(function(){
     
    // กำหนดค่าเริ่มต้น
    $('.css_s').unduplicated({
      initialVal:['','','','']
    }); 
 
});
</script>
  
  ";
?>
</html>