<?php
    session_start();
    if (!isset($_SESSION['ses_email']) or !isset($_SESSION['ses_user_type']) or !isset($_SESSION['ses_emp_code']))
    {
        $user_emp_code = "";
        $user_email = "";
        $user_user_type = "";
    }
    else
    {
        $user_emp_code = $_SESSION['ses_emp_code'];
        $user_email = $_SESSION['ses_email'];
        $user_user_type = $_SESSION['ses_user_type'];
    }
?>