<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    $username=$_SESSION['username'];
    $content="";
    $picture="";
    $conn = new mysqli("localhost", "root", "", "socialsite");
    $sqlUserinfo = "select * from userinfo where username = '".$username."'";
    $sqlAbout = "select * from about where username = '".$username."'";
    $sqlPost="select postid from post order by postid desc";

    $resultUserinfo= $conn->query($sqlUserinfo);
    $rowUserinfo=$resultUserinfo->fetch_assoc();
    
    $resultAbout= $conn->query($sqlAbout);
    $rowAbout=$resultAbout->fetch_assoc();

    $resultPost=$conn->query($sqlPost);
    $rowPost=$resultPost->fetch_assoc();

    $postid=0;


    $postStsErr="what's on your mind ?";

    if(isset($_POST['poststs']))
    {
        if(!empty($_POST['content']) && !empty($_FILES['picture']['name']))
        {
            $content=htmlspecialchars($_POST['content']);
            if($resultPost->num_rows>0)
            {
                $postid=$rowPost['postid'];
                $postid++;
            }

            $picture='postpic/'.$username.$postid.'.jpg';
            $handle = $_FILES["picture"]["tmp_name"];
            $insertQuery = "insert into post ( postid,username,content,picture,likecount) values ( '".$postid."' , '".$username."', '".$content."' , '".$picture."' , '0' ) ; "; 
            $conn->query($insertQuery) or die($conn->error);
            copy($handle, $picture);
            header("location:profile.php");
        }
        else
        {
            $postStsErr="Both fields can't be empty at least one field needs to have data!";
        }
    }
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
        <div class="form-input" id="top">
            <uL class="top_nav">
                <li class="top_search">
                    <input type="search" placeholder="Search">
                </li>
                <li class="first_element" id="item_upper_space">
                    <a href="profile.php" class="text_angel">Profile</a>
                </li>
                <li id="item_upper_space">
                    <a href="homepage.php" class="text_angel">Home</a>
                </li>
                <li class="logo top_nav_pic" id="item_upper_space">
                    <a href="#" ><img src="friendRequest.png"></a>
                </li>
                <li class="logo top_nav_pic" id="item_upper_space">
                        <a href="#"><img src="message.png"></a>
                </li>
                <li class="logo top_nav_pic" id="item_upper_space">
                    <a href="#"><img src="notification.png"></a>
                </li>
                <li class="logo top_nav_pic" id="item_upper_space">
                    <a href="logout.php"><img src="logout.png"></a>
                </li>
            </uL>
       </div>

    <div class="column center_align" id="col-1">
               
    </div>

    <div class="column" id="col-2">

        <div class="profile_top_div">
            <img src="<?php echo $rowAbout['coverpic']; ?>" class="cover_pic">
            <img src="<?php echo $rowAbout['propic']; ?>" class="pro_pic">
            <h1 class="text_angel big_font" id="user_name"> <b> <?php echo $username ?> </b> </h1>
        </div>
        <div class="profile_btns">
             <ul>
                 <li>
                     <a href="about.php"><p class="med_font text_primary">About</p></a>
                 </li>
                 <li>
                    <a href="profile.php"><p class="med_font text_primary">Profile</p></a>
                </li>
                 <li>
                    <a href="#"><p class="med_font text_primary">Friends</p></a>
                </li>
                <li>
                    <a href="#"><p class="med_font text_primary">Photos</p></a>
                </li>
             </ul>
        </div>

        <div class="post">
           <form method="post" action="" enctype="multipart/form-data">
                <textarea id="txtArea" class="med_font" name="content"  placeholder="<?php echo $postStsErr; ?>" style="resize:none;"></textarea>
                <div class="btn btn_container">
                    <ul  id="post_type">
                        <li><input type="file" accept="image/*" name="picture" enctype="multipart/form-data"></li>
                    </ul>
                </div>
                <div class="btn btn_primary center_align" id="post-btn">
                    <input type="submit" value="POST" name="poststs" id="post-status">
                </div>
           </form>
       </div>


        <?php
               $resultPostRender=$conn->query("select * from post where username = '".$username."' ;") or die("nooo");
                if ($resultPostRender->num_rows > 0)
                {
                    while($rowPostRender = $resultPostRender->fetch_assoc()) 
                    {
                        $propic =  $rowAbout['propic'];
                        $firstname = $rowUserinfo['firstName'];
                        $content = $rowPostRender['content'];
                        $picture = $rowPostRender['picture'];
                        $likecount = $rowPostRender['likecount'];
                        echo '<div class="news_feed_post">
                            <div class="logo chat_box" id="poster_pic">
                                <img src="'.$propic.'">
                                    <a href="#" class="text_primary">
                                        <p class="med_font" id="poster_name">  '.$firstname.'  </p>   
                                    </a> 
                            </div>
                                <!--feedcontent-->
                            <p>'. $content.' </p>
                                
                                <!--feed image-->
                            <img src="'.$picture.'" class="post_img">
                            <div class="like_count">
                                <p> '.$likecount.' Likes </p>
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
            
                    </div>'
                        ;
                    }
                }
        ?>

        <div class="extra_space">
            
        </div>
    </div>



    <div class="column" id="col-3">
        <ul>
            <li class="logo chat_box" >
                <img src="1.jpg">
                <a href="#" class="text_dark">
                    <p>Carlos</p>   
                </a> 
                <span class="active_now al"></span>
            </li>
            <li class="logo chat_box" >
                <img src="2.jpg">
                <a href="#" class="text_dark">
                    <p>Nicolas</p>
                </a>
                <span class="active_now"></span>
            </li>
            <li class="logo chat_box" >
                <img src="3.jpg">
                <a href="#" class="text_dark">
                    <p>Leoid</p>
                </a> 
                <span class="active_now"></span>
            </li>
            <li class="logo chat_box" >
                <img src="4.jpg">
                <a href="#" class="text_dark">
                    <p>Alex</p>
                </a> 
                <span class="active_now"></span>
            </li>
            <li class="logo chat_box" >
                <img src="6.jpg">
                <a href="#" class="text_dark">
                    <p>Maria</p>
                </a>
                <span class="not_now"></span>
            </li>
        </ul>
    </div>



    </body>
</html>
