<?php
    $conn = new mysqli("localhost", "root", "", "socialsite");
    session_start();
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    $username=trim(htmlspecialchars($_GET['username']));
    $sqlUserinfo = "select * from userinfo where username = '".$username."'";
    $sqlAbout = "select * from about where username = '".$username."'";
    $sqlLoadFriendList="select * from friend where (username ='".$username."' or receivername='".$username."') and status='accepted' ";
    $resultUserinfo= $conn->query($sqlUserinfo);
    $rowUserinfo=$resultUserinfo->fetch_assoc();
    $resultAbout= $conn->query($sqlAbout);
    $rowAbout=$resultAbout->fetch_assoc();
    $resultLoadFriendList=$conn->query($sqlLoadFriendList);
    
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="basicstyling.css">
        <link rel="stylesheet" type="text/css" href="homepage.css">
        <link rel="stylesheet" type="text/css" href="profile.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
       <?php
             include 'headerfile.php';
       ?>

    <div class="column center_align" id="col-1">
               
    </div>
    <div class="column" id="col-3">
        <?php 
            include("loadChatList.php");
        ?>
    </div>
    <div class="column" id="col-2">
        <?php
            if($resultUserinfo->num_rows==0)
            {
                die('<h1 class ="center_align">No Profile Found</h1>');
            } 
        ?>
        <div class="profile_top_div">
            <img src="<?php echo $rowAbout['coverpic']; ?>" class="cover_pic">
            <img src="<?php echo $rowAbout['propic']; ?>" class="pro_pic">
            <h1 class="text_angel big_font" id="user_name"> <b> <?php echo $username ?> </b> </h1>
        </div>
        <?php
            include("loadViewProfileBtns.php");
        ?>
        <div class="loadFriendListPanel">
        <ul>
            <?php
                while($rowLoadFriendList=$resultLoadFriendList->fetch_assoc())
                {
                    if($rowLoadFriendList['username']!=$username)
                    {
                        echo '<li class="logo chat_box friendListPanel" id="friendListPanel_id"> <img src="'.$rowLoadFriendList['usernamePropic'].'"> <a style="color:blue;font-size:20px;" id="friendListName" href="viewProfile.php?username='.$rowLoadFriendList['username'].' "> '.$rowLoadFriendList['usernameFirstName']." ".$rowLoadFriendList['usernameLastName'].'</a> </li>';
                    }
                    else
                    {
                        echo '<li class="logo chat_box friendListPanel"  id="friendListPanel_id"> <img src="'.$rowLoadFriendList['receivernamePropic'].'"> <a style="color:blue;font-size:20px;" id="friendListName" href="viewProfile.php?username='.$rowLoadFriendList['receivername'].' "> '.$rowLoadFriendList['receivernameFirstName']." ".$rowLoadFriendList['receivernameLastName'].'</a> </li>';
                    }
                }
            ?>
        </ul>
    </div>
        <div class="extra_space">
        </div>
    </div>
    </body>
</html>