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

     if(isset($_GET['postId']) && isset($_GET['likedBy']))
     {
        $postId=htmlspecialchars($_GET['postId']);
        $likedBy=htmlspecialchars($_GET['likedBy']);
        $sqlInsertLike="insert into postlike (postId,likedBy)  values ('".$postId."','".$likedBy."')";
        $conn->query($sqlInsertLike) or die("not inserted");
     }
     else
     {
        header("location:login.php");
     }
?>