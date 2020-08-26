<?php
     session_start();
     $conn=new mysqli("localhost","root","","socialsite");
     if(!isset($_SESSION['adminUsername']))
     {
         header("location:../securityCode.php");
     }
     

    function deleteUser()
    {
        global $conn;
        if($_GET['deleteFlag']==1)
        {
            $deleteQueryUserInfo="delete from userinfo where username= '".trim(htmlspecialchars($_GET['key']))."' ";
            $deleteQueryAbout="delete from about where username= '".trim(htmlspecialchars($_GET['key']))."' ";
            $deleteQueryPost="delete from post where username= '".trim(htmlspecialchars($_GET['key']))."' ";
            $deleteQueryPostLike="delete from postlike where likedby= '".trim(htmlspecialchars($_GET['key']))."' ";
            $deleteQueryPostComment="delete from postcomment where commentBy= '".trim(htmlspecialchars($_GET['key']))."' ";
            $deleteQueryPhotos="delete from photos where username= '".trim(htmlspecialchars($_GET['key']))."' ";
            $deleteQueryFriend="delete from friend where( username='".trim(htmlspecialchars($_GET['key']))."'  or receivername='".htmlspecialchars($_GET['key'])."' )";
            $deleteMessageQuery="delete from message where  (senderUsername='".trim(htmlspecialchars($_GET['key']))."' or receiverUsername='".htmlspecialchars($_GET['key'])."')";

            $conn->query($deleteQueryUserInfo) or die("Not Deleted 1");
            $conn->query($deleteQueryAbout) or die("Not Deleted 2 ");
            $conn->query($deleteQueryPost) or die("Not Deleted 3");
            $conn->query($deleteQueryPostLike) or die("Not Deleted 4");
            $conn->query($deleteQueryPostComment) or die("Not Deleted 5");
            $conn->query($deleteQueryPhotos) or die("Not Deleted 6");
            $conn->query($deleteQueryFriend) or die("Not Deleted 7");
            $conn->query($deleteMessageQuery) or die("Not Deleted 8");
            echo "success";
        }
    }
    
    function loadGridView()
    {
        global $conn;
        $key=htmlspecialchars($_GET['key']);
        $sql = "select * from userinfo inner join about on userinfo.username=about.username where userinfo.username like '%$key%'"; 
        $res=$conn->query($sql);
        echo '<table>
        <tr>
            <th style="width:10%;">Username</th>
            <th>User First Name</th>
            <th>User Last Name</th>
            <th>User Date Of Birth</th>
            <th>User Sequrity Question Ans</th>
            <th>User Gender</th>
            <th>User Education</th>
            <th>User Subject</th>
            <th>User Phonenumber</th>
            <th>User Profile Picture Path</th>
            <th>User Cover Picture Path</th>
        </tr>';
        if($res->num_rows>0)
        {
            
            while($row=$res->fetch_assoc())
            {
                echo '
                    <tr>
                        <td>'.$row['username'].'
                            <form action="" method="post">
                                <div class="update_cancel_btn_container">
                                    <a href="getInfoUpdatePanel.php?key='.$row['username'].' "><input type="submit" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                                    <input type="button" onclick="deleteUser(\''.$row['username'].'\')" value="Delete" style="color:white; padding:8px; background-color:rgb(166, 18, 18);">
                                </div>
                            </form>
                        </td>
                        <td>'.$row['firstName'].'</td>
                        <td>'.$row['lastName'].'</td>
                        <td>'.$row['dateOfBirth'].'</td>
                        <td>'.$row['securityQuestion'].'</td>
                        <td>'.$row['gender'].'</td>
                        <td>'.$row['education'].'</td>
                        <td>'.$row['subject'].'</td>
                        <td>'.$row['phonenumber'].'</td>
                        <td> <a href="../../../'.$row['propic'].'" ><img src="../../../'.$row['propic'].'" alt="" srcset="" style="object-fit:contain; width:100px;"> </a></td>
                        <td> <a href="../../../'.$row['coverpic'].'" ><img src="../../../'.$row['coverpic'].'" alt="" srcset="" style="object-fit:contain; width:100px;"> </a></td>
                    </tr>
                ';
            }
        }
    }
    function loadGridViewPost()
    {
        global $conn;
        echo '<table>
            <tr>
                <th style="width:10%;">Post ID</th>
                <th>Username</th>
                <th>Content</th>
                <th>Picture</th>
            </tr>';
        $username=htmlspecialchars($_GET['postUsername']);
        
        $sql="select * from post where username like '%$username%' ;";
        $res=$conn->query($sql);
        if($res->num_rows>0)
        {
            while($row=$res->fetch_assoc())
            {
                echo'
                <tr>
                    <td>'.$row['postid'].'
                    <form action="" method="post">
                        <div class="update_cancel_btn_container">
                            <a href="#"><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                            <input type="button" onclick=" (\''.$row['postid'].'\')"  value="Delete" style="color:white; padding:8px; background-color:rgb(166, 18, 18);">
                        </div>
                    </form>
                    </td>
                    <td>'.$row['username'].'</td>
                    <td>'.$row['content'].'</td>
                    <td>'.$row['picture'].'</td>
                </tr>';
            }
        }
        echo '</table>';
    }

    function deletePostId()
    {
        global $conn;
        $queryGetPhotoPath="select picture from post where postid='".trim(htmlspecialchars($_GET['deletePostId']))."' ";
        $res=$conn->query($queryGetPhotoPath);
        $row=$res->fetch_assoc();

        $deleteQueryPost="delete from post where postid='".trim(htmlspecialchars($_GET['deletePostId']))."' ";
        $deleteQueryPostLike="delete from postlike where postId='".trim(htmlspecialchars($_GET['deletePostId']))."' ";
        $deleteQueryPostComment="delete from postcomment where postId='".trim(htmlspecialchars($_GET['deletePostId']))."' ";
        $deleteQueryPhotos="delete from photos where path='".trim(htmlspecialchars($row['picture']))."' ";

        $conn->query($deleteQueryPost) or die("Not Deleted 3");
        $conn->query($deleteQueryPostLike) or die("Not Deleted 4");
        $conn->query($deleteQueryPostComment) or die("Not Deleted 5");
        
        if($res->num_rows>0)
        {
            $conn->query($deleteQueryPhotos) or die("Not Deleted 6");
        }
    }
    function deleteMessage()
    {
        global $conn;
        $deleteMessageQuery="delete from message where messageId='".trim(htmlspecialchars($_GET['deleteMessageId']))."' ";
        $conn->query($deleteMessageQuery) or die("Not Deleted 8");
    }

    function loadGridViewMessage()
    {
        global $conn;
        $sql="select * from message";
        $res=$conn->query($sql);
        echo '
        <table>
        <tr>
            <th style="width:10%;">Message Id</th>
            <th>Content</th>
            <th>Message Type</th>
            <th>Sender Username</th>
            <th>Receiver Username</th>
            <th>Send Time</th>
        </tr>';
        
        if($res->num_rows>0)
        {
            while($row=$res->fetch_assoc())
            { 
                if($row['messageType']=="text"){
                    echo'
                    <tr>
                        <td>'.$row['messageId'].'
                        <form action="" method="post">
                            <div class="update_cancel_btn_container">
                                <a href="updateUsers.php?messageId='.$row['messageId'].'&loadMessage=true"><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                                <input type="button" onclick="deleteMessageId(\''.$row['messageId'].'\')" value="Delete" style="color:white; padding:8px; background-color:rgb(166, 18, 18);">
                            </div>
                        </form>
                        </td>
                        <td>'.$row['content'].'</td>
                        <td>'.$row['messageType'].'</td>
                        <td>'.$row['senderUsername'].'</td>
                        <td>'.$row['receiverUsername'].'</td>
                        <td>'.$row['sendTime'].'</td>
                    </tr>';
                    }
                    else if($row['messageType']=="path")
                    {
                        echo'
                            <tr>
                                <td>'.$row['messageId'].'
                                <form action="" method="post">
                                    <div class="update_cancel_btn_container">
                                        <a href="updateUsers.php?messageId='.$row['messageId'].'&loadMessage=true"><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                                        <input type="button" onclick="deleteMessageId(\''.$row['messageId'].'\')" value="Delete" style="color:white; padding:8px; background-color:rgb(166, 18, 18);">
                                    </div>
                                </form>
                                </td>
                                <td><a href="../../../'.$row['content'].'" ><img src="../../../'.$row['content'].'" alt="" srcset="" style="object-fit:contain; width:100px;"> </a></td>
                                <td>'.$row['messageType'].'</td>
                                <td>'.$row['senderUsername'].'</td>
                                <td>'.$row['receiverUsername'].'</td>
                                <td>'.$row['sendTime'].'</td>
                            </tr>';
                    }
            }
        } 
    }

    function loadGridViewPhotos()
    {
        global $conn;
        $key= trim(htmlspecialchars($_GET['photosUsername']));
        $sql="select * from photos where username like '%$key%' ";
        $res=$conn->query($sql);
        echo '<table>
                <tr>
                    <th style="width:10%;">Photo ID </th>
                    <th  style="width:10%;">Username</th>
                    <th>Path</th>
                    <th>Type</th> 
                </tr>';
                if($res->num_rows>0)
                {
                    while($row=$res->fetch_assoc())
                    {
                        echo '
                            <tr>
                                <td>'.$row['photoId'].'
                                <form action="" method="post">
                                    <div class="update_cancel_btn_container">
                                        <a><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                                        <input type="button" value="Delete" style="color:white; padding:8px; background-color:rgb(166, 18, 18);">
                                    </div>
                                </form>
                                </td>
                                <td> '.$row['username'].'</td>
                                <td> <a style="background-color:white;" href="../../../'.$row['path'].'" ><img src="../../../'.$row['path'].'" alt="" srcset="" style="object-fit:contain; width:100px;"> </a></td>
                                <td>'.$row['type'].'</td>
                            </tr>
                        ';
                    }
                }
           echo '</table>';
    }
    function loadGridViewLike()
    {
        global $conn;
        $username=trim(htmlspecialchars($_GET['likedUsername']));
        $sql = " select * from postlike where likedBy like'%$username%' ";
        //die($sql);
        $res=$conn->query($sql);
        echo '<table>
        <tr>
            <th style="width:10%;"> ID </th>
            <th>POST ID</th>
            <th>Liked By</th>
        </tr>';
        if($res->num_rows>0)
        {
            while($row=$res->fetch_assoc()){
            echo '
                <tr>
                    <td>'.$row['id'].'
                    <div class="update_cancel_btn_container">
                        <a href="updateUsers.php?likeId='.$row['id'].' "><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                        <input type="button" value="Delete" onclick="deleteLike(\''.$row['id'].'\')"" style="color:white; padding:8px; background-color:rgb(223,40,35);">
                    </div>
                    </td>
                    <td>'.$row['postId'].'</td>
                    <td> '.$row['likedBy'].'</td>
                </tr>
            ';
            }
        }
    }
    function deleteLike()
    {
        global $conn;
        $id=trim(htmlspecialchars($_GET['likeId']));
        $col=$conn->query("delete from postlike where id='".$id."'") or die("stat died");
    }
    function loadGridViewComment()
    {
        global $conn;
        $commentBy=trim(htmlspecialchars($_GET['commentUsername']));
        $sql="select * from postcomment where commentBy like '%$commentBy%' ";
        $res=$conn->query($sql);
        if($res->num_rows>0)
        {
            echo '<table>
            <tr>
                <th style="width:10%;"> ID </th>
                <th>POST ID</th>
                <th>Comment By</th>
                <th>Comment Content</th>
            </tr>';
            while($row=$res->fetch_assoc())
            {
                echo '<tr>
                        <td>'.$row['id'].'
                        <div class="update_cancel_btn_container">
                            <a href="updateUsers.php?commentId='.$row['id'].' "><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                            <input type="button" value="Delete" onclick="deleteComment(\''.$row['id'].'\')"" style="color:white; padding:8px; background-color:rgb(223,40,35);">
                        </div>
                        </td>
                        <td>'.$row['postId'].'</td>
                        <td> '.$row['commentBy'].'</td>
                        <td> '.$row['commentContent'].'</td>
                    </tr>
                    ';
            }
        }
    }

    if(isset($_GET['deleteFlag']) && isset($_GET['key']) && !empty(htmlspecialchars($_GET['key'])))
    {
        deleteUser();
    }
    else if(isset($_GET['key']))
    {
        loadGridView();
    }
    else if(isset($_GET['postUsername']))
    {
        loadGridViewPost();
    }
    else if(isset($_GET['deletePostId']))
    {
        deletePostId();
        $_GET['postUsername']=" ";
        loadGridViewPost();
    }
    else if(isset($_GET['deleteMessageId']))
    {
        deleteMessage();
        loadGridViewMessage();
    }
    else if(isset($_GET['photosUsername']))
    {
        loadGridViewPhotos();
    }
    else if(isset($_GET['likedUsername']))
    {
        loadGridViewLike();
    }
    else if(isset($_GET['likeId']))
    {
        deleteLike();
        $_GET['likedUsername']=" ";
        loadGridViewLike();
    }
    else if(isset($_GET['commentUsername']))
    {
        loadGridViewComment();
    }
?>  