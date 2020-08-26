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
        header("location:login.php");
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
    $loadMessageQuery = "select * from message where (senderUsername = '".$_SESSION['username']."' and receiverUsername ='".$receiver."') or (senderUsername = '".$receiver."' and receiverUsername ='".$_SESSION['username']."') order by sendTime";
    $content="";
    $sendMessageQuery="";
    $messageId=0;
    $result=$conn->query($loadMessageQuery) or die("Nopee");
    //die($loadMessageQuery);
    while($row=$result->fetch_assoc())
    {
        
        if($row['senderUsername']==$_SESSION['username'])
        {
            
            if($row['messageType']=="path")
            {
                echo
                '<li class="receiver_msg msg_body" id="receiver_msg_body">
                <a href="messenger.php?username='.$receiver.'&photo='.$row['messageId'].' ">
                <img src="'.$row['content'].'" class="msg_img">
                </a>
                </li> ';
            }
            else
            {
                echo ' <li class="receiver_msg msg_body" id="receiver_msg_body">
                <p> '.$row['content'].' </p>
                </li>';
            }
                                
        }
        else
        {
            if($row['messageType']=="path")
            {
                echo
                '<li class="sender_msg msg_body">
                    <a href="messenger.php?username='.$receiver.'&photo='.$row['messageId'].' ">
                    <img src="'.$row['content'].'" class="msg_img">
                </a>
                </li>';
            }
            else
            {
                echo ' <li class="sender_msg msg_body">
                <p> '.$row['content'].' </p>
                </li>';
            }
        }                         
    }

?>