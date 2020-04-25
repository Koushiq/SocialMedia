<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    $username=$_SESSION['username'];
    $conn = new mysqli("localhost", "root", "", "socialsite");
    //$sql="select userinfo.username,userinfo.firstName,userinfo.lastName, about.propic from userinfo inner join about on userinfo.username=about.username";
    //$result= $conn->query($sql);
    

?>



<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="basicstyling.css">
        <link rel="stylesheet" type="text/css" href="homepage.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>

    <body>
       
      <?php
            include 'headerfile.php'; 
      ?>


        <div class="row">

            <div class="column center_align" id="col-1">
               
            </div>

            <div class="column" id="col-2">

               <div class="post">
                    <textarea id="txtArea" class="med_font" name="message"  placeholder="What's on your mind ? " style="resize:none;"></textarea>
                    <div class="btn btn_container">
                            <ul  id="post_type">
                                <li><input type="button" value="Add Photos"></li>
                                <li><input type="button" value="Tag"></li>
                            </ul>
                    </div>
                    <div class="btn btn_danger center_align" id="post-btn">
                        <input type="submit" value="POST" id="post-status">
                    </div>
               </div>
               

               <!--div for news feed-->
               <div class="news_feed_post">
                    <div class="logo chat_box" id="poster_pic">
                        <img src="1.jpg">
                        <a href="#" class="text_primary">
                            <p class="med_font" id="poster_name">Carlos</p>   
                        </a> 
                    </div>
                    <!--feedcontent-->
                    <p>Hello World!</p>
                    <p>I am carlos</p>
                    <!--feed image-->
                    <img src="1234.jpg" class="post_img">
                    <div class="like_count">
                        <p>10 Likes</p>
                    </div>
               </div>

               <div class="like_comment_section">

                  <div class="like_comment_btn">
                        <a href="#" class="text_primary">
                            <i class="like_comment_img logo"> 
                                <img src="like.png">
                            </i>
                            <p>  
                                <b>Like</b>  
                            </p>
                        </a>
                  </div>

                  <div class="like_comment_btn">
                    <a href="#" class="text_primary">
                        <i class="like_comment_img logo" id="comment_pic"> 
                            <img src="comment.png">
                        </i>
                        <p>  
                            <b>Comment</b>  
                        </p>
                    </a>
                 </div>

               </div>
               <div class="comment">
                   <div class="load_comments">
                        <ul>
                            <li class="write_comment logo" id="load_comment_section">
                                <img src="2.jpg">
                                <p>Wow nice picture</p>
                            </li>
                            <li class="write_comment logo" id="load_comment_section">
                                <img src="3.jpg">
                                <p>Damn! Cool picture</p>
                            </li>
                        </ul>
                   </div>

                    <div class="form-input">
                        <div class="write_comment logo">
                            <img src="1.jpg">
                            <input type="text" placeholder="add a comment..">
                        </div>
                    </div>

               </div>

             

              <!--extra space -->
              <div class="extra_space">
                  
              </div>
              
            </div>


            <!--Chatlist-->
            <div class="column" id="col-3">
                <?php include 'loadChatList.php'; ?>
            </div>

        </div>

    </body>

</html>