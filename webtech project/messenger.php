<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    $conn = new mysqli("localhost", "root", "", "socialsite");
    $hasFriend=true;
    function assignChatBuddy()
    {
        global $conn;
        $sql="select username,receivername from friend where username='".$_SESSION['username']."' and status='accepted' ";
        
        $result= $conn->query($sql);
        if($result->num_rows>0)
        {
            $rowProfile = $result->fetch_assoc();
            $receiver=$rowProfile['receivername'];
            header("location:messenger.php?username=$receiver");
        }
        else
        {
            $sql="select username,receivername from friend where receivername='".$_SESSION['username']."' and status='accepted' ";
            $result= $conn->query($sql);
            if($result->num_rows>0)
            {
                $rowProfile = $result->fetch_assoc();
                $receiver=$rowProfile['username'];
                header("location:messenger.php?username=$receiver");
            }
            else
            {
                die("<h1>No friends in friendlist found</h1>");
            }
        }         
    }

    session_start();
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    
    if(!isset($_GET['username']))
    {
       assignChatBuddy();
    }
    else
    {   
        $receiver=trim(htmlspecialchars($_GET['username']));
    }
    $_SESSION['receiver']=$receiver;
    $loadMessageQuery = "select * from message where (senderUsername = '".$_SESSION['username']."' and receiverUsername ='".$receiver."') or (senderUsername = '".$receiver."' and receiverUsername ='".$_SESSION['username']."') order by sendTime";
    $content="";
    $sendMessageQuery="";
    $messageId=0;
    $sql="select userinfo.username,userinfo.firstName,userinfo.lastName,about.propic from userinfo inner join about on userinfo.username=about.username where userinfo.username ='".trim(htmlspecialchars($_GET['username']))."' ";
    $result= $conn->query($sql);
    if($result->num_rows==0)
    {
        assignChatBuddy();
    } 
    $rowProfile = $result->fetch_assoc();
    
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="basicstyling.css">
        <link rel="stylesheet" type="text/css" href="homepage.css">
        <link rel="stylesheet" type="text/css" href="messenger.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
        <script>
            var isLoaded=false; 
            var setScroller=false;
            var sharedPictures=false;
        </script>
        <?php
            include 'headerfile.php';
        ?>
       
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
                            <img src= "<?php echo $rowProfile['propic'];?>" >
                            <a href="<?php echo "viewProfile.php?username=".$rowProfile['username']; ?>" class="text_dark">
                                <h4 id="receiverName"> <?php echo $rowProfile['firstName']." ".$rowProfile['lastName']; ?> </h4>
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
                                    console.log("var scroll ");
                                    isLoaded=true;
                                    var element = document.getElementById("msg_pnl_id");
                                    element.scrollTop = element.scrollHeight;
                                    console.log(element.scrollTop);
                                }
                            }
                        }
                        xhttp.open("get","loadMessagePanel.php?username="+receiverName,true);
                        xhttp.send();
                    }
                    setInterval(loadMessage, 500);
                </script>

                <script>
                    function loadSharedPictures()
                    {
                        var receiverName=document.getElementById("receiverName").innerHTML;
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange=function()
                        {
                            if(xhttp.readyState==4 && xhttp.status==200)
                            {
                                document.getElementById("shared_photos").innerHTML=xhttp.responseText;
                            }
                        }
                        xhttp.open("get","loadSharedPhotos.php?username="+receiverName,true);
                        xhttp.send();
                    }
                </script>
                <ul class="msg_pnl" id="msg_pnl_id">
                    
                </ul>
                <script>
                    function setScroll()
                    {
                        var element = document.getElementById("msg_pnl_id");
                            element.scrollTop = element.scrollHeight;
                            setScroller=false;
                    }
                    function send()
                    {
                        const inpFile = document.getElementById("inpFile");
                        //
                         var fileVal=inpFile.value;
                         if(fileVal.replace(/^.*\./, '')=="jpg" || fileVal.replace(/^.*\./, '')=="gif" || fileVal.replace(/^.*\./, '')=="PNG" || fileVal.replace(/^.*\./, '')=="png"  || fileVal.replace(/^.*\./, '')=="")
                         {
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
                            setScroller=true;
                            if(setScroller)
                            {
                                setTimeout(setScroll,200);
                            }
                            if(!sharedPictures)
                            {
                                setTimeout(loadSharedPictures,200);
                            } 
                         }
                         else
                         {
                             alert("File Format Not Supported ");
                         }

                        //

                        /* */
                    }
                </script>
               <!--  <form method="post" action="" enctype="multipart/form-data"> -->
                    <div class="send_msg">
                        <div class="msg_input">
                            <input type="text" placeholder="send message" name="message_content" id="message_content">
                        </div>
                        <div class="btn btn_danger" id="send_btn">
                            <input type="button" value="send" onclick="send();" name="send" id="send_message_btn">
                           <!--  <button id="send_message_btn" onclick="send()">send</button> -->
                        </div>
                        <div class="btn btn_success" id="upload_btn">
                            <input type="file"  accept="image/*"  id="inpFile">
                        </div>
                    </div>
                <!-- </form> -->
            </div>
            <div class="column" id="col-3">
                <!-- <div class="right_pnl_profile logo" id="right_pnl_profile">
                    <img src= "echo $rowProfile['propic'];?>" >
                        <h4> echo $rowProfile['firstName']." ".$rowProfile['lastName'];?> </h4>
                    </a>
                 </div> -->
                 <div class="share_images_pnl" id="shared_photos">
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
                    </div>
                 </div>
                 
            </div>
       </div>
      
    </body>
</html>