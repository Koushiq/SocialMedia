<?php
    session_start();
    $username="";
    $password="";
    $usernameErr="";
    $passwordErr="";
    $validateInfo=true;
    $usernameFound=false;
    $conn = new mysqli("localhost", "root", "", "socialsite");


    if(!isset($_SESSION['proceed']))
    {
        session_destroy();
        header("location:securityCode.php");
    }

    if(isset($_POST['login']))
    {
        if(!empty($_POST['username']))
        {
            $username=htmlspecialchars($_POST['username']);
            if ($conn->connect_error)
            {
                die("Connection failed: Server Down!!!" . $conn->connect_error);
            }
            $sql="select username,password from admininfo where username = '".$username."';";
            $result= $conn->query($sql);
            if($result->num_rows==0)
            {
                $usernameErr="username does not exsist";
                $validateInfo=false;
            }
            else
            {
                $usernameFound=true;
            }
        }
        else
        {
            $usernameErr="Username can't be empty";
            $validateInfo=false;
        }

        if($usernameFound)
        {
            if(!empty($_POST['password']))
            {  
                $password=htmlspecialchars($_POST['password']);
                $row = $result->fetch_assoc();
                if($row['password']!=$_POST['password'])
                {
                    $passwordErr="wrong password !";
                    $validateInfo=false;
                }
            }
            else
            {
                $passwordErr="password can't be empty";
                $validateInfo=false;
            }
        }
        if($validateInfo)
        {
            $_SESSION['adminUsername']=$username;
            header("location:adminDashboard.php");
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <link rel="stylesheet" type="text/css" href="../basicstyling.css">
         <link rel="stylesheet" type="text/css" href="adminLogin.css">
    </head>
    <body>
        <div class="container form-input" id="login_form_admin">
            <form method="post" action="">
                <h2 class="center_align upper_txt">Adminstrator area</h2>

                <div class="credential_input">
                    
                    <label class="med_font">username</label>
                    <br>
                    <input type="text" name="username" placeholder="Enter Admin Username">
                    <br>
                    <label class="sml_font text_error"> <?php echo $usernameErr; ?></label>
                    <br>
                    <label class="med_font">password</label>
                    <br>
                    <input type="password" name="password" placeholder="Enter Admin Password">
                    <br>
                    <label class="sml_font text_error"> <?php echo $passwordErr; ?></label>
                    <div class="btn btn_danger login_btn">
                        <input type="submit" name="login" value="login">
                    </div>
                   
                </div>
                
            </form>
        </div>
    </body>
</html>