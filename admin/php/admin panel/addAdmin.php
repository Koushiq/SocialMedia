<?php
    session_start();
    $conn=new mysqli("localhost","root","","socialsite");
    $validated=true;
    $passwordErr="";
    $usernameErr="";
    $inputFiledEmptyErr="";
    $validationSuccessMsg="";
    if(!isset($_SESSION['adminUsername']))
    {
        header("location:../securityCode.php");
    }

    if(isset($_POST['signup']))
    {
      if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['retypePassword']))
      {
        $sql="select * from admininfo where username='".$_POST['username']."' ";
        $res=$conn->query($sql);
        if($res->num_rows==0)
        {
            if(htmlspecialchars($_POST['password'])!=htmlspecialchars($_POST['retypePassword']))
            {
                $passwordErr="password mismatch";
                 $validated=false;
            }
        }
        else
        {
             $usernameErr="username exists try another name ";
             $validated=false;
        }
      }
      else
      {
            $inputFiledEmptyErr="Input Fields Can't Be Empty";
            $validated=false;
      }
      if($validated)
      {
        $insertAdminQuery="insert into admininfo (username,password) values('".htmlspecialchars($_POST['username'])."','".htmlspecialchars($_POST['password'])."') ;";
        $conn->query($insertAdminQuery) or die("page killed");
        $validationSuccessMsg="Account Successfully Added";

        $sqlUserdataPermission="insert into userdatapermission values('".htmlspecialchars($_POST['username'])."','false','false','false','false') ;";
        $sqlUserPostPermission="insert into userpostpermission values('".htmlspecialchars($_POST['username'])."','false','false','false','false') ;";
        $sqlUserMessagePermission="insert into usermessagepermission values('".htmlspecialchars($_POST['username'])."','false','false','false','false') ; ";
        $sqlUserPhotoPermission="insert into userphotopermission values('".htmlspecialchars($_POST['username'])."','false','false','false','false') ; ";
        $sqlUserlikePermission="insert into userlikepermission values('".htmlspecialchars($_POST['username'])."','false','false','false','false') ; ";
        $sqlUserCommentPermission="insert into usercommentpermission values ('".htmlspecialchars($_POST['username'])."','false','false','false','false') ; ";
        $conn->query($sqlUserdataPermission) or die("Killed 1 ");
        $conn->query($sqlUserPostPermission) or die("Killed 2 ");
        $conn->query($sqlUserMessagePermission) or die("Killed 3");
        $conn->query($sqlUserPhotoPermission) or die("Killed 4");
        $conn->query($sqlUserlikePermission) or die("Killed 5");
        $conn->query($sqlUserCommentPermission) or die("Killed 6");
        
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
    <link rel="stylesheet" href="../../css/addAdmin.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <script src="fontawesome/js/all.js"></script>
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    
  </head>
  <body>
    <div class="column" id="col-1">
        <?php include("../navigatormenu/sidebarNav.php"); ?>
    </div>
    <div class="column text_angel" id="col-2">
         <form action="" method="post" class="form-input" >
               <div class="add_admin_panel">
                   <h1>Add New Admin</h1>
                   <div class="form_data">
                        <h5>Username</h5>
                        <input type="text" name="username" placeholder="Input unique username" id="username_input"><br>
                        <?php echo '<p class="text_danger">'.$usernameErr.'</p>';?>
                        <h5>Password</h5>
                        <input type="password" name="password" placeholder="Password" id="password_input"><br>

                        <h5>Retype-Password</h5>
                        <input type="password" name="retypePassword" placeholder="Retype-Password" id="retype_password_input"><br>
                        <?php echo '<p class="text_danger">'.$passwordErr.'</p>';?>
                        <?php echo '<p class="text_danger">'.$inputFiledEmptyErr.'</p>';?>
                        <div class="adminBtn btn_signup">
                            <input type="submit" value="Add Admin" name="signup" id="signupBtnId">
                        </div>
                        <?php echo '<p class="text_danger">'.$validationSuccessMsg.'</p>';?>
                    </div>
               </div>
         </form>
    </div>
  </body>
</html>