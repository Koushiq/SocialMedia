<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    session_start();
    $conn=new mysqli("localhost","root","","socialsite");
    if(!isset($_SESSION['adminUsername']))
    {
        header("location:../securityCode.php");
    }
    if(isset($_POST['updatePhotoData']))
    {
        if(isset( $_SESSION['photoId']) && isset($_SESSION['pictype']))
        {
            if(!empty($_FILES['updatePic']['name'])) 
            {
                $ext = pathinfo($_FILES['updatePic']['name'], PATHINFO_EXTENSION);
                if($ext=="jpg" || $ext=="png" || $ext=="gif"  || $ext=="tiff"  || $ext=="BMP")
                {
                    $sql="select * from photos where photoId = '".$_SESSION['photoId']."' ";
                    $res=$conn->query($sql);
                    $row=$res->fetch_assoc();
                    $handle = $_FILES["updatePic"]["tmp_name"];
                    copy($handle,'../../../'.$row['path']) or die("died");
                    $pic=$_SESSION['photoId'];
                    header("location:updateUsers.php?loadPhoto=true&photoId=$pic ");
                    unset($_SESSION['photoId']);
                    unset($_SESSION['pictype']);
                }
                else
                {
                    echo '<script>alert("File Format Not Supported")</script>';
                }
                
            }
            else
            {
               echo' <script>alert("no changes")</script>';
            }
        }
    }
    
  

    function generateMessageDataTable()
    {
        global $conn;
        if(isset($_SESSION['messageId']) && isset($_POST['updateMessageData']))
        {
            $sqlMessageId="select * from message where messageId= '".$_SESSION['messageId']."' ";
            $res=$conn->query($sqlMessageId);
            $row=$res->fetch_assoc();
            if($row['messageType']=="text")
            {
                if(!empty($_POST['messageContent']) && !empty($_POST['messageType']) && !empty($_POST['senderUsername'])  && !empty($_POST['receiverUsername']) )
                {
                    if(trim(htmlspecialchars($_POST['messageType']))=="text")
                    {
                        $sql="update message set content='".trim(htmlspecialchars($_POST['messageContent']))."',messageType='".trim(htmlspecialchars($_POST['messageType']))."',senderUsername='".trim(htmlspecialchars($_POST['senderUsername']))."',receiverUsername='".trim(htmlspecialchars($_POST['receiverUsername']))."'  where messageId='".$_SESSION['messageId']."' ";
                        $conn->query($sql);
                        unset($_SESSION['messageId']);
                        echo '<script>alert("Success")</script>';
                    }
                    else
                    {
                        echo '<script>alert("Invalid Data For Message Type")</script>';
                    }
                }
                else
                {
                    echo '<script>alert("Fields can not be empty");</script>';
                }
            }
            else
            {

                $makeChages=true;
                if(!empty($_FILES['updateMessagePic']['name']) || isset($_SESSION['messageId']) && isset($_POST['updateMessageData']) && !empty($_POST['senderUsername'])  && !empty($_POST['receiverUsername'])) 
                {
                    $ext = pathinfo($_FILES['updateMessagePic']['name'], PATHINFO_EXTENSION);
                    if($ext!="")
                    {
                        if($ext=="jpg" || $ext=="png" || $ext=="gif"  || $ext=="tiff"  || $ext=="bmp")
                        {
                            $handle = $_FILES["updateMessagePic"]["tmp_name"];
                            copy($handle,'../../../'.$row['content']) or die("died");
                        }
                        else
                        {
                            $makeChages=false;
                            echo '<script>alert("File Format Not Supported")';
                        }
                    }
                   if($makeChages)
                   {
                        $sql="update message set senderUsername='".trim(htmlspecialchars($_POST['senderUsername']))."',receiverUsername='".trim(htmlspecialchars($_POST['receiverUsername']))."'  where messageId='".$_SESSION['messageId']."' ";
                        $conn->query($sql) or die("Failed to Update ! !! ");
                        echo '<script>alert("Message Updated!")</script>';
                        unset($_SESSION['messageId']);
                   }
                    
                }
                else
                {
                    echo' <script>alert("no changes")</script>';
                }
            }
        }

        if(isset($_GET['messageId']))
        {
            $sql="select * from message where messageId='".trim(htmlspecialchars($_GET['messageId']))."'";
            $res=$conn->query($sql);
            if($res->num_rows==0)
            {
                header("location:message.php?warning=true");
            }
            $row=$res->fetch_assoc();
            $_SESSION['messageId']=trim(htmlspecialchars($_GET['messageId']));
            
        }
        else
        {
            header("location:message.php?warning=notChosen");
        }
        if($row['messageType']=="text")
        {
            echo '<form action="" method="post" >
            <table class="text_angel form-input">
            <tr>
                <td>Content</td>
                <td><input type="text" name="messageContent" id="" value="'.$row['content'].'"></td>
            </tr>';
        }
        else
        {
            echo '<form action="" method="post" enctype="multipart/form-data">
            <table class="text_angel form-input">
            <tr>
                <td>Content</td>
                <td> <a href="../../../'.$row['content'].'"><img style="object-fit:contain; width:250px;" src="../../../'.$row['content'].'"></a> <input type="file" accept="image/*" name="updateMessagePic" id="" enctype="multipart/form-data"> </td>
            </tr>';
        }
        echo '
        <tr>
            <td>Message Type</td>
            <td><input type="text" name="messageType" id="" value="'.$row['messageType'].'"></td>
        </tr>
        <tr>
            <td>Sender Username</td>
            <td><input type="text" name="senderUsername" id="" value="'.$row['senderUsername'].'"></td>
        </tr>
        <tr>
            <td>Receiver Username</td>
            <td><input type="text" name="receiverUsername" id="" value="'.$row['receiverUsername'].'"></td>
        </tr>
        
        <tr>
        <td><input  style="color:white; padding:8px; background-color:green;" type="submit" value="update" name="updateMessageData">
        <a href="message.php" style="background-color:rgb(166, 18, 18); color:white; padding:8px;">Back</a></td>
        </tr>
        </table></form> ';
        
    }

    function generatePostDataTable()
    {
        global $conn;

        if(isset($_SESSION['postid']) && isset($_POST['updatePostData']) && !empty($_POST['postContent']))
        {
            $sql="update post set content='".trim(htmlspecialchars($_POST['postContent']))."' where postid='".$_SESSION['postid']."' ";
            $conn->query($sql) or die("not updated");
            unset($_SESSION['postid']);
        }
        if(isset($_GET['postid']))
        {
            $postid="select content from post where postid='".trim(htmlspecialchars($_GET['postid']))."' ";
            $res=$conn->query($postid);
            if($res->num_rows==0)
            {
                header("location:post.php?warning=true");
            }
            $row=$res->fetch_assoc();
            $_SESSION['postid']=trim(htmlspecialchars($_GET['postid']));
        }
        else
        {
            header("location:post.php?warning=notChosen");
        }
        
        echo '<table class="text_angel form-input">
        <tr>
        <form action="" method="post">
            <td>Content</td>
            <td><input type="text" name="postContent" id="" value="'.$row['content'].'"></td>
        </tr>
        
        <tr>
        <td><input  style="color:white; padding:8px; background-color:green;" type="submit" value="update" name="updatePostData">
        <a href="post.php" style="background-color:rgb(166, 18, 18); color:white; padding:8px;">Back</a></td>
        </form> 
        </tr>
        </table>';
    }
    function genereatePhotosDataTable()
    {
        global $conn;
        $sql="select * from photos where photoId='".trim(htmlspecialchars($_GET['photoId']))."' ";
        $res=$conn->query($sql);
       
        if($res->num_rows>0)
        {
            $row=$res->fetch_assoc();
            $_SESSION['photoId']=trim(htmlspecialchars($_GET['photoId']));
            $_SESSION['pictype']=trim(htmlspecialchars($row['type']));
            
            echo
            '<table class="text_angel form-input">
                <tr>
                    <form action="" method="post" enctype="multipart/form-data">
                    <th style="width:10%;">username</th>
                    <th>path</th>
                </tr>
                <tr>
                    <td>'.$row['username'].'</td>
                    <td> <a href="../../../'.$row['path'].'"> <img style="width:100px; object-fit:contain;" src="../../../'.$row['path'].'" alt="" srcset=""></a>
                    <input type="file" accept="image/*" name="updatePic" enctype="multipart/form-data">
                    </td>
               
                </tr>
                <tr>
                    <td><input tyle="color:white; padding:8px; background-color:green;" type="submit" value="update" name="updatePhotoData">
                    <a href="photo.php" style="background-color:rgb(166, 18, 18); color:white; padding:8px;">Back</a></td>
                    </form> 
                </tr>
            </table>';
        }
        else
        {
            echo '<h1 class="center_align text_angel">Invalid Id</h1>';
            echo'<a href="photo.php" style="background-color:rgb(166, 18, 18); margin-left:50%; color:white; padding:8px;">Back</a>';
        }  
    }


    function generateLikeDataTable()
    {
        global $conn;
        $_SESSION['likeId']=trim(htmlspecialchars($_GET['likeId']));
        $id=$_SESSION['likeId'];
        $sql="select * from postlike where id= '".$id."' ";
        $res=$conn->query($sql);
        if($res->num_rows>0)
        {
            if(isset($_POST['updateLikeData']))
            {
                if(!empty($_POST['likedBy']) && !empty($_POST['postId']) )
                {
                    $updateLike="update postlike set postId='".trim(htmlspecialchars($_POST['postId']))."',likedBy='".trim(htmlspecialchars($_POST['likedBy']))."'  where id='".$id."' ";
                    $conn->query($updateLike);
                    echo '<script>alert("Success")</script>';
                    unset($_SESSION['likeId']);
                }
                else
                {
                    echo '<script> alert("Can not be empty");</script>';
                }
                
            }
            $sql="select * from postlike where id= '".$id."' ";
            $res=$conn->query($sql);
            $row=$res->fetch_assoc();
            echo '<table class="text_angel form-input">
                    <tr>
                        <th>Post Id</th>
                        <th>Liked By</th> 
                    </tr>
                    <tr>
                        <form action="" method="post">
                            <td><input type="text" name="postId" value="'.$row['postId'].'"  ></td>
                            <td><input type="text" name="likedBy" value="'.$row['likedBy'].'"></td>
                           
                    </tr>
                    <tr>
                    <td><input tyle="color:white; padding:8px; background-color:green;" type="submit" value="update" name="updateLikeData">
                            <a href="like.php" style="background-color:rgb(166, 18, 18); color:white; padding:8px;">Back</a></td>
                        </form>
                    </tr>
            </table>';
        }
        else
        {
           echo' <h1 class="text_angel center_align">Invalid ID</h1>';
        }

    }
    function generateCommentTable()
    {
        global $conn;
        $_SESSION['commentId']=trim(htmlspecialchars($_GET['commentId']));
        $id=$_SESSION['commentId'];
        $sql="select * from postcomment where id='".$id."' ";
        $res=$conn->query($sql);
        if($res->num_rows>0)
        {
            if(isset($_POST['updateCommentData']))
            {
                if(!empty($_POST['postId']) && !empty($_POST['commentBy']) && !empty($_POST['commentContent']) )
                {
                    $sqlFindCommenter="select * from postcomment where commentBy='".$id."' ";
                    $res=$conn->query($sqlFindCommenter);
                    $updateComment="update postcomment set postId='".trim(htmlspecialchars($_POST['postId']))."',commentBy='".trim(htmlspecialchars($_POST['commentBy']))."',commentContent='".trim(htmlspecialchars($_POST['commentContent']))."' where id='".$id."' ";
                    $conn->query($updateComment);
                    echo '<script>alert("Success")</script>';
                }
                else
                {
                    echo '<script>alert("Can not be empty")</script>';
                }
            }
            $sql="select * from postcomment where id='".$id."' ";
            $res=$conn->query($sql);
            $row=$res->fetch_assoc();
            echo '<table class="text_angel form-input">
                <tr>
                    <th>Post ID</th>
                    <th>Comment By</th>
                    <th>Comment Content</th>
                </tr>';
                echo'
                <form action="" method="post">
                    <tr><td><input type="text" name="postId" value="'.$row['postId'].'"></td>
                    <td><input type="text" name="commentBy" value="'.$row['commentBy'].'"></td>
                    <td><input type="text" name="commentContent" value="'.$row['commentContent'].'"></td></tr>
                    <tr><td><input tyle="color:white; padding:8px; background-color:green;" type="submit" value="update" name="updateCommentData">
                    <a href="comment.php" style="background-color:rgb(166, 18, 18); color:white; padding:8px;">Back</a></td></tr>
                </form>
            </table>';
        }
        else
        {
            echo '<h1 class="center_align text_angel"></h1>';
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../basicstyling.css">
    <link rel="stylesheet" href="../../css/adminTemplate.css">
    <link rel="stylesheet" href="../../css/adminDashboard.css">
    <link rel="stylesheet" href="../../css/adminData.css">
</head>
<body>
    <?php
        if(isset($_GET['loadPost']) && trim(htmlspecialchars($_GET['loadPost']))==true)
        {
            generatePostDataTable();
        }
        else if(isset($_GET['loadMessage']) && trim(htmlspecialchars($_GET['loadMessage']))==true)
        {
            generateMessageDataTable();
        }
        else if (isset($_GET['loadPhoto']) && trim(htmlspecialchars($_GET['loadPhoto']))==true)
        {
            genereatePhotosDataTable();
        }
        else if(isset($_GET['likeId']))
        {
            generateLikeDataTable();
        }
        else if(isset($_GET['commentId']))
        {
            generateCommentTable();
        }
    ?>
</body>
</html>
