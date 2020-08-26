<?php
    session_start();
    $username="";
    $password="";
    $usernameErr="";
    $passwordErr="";
    $validateInfo=true;
    $usernameFound=false;
    $conn = new mysqli("localhost", "root", "", "socialsite");
    
    
    if(isset($_POST['login']))
    {
        if(!empty($_POST['username']))
        {
            $username=htmlspecialchars($_POST['username']);
            if ($conn->connect_error)
            {
                die("Connection failed: Server Down!!!" . $conn->connect_error);
            }
            $sql="select username,password from userinfo where username = '".$username."';";
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
            $_SESSION['username']=$username;
            header("location:homepage.php");
        }
    }
  


?>



<!DOCTYPE html>
<html>
    <head>
         <link rel="stylesheet" type="text/css" href="basicstyling.css">
         <link rel="stylesheet" type="text/css" href="login.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
       
    </head>

    <body>
          <div class="login_box">
            <form method="post" action="" class="form_box">
                <div class="form-input">
                    <label>Enter Username</label>
                    <input type="text" name="username" placeholder="Username">
                    <label class="text_error"> <?php echo $usernameErr; ?>  </label>
                </div>
                    
                <div class="form-input">
                    <label>Enter Password</label>
                    <input type="password" name="password" placeholder="Password">
                    <label class="text_error"> <?php echo $passwordErr; ?>  </label>
                </div>
                    
                <div class="btn btn_danger center_align">
                    <input type="submit" value="Login" name="login">
                </div>
               <!--  <div class="center_align">
                   <p> <a class="text_danger" href="#">Forgot Password? </a></p>
                </div>
 -->
                <div class="center_align">
                    <p>Don't have an account ?</p>
                         <p><a class="text_success" href="signup.php">Sign up Here </a>
                    </p>
                </div>
            </form>
          </div>
    </body>
</html>