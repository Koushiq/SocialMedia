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
     $postid=htmlspecialchars($_GET['postid']);
     //$sql = "select post.postid,post.username,userinfo.firstName,userinfo.lastName,about.propic from post inner join userinfo on post.username=userinfo.username inner join about on about.username=post.username where post.postid='".$postid."'";
     //die($sql);
     $sql="select * from postlike where postid='".$postid."' ";
     $res=$conn->query($sql);
     if($res->num_rows>0)
     {
         while($row=$res->fetch_assoc())
         {
            $sqlGetUserAttr ="select userinfo.username,userinfo.firstName,userinfo.lastName,about.propic from userinfo inner join about on userinfo.username=about.username where userinfo.username='".$row['likedBy']."' ";
            
            $resGetUserAttr=$conn->query($sqlGetUserAttr);
            while($rowGetUserAttr=$resGetUserAttr->fetch_assoc())
            {
                echo '<div class="logo chat_box" > <img src="'.$rowGetUserAttr['propic'].'"> <p id="likeby_username"><a style="color:blue;" href="viewProfile.php?username='.$rowGetUserAttr['username'].'"> '.$rowGetUserAttr['firstName']." ".$rowGetUserAttr['lastName'].'</a></p>  <div class="btn btn_primary" id="message_btn"> <a href="messenger.php?username='.$rowGetUserAttr['username'].'"><input type="button" value="Message"  id="message_user_id" ></a></div></div>';
            }
            
         }
     }
     else
     {
         echo "<h3>No Likes Yet</h3>";
     }
     
?>