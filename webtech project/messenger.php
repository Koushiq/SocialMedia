<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    $conn = new mysqli("localhost", "root", "", "socialsite");
    if(!isset($_GET['username']))
    {
        $sql="select username from userinfo where username != '".$_SESSION['username']."' ";
        $result= $conn->query($sql);
        $row = $result->fetch_assoc();
        $receiver=$row['username'];
        header("location:messenger.php?username=$receiver");
    }
    else
    {
        $receiver=$_GET['username'];
    }
    $_SESSION['receiver']=$receiver;
    $loadMessageQuery = "select * from message where (senderUsername = '".$_SESSION['username']."' and receiverUsername ='".$receiver."') or (senderUsername = '".$receiver."' and receiverUsername ='".$_SESSION['username']."') order by sendTime";
    $content="";
    $sendMessageQuery="";
    $messageId=0;
    //copied
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
    }
    if(isset($_POST['send']) || isset($_FILES['picture']['name']))
    {
        echo "location:messenger.php?username=$receiver";
        header("location:messenger.php?username=$receiver");
    } */
?>


<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="basicstyling.css">
        <link rel="stylesheet" type="text/css" href="homepage.css">
        <link rel="stylesheet" type="text/css" href="messenger.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
        <script>
            var isLoaded=false; 
        </script>
        <?php include 'headerfile.php'?>
       
       <div class="row">
            <div class="column" id="col-1">
                <div class="side_bar_chat">
                  <?php include 'loadChatList.php' ?>
                </div>
            </div>
            
            <div class="column" id="col-2">
                <ul>
                    <li>
                        <div class="logo chat_box" id="chat_head">
                            <img src="1.jpg">
                            <a href="#" class="text_dark">
                                <h4 id="receiverName"> <?php echo $receiver; ?> </h4>
                            </a>
                         </div>
                    </li>
                </ul>
                <script>
                    function loadMessage()
                    {
                        var receiverName=document.getElementById("receiverName").innerHTML;
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange=function()
                        {
                            if(xhttp.readyState==4 && xhttp.status==200)
                            {
                                document.getElementById("msg_pnl_id").innerHTML=xhttp.responseText;
                                if(!isLoaded)
                                {
                                    console.log("here");
                                    isLoaded=true;
                                    var element = document.getElementById("msg_pnl_id");
                                    element.scrollTop = element.scrollHeight;
                                    console.log(element.scrollTop);
                                }
                            }
                        }
                        xhttp.open("get","loadMessagePanel.php?username="+receiverName);
                        xhttp.send();
                    }
                    setInterval(loadMessage, 1000);
                   

                </script>
                <ul class="msg_pnl" id="msg_pnl_id">
                    
                </ul>

                <script>
                    function send()
                    {
                        const inpFile = document.getElementById("inpFile");
                        const send_btn = document.getElementById("send_message_btn");
                        var message_content = document.getElementById("message_content").value;
                        const xhr = new XMLHttpRequest();
                        const formData=new FormData();
                        for(const file of inpFile.files)
                        {
                            formData.append("picture[]",file);
                        } 
                        formData.append("message_content",message_content);
                        xhr.open("post","sendMessage.php");
                        xhr.send(formData);
                        document.getElementById("message_content").value="";
                        document.getElementById("inpFile").value="";
                        isLoaded=false;
                        loadMessage();
                        /*var element = document.getElementById("msg_pnl_id");
                        element.scrollTop = element.scrollHeight;*/
                    }
                </script>
               <!--  <form method="post" action="" enctype="multipart/form-data"> -->
                    <div class="send_msg">
                        <div class="msg_input">
                            <input type="text" placeholder="send message" name="message_content" id="message_content">
                        </div>
                        <div class="btn btn_danger" id="send_btn">
                            <input type="button" value="send" onclick="send()" name="send" id="send_message_btn">
                           <!--  <button id="send_message_btn" onclick="send()">send</button> -->
                        </div>
                        <div class="btn btn_success" id="upload_btn">
                            <input type="file" accept="image/*"  id="inpFile">
                        </div>
                    </div>
                <!-- </form> -->
            </div>
            <div class="column" id="col-3">
                <div class="right_pnl_profile" id="right_pnl_profile">
                    <img src="1.jpg">
                    <a href="#" class="text_dark">
                        <h4>Username </h4>
                    </a>
                 </div>
                 <form class="share_images_pnl" method="post" action="" id="shared_photos">
                     <h2 class="text_angel" style="text-align: center;">Shared Photos</h2>
                        <?php
                            $loadMessageQuery="select content,messageId,messageType from message where (senderUsername = '".$_SESSION['username']."' and receiverUsername ='".$receiver."') or (senderUsername = '".$receiver."' and receiverUsername ='".$_SESSION['username']."') and messageType='path' order by sendTime desc";
                            global $conn;
                            $result=$conn->query($loadMessageQuery) or die("Page Killed");
                            while($row=$result->fetch_assoc())
                            {
                                if($row['messageType']=="path")
                                {
                                    echo
                                    '<a href="messenger.php?username='.$receiver.'&photo='.$row['messageId'].' ">
                                        <img src="'.$row['content'].'">  
                                    </a> '; 
                                }
                            }
                        ?>
                    </form>
                 </div>
                 
            </div>
       </div>
      
    </body>
</html>