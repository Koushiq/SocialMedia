<?php
     header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
     header("Cache-Control: post-check=0, pre-check=0", false);
     header("Pragma: no-cache");
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:messenger.php");
    }
    $conn = new mysqli("localhost", "root", "", "socialsite");
    if(!isset($_SESSION['receiver']))
    {
        $sql="select username from userinfo where username != '".$_SESSION['username']."' ";
        $result= $conn->query($sql);
        $row = $result->fetch_assoc();
        $receiver=$row['username'];
        header("location:messenger.php?username=$receiver");
    }
    else
    {
        $receiver=$_SESSION['receiver'];
    }
    $loadMessageQuery = "select content,messageId,messageType from message where (senderUsername = '".$_SESSION['username']."' and receiverUsername ='".$receiver."') or (senderUsername = '".$receiver."' and receiverUsername ='".$_SESSION['username']."') and messageType='path' order by sendTime desc";
    
    $result=$conn->query($loadMessageQuery) or die("Page Killed");
    echo '<h2 class="text_angel" style="text-align: center;">Shared Photos</h2>';
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
