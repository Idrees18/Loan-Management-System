<?php

session_start();
if (empty($_SESSION['emp_id'])) {
    header("Location: /Loan-Management-system/auth/index.php?AccessDenied");
    exit();
}
$con=mysqli_connect('localhost','root','','loan_management_system');

if(!$con){
    echo'Connection error'. mysqli_connect_errno();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History of Payments</title>
</head>
<body>

<!-- STYLE -->

<style>
* {
  box-sizing: border-box;
}

/* Style the body */
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

/* Header/logo Title */
.header {
  padding: 20px;
  text-align: center;
  background: #ADEFD1FF ;
  color: #00203FFF;
}

/* Increase the font size of the heading */
.header h1 {
  font-size: 40px;
}

.header p {
  font-size: 30px;
}
.navbar {
  overflow: hidden;
  background-color: #333;
}
.backbtn {
  background-color: #555;
  color: rgb(252, 244, 244);
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  position:middle;
  opacity: 0.8;
  bottom: 23px;
  left: 28px;
  width: 280px;
  }
  backbtn:hover {
  opacity: 0.8;
}
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;

}

tr:nth-child(even) {
    background-color: white;
}
tr:nth-child(odd) {
    background-color:grey;
}
</style>

    <?php
    if (isset($_SESSION['emp_id'])) {
        echo "<a href='/Loan-Management-system/auth/logout.php'>Logout</a>";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        echo '<a href="/Loan-Management-system/auth/home/index.php">Back</a>';
    }
      ?>
    <h2>Payment Approval Site.</h2>

    <h3>Loans for Approval & Rejection</h3>
<table>
    <tr>
    <td><b>Receipt No.</b></td><br>
    <td><b>Loan ID</b></td>
    <td><b>Cust ID</b></td>
    <td><b>Cust Name</b></td>
    <td><b>EMI Paid</b></td>
    <td><b>Paymt. Date</b></td>
    
    <td colspan=2><b>Paymt. Status Upd.</b></td>
    </tr>
    <?php
    $sql = "SELECT * FROM loan_payment WHERE paymt_status='Processing' ORDER BY receipt_no DESC";

    $stmt = mysqli_stmt_init($con);
    
    // connection verify
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        // checking
    header("Location: /Loan-Management-system/auth/home/all_payts.php?error=sqlerrorstmt");
    }
    else {
        mysqli_stmt_bind_param($stmt);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); 
    }

    setlocale(LC_MONETARY, 'en_IN');
    while($row = mysqli_fetch_assoc($result)) {
        // vars for GET
        $customer_id = $row['customer_id'];
        $loan_id = $row['loan_id'];
        $receipt_no = $row['receipt_no'];
        echo "<tr>";
        echo "<td>" . $row['receipt_no'] . "</td>";
        echo "<td>" . $row['loan_id'] . "</td>";
        echo "<td>" . $row['customer_id'] . "</td>";
        
        echo "<td>" . $row['customer_name'] . "</td>";
        // using money_format to put the comma in digits
        echo "<td>₹ " .money_format('%!.2n', $row['emi_payed_amount'])."</td>";
        echo "<td>" . $row['paymt_date'] . "</td>";
        echo "<td><a href='/Loan-Management-system/auth/home/paymt_apr.php?cust_id=".$customer_id."&loan_id=".$loan_id."&recp_id=".$receipt_no."'>Received</a></td>";
        echo "<td><a href='/Loan-Management-system/auth/home/paymt_rejc.php?cust_id=".$customer_id."&loan_id=".$loan_id."'>Not Received</a></td>";
        echo "</tr>";
    }
    mysqli_stmt_close($stmt);
    mysqli_stmt_free_result($result);
    mysqli_close($con);
    ?>
    
</table>
</body>
</html>