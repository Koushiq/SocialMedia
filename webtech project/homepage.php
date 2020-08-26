<?php
    session_start();
    $username=$_SESSION['username'];
    $conn = new mysqli("localhost", "root", "", "socialsite");
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    
    function getPhotoId()
    {
        global $conn;
        $photoQuery="select * from photos order by photoid desc";
        $resultPhoto=$conn->query($photoQuery);
        $rowPhoto=$resultPhoto->fetch_assoc();
        $photoId=1;
        if($resultPhoto->num_rows>0)
        {
            $photoId=$rowPhoto['photoId'];
            $photoId++;
        }
        return $photoId;
    }

    $content="";
    $picture="";
   // $conn = new mysqli("localhost", "root", "", "socialsite");
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
            $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            if($ext=="jpg" || $ext=="PNG" || $ext=="gif"  || $ext=="tiff"  || $ext=="BMP")
            {
                $content=htmlspecialchars($_POST['content']);
                $picture='postpic/'.$username."-".getPhotoId().'.jpg';
                $sqlInsertToPhotos="insert into photos (username,path,type) values ('".$username."','".$picture."','postpic')";
                $conn->query($sqlInsertToPhotos) or die($conn->error);
                $handle = $_FILES["picture"]["tmp_name"];
                $insertQuery = "insert into post (username,content,picture) values ('".$username."', '".$content."' , '".$picture."' ) ; "; 
                $conn->query($insertQuery) or die($conn->error);
                copy($handle, $picture);
                header("location:homepage.php");
            }
            else
            {
                $postStsErr="Wrong file format";
            }
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
        <div class="top_nav_attr">
            <?php
                include 'headerfile.php';
            ?>
        </div>    
        <div class="row">
            <div class="column center_align" id="col-1">
            </div>
            <div class="column" id="col-2">
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
                $sqlGetFriend="select * from friend where (username='".$username."' or receivername='".$username."') ";
               // die($sqlGetFriend);
                $resGetFriend=$conn->query($sqlGetFriend);
                if($resGetFriend->num_rows>0)
                {
                    while($rowGetFriend=$resGetFriend->fetch_assoc())
                    {
                        
                        
                        if($rowGetFriend['username']==$username)
                        {
                            $getFriend="select * from post where username = '".$rowGetFriend['receivername']."' order by postid desc ;";
                            $resultPostRender=$conn->query($getFriend) or die("nooo");
                            if ($resultPostRender->num_rows > 0)
                            {
                                while($rowPostRender = $resultPostRender->fetch_assoc()) 
                                {
                                    $propic =  $rowGetFriend['receivernamePropic'];
                                    $firstname = $rowGetFriend['receivernameFirstName'];
                                    $lastname=$rowGetFriend['receivernameLastName'];
                                    $content = $rowPostRender['content'];
                                    $picture = $rowPostRender['picture'];
                                    $res=$conn->query("select * from postlike where postId= '".$rowPostRender['postid']."' ");
                                    $likeCount=$res->num_rows;
                                    //$likecount = $rowPostRender['likecount'];
                                    echo '<div class="news_feed_post">
                                        <div class="logo chat_box" id="poster_pic">
                                            <img src="'.$propic.'">
                                                <a href="viewProfile.php?username='.$rowGetFriend['receivername'].'" class="text_primary">
                                                    <p class="med_font" id="poster_name">  '.$firstname.' '.$lastname.' </p>   
                                                </a> 
                                        </div>
                                            <!--feedcontent-->
                                        <p>'. $content.' </p>
                                            
                                            <!--feed image-->
                                        <img src="'.$picture.'" class="post_img">
                                        <div class="like_count">
                                            <a href="#" onclick="setPostId('.$rowPostRender['postid'].');loadLikes();" style="color:black;"><p> '.$likeCount.' Likes </p></a>
                                        </div>
                                    </div>
            
                                    <div class="like_comment_section">
            
                                    <div class="like_comment_btn">
                                          <a href="#" class="text_primary" onclick="getPostIdByLike('.$rowPostRender['postid'].')">
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
                                            <ul>';
                                    // select comment
                                    $sqlComment="select * from postComment where postId='".$rowPostRender['postid']."';";
                                    $resComment=$conn->query($sqlComment);
                                    if($resComment->num_rows>0)
                                    {
                                        while($rowComment=$resComment->fetch_assoc())
                                        {
                                            $sqlCommenterInfo="select userinfo.username,userinfo.firstName,userinfo.lastName,about.propic from userinfo inner join about on userinfo.username=about.username where userinfo.username='".$rowComment['commentBy']."' ";
                                            $resCommentInfo=$conn->query($sqlCommenterInfo);
                                            $rowCommentInfo=$resCommentInfo->fetch_assoc();
                                            echo '<li class="write_comment logo" id="load_comment_section">
                                                        <img src="'.$rowCommentInfo['propic'].'">
                                                        <p><a style="color:black; font-weight:600;font-size:18px;" href="viewProfile.php?username='.$rowCommentInfo['username'].'">'.$rowCommentInfo['firstName']." ".$rowCommentInfo['lastName'].'</a><br>'.$rowComment['commentContent'].'</p>
                                                </li>';
                                        }
                                    }
                                    echo '</ul>
                                    </div>
                                    <div class="form-input">
                                        <div class="write_comment logo">
                                            <img src="'.$propic.'">
                                            <input type="text"  onkeypress="setPostId('.$rowPostRender['postid'].')" placeholder="add a comment.." class="input_comment">
                                        </div>
                                    </div>
                                  </div>';
                                }
                            }
                        }
                        else
                        {
                            $getFriend="select * from post where username = '".$rowGetFriend['username']."' order by postid desc ;";
                            $resultPostRender=$conn->query($getFriend) or die("nooo");
                            if ($resultPostRender->num_rows > 0)
                            {
                                while($rowPostRender = $resultPostRender->fetch_assoc()) 
                                {
                                    $propic =  $rowGetFriend['usernamePropic'];
                                    $firstname = $rowGetFriend['usernameFirstName'];
                                    $lastname=$rowGetFriend['usernameLastName'];
                                    $content = $rowPostRender['content'];
                                    $picture = $rowPostRender['picture'];
                                    $res=$conn->query("select * from postlike where postId= '".$rowPostRender['postid']."' ");
                                    $likeCount=$res->num_rows;
                                    //$likecount = $rowPostRender['likecount'];
                                    echo '<div class="news_feed_post">
                                        <div class="logo chat_box" id="poster_pic">
                                            <img src="'.$propic.'">
                                                <a href="viewProfile.php?username='.$rowGetFriend['username'].'" class="text_primary">
                                                    <p class="med_font" id="poster_name">  '.$firstname.' '.$lastname.' </p>   
                                                </a> 
                                        </div>
                                            <!--feedcontent-->
                                        <p>'. $content.' </p>
                                            
                                            <!--feed image-->
                                        <img src="'.$picture.'" class="post_img">
                                        <div class="like_count">
                                            <a href="#" onclick="setPostId('.$rowPostRender['postid'].');loadLikes();" style="color:black;"><p> '.$likeCount.' Likes </p></a>
                                        </div>
                                    </div>
            
                                    <div class="like_comment_section">
            
                                    <div class="like_comment_btn">
                                          <a href="#" class="text_primary" onclick="getPostIdByLike('.$rowPostRender['postid'].')">
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
                                            <ul>';
                                    // select comment
                                    $sqlComment="select * from postComment where postId='".$rowPostRender['postid']."';";
                                    $resComment=$conn->query($sqlComment);
                                    if($resComment->num_rows>0)
                                    {
                                        while($rowComment=$resComment->fetch_assoc())
                                        {
                                            $sqlCommenterInfo="select userinfo.username,userinfo.firstName,userinfo.lastName,about.propic from userinfo inner join about on userinfo.username=about.username where userinfo.username='".$rowComment['commentBy']."' ";
                                            $resCommentInfo=$conn->query($sqlCommenterInfo);
                                            $rowCommentInfo=$resCommentInfo->fetch_assoc();
                                            echo '<li class="write_comment logo" id="load_comment_section">
                                                        <img src="'.$rowCommentInfo['propic'].'">
                                                        <p><a style="color:black; font-weight:600;font-size:18px;" href="viewProfile.php?username='.$rowCommentInfo['username'].'">'.$rowCommentInfo['firstName']." ".$rowCommentInfo['lastName'].'</a><br>'.$rowComment['commentContent'].'</p>
                                                </li>';
                                        }
                                    }
                                    echo '</ul>
                                    </div>
                                    <div class="form-input">
                                        <div class="write_comment logo">
                                            <img src="'.$propic.'">
                                            <input type="text"  onkeypress="setPostId('.$rowPostRender['postid'].')" placeholder="add a comment.." class="input_comment">
                                        </div>
                                    </div>
                                  </div>';
                                }
                            }
                        }
                    }
                }
                        
        ?>
        <div id="likes_list_panel" onclick="hideLikeList()">

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

