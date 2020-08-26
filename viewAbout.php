<?php
     $conn = new mysqli("localhost", "root", "", "socialsite");
     session_start();
     if(!isset($_SESSION['username']))
     {
         session_destroy();
         header("location:login.php");
     }

     if(isset($_GET['username']))
     {
        $viewUsername=trim(htmlspecialchars($_GET['username']));
        $username=$viewUsername;
     }

     else
     {
        die('<script>history.go(-1)</script>');
     }
    

    $sqlUserinfo = "select * from userinfo where username = '".$viewUsername."'";
    $sqlAbout = "select * from about where username = '".$viewUsername."'";
    $resultUserinfo= $conn->query($sqlUserinfo);
    $rowUserinfo=$resultUserinfo->fetch_assoc();
    $resultAbout= $conn->query($sqlAbout);
    $rowAbout=$resultAbout->fetch_assoc();
    $profileFound=true;

    $firstName=$rowUserinfo['firstName'];
    $lastName=$rowUserinfo['lastName'];
    $education=$rowAbout['education'];
    $subject=$rowAbout['subject'];
    $phonenumber=$rowAbout['phonenumber'];



    if($resultAbout->num_rows==0)
    {
        $profileFound=false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="basicstyling.css">
    <link rel="stylesheet" type="text/css" href="homepage.css"> 
    <link rel="stylesheet" type="text/css" href="profile.css">
    <link rel="stylesheet" type="text/css" href="about.css">
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
                             <h1 class="text_angel big_font" id="user_name"> <b>  '.$firstName." ".$lastName.' </b> </h1>
                           </div>';
                    include("loadViewProfileBtns.php");
                    include("addBlockBtn.php");
                }
           ?>
        <div class="user_info_tab">
            <h3><?php echo $firstName." ".$lastName; ?>'s profile Info</h3>
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
                            <input type="text" value= "<?php echo $firstName; ?>" name="firstName" readonly>
                        </td>
                    </tr>
                 
                    <tr>
                        <td>
                            <label>Last Name :</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $lastName; ?>" name="lastName" readonly>
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
                            <input type="text" value="<?php echo $education; ?>" name="education" readonly>
                        </td>
                    </tr>

                    <tr> 
                        <td>
                            <label>Subject:</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $subject; ?>" name="subject" readonly>
                        </td>
                    </tr>
                    <tr> 
                        <td>
                            <label>Phone Number:</label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo $phonenumber; ?>" name="phonenumber" readonly>
                        </td>
                    </tr>
                </table>
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