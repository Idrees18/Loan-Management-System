<?php

$customer_id = $_GET['cust_id'];
$loan_id = $_GET['loan_id'];

// echo $customer_id;
// echo "<br>";
// echo $loan_id;

// update the status on loan as rejected.

// Include check for acs_code & authorize rejection.

session_start();
if (empty($_SESSION['emp_id'])) {
    header("Location: /Loan-Management-system/auth/index.php?AccessDenied");
    exit();
}
$con=mysqli_connect('localhost','root','','loan_management_system');

if(!$con){
    echo'Connection error'. mysqli_connect_errno();
}


// $SQL
$sql = "UPDATE loan_details SET loan_status=? WHERE loan_id=? AND customer_id=?";

$stmt = mysqli_stmt_init($con);
if(!mysqli_stmt_prepare($stmt, $sql)) {

    header("Location: /Loan-Management-system/auth/home/all_loans.php?msg=stmterror_reject_loan");
    exit();
    // replace with header soon.
}
else {
    $loan_status_upd = "Rejected";
    mysqli_stmt_bind_param($stmt, "sii", $loan_status_upd, $loan_id, $customer_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    // close them
    header("Location: /Loan-Management-system/auth/home/all_loans.php?loan_rejection=success");
exit();

mysqli_stmt_close($stmt);
mysqli_stmt_free_result($result);
mysqli_close($con);
}

