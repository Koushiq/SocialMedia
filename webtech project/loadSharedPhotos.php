<?php
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    $conn = new mysqli("localhost", "root", "", "socialsite");
    $loadMessageQuery = "select * from message where (senderUsername = '".$_SESSION['username']."' and receiverUsername ='".$_SESSION['receiver']."') or (senderUsername = '".$receiver."' and receiverUsername ='".$_SESSION['username']."') order by sendTime";
    $result=$conn->query($loadMessageQuery) or die("Page Killed");
    while($row=$result->fetch_assoc())
    {
        if($row['messageType']=="path")
        {
            echo
            '<a href="messenger.php?username='.$_SESSION['receiver'].'&photo='.$row['messageId'].' ">
                <img src="'.$row['content'].'">  
            </a> '; 
        }
    }
?>
