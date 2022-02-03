<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: /Loan-Management-system/index.php?logout=success");
?>