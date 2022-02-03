<!-- check for login -->

<!-- check if the person came to the login page correctly -->

<!-- check for username and password -->


<?php 
$con=mysqli_connect('localhost','root','','loan_management_system');

if(!$con){
    echo'Connection error'. mysqli_connect_errno();

}
else {
  echo "Connected";
}

// check for auth

if(isset($_POST['login'])) {
  $usrname = $_POST['uname'];
  $pswd = $_POST['psw'];
  
  echo $usrname;
  echo "<br>";
  echo $pswd;

  //using stmt statements
  $sql = 'SELECT * FROM customer WHERE username=?';

  // stmt init
  $stmt = mysqli_stmt_init($con);

  // connection verify
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    // checking
    header("Location: ../login.php?error=sqlerrorstmt");
  }
  else {
    mysqli_stmt_bind_param($stmt, "s", $usrname);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    echo "Success";
    echo "<br>";
    // echo $row['pswd'];
    if($row['pswd'] == $pswd) {
      // echo "correct password";
      session_start();
      $_SESSION['usrname'] = $row['username'];
      $_SESSION['name'] = $row['name'];
      $_SESSION['customer_id'] = $row['customer_id'];

      header("Location: ../index.php?login=success");
    }
    else {
      // echo "wrong password";
      header("Location: ../Login.php?accessdenied");
    }
  }
}
else {
  header("Location: ../login.php?accessdenied");
}
?>
