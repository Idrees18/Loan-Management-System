<!-- LOGIN SYSTEM -->
<?php
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
    <title>Employee Login System</title>
</head>
<body>
    <h2>Login System - Employee</h2>
    <a href="/Loan-Management-system/auth/index.php">Back</a>
    <br>
    <br>
    <form action="index.php" method="post">
        <input type="text" placeholder="Username" name="emp_username">
        <br>
        <input type="password" placeholder="accesscode" name="emp_access_code">
        <br>
        <input type="password" placeholder="Password" name="emp_passwd">
        <br>
        <button type="submit" name="login-emp">Login</button>
    </form>

    <?php
        if (isset($_POST['login-emp'])) {
            // echo "true";
            $emp_username = $_POST['emp_username'];
            $emp_access_code = $_POST['emp_access_code'];
            $emp_passwd = $_POST['emp_passwd'];

            echo $emp_username;
            echo $emp_access_code;
            echo $emp_passwd;

            // checking db for authorization
            $sql = "SELECT * FROM employees WHERE emp_username=? AND emp_access_code=?";

            $stmt = mysqli_stmt_init($con);

            if(!mysqli_stmt_prepare($stmt, $sql)) {
  
                header("Location: /Loan-Management-system/auth/index.php?msg=stmterror");
                exit();
                // replace with header soon.
            }
            else {
                mysqli_stmt_bind_param($stmt, "ss", $emp_username, $emp_access_code);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                
                $row = mysqli_fetch_assoc($result);

                if ($emp_passwd == $row['emp_passwd']) {
                    echo "Logged in!";
                    session_start();
                    $_SESSION['emp_id'] = $row['emp_id'];
                    $_SESSION['emp_name'] = $row['emp_name'];
                    $_SESSION['emp_desig'] = $row['emp_desig'];
                    // acs_code while for loan rejection and approval.
                    $_SESSION['emp_access_code'] = $row['emp_access_code'];
                    header("Location: /Loan-Management-system/auth/home/index.php?msg=success");
                    exit();
                }
                else {
                    echo "Wrong password";
                }
            }
            
        }
        else {
            echo "false";
        }
    ?>
</body>
</html>