<!-- APPROVE -->
<?php 
if (isset($_POST['approve'])) {
    header("Location: /Loan-Management-system/auth/cong.html?pushed!");
    exit();
}
else {
$con=mysqli_connect('localhost','root','','loan_management_system');

if(!$con){
    echo'Connection error'. mysqli_connect_errno();
}


$loan_id = $_GET['loan_id'];
$customer_id = $_GET['cust_id'];

echo $loan_id;
echo "<br>";
echo $customer_id;

// store vars and then push it too the emi table.


// we should get the information of emi and others

$sql = "SELECT * FROM loan_details WHERE loan_id=? AND customer_id=?";

$stmt = mysqli_stmt_init($con);

if(!mysqli_stmt_prepare($stmt, $sql)) {
    // checking
  header("Location: /Loan-Management-system/auth/test.php?error=sqlerrorstmt");
}
else {
mysqli_stmt_bind_param($stmt, "ss", $loan_id, $customer_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
}

// customer_id and loan_id exists
$loan_amount = $row['loan_amount'];
$interest_rate = $row['interest_rate'];
// loan_type = n;
$n = $row['loan_tenure'];
$customer_name = $row['customer_name'];
$no_of_emi = $n;


// EMI($loan_amount, $interest_rate, $n);
$loan_type = $row['loan_type'];
$r = $interest_rate / 100 / 12;
(float) $x = (float) pow((1+$r), $n);
(float) $E = (int) $loan_amount * $r * (($x) / ($x - 1));
setlocale(LC_MONETARY, 'en_IN');
// $EMI = money_format('%!.0n', $E);

// check with undo round,
$monthly_installment = number_format((float)$E, 2, '.', '');
$emis_left = $n;
$total_loan_amount_paid = "0";
$total_due_amount = number_format((float) $monthly_installment * $no_of_emi, 2, '.', '') ;


echo "<br>";
echo "loan_id ". $row['loan_id'];
echo "<br>";
echo "customer_id " . $row['customer_id'] . "</td>";
echo "<br>";
echo "customer_name " . $row['customer_name'] . "</td>";
echo "<br>";
echo "loan_type " . $row['loan_type'] . "</td>";
echo "<br>";
echo "Loan amount ₹ " .money_format('%!.0n', $row['loan_amount'])."</td>";
echo "<br>";
echo "loan_tenure " . $row['loan_tenure'] . " Months</td>";
echo "<br>";
echo "interest_rate " . $interest_rate . "</td>";
echo "<br>";
echo "EMI " .money_format('%!.0n',$E). "</td>";
echo "<br>";
echo "loan_status " . $row['loan_status'] . "</td>";
echo "<br>";
// echo $sql;

$SQL = "INSERT INTO `emi` (loan_id, customer_id, customer_name, loan_type, loan_amount, no_of_emi, loan_tenure, interest_rate, monthly_installment, emis_left, total_loan_amount_paid, total_due_amount) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";


$stmt = mysqli_stmt_init($con);
if(!mysqli_stmt_prepare($stmt, $SQL)) {

    header("Location: /Loan-Management-system/auth/home/all_loans.php?msg=stmterror");
    exit();
    // replace with header soon.
}
else {
    mysqli_stmt_bind_param($stmt, "iisssssssiss", $loan_id, $customer_id, $customer_name, $loan_type, $loan_amount, $no_of_emi, $n, $interest_rate, $monthly_installment, $emis_left, $total_loan_amount_paid, $total_due_amount);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    $SQL2 = "UPDATE loan_details SET loan_status=? WHERE loan_id=? AND customer_id=?";

    $stmt = mysqli_stmt_init($con);
    if(!mysqli_stmt_prepare($stmt, $SQL2)) {

        header("Location: /Loan-Management-system/auth/home/all_loans.php?msg=stmterror1");
        exit();
        // replace with header soon.
    }
    else {
        $loan_approved = "Approved";
        mysqli_stmt_bind_param($stmt, "sii", $loan_approved, $loan_id, $customer_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        header("Location: /Loan-Management-system/auth/home/all_loans.php?msg=success");
    exit();
    }
}
mysqli_stmt_close($stmt);
mysqli_stmt_free_result($result);
mysqli_close($con);
}
?>