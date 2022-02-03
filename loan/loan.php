<?php 
session_start();
if (!isset($_SESSION['customer_id'])) {
  header("Location: /Loan-Management-system/Login.php");
  exit();
}
?>
<!-- code works when the customer_id session var exists. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan</title>
</head>
<body>
<!-- create navigation here. -->
  <nav>
    <a href="/Loan-Management-system/index.php">Home</a>
  </nav>
<div class="form-popup" id="myForm">
  <form action="/Loan-Management-system/loan/loan.inc.create.php" class="form-container"  method="POST">
    <h1> ENTER LOAN DETAILS :</h1>
     <label for="loan type"><b>LOAN TYPE</b></label>
    <select id="loantype" name="loantype">
      <option value="#" disabled selected>Choose</option>
      <option value="HOME LOAN">Home Loan</option>
      <option value="PERSONAL LOAN">Personal Loan</option>
      <option value="VEHICLE LOAN">Vehicle Loan</option>
    </select>
     <br>
     
     <label for="loan amount"><b>LOAN AMOUNT</b></label>
     <input type="number" maxlength = "10" placeholder="Enter loan amount" name="loanamount" required>
     <br>
     
     <label for="loan tenure"><b>LOAN TENURE</b></label>
     <!-- <input type="months" maxlength = "50" placeholder="Enter loan tenure" name="loantenure" required> -->
     <select id="loantenure" name="loantenure">
      <option value="#" disabled selected>Select</option>
      <option value="16">16 Months</option>
      <option value="24">24 Months</option>
      <option value="60">60 Months</option>
      <option value="84">84 Months</option>
    </select>
     <br>
     <button type="submit" class="submitbtn" name="submit">SUBMIT</button>
<button type="reset" class="resetbtn">RESET</button>
  </form>
</div>

</body>
</html>