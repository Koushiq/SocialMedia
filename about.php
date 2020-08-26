<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    $conn = new mysqli("localhost", "root", "", "socialsite");
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
    
    $username=$_SESSION['username'];
    
    $sqlUserinfo = "select * from userinfo where username = '".$username."'";
    $sqlAbout = "select * from about where username = '".$username."'";
    $resultUserinfo= $conn->query($sqlUserinfo);
    $rowUserinfo=$resultUserinfo->fetch_assoc();
    $resultAbout= $conn->query($sqlAbout);
    $rowAbout=$resultAbout->fetch_assoc();
    $updateValidation=true;
    $firstName=$rowUserinfo['firstName'];
    $lastName=$rowUserinfo['lastName'];
    $education=$rowAbout['education'];
    $subject=$rowAbout['subject'];
    $phonenumber=$rowAbout['phonenumber'];
    $propic="";
    $coverpic="";
    $firstNameErr="";
    $lastNameErr="";
    $educationErr="";
    $subjectErr="";
    $phonenumberErr="";
    $propicErr="";
    $coverpicErr="";
   
    if(isset($_POST['update']))
    {
        if(!empty($_POST['firstName']))
        {
                $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
                if(!preg_match('#[0-9]#',$_POST['firstName'])   && !preg_match($pattern, $_POST['firstName']))
                {
                    $firstName=htmlspecialchars($_POST['firstName']);
                }
                else
                {
                    $firstName= $rowUserinfo['firstName'];
                    $firstNameErr="numbers and special chars not allowed";
                    $updateValidation=false;
                }
        }
        else
        {
            $firstName= $rowUserinfo['firstName'];
            $firstNameErr="Can't be empty";
            $updateValidation=false;
        }
        if(!empty($_POST['lastName']))
        {
                $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
                if(!preg_match('#[0-9]#',$_POST['lastName'])   && !preg_match($pattern, $_POST['lastName']))
                {
                    $lastName=htmlspecialchars($_POST['lastName']);
                }
                else
                {
                    $lastName= $rowUserinfo['lastName'];
                    $lastNameErr="numbers and special chars not allowed";
                    $updateValidation=false;
                }
        }
        else
        {
            $lastName= $rowUserinfo['lastName'];
            $lastNameErr="Can't be empty";
            $updateValidation=false;
        }
        if(!empty($_POST['education']))
        {
            $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
            if(!preg_match('#[0-9]#',$_POST['education']) && !preg_match($pattern, $_POST['education']))
            {
                $education=htmlspecialchars($_POST['education']);
            }
            else
            {
                $education=$rowAbout['education'];
                if($_POST['education']!="N/A")
                {
                    $educationErr="numbers and special chars not allowed";
                    $updateValidation=false;
                }
            }
        }
        else
        {
            $education=$rowAbout['education'];
            $educationErr="can't be empty";
            $updateValidation=false;
        }
        if(!empty($_POST['subject']))
        {
            $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
            if(!preg_match('#[0-9]#',$_POST['subject']) && !preg_match($pattern, $_POST['subject']))
            {
                $subject=htmlspecialchars($_POST['subject']);
            }
            else
            {
                $subject=$rowAbout['subject'];
                if($_POST['subject']!="N/A")
                {
                    $subjectErr="numbers and special chars not allowed";
                    $updateValidation=false;
                }
            }
        }
        else
        {
            $subject=$rowAbout['subject'];
            $subjectErr="can't be empty";
            $updateValidation=false;
        }
        if(!empty($_POST['phonenumber']))
        {
            if(is_numeric($_POST['phonenumber']))
            {
                $phonenumber=htmlspecialchars($_POST['phonenumber']);
            }
            else
            {
                $phonenumber=$rowAbout['phonenumber'];
                if($_POST['phonenumber']!="N/A")
                {
                    $phonenumberErr="No characters allowed !";
                    $updateValidation=false;
                }
            }
        }
        else
        {
            $phonenumber=$rowAbout['phonenumber'];
            $phonenumberErr="can't be empty";
            $updateValidation=false;
        }

       if(!empty($_FILES['propic']['name']))
       {
            $ext = pathinfo($_FILES['propic']['name'], PATHINFO_EXTENSION);
            if($ext=="jpg" || $ext=="PNG" || $ext=="gif"  || $ext=="tiff"  || $ext=="BMP")
            {
                $propic='propic/'.$username."-".getPhotoId().'.jpg';
                $handle = $_FILES["propic"]["tmp_name"];
                $sqlInsertPhoto = "insert into photos (username,path,type) values ('".$_SESSION['username']."','".$propic."','propic')";
                $conn->query($sqlInsertPhoto);
                copy($handle, $propic);
            }
            else
            {
                $propic=$rowAbout['propic'];
                $propicErr="Wrong file format !";
                $updateValidation=false;
            }
            
       }
       else
       {
            $propic=$rowAbout['propic'];
       }
       if(!empty($_FILES['coverpic']['name']))
       {
            $ext = pathinfo($_FILES['coverpic']['name'], PATHINFO_EXTENSION);
            if($ext=="jpg" || $ext=="PNG" || $ext=="gif"  || $ext=="tiff"  || $ext=="BMP")
            {
                $coverpic='coverpic/'.$username."-".getPhotoId().'.jpg';
                $handle = $_FILES["coverpic"]["tmp_name"];
                $sqlInsertPhoto = "insert into photos (username,path,type) values ('".$_SESSION['username']."','".$coverpic."','coverpic')";
                $conn->query($sqlInsertPhoto);
                copy($handle, $coverpic);
            }
            else
            {
                $coverpic=$rowAbout['coverpic'];
                $propicErr="Wrong file format !";
                $updateValidation=false;
            }
            
       }
       else
       {
            $coverpic=$rowAbout['coverpic'];
       }
       $sqlUserinfoUpdate = "update userinfo set firstname='".$firstName."' ,lastname='".$lastName."'  where username='".$username."' ;";
       $sqlAboutUpdate = "update about set education='".$education."' ,subject='".$subject."' , phonenumber='".$phonenumber."' ,  propic='".$propic."',  coverpic='".$coverpic."' where username='".$username."' ;";
       
       if($updateValidation==true)
       {
            $conn->query($sqlUserinfoUpdate);
            $conn->query($sqlAboutUpdate);
            $UpdateFriendTable="select * from friend where username='".$_SESSION['username']."' ";
            $res=$conn->query($UpdateFriendTable);
            if($res->num_rows>0)
            {
                $updateUsername="update friend set usernameFirstName='".$firstName."',usernameLastName='".$lastName."' , usernamePropic='".$propic."' where username='".$_SESSION['username']."'";
                $conn->query($updateUsername);
            }

            $UpdateFriendTable="select * from friend where receivername='".$_SESSION['username']."' ";
            $res=$conn->query($UpdateFriendTable);
            if($res->num_rows>0)
            {
                $updateUsername="update friend set receivernameFirstName='".$firstName."',receivernameLastName='".$lastName."' , receivernamePropic='".$propic."' where receivername='".$_SESSION['username']."'";
                $conn->query($updateUsername);
            }

            header("location:about.php");
       }
    }
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="basicstyling.css">
         <link rel="stylesheet" type="text/css" href="homepage.css"> 
         <link rel="stylesheet" type="text/css" href="profile.css">
         <link rel="stylesheet" type="text/css" href="about.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <script>
            function alphaOnly(event,choice) 
            {
                var key = event.keyCode;
                if(choice==1)
                {
                    if((key >= 65 && key <= 90) || (key >= 97 && key <= 122)  || key == 8)
                    {
                        document.getElementById("firstNameErr").innerHTML="";
                    }
                    else
                    {
                        document.getElementById("firstNameErr").innerHTML="Only Alphabets Allowed";
                        document.getElementById("firstName").value="";
                    }
                }
                else if(choice==2)
                {
                    if((key >= 65 && key <= 90) || (key >= 97 && key <= 122)  || key == 8)
                    {
                        document.getElementById("lastNameErr").innerHTML="";
                    }
                    else
                    {
                        document.getElementById("lastNameErr").innerHTML="Only Alphabets Allowed";
                        document.getElementById("lastName").value="";
                    }
                }
                else if(choice==3)
                {
                    if((key >= 65 && key <= 90) || (key >= 97 && key <= 122)  || key == 8)
                    {
                        document.getElementById("educationErr").innerHTML="";
                    }
                    else
                    {
                        document.getElementById("educationErr").innerHTML="Only Alphabets Allowed";
                        document.getElementById("education").value="";
                    }
                }
                else if(choice==4)
                {
                    if((key >= 65 && key <= 90) || (key >= 97 && key <= 122)  || key == 8)
                    {
                        document.getElementById("subjectErr").innerHTML="";
                    }
                    else
                    {
                        document.getElementById("subjectErr").innerHTML="Only Alphabets Allowed";
                        document.getElementById("subject").value="";
                    }
                }
                console.log(key);
            
            }

            function numericOnly(event)
            {
                var key=event.keyCode;

                if(key>=48 && key<=57)
                {
                    document.getElementById("phonenumberErr").innerHTML="";
                }
                else
                {
                    document.getElementById("phonenumberErr").innerHTML="Only Numeric Allowed";
                    document.getElementById("phonenumber").value="";
                }
            }
            
        </script>



        <?php
            include("headerfile.php");   
        ?>

       <div class="column center_align" id="col-1">
               
    </div>

    <div class="column" id="col-2">
        <div class="profile_top_div form-input">
            <img src="<?php echo $rowAbout['coverpic']; ?>" class="cover_pic">
            <img src="<?php echo $rowAbout['propic']; ?>" class="pro_pic">
            <h1 class="text_angel big_font" id="user_name"> <b> <?php echo $username;?> </b> </h1>
        </div>
        <?php 
            include("loadProfileBtns.php");
        ?>
        <form class="user_info_tab" method="post" action="" enctype="multipart/form-data">
            <h3>Edit profile Info</h3>
                <table class="form-input">
                    <tr>
                        <td>
                            <label>Username</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $username; ?>" name="username" readonly>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>
                            <label>First Name</label>
                        </td>
                        <td>
                            <input type="text" onkeypress="alphaOnly(event,'1')" id="firstName" value= "<?php echo $firstName; ?>" name="firstName">
                        </td>
                        <td>
                            <label class="text_error" id="firstNameErr"> <?php echo $firstNameErr; ?> </label>
                        </td>
                    </tr>
                 
                    <tr>
                        <td>
                            <label>Last Name :</label>
                        </td>
                        <td>
                            <input type="text" id="lastName" onkeypress="alphaOnly(event,'2')" value="<?php echo $lastName; ?>" name="lastName">
                        </td>
                        <td>
                            <label class="text_error" id="lastNameErr"> <?php echo $lastNameErr; ?> </label>
                        </td>
                    </tr>
                    <tr> 
                        <td>
                            <label>Gender:</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $rowUserinfo['gender']; ?>" name="gender" readonly>
                        </td>
                    </tr>

                    <tr> 
                        <td>
                            <label>Studies at:</label>
                        </td>

                        <td>
                            <input type="text" id="education" onkeypress="alphaOnly(event,'3')"  value="<?php echo $education; ?>" name="education">
                        </td>
                        <td>
                            <label class="text_error" id="educationErr"> <?php echo $educationErr; ?> </label>
                        </td>
                    </tr>

                    <tr> 
                        <td>
                            <label>Subject:</label>
                        </td>
                        <td>
                            <input type="text" onkeypress="alphaOnly(event,'4')"  id="subject" value="<?php echo $subject; ?>" name="subject">
                        </td>
                        <td>
                            <label class="text_error" id="subjectErr"> <?php echo $subjectErr; ?> </label>
                        </td>
                    </tr>
                    <tr> 
                        <td>
                            <label>Phone Number:</label>
                        </td>
                        <td>
                            <input type="text" onkeypress="numericOnly(event)"  id="phonenumber" value="<?php echo $phonenumber; ?>" name="phonenumber">
                        </td>
                        <td>
                            <label class="text_error" id="phonenumberErr"> <?php echo $phonenumberErr; ?> </label>
                        </td>
                    </tr>

                    <tr>
                        <td>Profile Picture</td>
                        <td class="logo">
                            <input type="file" accept="image/*" name="propic" enctype="multipart/form-data">
                        </td>
                        <td>
                            <label class="text_error" id="propicErr"> <?php echo $propicErr; ?> </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Cover Photo</td>
                        <td class="logo">
                            <input type="file" accept="image/*" name="coverpic" enctype="multipart/form-data">
                        </td>
                        <td>
                            <label class="text_error" id="coverpicErr"> <?php echo $coverpicErr; ?> </label>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="btn btn_danger" id="update_info_btn">
                            <input type="submit" value="Update" name="update">
                            
                        </td>
                       <tr>
                           <td></td>
                            <td class="btn btn_success" id="update_info_btn">
                                <input type="submit" value="Cancel" name="cancel" action="about.php">
                            </td>
                      </tr>
                    </tr>
                </table>
        </form>
        
        <div class="extra_space">
        </div>

        <div class="extra_space">    
        </div>

    </div>

    <div class="column" id="col-3">
       <?php  include("loadChatList.php"); ?>
    </div>  
    </body>
</html>
