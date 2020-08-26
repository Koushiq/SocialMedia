<?php
     $conn = new mysqli("localhost", "root", "", "socialsite");
     session_start();
     if(!isset($_SESSION['username']))
     {
         session_destroy();
         header("location:login.php");
     }
     $username=$_SESSION['username'];

     if(isset($_GET['username']))
     {
        $viewUsername=trim(htmlspecialchars($_GET['username']));
     }
     else
     {
        die('<script>history.go(-1)</script>');
     }
     if($username==$viewUsername)
     {
         header("location:profile.php");
     }
    

    $sqlUserinfo = "select * from userinfo where username = '".$viewUsername."'";
    $sqlAbout = "select * from about where username = '".$viewUsername."'";
    $resultUserinfo= $conn->query($sqlUserinfo);
    $rowUserinfo=$resultUserinfo->fetch_assoc();
    $resultAbout= $conn->query($sqlAbout);
    $rowAbout=$resultAbout->fetch_assoc();
    $profileFound=true;
    if($resultAbout->num_rows==0)
    {
        $profileFound=false;
    }
    $firstName=$rowUserinfo['firstName'];
    $lastName=$rowUserinfo['lastName'];
    $resGetProPic= $conn->query("select propic from about where username='".$_SESSION['username']."' ;");
    $rowGetProPic=$resGetProPic->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="basicstyling.css">
    <link rel="stylesheet" type="text/css" href="homepage.css">
    <link rel="stylesheet" type="text/css" href="profile.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>viewProfile</title>
</head>
<body>
       <?php
             include 'headerfile.php';
             
       ?>
       <div class="column center_align" id="col-1">
               
        </div>
        <div class="column" id="col-2">
           <?php
                if(!$profileFound)
                {
                    echo  "<h1 class='center_align'>No Profile Found</h1>";
                }
                else if($viewUsername==$_SESSION['username'])
                {
                    echo  "<h1 class='center_align'>No Profile Found</h1>";
                }
                else
                {
                    echo '<div class="profile_top_div">
                             <img src=" '.$rowAbout['coverpic'].' " class="cover_pic"> 
                             <img src=" '.$rowAbout['propic'].' " class="pro_pic">
                             <h1 class="text_angel big_font" id="user_name"> <b>  '.$firstName." ".$lastName.'  </b> </h1>
                           </div>';
                    include("loadViewProfileBtns.php");
                    include("addBlockBtn.php");
                }
           ?>
        <?php
            if($viewUsername!=$_SESSION['username'])
            {
                $resultPostRender=$conn->query("select * from post where username = '".$viewUsername."' ;") or die("nooo");
                if ($resultPostRender->num_rows > 0)
                {
                    while($rowPostRender = $resultPostRender->fetch_assoc()) 
                    {
                        $propic =  $rowAbout['propic'];
                        $firstname = $rowUserinfo['firstName'];
                        $content = $rowPostRender['content'];
                        $picture = $rowPostRender['picture'];
                        $res=$conn->query("select * from postlike where postId= '".$rowPostRender['postid']."' ");
                        $likeCount=$res->num_rows;
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
                            <a href="#" onclick="setPostId('.$rowPostRender['postid'].');loadLikes();" style="color:black;"><p> '.$likeCount.' Likes </p></a>
                            </div>
                        </div>

                        <div class="like_comment_section">

                        <div class="like_comment_btn">
                              <a href="#" class="text_primary" onclick=getPostIdByLike('.$rowPostRender['postid'].')>
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
                                     <img src="'.$rowGetProPic['propic'].'">
                                     <input type="text"  onkeypress="setPostId('.$rowPostRender['postid'].')" placeholder="add a comment.." class="input_comment">
                                 </div>
                             </div>
                           </div>';
                         }       
                    }
                }
        ?>
        <div id="likes_list_panel" onclick="hideLikeList()">

        </div>
        <div class="extra_space">

        </div>
        <div class="extra_space">
            
        </div>
        </div>
        <div class="column" id="col-3">
            <?php 
                include("loadChatList.php");
            ?>
        </div>

</body>
</html>
<script>
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
