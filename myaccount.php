<?php
  session_start();
?>
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
</head>
<body>

<div class="header">
  <h1>LOAN MANAGEMENT</h1>
  <h4>MY ACCOUNT</h4>
</div>
<div class="navbar">
    <center><button onclick="window.location.href='http:index.php';" class="backbtn">
        BACK
        </button></center>
      </div>
    </body>
    <body>
    <?php

  // $con=mysqli_connect('localhost','root','','loan_management_system');
  include ("/var/www/html/access/access_loan.php");
  // //connection
  $db = "loan_management_system";
  $con = mysqli_connect($host, $user, $passwd, $db);
  unset($hostname, $username, $passwd, $db);

      if(!$con){
          echo'Connection error'. mysqli_connect_errno();
      }

        $usrname = $_SESSION['usrname'];

        $sql = "SELECT * FROM customer WHERE username=?";

        $stmt = mysqli_stmt_init($con);

      // connection verify
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        // checking
      header("Location: ./index.php?error=sqlerrorstmt");
      }
      else {
        mysqli_stmt_bind_param($stmt, "s", $usrname);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
      }
  ?>
      <table>
  
      <tr>
        <td><b>NAME</b></td><br>
        <td><b>CUSTOMER_ID</b></td>
        <td><b>USERNAME</b></td>
        <td><b>PHNO</b></td>
        <td><b>DOB</b></td>
        <td><b>ADDRESS</b></td>
        <td><b>PAN_NO</b></td>
        <td><b>EMAIL</b></td>
      </tr>
    <?php
    $i=0;
    session_start();
    ?>
    <tr>
        <td><?php echo $row["name"]; ?></td>
        <td><?php echo $row["customer_id"]; ?></td>
        <td><?php echo $row["username"]; ?></td>
        <td><?php echo $row["phno"]; ?></td>
        <td><?php echo $row["dob"]; ?></td>
        <td><?php echo $row["address"]; ?></td>
        <td><?php echo $row["pan_no"]; ?></td>
        <td><?php echo $row["email"]; ?></td>
    </tr>
    <?php
    

    $i++;
    
    ?>
    </table>
     <?php
    echo "Customer_id: ".$_SESSION['customer_id'];
    
    ?>
     </body>
    </html>   
 