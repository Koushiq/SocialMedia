<?php
    session_start();
    $username="";
    $firstName="";
    $lastName="";
    $password="";
    $dateOfBirth="";
    $securityQuestion="";
    $gender="";
    $validateInfo=true;
    $usernameErr="";
    $firstNameErr="";
    $lastNameErr="";
    $passwordErr="";
    $dateOfBirthErr="";
    $securityQuestionErr="";
    $genderErr="";

    if(isset(($_POST['submit'])))
    {
        if(!empty($_POST["username"]))
        {
            
            $username=htmlspecialchars($_POST["username"]);
            
        }
        else
        {
            $usernameErr="username required!";
            $validateInfo=false;
        }

        if(!empty($_POST["firstName"]))
        {
            $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
                if(!preg_match('#[0-9]#',$_POST['firstName'])   && !preg_match($pattern, $_POST['firstName']))
                {
                    $firstName=htmlspecialchars($_POST['firstName']);
                }
                else
                {
                    $firstNameErr="numbers and special chars not allowed";
                    $validateInfo=false;
                }
           
        }
        else
        {
            $firstNameErr="Firstname required!";
            $validateInfo=false;
        }

        if(!empty($_POST["lastName"]))
        {
                $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
                if(!preg_match('#[0-9]#',$_POST['lastName'])   && !preg_match($pattern, $_POST['lastName']))
                {
                    $lastName=htmlspecialchars($_POST['lastName']);
                }
                else
                {
                    $lastNameErr="numbers and special chars not allowed";
                    $validateInfo=false;
                }
            
        }
        else
        {
            $lastNameErr="Lastname required!";
            $validateInfo=false;
        }

        if(!empty($_POST["password"]))
        {
            if($_POST['password']==$_POST['retypePassword'])
            {
                $password=htmlspecialchars($_POST["password"]);
            }
            else
            {
                $passwordErr="password Mismatch!";
                $validateInfo=false;
            }
           
        }
        else
        {
            $passwordErr="password required!";
            $validateInfo=false;
        }

        if(!empty($_POST['securityQuestion']))
        {
            $securityQuestion=htmlspecialchars($_POST["securityQuestion"]);
        }
        else
        {
            $securityQuestionErr="Sequirty Question Must Be set";
            $validateInfo=false;
        }

        if(!empty($_POST['dateOfBirth']))
        {
            $dateOfBirth=htmlspecialchars($_POST['dateOfBirth']);
        }
        else
        {
            $dateOfBirthErr="Enter Valid date!";
        }

        if(!empty($_POST['gender']))
        {
            $gender=htmlspecialchars($_POST["gender"]);
        }
        else
        {
            $genderErr="Gender not set!";
            $validateInfo=false;
        }
        if($validateInfo)
        {
            $conn = new mysqli("localhost", "root", "", "socialsite");
           
            if ($conn->connect_error)
            {
                die("Connection failed: Server Down!!!" . $conn->connect_error);
            }

            $sql="select username from userinfo where username = '".$username."';";

            $result= $conn->query($sql);
            if($result->num_rows>0)
            {
                $usernameErr="name exists try another name !";
                $validateInfo=false;
            }
            else
            {
                $sql = "insert into userinfo (username,firstname, lastname, password ,dateOfBirth,securityQuestion,gender) values ( '".$username."' , '".$firstName."', '".$lastName."' , '".$password."' , '".$dateOfBirth."' ,'".$securityQuestion."','".$gender."' )"; 
                $sql2 = "insert into about (username,education,subject,phonenumber,propic,coverpic) values ('".$username."', 'N/A','N/A','N/A','blankImage/propic.jpg','blankImage/coverpic.jpg')";
                if ($conn->query($sql) === TRUE)
                {
                    echo "<script> alert('account created');  </script>";
                }
                else 
                {
                    die( "Something is wrong!" );
                }
                if($conn->query($sql2) === TRUE)
                {
                    echo "<script> alert('extra details created');  </script>";
                }
                else 
                {
                    echo $sql2;
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    die("Something is wrong!");
                }
                $conn->close();
                header("location:signup.php");
            }

        }
        
    }
?>


