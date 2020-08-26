<?php
    session_start();
    $conn=new mysqli("localhost","root","","socialsite");
    if(!isset($_SESSION['adminUsername']))
    {
        header("location:../securityCode.php");
    }
    $sql = "select * from admininfo where username!='".$_SESSION['adminUsername']."' ";
    $res=$conn->query($sql);
    
    $sqlCheck=$sql;
    $resCheck=$conn->query($sqlCheck);

    $userdataC="false";
    $userdataR="false";
    $userdataU="false";
    $userdataD="false";

    $userpostC="false";
    $userpostR="false";
    $userpostU="false";
    $userpostD="false";

    $usermessageC="false";
    $usermessageR="false";
    $usermessageU="false";
    $usermessageD="false";

    $userphotoC="false";
    $userphotoR="false";
    $userphotoU="false";
    $userphotoD="false";

    $userlikeC="false";
    $userlikeR="false";
    $userlikeU="false";
    $userlikeD="false";


    $usercommentC="false";
    $usercommentR="false";
    $usercommentU="false";
    $usercommentD="false";

    while($rowCheck=$resCheck->fetch_assoc())
    {
        if(isset($_POST[$rowCheck['username'].'update']))
        {
            if(!empty($_POST['userdataC'.$rowCheck['username']]))
            {
                $userdataC="true";
                //echo '<script>alert(1);</script>';
            }
            if(!empty($_POST['userdataR'.$rowCheck['username']]))
            {
                $userdataR="true";
                //echo '<script>alert(2);</script>';
            }
            if(!empty($_POST['userdataU'.$rowCheck['username']]))
            {
                $userdataU="true";
                //echo '<script>alert(3);</script>';
            }
            if(!empty($_POST['userdataD'.$rowCheck['username']]))
            {
                $userdataD="true";
                //echo '<script>alert(4);</script>';
            }
            // update permission table userdata
            $sqlUpdateUserData="update userdatapermission set c='".$userdataC."',r='".$userdataR."',u='".$userdataU."',d='".$userdataD."' where username='".$rowCheck['username']."' ;";
            $conn->query($sqlUpdateUserData);

            if(!empty($_POST['userpostC'.$rowCheck['username']]))
            {
                $userpostC="true";
                //echo '<script>alert(1);</script>';
            }
            if(!empty($_POST['userpostR'.$rowCheck['username']]))
            {
                $userpostR="true";
                //echo '<script>alert(2);</script>';
            }
            if(!empty($_POST['userpostU'.$rowCheck['username']]))
            {
                $userpostU="true";
                //echo '<script>alert(3);</script>';
            }
            if(!empty($_POST['userpostD'.$rowCheck['username']]))
            {
                $userpostD="true";
                //echo '<script>alert(4);</script>';
            }
            $sqlUpdateUserPost="update userpostpermission set c='".$userpostC."',r='".$userpostR."',u='".$userpostU."',d='".$userpostD."' where username='".$rowCheck['username']."' ;";
            $conn->query($sqlUpdateUserPost);

            if(!empty($_POST['usermessageC'.$rowCheck['username']]))
            {
                $usermessageC="true";
                //echo '<script>alert(1);</script>';
            }
            if(!empty($_POST['usermessageR'.$rowCheck['username']]))
            {
                $usermessageR="true";
                //echo '<script>alert(2);</script>';
            }
            if(!empty($_POST['usermessageU'.$rowCheck['username']]))
            {
                $usermessageU="true";
                //echo '<script>alert(3);</script>';
            }
            if(!empty($_POST['usermessageD'.$rowCheck['username']]))
            {
                $usermessageD="true";
                //echo '<script>alert(4);</script>';
            }
            $sqlUpdateUserMessage="update usermessagepermission set c='".$usermessageC."',r='".$usermessageR."',u='".$usermessageU."',d='".$usermessageD."' where username='".$rowCheck['username']."' ;";
            $conn->query($sqlUpdateUserMessage);

            if(!empty($_POST['userphotoC'.$rowCheck['username']]))
            {
                $userphotoC="true";
                //echo '<script>alert(1);</script>';
            }
            if(!empty($_POST['userphotoR'.$rowCheck['username']]))
            {
                $userphotoR="true";
                //echo '<script>alert(2);</script>';
            }
            if(!empty($_POST['userphotoU'.$rowCheck['username']]))
            {
                $userphotoU="true";
                //echo '<script>alert(3);</script>';
            }
            if(!empty($_POST['userphotoD'.$rowCheck['username']]))
            {
                $userphotoD="true";
                //echo '<script>alert(4);</script>';
            }
            $sqlUpdateUserPhoto="update userphotopermission set c='".$userphotoC."',r='".$userphotoR."',u='".$userphotoU."',d='".$userphotoD."' where username='".$rowCheck['username']."' ;";
            $conn->query($sqlUpdateUserPhoto);
            
            if(!empty($_POST['userlikeC'.$rowCheck['username']]))
            {
                $userlikeC="true";
                //echo '<script>alert(1);</script>';
            }
            if(!empty($_POST['userlikeR'.$rowCheck['username']]))
            {
                $userlikeR="true";
                //echo '<script>alert(2);</script>';
            }
            if(!empty($_POST['userlikeU'.$rowCheck['username']]))
            {
                $userlikeU="true";
                //echo '<script>alert(3);</script>';
            }
            if(!empty($_POST['userlikeD'.$rowCheck['username']]))
            {
                $userlikeD="true";
                //echo '<script>alert(4);</script>';
            }
            $sqlUserLikePermission="update userlikepermission set c='".$userlikeC."',r='".$userlikeR."',u='".$userlikeU."',d='".$userlikeD."' where username='".$rowCheck['username']."' ;";
            $conn->query($sqlUserLikePermission);

            if(!empty($_POST['usercommentC'.$rowCheck['username']]))
            {
                $usercommentC="true";
                //echo '<script>alert(1);</script>';
            }
            if(!empty($_POST['usercommentR'.$rowCheck['username']]))
            {
                $usercommentR="true";
                //echo '<script>alert(2);</script>';
            }
            if(!empty($_POST['usercommentU'.$rowCheck['username']]))
            {
                $usercommentU="true";
                //echo '<script>alert(3);</script>';
            }
            if(!empty($_POST['usercommentD'.$rowCheck['username']]))
            {
                $usercommentD="true";
                //echo '<script>alert(4);</script>';
            }
            $sqlUserCommentPermission="update usercommentpermission set c='".$usercommentC."',r='".$usercommentR."',u='".$usercommentU."',d='".$usercommentD."' where username='".$rowCheck['username']."' ;";
            $conn->query($sqlUserCommentPermission);

        }
    }

    
    
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../basicstyling.css">
    <link rel="stylesheet" href="../../css/adminTemplate.css">
    <link rel="stylesheet" href="../../css/adminDashboard.css">
    <link rel="stylesheet" href="../../css/adminData.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <script src="fontawesome/js/all.js"></script>
    
  </head>
  <body>
    <div class="column" id="col-1">
        <?php include("../navigatormenu/sidebarNav.php"); ?>
    </div>

    <div class="column" style="color:rgb(224, 220, 220);" id="col-2">
        <div class="table_wrapper">
            <h5><a style="color:white;" href="systemData.php">Back</a></h5>
            <header><h1>Admin Data Table</h1></header>
            
            <table>
            <tr>
                <th style="width:10%;">Username</th>
                <th>User Data Permissions</th>
                <th>User Post Permissions</th>
                <th>User Message Permissions</th>
                <th>User Photo Permissions</th>
                <th>User Like Permissions</th>
                <th>User Comment Permissions</th>
            </tr>
            <?php
                
                if($res->num_rows>0)
                {
                    while($row=$res->fetch_assoc())
                    {
                        $sqlUserdataPermission="select * from userdatapermission where username='".$row['username']."' ";
                        $resUserdataPermission=$conn->query($sqlUserdataPermission);
                        $rowUserdataPermission=$resUserdataPermission->fetch_assoc();

                        $sqlUserPostPermission="select * from userpostpermission where username='".$row['username']."' ";
                        $resUserPostPermission=$conn->query($sqlUserPostPermission);
                        $rowUserPostPermission=$resUserPostPermission->fetch_assoc();

                        $sqlUserMessagePermission="select * from usermessagepermission where username ='".$row['username']."'  ";
                        $resUserMessagePermission=$conn->query($sqlUserMessagePermission);
                        $rowUserMessagePermission=$resUserMessagePermission->fetch_assoc();

                        $sqlUserPhotoPermission="select * from userphotopermission where username='".$row['username']."' ";
                        $resUserPhotoPermission=$conn->query($sqlUserPhotoPermission);
                        $rowUserPhotoPermission=$resUserPhotoPermission->fetch_assoc();

                        $sqlUserLikePermission="select * from userlikepermission where username='".$row['username']."' ";
                        $resUserLikePermission=$conn->query($sqlUserLikePermission);
                        $rowUserLikePermission=$resUserLikePermission->fetch_assoc();

                        $sqlUserCommentPermission="select * from usercommentpermission where username='".$row['username']."' ";
                        $resUserCommentPermission=$conn->query($sqlUserCommentPermission);
                        $rowUserCommentPermission=$resUserCommentPermission->fetch_assoc();

                        echo
                        '<tr><td>'.$row['username'].'
                            <div class="edit_update_btns">
                                <form action="" method="post">
                                    <div class="update_cancel_btn_container">
                                        <input type="submit" value="Update" style="color:white; padding:8px; background-color:green;" name="'.$row['username']."update".'">
                                        <input type="submit" style="color:white; padding:8px; background-color:purple;" name="'.$row['username']."delete".'" value="Delete">     
                                    </div>
                            </div>
                        </td>
                        
                        <td>';

                        if($resUserdataPermission->num_rows>0)
                        {
                            if($rowUserdataPermission['c']=="true")
                            {
                                echo '<input type="checkbox" id="userdataC" checked="checked" name="userdataC'.$row['username'].'">
                                <label for="userdataC"> Create</label>
                                <br>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="userdataC" name="userdataC'.$row['username'].'" value="userdataC" >
                                <label for="userdataC"> Create</label>
                                <br>';
                            }
                            if($rowUserdataPermission['r']=="true")
                            {
                                echo '<input type="checkbox" id="userdataR" checked="checked" name="userdataR'.$row['username'].'">
                                <label for="userdataR"> Read</label>
                                <br>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="userdataR" name="userdataR'.$row['username'].'">
                                <label for="userdataR"> Read</label>
                                <br>';
                            } 
                            if($rowUserdataPermission['u']=="true")
                            {
                                echo '<input type="checkbox" id="userdataU" checked="checked" name="userdataU'.$row['username'].'">
                                <label for="userdataU"> Update</label>
                                <br>';
                            }  
                            else
                            {
                                echo '<input type="checkbox" id="userdataU" name="userdataU'.$row['username'].'">
                                <label for="userdataU"> Update</label>
                                <br>';
                            }
                            if($rowUserdataPermission['d']=="true")
                            {
                                echo '<input type="checkbox" id="userdataD" checked="checked" name="userdataD'.$row['username'].'">
                                <label for="userdataD"> Delete</label></td>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="userdataD" name="userdataD'.$row['username'].'">
                                <label for="userdataD"> Delete</label></td>';
                            }
                        }
                        if($resUserPostPermission->num_rows>0)
                        {
                            if($rowUserPostPermission['c']=="true")
                            {
                                echo '<td><input type="checkbox" id="userpostC" checked="checked" name="userpostC'.$row['username'].'">
                                <label for="userdataC"> Create</label>
                                <br>';
                            }
                            else
                            {
                                echo '<td><input type="checkbox" id="userpostC" name="userpostC'.$row['username'].'">
                                <label for="userdataC"> Create</label>
                                <br>';
                            }
                            if($rowUserPostPermission['r']=="true")
                            {
                                echo '<input type="checkbox" id="userpostR" checked="checked" name="userpostR'.$row['username'].'">
                                <label for="userdataR"> Read</label>
                                <br>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="userpostR" name="userpostR'.$row['username'].'">
                                <label for="userdataR"> Read</label>
                                <br>';
                            } 
                            if($rowUserPostPermission['u']=="true")
                            {
                                echo '<input type="checkbox" id="userpostU" checked="checked" name="userpostU'.$row['username'].'">
                                <label for="userdataU"> Update</label>
                                <br>';
                            }  
                            else
                            {
                                echo '<input type="checkbox" id="userpostU" name="userpostU'.$row['username'].'">
                                <label for="userdataU"> Update</label>
                                <br>';
                            }
                            if($rowUserPostPermission['d']=="true")
                            {
                                echo '<input type="checkbox" id="userpostD" checked="checked" name="userpostD'.$row['username'].'">
                                <label for="userdataD"> Delete</label></td>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="userpostD" name="userpostD'.$row['username'].'">
                                <label for="userdataD"> Delete</label></td>';
                            }
                        }
                        if($resUserMessagePermission->num_rows>0)
                        {
                            if($rowUserMessagePermission['c']=="true")
                            {
                                echo '<td><input type="checkbox" id="usermessageC" checked="checked" name="usermessageC'.$row['username'].'">
                                <label for="usermessageC"> Create</label>
                                <br>';
                            }
                            else
                            {
                                echo '<td><input type="checkbox" id="usermessageC" name="usermessageC'.$row['username'].'">
                                <label for="usermessageC"> Create</label>
                                <br>';
                            }
                            if($rowUserMessagePermission['r']=="true")
                            {
                                echo '<input type="checkbox" id="usermessageR" checked="checked" name="usermessageR'.$row['username'].'">
                                <label for="usermessageR"> Read</label>
                                <br>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="userMessageR" name="usermessageR'.$row['username'].'">
                                <label for="usermessageR"> Read</label>
                                <br>';
                            } 
                            if($rowUserMessagePermission['u']=="true")
                            {
                                echo '<input type="checkbox" id="usermessageU" checked="checked" name="usermessageU'.$row['username'].'">
                                <label for="usermessageU"> Update</label>
                                <br>';
                            }  
                            else
                            {
                                echo '<input type="checkbox" id="usermessageU" name="usermessageU'.$row['username'].'">
                                <label for="usermessageU"> Update</label>
                                <br>';
                            }
                            if($rowUserMessagePermission['d']=="true")
                            {
                                echo '<input type="checkbox" id="usermessageD" checked="checked" name="usermessageD'.$row['username'].'">
                                <label for="usermessageD"> Delete</label></td>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="usermessageD" name="usermessageD'.$row['username'].'">
                                <label for="usermessageD"> Delete</label></td>';
                            }
                        }

                        if($resUserPhotoPermission->num_rows>0)
                        {
                            if($rowUserPhotoPermission['c']=="true")
                            {
                                echo '<td><input type="checkbox" id="userphotoC" checked="checked" name="userphotoC'.$row['username'].'">
                                <label for="userphotoC"> Create</label>
                                <br>';
                            }
                            else
                            {
                                echo '<td><input type="checkbox" id="userphotoC" name="userphotoC'.$row['username'].'">
                                <label for="userphotoC"> Create</label>
                                <br>';
                            }
                            if($rowUserPhotoPermission['r']=="true")
                            {
                                echo '<input type="checkbox" id="userphotoR" checked="checked" name="userphotoR'.$row['username'].'">
                                <label for="userphotoR"> Read</label>
                                <br>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="userphotoR" name="userphotoR'.$row['username'].'">
                                <label for="userphotoR"> Read</label>
                                <br>';
                            } 
                            if($rowUserPhotoPermission['u']=="true")
                            {
                                echo '<input type="checkbox" id="userphotoU" checked="checked" name="userphotoU'.$row['username'].'">
                                <label for="userphotoU"> Update</label>
                                <br>';
                            }  
                            else
                            {
                                echo '<input type="checkbox" id="userphotoU" name="userphotoU'.$row['username'].'">
                                <label for="userphotoU"> Update</label>
                                <br>';
                            }
                            if($rowUserPhotoPermission['d']=="true")
                            {
                                echo '<input type="checkbox" id="userphotoD" checked="checked" name="userphotoD'.$row['username'].'">
                                <label for="userphotoD"> Delete</label></td>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="userphotoD" name="userphotoD'.$row['username'].'">
                                <label for="userphotoD"> Delete</label></td>';
                            }
                        }

                        if($resUserLikePermission->num_rows>0)
                        {
                            if($rowUserLikePermission['c']=="true")
                            {
                                echo '<td><input type="checkbox" id="userlikeC" checked="checked" name="userlikeC'.$row['username'].'">
                                <label for="userlikeC"> Create</label>
                                <br>';
                            }
                            else
                            {
                                echo '<td><input type="checkbox" id="userlikeC" name="userlikeC'.$row['username'].'">
                                <label for="userlikeC"> Create</label>
                                <br>';
                            }
                            if($rowUserLikePermission['r']=="true")
                            {
                                echo '<input type="checkbox" id="userlikeR" checked="checked" name="userlikeR'.$row['username'].'">
                                <label for="userlikeR"> Read</label>
                                <br>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="userlikeR" name="userlikeR'.$row['username'].'">
                                <label for="userlikeR"> Read</label>
                                <br>';
                            } 
                            if($rowUserLikePermission['u']=="true")
                            {
                                echo '<input type="checkbox" id="userlikeU" checked="checked" name="userlikeU'.$row['username'].'">
                                <label for="userlikeU"> Update</label>
                                <br>';
                            }  
                            else
                            {
                                echo '<input type="checkbox" id="userlikeU" name="userlikeU'.$row['username'].'">
                                <label for="userlikeU"> Update</label>
                                <br>';
                            }
                            if($rowUserLikePermission['d']=="true")
                            {
                                echo '<input type="checkbox" id="userlikeD" checked="checked" name="userlikeD'.$row['username'].'">
                                <label for="userlikeD"> Delete</label></td>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="userlikeD" name="userlikeD'.$row['username'].'">
                                <label for="userlikeD"> Delete</label></td>';
                            }
                        }

                        if($resUserCommentPermission->num_rows>0)
                        {
                            if($rowUserCommentPermission['c']=="true")
                            {
                                echo '<td><input type="checkbox" id="usercommentC" checked="checked" name="usercommentC'.$row['username'].'">
                                <label for="usercommentC"> Create</label>
                                <br>';
                            }
                            else
                            {
                                echo '<td><input type="checkbox" id="usercommentC" name="usercommentC'.$row['username'].'">
                                <label for="usercommentC"> Create</label>
                                <br>';
                            }
                            if($rowUserCommentPermission['r']=="true")
                            {
                                echo '<input type="checkbox" id="usercommentR" checked="checked" name="usercommentR'.$row['username'].'">
                                <label for="usercommentR"> Read</label>
                                <br>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="usercommentR" name="usercommentR'.$row['username'].'">
                                <label for="usercommentR"> Read</label>
                                <br>';
                            } 
                            if($rowUserCommentPermission['u']=="true")
                            {
                                echo '<input type="checkbox" id="usercommentU" checked="checked" name="usercommentU'.$row['username'].'">
                                <label for="usercommentU"> Update</label>
                                <br>';
                            }  
                            else
                            {
                                echo '<input type="checkbox" id="usercommentU" name="usercommentU'.$row['username'].'">
                                <label for="usercommentU"> Update</label>
                                <br>';
                            }
                            if($rowUserCommentPermission['d']=="true")
                            {
                                echo '<input type="checkbox" id="usercommentD" checked="checked" name="usercommentD'.$row['username'].'">
                                <label for="usercommentD"> Delete</label></td>';
                            }
                            else
                            {
                                echo '<input type="checkbox" id="usercommentD" name="usercommentD'.$row['username'].'">
                                <label for="usercommentD"> Delete</label></td>';
                            }
                        }
                        
                        echo'</td></tr>';
                    }
                } 

                echo ' </form>';
                ?>
            </table>
        </div>
    </div>
  </body>
</html>
