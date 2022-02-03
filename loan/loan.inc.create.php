<?php

session_start();

$con=mysqli_connect('localhost','root','','loan_management_system');

if(!$con){
    echo'Connection error'. mysqli_connect_errno();

}
if(isset($_POST['submit']))
{
  
$customer_name = $_SESSION['name'];
$customer_id = $_SESSION['customer_id'];

$loan_type=$_POST["loantype"];
$loan_amount=$_POST["loanamount"];
$n=$_POST["loantenure"];
// $interest_rate=$_POST["interestrate"];

echo $customer_id;
echo "<br>";
echo $customer_name;
echo "<br>";
echo $loan_type;
echo "<br>";
echo $loan_amount;
echo "<br>";
echo $n;
echo "<br>";

if ($loan_type === "HOME LOAN") {
    // set interest
    $interest_rate = 7;

}
elseif ($loan_type === "PERSONAL LOAN") {
    // set interest
    $interest_rate = 11;

}
elseif ($loan_type === "VEHICLE LOAN") {
    $interest_rate = 9;
}


// EMI($loan_amount, $interest_rate, $n);

$sql = "INSERT INTO loan_details (customer_id, customer_name, loan_type, loan_amount, loan_tenure, interest_rate) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_stmt_init($con);

if(!mysqli_stmt_prepare($stmt, $sql)) {
  
    header("Location: /Loan-Management-system/loan.php?msg=stmterror");
    exit();
    // replace with header soon.
}
else {
    mysqli_stmt_bind_param($stmt, "isssss", $customer_id, $customer_name, $loan_type, $loan_amount, $n, $interest_rate);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    header("Location: /Loan-Management-system/loan/loan.php?msg=success");
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($con);

}
?>