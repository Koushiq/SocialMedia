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

     if(isset($_GET['comment']) && isset($_GET['postid']) && isset($_GET['commentBy']))
     {
        $commentContent=htmlspecialchars($_GET['comment']);
        $postId=htmlspecialchars($_GET['postid']);
        $commentBy=htmlspecialchars($_GET['commentBy']);
        $sqlInsertComment="insert into postcomment (postId,commentBy,commentContent)  values ('".$postId."','".$commentBy."','".$commentContent."')";
        $conn->query($sqlInsertComment) or die("not inserted");
     }
     else
     {
        header("location:login.php");
     }


?>