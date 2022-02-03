<?php
$customer_id = $_POST['customer_id'];
$loan_id = $_POST['loan_id'];

// echo $customer_id;
// echo "<br>";
// echo $loan_id;

$con=mysqli_connect('localhost','root','','loan_management_system');

if(!$con){
    echo 'Connection error'. mysqli_connect_errno();
}

$sql = "SELECT * FROM emi WHERE customer_id=? AND loan_id=?";

$stmt = mysqli_stmt_init($con);

// connection verify
if(!mysqli_stmt_prepare($stmt, $sql)) {
// checking
header("Location: /Loan-Management-system/loan/loan_details.php?error=sqlerrorstmt");
}
else {
mysqli_stmt_bind_param($stmt, "ii", $customer_id, $loan_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
setlocale(LC_MONETARY, 'en_IN');
$row = mysqli_fetch_assoc($result);

// init vars related to emi and loan_payment table.
$emi_payed_amt = number_format((float) $row['monthly_installment'], 2, '.', '');
$customer_name = $row['customer_name'];

echo "<br>";
echo "emi ".$emi_payed_amt;
echo "<br>";
echo "<br>";
echo "Name: ".$customer_name;
echo "<br>";
date_default_timezone_set("Asia/Kolkata");
$date = date("H:i:a d/m/Y");
echo $date;


// SQL
$SQL = "INSERT INTO loan_payment (loan_id, customer_id, customer_name, emi_payed_amount, paymt_date) VALUES (?,?,?,?,?)";

$stmt = mysqli_stmt_init($con);

if(!mysqli_stmt_prepare($stmt, $SQL)) {
  
    header("Location: /Loan-Management-system/loan/payments/loan_payment.php?msg=stmterror");
    exit();
    // replace with header soon.
}
else {
    mysqli_stmt_bind_param($stmt, "iisss", $loan_id, $customer_id, $customer_name, $emi_payed_amt, $date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    header("Location: /Loan-Management-system/loan/payments/previous_payments.php?msg=success");
    exit();
}

}
?>