<script>
   /*  */
    var PostId;
    var CommentBy="<?php echo $_SESSION['username']; ?>";
    function setPostId(postId)
    {
        PostId=postId;
    }
    function getPostId()
    {
        return PostId;
    }

    function insertComment(comment)
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4 && this.status == 200)
            {
                document.getElementsByClassName("input_comment").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "insertComment.php?comment="+comment+"&postid="+PostId+"&commentBy="+CommentBy, true);
        xhttp.send();
    } 
    function bindComment()
    {
        var elements =document.getElementsByClassName("input_comment");
        var myFunction = function(event) {
            var char = event.which || event.keyCode;
            if(char==13 && this.value!="")
            {
                insertComment(this.value);
                this.value="";
            }
        };
        for (var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('keyup', myFunction, false);
        }
    }
    setTimeout(bindComment, 50);


    function getPostIdByLike(postId)
    {
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "insertLike.php?postId="+postId+"&likedBy="+CommentBy, true);
        xhttp.send();
    }
    function loadLikeList(elem)
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if (this.readyState == 4 && this.status == 200)
            {
                elem.innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "loadLikes.php?&postid="+PostId, true);
        xhttp.send();
    }
    function loadLikes()
    {
       /*  var elem=document.getElementById("load_likes");
        elem.classList.toggle("likes_list_panel"); */
        var elem=document.getElementById("likes_list_panel");
        if(elem.style.display=="block")
        {
            elem.style.display="none";
        }
        else
        {
            elem.style.display="block";
        }
        loadLikeList(elem);

    }
    function redirectToMessenger(username)
    {
        console.log(username);
        window.location.replace("messenger.php?username="+username);
    }
    function hideLikeList()
    {
        var elem=document.getElementById("likes_list_panel");
        if(elem.style.display=="block")
        {
            elem.style.display="none";
        }
    }
</script>
