<?php

    $db=mysqli_connect("localhost","root","","bill");   
    if(!$db) die("Unable to Connect".mysqli_connect_error());

?>

<?php
$con  = mysqli_connect("localhost","root","","bill");
 if (!$con) {
     # code...
    echo "Problem in database connection! Contact administrator!" . mysqli_error();
 }else{
         $sql ="SELECT * FROM bill";
         $result = mysqli_query($con,$sql);
         $chart_data="";
         while ($row = mysqli_fetch_array($result)) { 
 
            $sales[]  = $row['units']  ;
            $productname[] = $row['amount'];
        }
 
 }
?>