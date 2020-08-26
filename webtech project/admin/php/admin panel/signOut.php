<?php
    session_start();
    if(isset($_SESSION['adminUsername']))
    {
       unset($_SESSION['adminUsername']);
       
    }
    header("location:../securityCode.php");
?>