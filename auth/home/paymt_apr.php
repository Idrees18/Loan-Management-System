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

$customer_id = $_GET['cust_id'];
$receipt_no = $_GET['recp_id'];
$loan_id = $_GET['loan_id'];

// echo $customer_id;
// echo "<br>";
// echo $receipt_no;
// echo "<br>";
// echo $loan_id;
// echo "<br>";

// update the payment status of each receipt.
$sql = "UPDATE loan_payment SET paymt_status=? WHERE customer_id=? AND receipt_no=? AND loan_id=?";

$paymt_status_apr = "PAID";

$stmt = mysqli_stmt_init($con);

// connection verify
if(!mysqli_stmt_prepare($stmt, $sql)) {
    // checking
header("Location: /Loan-Management-system/auth/home/all_payts.php?error=paymt_apr_stmt_error");
}
else {
    mysqli_stmt_bind_param($stmt, "siii", $paymt_status_apr, $customer_id, $receipt_no, $loan_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    // header("Location: /Loan-Management-system/auth/home/all_payts.php?apr=success");
    // exit();


    $sql1 = "SELECT * FROM emi WHERE customer_id=? AND loan_id=?";

    $stmt = mysqli_stmt_init($con);

    if(!mysqli_stmt_prepare($stmt, $sql1)) {
        // checking
    header("Location: /Loan-Management-system/auth/home/all_payts.php?error=paymt_apr_stmt_error_sql1_error");
    exit();
    }
    else {
    mysqli_stmt_bind_param($stmt, "ii", $customer_id, $loan_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);
    // create vars.
    $total_amt = $row['total_due_amount'];
    $paid_loan_amt = $row['total_loan_amount_paid'];
    $emis_left = $row['emis_left'];
    $monthly_installment = $row['monthly_installment'];

    // echo "<br>";
    // echo "total_due_amount: ".$total_amt;
    // echo "<br>";
    // echo "emis_left: ".$emis_left;
    // echo "<br>";
    // echo "total_loan_amount_paid: ".$paid_loan_amt;
    // echo "<br>";
    // echo "monthly_installment: ".$monthly_installment;
    // echo "<br>";
    // echo "<br>";
    // echo "<br>";

    // UPDATED ONCE
    $upd_emis_left = $emis_left - 1;
    // echo "upd_emis_left: ".$upd_emis_left;
    // echo "<br>";
    $upd_paid_loan_amt = $paid_loan_amt + $monthly_installment;
    // echo "upd_paid_loan_amt: ".$upd_paid_loan_amt;
    // echo "<br>";
    $upd_total_amt = $total_amt - $monthly_installment;
    // echo "upd_total_amt: ".$upd_total_amt;
    // echo "<br>";
    
    
    $SQL = "UPDATE emi SET emis_left=?, total_loan_amount_paid=?,  total_due_amount=? WHERE customer_id=? AND loan_id=?";

    $stmt = mysqli_stmt_init($con);

    if(!mysqli_stmt_prepare($stmt, $SQL)) {
        // checking
    header("Location: /Loan-Management-system/auth/emi_details.php?error=sqlerrorstmt_SQL_ERROR.");
    }
    else {
    mysqli_stmt_bind_param($stmt, "issii", $upd_emis_left, $upd_paid_loan_amt, $upd_total_amt, $customer_id, $loan_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    
    header("Location: /Loan-Management-system/auth/home/all_payts.php?apr=success");
    
    exit();
}
}
mysqli_stmt_close($stmt);
mysqli_stmt_free_result($result);
mysqli_close($con);
    
}
?>