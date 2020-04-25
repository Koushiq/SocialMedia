<?php
    if(!isset($_SESSION['username']))
    {
        header("location:login.php");
    }
    
        $conn->query($sendMessageQuery) or die($conn->error);
        echo "location:messenger.php?username=$receiver";
        header("location:messenger.php?username=$receiver");
?>