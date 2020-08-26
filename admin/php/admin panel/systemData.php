<?php
    session_start();
    $conn=new mysqli("localhost","root","","socialsite");
    if(!isset($_SESSION['adminUsername']))
    {
        header("location:../securityCode.php");
    }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../basicstyling.css">
    <link rel="stylesheet" href="../../css/adminTemplate.css">
    <link rel="stylesheet" href="../../css/adminDashboard.css">
    <link rel="stylesheet" href="../../css/systemData.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <script src="fontawesome/js/all.js"></script>
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    
  </head>
  <body>
    <div class="column" id="col-1">
        <?php include("../navigatormenu/sidebarNav.php"); ?>
    </div>
    <div class="column" id="col-2">

        <div class="wrapper_btns">
            <div class="show AdminData">
                <img src="../../imgs/admin_data.png">
                <div class="selectMenu btn_signup"><a href="adminData.php"><input type="button" value="View Admin Data"></a></div>
            </div>
            <div class="show UsersData">
                <img src="../../imgs/data.png">
                <div class="selectMenu btn_signup"><a href="userData.php"><input type="button" value="View User Data"></a></div>
            </div>
            <div class="show Posts">
                <img src="../../imgs/post.png">
                <div class="selectMenu btn_signup"><a href="post.php"><input type="button" value="View Posts"></a></div>
            </div>
            <div class="show Messages">
                <img src="../../imgs/message.png">
                <div class="selectMenu btn_signup"><a href="message.php"><input type="button" value="View Messages"></a></div>
            </div>
            <div class="show Photos">
                <img src="../../imgs/photo.png">
                <div class="selectMenu btn_signup"><a href="photo.php"><input type="button" value="View Photos"></a></div>
            </div>
            <div class="show Likes">
                <img src="../../imgs/like.png">
                <div class="selectMenu btn_signup"><a href="like.php"><input type="button" value="View Likes"></a></div>
            </div>
            <div class="show Comments">
                <img src="../../imgs/comment.png">
                <div class="selectMenu btn_signup"><a href="comment.php"><input type="button" value="View Comments"></a></div>
            </div>
        </div>

    </div>
  </body>
</html>