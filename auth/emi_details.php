<?php
$con=mysqli_connect('localhost','root','','loan_management_system');

if(!$con){
    echo'Connection error'. mysqli_connect_errno();
}

// We are getting the customer_id and loan_id
$loan_id = $_GET['loan_id'];


// we should get the information of emi and others

$sql = "SELECT * FROM emi WHERE loan_id=?";

$stmt = mysqli_stmt_init($con);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    // checking
  header("Location: /Loan-Management-system/auth/emi_details.php?error=sqlerrorstmt");
}
else {
mysqli_stmt_bind_param($stmt, "i", $loan_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
}

// finally the accountant will approve or reject and same should update in db.


// store the information;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details about the loan</title>
</head>
<body>
  <br>
    EMI & Details about Loan No:<?php echo $loan_id; ?>
    <br>
    <a href="/Loan-Management-system/auth/home/all_loans.php">Back</a>


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
      </tr>
<?php
setlocale(LC_MONETARY, 'en_IN');
            
// customer_id and loan_id exists
$loan_amount = $row['loan_amount'];
$interest_rate = $row['interest_rate'];
// loan_type = n;
$n = $row['loan_tenure'];
$customer_name = $row['customer_name'];
$no_of_emi = $n;

echo "<tr>";
echo "<td>" . $row['loan_id'] . "</td>";
echo "<td>" . $row['customer_name'] . "</td>";
echo "<td>" . $row['loan_type'] . "</td>";
// using money_format to put the comma in digits
echo "<td>₹ " .money_format('%!.0n', $loan_amount)."</td>";
echo "<td>" . $row['no_of_emi']."</td>";
echo "<td>" . $row['loan_tenure']." Months</td>";
echo "<td>" . $row['interest_rate']."</td>";
echo "<td>" .money_format('%!.0n', $row['monthly_installment']). "</td>";
echo "<td>" . $row['emis_left'] . "</td>";
echo "<td>" . $row['total_loan_amount_paid'] . "</td>";
echo "<td>" . money_format('%!.0n',$row['total_due_amount']). "</td>";
echo "</tr>";
        // echo $r;
        mysqli_stmt_close($stmt);
        mysqli_stmt_free_result($result);
        mysqli_close($con);
      ?>
    </table>

</body>
</html>
