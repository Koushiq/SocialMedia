<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    $username=$_SESSION['username'];

    //db connection 
    $conn = new mysqli("localhost", "root", "", "socialsite");
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
            $propic='propic/'.$username.'.jpg';
            $handle = $_FILES["propic"]["tmp_name"];
            copy($handle, $propic);
       }
       else
       {
             $propic=$rowAbout['propic'];
       }
       if(!empty($_FILES['coverpic']['name']))
       {
            $coverpic='coverpic/'.$username.'.jpg';
            $handle = $_FILES["coverpic"]["tmp_name"];
            copy($handle, $coverpic);
       }
       else
       {
            $coverpic=$rowAbout['coverpic'];
       }

       $sqlUserinfoUpdate = "update userinfo set firstname='".$firstName."' ,lastname='".$lastName."'  where username='".$username."' ;";
       $sqlAboutUpdate = "update about set education='".$education."' ,subject='".$subject."' , phonenumber='".$phonenumber."' ,  propic='".$propic."',  coverpic='".$coverpic."' where username='".$username."' ;";
       if($updateValidation==true)
       {
           /* if ($conn->query($sqlUserinfoUpdate); === TRUE)
            {
                echo "<script> alert('account updated');  </script>";
            }
            else 
            {
                die($conn->error);
            }
    
            if ($conn->query($sqlAboutUpdate) === TRUE)
            {
                echo "<script> alert('account updated');  </script>";
            }
            else 
            {
                die( "Something is wrong!" );
            }*/
            $conn->query($sqlUserinfoUpdate);
            $conn->query($sqlAboutUpdate);
            header("location:about.php");
       }
      
    }




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
        <div class="profile_top_div form-input">
            <img src="<?php echo $rowAbout['coverpic']; ?>" class="cover_pic">
            <img src="<?php echo $rowAbout['propic']; ?>" class="pro_pic">
            <h1 class="text_angel big_font" id="user_name"> <b> <?php echo $username;?> </b> </h1>
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
                            <input type="text" value= "<?php echo $firstName; ?>" name="firstName">
                        </td>
                        <td>
                            <label class="text_error"> <?php echo $firstNameErr; ?> </label>
                        </td>
                    </tr>
                 
                    <tr>
                        <td>
                            <label>Last Name :</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $lastName; ?>" name="lastName">
                        </td>
                        <td>
                            <label class="text_error"> <?php echo $lastNameErr; ?> </label>
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
                            <input type="text" value="<?php echo $education; ?>" name="education">
                        </td>
                        <td>
                            <label class="text_error"> <?php echo $educationErr ?> </label>
                        </td>
                    </tr>

                    <tr> 
                        <td>
                            <label>Subject:</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $subject; ?>" name="subject">
                        </td>
                        <td>
                            <label class="text_error"> <?php echo $subjectErr ?> </label>
                        </td>
                    </tr>
                    <tr> 
                        <td>
                            <label>Phone Number:</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $phonenumber; ?>" name="phonenumber">
                        </td>
                        <td>
                            <label class="text_error"> <?php echo $phonenumberErr ?> </label>
                        </td>
                    </tr>

                    <tr>
                        <td>Profile Picture</td>
                        <td class="logo">
                            <input type="file" accept="image/*" name="propic" enctype="multipart/form-data">
                        </td>
                    </tr>
                    <tr>
                        <td>Cover Photo</td>
                        <td class="logo">
                            <input type="file" accept="image/*" name="coverpic" enctype="multipart/form-data">
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



<!--<ul class="user_info_list form-input ">
                   
                </ul>-->