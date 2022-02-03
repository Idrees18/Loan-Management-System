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

if(isset($_POST['submit']))
{
$name=$_POST['name'];
$username=$_POST['uname'];
$phno=$_POST['ph_no'];
$dob=$_POST['dob'];
$address=$_POST['address'];
$pan_no=$_POST['pan_no'];
$email=$_POST['email'];
$pswd=$_POST['psw'];

if(mysqli_query($con, "INSERT INTO customer(name,username,pswd,phno,dob,address,pan_no,email)
 VALUES('$name','$username','$pswd','$phno','$dob','$address','$pan_no','$email')")){
   echo 'done';
}
 else{
   echo "error" . mysqli_error($con);
}

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>
</head>
<style>
	body {font-family: Arial, Helvetica, sans-serif;}
    form {border: 3px solid #0f0f0f;}
	input[type=text], input[type=password] , input[type=tel], input[type=email], input[type=date]{
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
	}
	.container {
	 width: 100%;
	 padding:16px; 
     margin: 8px 0;
     display: inline-block;
     border: 1px solid rgb(0, 0, 0);
     box-sizing: border-box;
	}
	.submitbtn {
  background-color: #1d7a21; /* Green */
  border:none;
  width: 25%;
  margin: 8px 0;
  color: rgb(255, 248, 248);
  padding: 14px 20px;
  display: inline-block;
}
button:hover {
  opacity: 0.8;
}
.resetbtn {
  background-color: #fa2335;
  border:none;
  width: 25%;
  float: left;
  margin: 8px 0;
  color: rgb(255, 248, 248);
  padding: 14px 20px;
  display: inline-block;
}
.backbtn {
  background-color: #f1ef5d;
  border:none;
  width: 25%;
  float:right;
  margin: 8px 0;
  color: rgb(10, 10, 10);
  padding: 14px 20px;
  display: inline-block;
}


</style>
<body> 
	<center>	<h1> 
		<u>LOAN MANAGEMENT</u>
	</h1>
	<h2> CREATE ACCOUNT :</h2>
	 

		<form action="create.php" method="POST">
			<div class="imgcontainer">
				<img src="image/avatar.png" alt="Avatar" class="avatar">
			</center> 
			<div class ="container">

				<label for="name"><b>NAME</b></label>
				<input type="text"  maxlength="20" placeholder="Enter name" name="name" required>
				<br>
			
				<label for="uname"><b>USERNAME</b></label>
				<input type="text" maxlength="20" placeholder="Enter Username" name="uname" required>
				<br>
				
				 <label for="phno"><b>PHONE NUMBER</b></label>
				 <input type="tel"  maxlength = "10" placeholder="Enter phone number" name="ph_no" required>
				 <br>
				
				 <label for="dob"><b>DATE OF BIRTH</b></label>
				 <input type="date" placeholder="Enter dob" name="dob" required>
				 <br>
				
				 <label for="address"><b>ADDRESS</b></label>
				 <input type="text" maxlength = "50" placeholder="Enter address" name="address" required>
				 
				 <br>

				 <label for="pan no"><b>PAN NUMBER</b></label>
				 <input type="text" maxlength = "10" placeholder="Enter pan number" name="pan_no" required>
				 <br>

				 <label for="email"><b>EMAIL</b></label>
				 <input type="email" maxlength = "30" placeholder="Enter email" name="email" required>
				 <br>
				 <label for="psw"><b>PASSWORD</b></label>
				<input type="password" maxlength="10" placeholder="Enter Password" name="psw" required>
				<br>
				<br>
			<div>
				<center><button type="submit" class="submitbtn" name="submit">SUBMIT</button>
				    </center>
				
				
					<button type="reset" class="resetbtn">RESET</button>
					<button onclick="window.location.href='http:login.php';" class="backbtn">
						BACK
					  </button>		
			
			</div>
					
				
		</div>
	 </form>
    </body>

</html>