<!DOCTYPE html>
<html>
    <head>
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <link rel="stylesheet" type="text/css" href="basicstyling.css">
         <link rel="stylesheet" type="text/css" href="signup.css">
         <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
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
                if (!(key == 32) && !(key > 47 && key < 58) && !(key > 64 && key < 91) && !(key > 96 && key < 123))
                {
                    document.getElementById("securityQuestionErr").innerHTML="Only Alphabets and Numbers Allowed";
                    document.getElementById("securityQuestion").value="";
                }
                else
                {
                    document.getElementById("securityQuestionErr").innerHTML="";
                }
            }
            console.log(key);
           
       }

       function validatePass(event)
       {
           var key= event.keyCode;
           var pass1=document.getElementById("password").value;
           var pass2=document.getElementById("retypePassword").value;
           var errPass=document.getElementById("retypePasswordErr");
           if(pass1!=pass2)
           {
                errPass.innerHTML="Mismatch";
           }
           else
           {
                errPass.innerHTML="";
           }
       }
        
    </script>
        
        <div class="row">
            <div class="column" id="col-1">
                <div class="container" id="createaccountText">
                    <h1 class="big_font" id="signuptxt">Sign up</h1>
                        <p class="med_font" id="aboutustxt">
                            This site is much more fun to use when 
                            you have an account. 
                            Sign up to join your friends now !
                        </p>
                </div>
            </div>
                
            <div class="column" id="col-2">
                
                <div class="sign_up_form">
                    <form method="post" action="#">

                        <div class="form-input">
                            <h1 class="font_bold">Create an account</h2>
                            <h5 style="padding-left: 80px;">It's Quick and easy.</h5>
                        </div>

                        <div class="form-input">
                            <label>Enter Username</label>
                            <br>
                            <input type="text" name="username" placeholder="Username">
                            
                            <label class="text_error" id="usernameErr"> <?php echo $usernameErr; ?> </label>
                        </div>

                        <div class="form-input">
                            <label>First Name</label>
                            <br>
                            <input type="text" onkeypress="alphaOnly(event,'1')" name="firstName" placeholder="First Name" id="firstName">
                            <label class="text_error"  id="firstNameErr"><?php echo $firstNameErr; ?></label>
                            <br>
                            <label>Last Name</label>
                            <br> 
                            <input type="text" name="lastName" onkeypress="alphaOnly(event,'2')" placeholder="Last Name">
                            <label class="text_error" id="lastNameErr"><?php echo $lastNameErr; ?></label>
                            
                        </div>

                        <div class="form-input">
                            <label>Enter Password</label>
                            <br>
                            <input type="password" name="password" id="password" placeholder="Password">
                            
                            <label class="text_error" id="passwordErr"><?php echo $passwordErr; ?></label>
                        </div>

                        <div class="form-input">
                            <label>Re-type Password</label>
                            <br>
                            <input type="password" onkeyup="validatePass(event)" name="retypePassword" id="retypePassword" placeholder="Password">
                            
                            <label class="text_error" id="retypePasswordErr"><?php echo $passwordErr; ?></label>
                        </div>
                        
                        <div class="form-input">
                            <label>Select Date Of Birth</label>
                            <br>
                            <input type="date" name="dateOfBirth" value="YYYY-MM-DD">
                            <label class="text_error" id="dateOfBirthErr"><?php echo $dateOfBirthErr; ?></label>


                        </div>

                        <div class="form-input">
                            <label>Security Question</label>
                            <br>
                            <input type="text" onkeypress="alphaOnly(event,'3')" id="securityQuestion" name="securityQuestion" placeholder="Enter the name of your favorite movie ? ">
                            <label class="text_error" id="securityQuestionErr"><?php echo $securityQuestionErr; ?></label>
                        </div>



                        <div class="form-input">
                            <label>Select Gender</label>
                            <br>
                            <input type="radio" name="gender" value="male">
                            <label>Male</label>
                            <input type="radio" name="gender" value="female">
                            <label>Female</label>
                            
                            <label class="text_error">
                                <?php echo $genderErr; ?>
                            </label>
                        </div>

                        <div class="btn btn_success" id="signUpBtn">
                            <input type="submit" value="Sign Up" name="submit">
                            <span>or</span>
                            <a href="login.php" class="text_error">Log In</a>
                        </div>

                    </form>
                </div>
            </div>
            
        </div>
    </body>
</html>