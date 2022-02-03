<?php 
session_start();
if (!isset($_SESSION['customer_id'])) {
  header("Location: /Loan-Management-system/Login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Payment & Details</title>
</head>
<body>
    <h1>Loan Payments & Detail</h1>
    <!-- Create Navigation Bar -->
    <a href="/Loan-Management-system/index.php">Home</a>
    <h4>Loan Information & Payment.</h4>
    <a href="/Loan-Management-system/loan/payments/previous_payments.php">Previous Payments</a>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Page Title</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
$con=mysqli_connect('localhost','root','','loan_management_system');

if(!$con){
    echo 'Connection error'. mysqli_connect_errno();
}
        $customer_id = $_SESSION['customer_id'];

        $sql = "SELECT * FROM emi WHERE customer_id=? ORDER BY loan_id DESC";

        $stmt = mysqli_stmt_init($con);

      // connection verify
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        // checking
      header("Location: /Loan-Management-system/loan/loan_details.php?error=sqlerrorstmt");
      }
      else {
        mysqli_stmt_bind_param($stmt, "i", $customer_id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
      }
  ?>
    <table>
      <tr>
        <td><b>LOAN ID</b></td><br>
        <td><b>Cust Name</b></td>
        <td><b>LOAN TYPE</b></td>
        <td><b>LOAN AMOUNT</b></td>
        <td><b>No. of EMI</b></td>
        <td><b>LOAN TENURE</b></td>
        <td><b>INTEREST RATE</b></td>
        <td><b>EMI</b></td>
        <td><b>Remaining Paymts.</b></td>
        <td><b>Repayed Amt.</b></td>
        <td><b>Due Amt.</b></td>
        <td><b>Action</b></td>
      </tr>
      <?php
            setlocale(LC_MONETARY, 'en_IN');
            while($row = mysqli_fetch_assoc($result)) {
            // customer_id and loan_id exists
            $loan_amount = $row['loan_amount'];
            $interest_rate = $row['interest_rate'];
            // loan_type = n;
            $n = $row['loan_tenure'];
            $customer_name = $row['customer_name'];
            $no_of_emi = $n;
            echo "<tr>";
            echo "<td>" . $row['loan_id'] . "</td>";
            $loan_id = $row['loan_id'];
            echo "<td>" . $row['customer_name'] . "</td>";
            echo "<td>" . $row['loan_type'] . "</td>";
            // using money_format to put the comma in digits
            echo "<td>₹" .money_format('%!.0n', $loan_amount)."</td>";
            echo "<td>" . $row['no_of_emi']."</td>";
            echo "<td>" . $row['loan_tenure']." Months</td>";
            echo "<td>" . $row['interest_rate']."</td>";
            echo "<td>₹" .money_format('%!.2n', $row['monthly_installment']). "</td>";
            echo "<td>" . $row['emis_left'] . "</td>";
            echo "<td>₹" .  money_format('%!.2n',$row['total_loan_amount_paid']). "</td>";
            echo "<td>₹" . money_format('%!.2n',$row['total_due_amount']). "</td>";
            
            // SQL query to check loan_payment for existing processing payments and hold payment until they are approved or rejected.
            $SQL = "SELECT * FROM loan_payment WHERE customer_id=? AND loan_id=? ORDER BY receipt_no DESC";
              
            $stmt = mysqli_stmt_init($con);

            if(!mysqli_stmt_prepare($stmt, $SQL)) {
              // checking
            header("Location: /Loan-Management-system/loan/loan_details.php?error=sqlerrorstmt");
            }
            else {
              mysqli_stmt_bind_param($stmt, "ii", $customer_id, $loan_id);
              mysqli_stmt_execute($stmt);
      
              $res = mysqli_stmt_get_result($stmt);
              $rw = mysqli_fetch_assoc($res);
            }
            if ($rw['paymt_status'] == 'Processing') {
              echo "<td>Paymt, Pending.</td>";
            }
            else{
              if ($row[total_due_amount] != 0) {
                echo "<td><a href='/Loan-Management-system/loan/payments/pay_emi.php?loan_id=".$row['loan_id']."&cust_id=".$customer_id."'>Pay</a></td>";  
              }else {
                echo "<td>Loan Cleared!</td>";
              }
            }
            echo "</tr>";
          }  
        mysqli_stmt_close($stmt);
        mysqli_stmt_free_result($result);
        mysqli_close($con);
      ?>
    </table>
</body>
</html>