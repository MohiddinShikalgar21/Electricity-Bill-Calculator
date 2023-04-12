<?php
include "conn.php";
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Electricity Bill Calculator</title>
    <style>
         @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600&display=swap");
   *{
       font-family: 'Nunito', sans-serif;
       
    }
        body{
            background-color:#6abadeba;
        }
        .login{
          width: 382px;
          align-items:center;
          justify-content:center;
          overflow: hidden;
          margin: auto;
          margin-top:2%;
          margin: 10 0 0 450px;
          padding: 40px;
          background: #23463f;
          border-radius: 15px ;
        }
    button {
      width: 100%;
      background-color: #155e91;
      color: white;
      padding: 3%;
    } 
    button:hover {
      opacity: 0.6;
      cursor: pointer;
    }
    input{
      width: 100%;
      margin: 10px 0;
      border-radius: 5px;
      padding: 15px 18px;
      box-sizing: border-box;
  }
    </style>
</head>

<?php
$result_str = $result = '';
if (isset($_POST['submit'])) {
    $units = $_POST['units'];
    if (!empty($units)) {
        $result = calculate_bill($units);
        if($units<=50) $result_str = 'Your Consumption in Units is applicable to cost of Rs.3.50 per unit. Hence Consumption of '.$units.'*3.50 results into your payable bill. So the Total Payable Amount of ' . $units . ' is Rs.' . $result;
        else if($units>50 && $units<=100) $result_str = 'Your Consumption in Units is applicable to cost of Rs.4 per unit. Hence Consumption of '.$units.'*4 results into your payable bill. So the Total Payable Amount of ' . $units . ' is Rs.' . $result;
        else if($units>100 && $units<200) $result_str = 'Your Consumption in Units is applicable to cost of Rs.5.20 per unit. Hence Consumption of '.$units.'*5.20 results into your payable bill. So the Total Payable Amount of ' . $units . ' is Rs.' . $result;
        else $result_str = 'Your Consumption in Units is applicable to cost of Rs.6.50 per unit. Hence Consumption of '.$units.'*6.50 results into your payable bill. So the Total Payable Amount of ' . $units . ' is Rs.' . $result;
        
        mysqli_query($db,"INSERT INTO `bill`(`month`,`units`,`amount`) VALUES('$_POST[month]','$_POST[units]','$result');");
    }
}
/**
 * To calculate electricity bill as per unit cost
 */
function calculate_bill($units) {
    $unit_cost_first = 3.50;
    $unit_cost_second = 4.00;
    $unit_cost_third = 5.20;
    $unit_cost_fourth = 6.50;

    if($units <= 50) {
        $bill = $units * $unit_cost_first;
    }
    else if($units > 50 && $units <= 100) {
        $temp = 50 * $unit_cost_first;
        $remaining_units = $units - 50;
        $bill = $temp + ($remaining_units * $unit_cost_second);
    }
    else if($units > 100 && $units <= 200) {
        $temp = (50 * 3.5) + (100 * $unit_cost_second);
        $remaining_units = $units - 150;
        $bill = $temp + ($remaining_units * $unit_cost_third);
    }
    else {
        $temp = (50 * 3.5) + (100 * $unit_cost_second) + (100 * $unit_cost_third);
        $remaining_units = $units - 250;
        $bill = $temp + ($remaining_units * $unit_cost_fourth);
    }
    return number_format((float)$bill, 2, '.', '');
}

?>

<body>
	<div id="page-wrap">
        <div class="login">
        <img src="bill.png" alt="VIT" style="display: inline-block; height: 100px; margin-left: 65px;">
        <h2 style="color:white; margin-left:35px;font-size:26px;">Electricity Bill Calculator</h2>
		<form action="" method="post" id="quiz-form">
                <input type="text" name="month" id="month" placeholder="Please Enter the Month of Consumption" />
            	<input type="number" name="units" id="units" placeholder="Please Enter No. of Units Consumed" />
            	<button type="submit" name="submit" id="submit" value="Submit" >Submit</button>
		</form>
        <br><br>
        <?php echo '<span style="color:white; font-family: Nunito; font-size:16px;">'  . $result_str; ?>
        <br><br>
        <h3 style="fontfamily:sans-serif;">Total Amount in Rupees: <?php echo '<span style="color:white; font-family: sans-serif; font-size:18px;">'  . $result; ?></h3>
	    <div>
        <div>
            <a href="view.php"><button class="btn" style="height:40px; width:80%; margin-top:10px;margin-left:30px;" type="edit" name="edit" value="Edit">View Existing Records</button></a>
        </div>
	</div>
	</div>
    </div>
</body>
</html>

