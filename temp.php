<?php
// Start the session
session_start();
?>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <?php
    include('../webPJ/Homedata.php');
  ?>
</head>
    <body>
    
        <?php
            include('../webPJ/DB/config.php');

            if(isset($_GET['status'])){
                $_SESSION['status'] = $_GET['status'];
            }
            $user = $_SESSION['user'];
            $state = '';
            if(isset($_SESSION['status'])){
                $status = $_SESSION['status'];
                if($status == '0'){
                    $state = 'SKU ที่ยังไม่ได้ทำ';
                }else if($status == '1'){
                    $state = 'SKU ที่ทำแล้ว';
                }   
            }
            $sql = "SELECT DISTINCT `sku` FROM `$user` WHERE `status` = '$status' ORDER BY sku ASC";
            $result = mysqli_query($conn, $sql) or die(mysqli_error($result));
            $numrows = mysqli_num_rows($result);
            $perpage = 100;
            $half_perpage = ceil($perpage / 2);

            if( isset($_GET["page"]) ) {
                $page = $_GET['page'];
            }
            else {
                $page = 1;
            }

            $start_idx = ($page-1) * $perpage;
            $end_idx = $start_idx + $perpage;
            
            if ( $end_idx >= $numrows ) {
                $end_idx = $numrows;
            }

            // echo $start_idx;
            // echo '<br>';
            // echo $end_idx;

            $rows = [];
            $i = 0;
            while($row = mysqli_fetch_assoc($result)) {
                
                if ( $i >= $start_idx && $i < $end_idx ){
                    $rows[] = $row['sku'];
                }
                $i++;
            }


            $end_1 = $half_perpage;
            $end_2 = $perpage;

            if ($end_1 > count($rows)){
                $end_1 = count($rows);
            }

            if ($end_2 > count($rows)) {
                $end_2 = count($rows);
            }
        ?>

        <div class="container-fluid">
            <div class='row'>
                <div class="col-sm-4"> 
                    <h1>Product SKU</h1>
                    <h3><li><?php echo $state; ?></li></h3>
                </div>
                <div class="col-sm-4"> <h1><a href='index.php' role="button" class="btn btn-success">HOME</a></h1></div>
            </div>
            <div class="row">            
                <div>
  
                <table>
                        <tr>
                            <!-- <th>No.</th> -->
                            <th>SKU</th>
                            <!-- <th>Status</th> -->
                        </tr>
                        <?php
                            for( $i=0; $i<$end_2; $i++ ) {
                                
                                echo '<tr>';
                                    // echo "<td>".($i+1)."</td>";
                                if($status == 0){
                                    echo '<td><a href = "Product.php?sku='.$rows[$i].'&home='.$page.'&next='.$rows[$i].'">'.$rows[$i].' </a></td>';
                                
                                }else{
                                    echo '<td>'.$rows[$i].' </a></td>';
                                }
                                
                                echo '</tr>';

                            }
                        ?>
                    </table>
                </div>
                <!-- <div class="col-sm-9 col-md-6">
                <table>
                        <tr>  
                            <th>SKU</th>
                            <!-- <th>Status</th> -->
                        </tr>
                        <?php
                           // for( $i=$end_1; $i<$end_2; $i++ ) {
                                
                               // echo '<tr>';
                               // echo '<td><a href = "Product.php?sku='.$rows[$i].'&home='.$page.'&next='.$rows[$i].'">'.$rows[$i].' </a></td>';
                               // echo '</tr>';
                            //}
                        ?>
                    </table>
                </div> 
            </div>
            </div>

        <ul class="pagination pagination-lg">
        <?php
            $total_page = ceil( $numrows / $perpage );
            for($i=1;$i<=$total_page;$i++) {
                echo '<li><a href="temp.php?page='.$i.'">'.$i.'</a></li>';
            }
        ?>
        </ul>

    </body>
</html>