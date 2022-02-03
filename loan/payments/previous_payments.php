<?php
session_start();
$customer_id = $_SESSION['customer_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previous Payments</title>
</head>
<body>
    <h2>Previous Payments</h2>
    <h5><a href="/Loan-Management-system/loan/payments/loan_payment.php">Back</a></h5>
    <!-- show previous payments below-->
    <?php
    
    $con=mysqli_connect('localhost','root','','loan_management_system');
    
    if(!$con){
        echo'Connection error'. mysqli_connect_errno();
    }
    
    $sql = "SELECT * FROM loan_payment WHERE customer_id=? ORDER BY receipt_no DESC";

    $stmt = mysqli_stmt_init($con);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
  
        header("Location: /Loan-Management-system/loan/payments/previous_payments.php?msg=stmterror");
        exit();
        // replace with header soon.
    }
    else {
        mysqli_stmt_bind_param($stmt, "i", $customer_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }
    ?>
    <table>
      <tr>
        <td><b>Receipt_no</b></td><br>
        <td><b>Loan ID</b></td>
        <td><b>Cust ID</b></td>
        <td><b>Cust Name</b></td>
        <td><b>EMI Paid</b></td>
        <td><b>Date Paid</b></td>
        <td><b>Payment Status</b></td>
      </tr>
      <?php
      setlocale(LC_MONETARY, 'en_IN');
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" .$row['receipt_no']."</td>";
            echo "<td>" .$row['loan_id']."</td>";
            echo "<td>" .$row['customer_id']."</td>";
            echo "<td>" .$row['customer_name']."</td>";
            // using money_format to put the comma in digits
            echo "<td>₹ ".money_format('%!.2n', $row['emi_payed_amount'])."</td>";
            echo "<td>" .$row['paymt_date']."</td>";
            echo "<td>" .$row['paymt_status'] . "</td>";
            // shows view emi details only if they are approved.
            echo "</tr>";
        }
        mysqli_stmt_close($stmt);
        mysqli_stmt_free_result($result);
        mysqli_close($con);
      ?>
    </body>
</html>