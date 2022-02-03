<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: /Loan-Management-system/auth/index.php?logout=success");
?>