<?php    
    session_start();
    unset ( $_SESSION['ses_email'] );
    unset ( $_SESSION['ses_user_type'] );
    unset ( $_SESSION['ses_emp_code'] );
    session_destroy();

    echo "<script> window.location.href='login.php'; </script>";
    /*
    echo "<script>
            alert('Warning! Logout already');
            window.location.href='login.php';
        </script>";
    */
?>