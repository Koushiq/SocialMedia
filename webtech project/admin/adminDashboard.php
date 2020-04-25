<?php
     session_start();
      if(!isset($_SESSION['adminUsername']))
      {
          session_destroy();
          header("location:securityCode.php");
      }
      $adminUsername=$_SESSION['adminUsername'];
?>


<!DOCTYPE html>
<html>
    <head>
         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <link rel="stylesheet" type="text/css" href="../basicstyling.css">
         <link rel="stylesheet" type="text/css" href="adminDashboard.css">
    </head>
    <body>
          <div class="side_bar_nav column" id="col-1">
               <ul>
                    <li> <a href="adminDashboard.php" class="text_angel">Home</a>  </li>
                    <li> <a href="#" class="text_angel">Add Admin</a>  </li>
                    <li> <a href="usersData.php" class="text_angel">Users Data</a>  </li>
               </ul>
         </div>
         <div class="welcome_text column" id="col-2">
               <h2 class="text_dark center_align">Welcome User  <?php echo $adminUsername ;?>  </h2>
         </div>
         
    </body>
</html>