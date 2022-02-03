<?php
// $con=mysqli_connect('localhost','root','','loan_management_system');
include ("/var/www/html/access/access_loan.php");

  // //connection
  $con = mysqli_connect($host, $user, $passwd, $db);
  unset($hostname, $username, $passwd, $db);
if(!$con){
  echo'Connection error'. mysqli_connect_errno();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #0f0f0f;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #2326cf;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 35%;
}
button:hover {
  opacity: 0.8;
}
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 10%;
  border-radius: 10%;
}

.container {
  padding: 16px; 
}

.onclickbtn {
    width : 35%;
    padding: 14px 20px;
    background-color:rgb(37, 75, 48);
}


span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
<style>
    body {
      background-image: url("image/rin.jpg");
      background-repeat: no-repeat;
      image-resolution:inherit;
    }
    </style>
</head>
<body>
    <center> 
        <br>
        <h1> 
            <u>LOAN MANAGEMENT</u>
        </h1>
    
    </center>
    <h2>Login Form:</h2>

<form action="includes/login.inc.php" method="post">
  <div class="imgcontainer">
    <img src="image/avatar.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>  
    <center> <button type="submit" name="login">LOGIN</button></center>
    
  </div>

  <div class="container" style="background-color:#f1f1f1">
   <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
    <center> <button onclick="window.location.href='create.php';" class="onclickbtn">
      CREATE ACCOUNT
    </button></center>
  </div>
</form>

</body>
</html>
