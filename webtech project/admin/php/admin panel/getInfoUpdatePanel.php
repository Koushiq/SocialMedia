<?php
     session_start();
     $conn=new mysqli("localhost","root","","socialsite");
     if(!isset($_SESSION['adminUsername']))
     {
         header("location:../securityCode.php");
     }
    $sqlCheck="select * from userdatapermission where username='".$_SESSION['adminUsername']."' ;";
    $resCheck=$conn->query($sqlCheck);
    $rowCheck=$resCheck->fetch_assoc();

    if($rowCheck['u']=="false")
    {
        echo'<script>alert("You do not have permission to update");
        window.location.href="userData.php";
        </script>';
    }

     if(isset($_GET['successMsg']))
     {
         if(htmlspecialchars($_GET['successMsg']==1))
         {
            echo '<script>alert("Success");</script>';
         }
         else if(htmlspecialchars($_GET['successMsg']==0))
         {
            echo '<script>alert("Username Exists Try Another username");</script>';
         }
     }
            if(isset($_POST['updatePhotoData']))
            {
                if(isset( $_SESSION['photoId']) && isset($_SESSION['pictype']))
                {
                    if(!empty($_FILES['updatePic']['name']))
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
                    echo' <script>alert("no changes")</script>';
                    }
                }
            }
     $key=htmlspecialchars($_GET['key']);
     $sql = "select * from userinfo inner join about on userinfo.username=about.username where userinfo.username = '".$key."' ";
     $res=$conn->query($sql);
     if($res->num_rows>1)
     {
         header("location:userData.php");
     }

     $row=$res->fetch_assoc();
     if(isset($_POST['update']))
     {
        if(!empty($_POST['username']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['dateOfBirth']) && !empty($_POST['securityQuestion']) && !empty($_POST['education']) && !empty($_POST['subject'])  && !empty($_POST['phonenumber']) && !empty($_POST['gender']) )
        {
            $checkUsernameAvailable="select * from userinfo where username='".htmlspecialchars($_POST['username'])."' ";
            $resAvailable=$conn->query($checkUsernameAvailable);
            if($resAvailable->num_rows==0 || htmlspecialchars($_POST['username'])==$key)
            {
                $updateQuery1="update userinfo set username='".htmlspecialchars($_POST['username'])."',firstName='".htmlspecialchars($_POST['firstName'])."',lastName='".htmlspecialchars($_POST['lastName'])."',dateOfBirth='".htmlspecialchars($_POST['dateOfBirth'])."',securityQuestion='".htmlspecialchars($_POST['securityQuestion'])."',securityQuestion='".htmlspecialchars($_POST['securityQuestion'])."',gender='".htmlspecialchars($_POST['gender'])."' where username='".$key."' ";
                $updateQuery2="update about set username='".htmlspecialchars($_POST['username'])."',education='".htmlspecialchars($_POST['education'])."',subject='".htmlspecialchars($_POST['subject'])."',phonenumber='".htmlspecialchars($_POST['phonenumber'])."' where username='".$key."' ";
                $conn->query($updateQuery1);
                $conn->query($updateQuery2);
                header("location:getInfoUpdatePanel.php?key=$key&successMsg=1");
            }
            else
            {
                header("location:getInfoUpdatePanel.php?key=$key&successMsg=0");
            }
        }
        else
        {
            echo '<script>alert("No fields can not be empty");</script>';
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
    <title>Document</title>
</head>
<body>
     <form action="" method="post">
        <div class="update_window_panel form-input">
            <table>
            <tr>
                <td> username</td>
                <td> <input type="text" name="username" id="" value="<?php echo $row['username'];?>"></td>
            </tr>
            <tr>
                <td>firstname</td> 
                <td><input type="text" name="firstName" id="" value="<?php echo $row['firstName'];?>"></td>
            </tr>
            <tr>
                <td>
                lastname
                </td>
                <td>
                <input type="text" name="lastName" id="" value="<?php echo $row['lastName'];?>">
                </td>
            </tr>
            <tr>
                <td>
                dateofbirth
                </td>
                <td>
                <input type="date" name="dateOfBirth" id="" value="<?php echo $row['dateOfBirth'];?>">
                </td>
            </tr>
            <tr>
                <td>
                sequrity question
                </td>
                <td>
                <input type="text" name="securityQuestion" id="" value="<?php echo $row['securityQuestion'];?>">
                </td>
            </tr>
            <tr>
                <td>
                education
                </td>
                <td>
                <input type="text" name="education" id="" value="<?php echo $row['education'];?>"><br>
                </td>
            </tr>
            <tr>
                    <td>
                        subject
                    </td>
                    <td>
                    <input type="text" name="subject" id="" value="<?php echo $row['subject'];?>">
                    </td>
            </tr>
            <tr>
                <td>phonenumber</td>
                <td><input type="text" name="phonenumber" id="" value="<?php echo $row['phonenumber'];?>"></td>
            </tr>
            <tr>
                <td>Gender</td>
                 <?php
                     if($row['gender']=="male")
                     {
                         echo '<td><input type="radio" value="male" checked="checked" name="gender" id=""> male<br>';
                         echo '<input type="radio" value="female"  name="gender" id="">female</td> ';
                     }
                     else
                     {
                        echo '<td><input type="radio" value="male"  name="gender" id=""> male<br>';
                        echo '<input type="radio" value="female" checked="checked" name="gender" id="">female</td>';
                     }
                 ?>
            </tr>
            <tr>
                <td><input  style="color:white; padding:8px; background-color:green;" type="submit" value="update" name="update">
                <a href="userData.php" style="background-color:rgb(166, 18, 18); color:white; padding:8px;">Back</a></td>
            </tr>
            </table>
        </div>
    </form>
</body>
</html>
