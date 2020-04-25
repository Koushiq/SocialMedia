<?php

    $securityCodeErr="";
    if(isset($_POST['submit']))
    {
        if(!empty($_POST['securityCode']))
        {
           if($_POST['securityCode']=="abc123")
           {
                session_start();
                $_SESSION['proceed']="true";
                header("location:adminLogin.php");
           }
           else
           {
                $securityCodeErr="Wrong Code Try again!";
           }
        }
        else
        {
            $securityCodeErr="Can't be empty!";
        }
    }



?>


<!DOCTYPE html>
<html>
    <head>
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <link rel="stylesheet" type="text/css" href="../basicstyling.css">
         <link rel="stylesheet" type="text/css" href="securityCode.css">
    </head>
    <body>
       <div class="security_code_tab form-input center_align">
           <form method="post" action="" style="margin-top:150px;" autocomplete="off">

                <div class="security_code_input">
                    <input type="password" name="securityCode" placeholder="Enter Security Code to Proceed ">
                </div>
                <div class="btn btn_danger">
                    <input type="submit" name="submit" value="Submit Code">
                </div>
                <br>
                <label class="text_danger"> <?php echo $securityCodeErr; ?></label>

           </form>
       </div>
    </body>
</html>