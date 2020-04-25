<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    $messageId=0;
    $receiver=$_SESSION['receiver'];
    $conn = new mysqli("localhost","root","","socialsite");
    $getIdQuery="select messageId from message order by messageId desc";
   
    /*if($_GET['msg'])!="")
    {
        $getId=$conn->query($getIdQuery) or die("no");
        if($getId->num_rows!=0)
        {
            $getId=$getId->fetch_assoc();
            $messageId=$getId['messageId'];
        }
        $content=htmlspecialchars($_GET['msg']);
        $sendMessageQuery="insert into message (messageId,content,messageType,senderUsername,receiverUsername,sendTime) values('".(++$messageId)."','".$content."','text','".$_SESSION['username']."','".$receiver."','".date("Y-m-d H:i:s")."')";
        $conn->query($sendMessageQuery) or die($conn->error);
    }

    if($_GET['path']!="")
    {
        $content=$_GET['path'];
        $getId=$conn->query($getIdQuery) or die("no");
        if($getId->num_rows!=0)
        {
            $getId=$getId->fetch_assoc();
            $messageId=$getId['messageId'];
            $messagePics='messagePics/'.$messageId.'.jpg';
            $handle = $content;
            copy($handle,$messagePics);
        }
        $content=$messagePics;
        $sendMessageQuery="insert into message (messageId,content,messageType,senderUsername,receiverUsername,sendTime) values('".(++$messageId)."','".$content."','path','".$_SESSION['username']."','".$receiver."','".date("Y-m-d H:i:s")."')";
        $conn->query($sendMessageQuery) or die($conn->error);
    }*/
   
    /* if(isset($_POST['send']))
    {
        if(!empty($_POST['message_content']))
        {
            $getIdQuery="select messageId from message order by messageId desc";
            $getId=$conn->query($getIdQuery) or die("no");
            if($getId->num_rows!=0)
            {
                $getId=$getId->fetch_assoc();
                $messageId=$getId['messageId'];
            }
            $content=htmlspecialchars($_POST['message_content']);
            $sendMessageQuery="insert into message (messageId,content,messageType,senderUsername,receiverUsername,sendTime) values('".(++$messageId)."','".$content."','text','".$_SESSION['username']."','".$receiver."','".date("Y-m-d H:i:s")."')";
            $conn->query($sendMessageQuery) or die($conn->error);
        }
        if(!empty($_FILES['picture']['name']))
        {
            $getIdQuery="select messageId from message order by messageId desc";
            $getId=$conn->query($getIdQuery) or die("no");
            if($getId->num_rows!=0)
            {
                $getId=$getId->fetch_assoc();
                $messageId=$getId['messageId'];
                $messagePics='messagePics/'.$messageId.'.jpg';
                $handle = $_FILES["picture"]["tmp_name"];
                copy($handle,$messagePics);
            }
            $content=$messagePics;
            $sendMessageQuery="insert into message (messageId,content,messageType,senderUsername,receiverUsername,sendTime) values('".(++$messageId)."','".$content."','path','".$_SESSION['username']."','".$receiver."','".date("Y-m-d H:i:s")."')";
            $conn->query($sendMessageQuery) or die($conn->error);
        } 
    } */
    if(!empty($_POST['message_content']))
    {
        $getIdQuery="select messageId from message order by messageId desc";
        $getId=$conn->query($getIdQuery) or die("no");
        if($getId->num_rows!=0)
        {
            $getId=$getId->fetch_assoc();
            $messageId=$getId['messageId'];
        }
        $messageId++;
        $content=htmlspecialchars($_POST['message_content']);
        $sendMessageQuery="insert into message (messageId,content,messageType,senderUsername,receiverUsername,sendTime) values('".$messageId."','".$content."','text','".$_SESSION['username']."','".$receiver."','".date("Y-m-d H:i:s")."')";
        $conn->query($sendMessageQuery) or die($conn->error);
    }
    else
    {
        echo " no";
    }
    
    if(!empty($_FILES['picture']['name']))
    {
        $getIdQuery="select messageId from message order by messageId desc";
        $getId=$conn->query($getIdQuery) or die("no");
        if($getId->num_rows!=0)
        {
            $getId=$getId->fetch_assoc();
            $messageId=$getId['messageId'];
        }
        $messageId++;
        $messagePics='messagePics/'.$messageId.'.jpg';
        foreach($_FILES["picture"]["tmp_name"] as $value)
        {
            $handle = $value;
            copy($handle,$messagePics);
        }
        $content=$messagePics;
        $sendMessageQuery="insert into message (messageId,content,messageType,senderUsername,receiverUsername,sendTime) values('".$messageId."','".$content."','path','".$_SESSION['username']."','".$receiver."','".date("Y-m-d H:i:s")."')";
        $conn->query($sendMessageQuery) or die($conn->error);
    }
    else
    {
        echo "he";
    }

?>