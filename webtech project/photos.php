<?php
    session_start();
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    $conn = new mysqli("localhost", "root", "", "socialsite");
    $username=$_SESSION['username'];
    $sqlUserinfo = "select * from userinfo where username = '".$username."'";
    $sqlAbout = "select * from about where username = '".$username."'";
    $resultUserinfo= $conn->query($sqlUserinfo);
    $rowUserinfo=$resultUserinfo->fetch_assoc();
    $resultAbout= $conn->query($sqlAbout);
    $rowAbout=$resultAbout->fetch_assoc();
    $sqlPhotos="select * from photos where username='".$username."'";
    $resultPhotos=$conn->query($sqlPhotos);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="basicstyling.css">
    <link rel="stylesheet" type="text/css" href="homepage.css"> 
    <link rel="stylesheet" type="text/css" href="profile.css">
    <link rel="stylesheet" type="text/css" href="about.css">
    <link rel="stylesheet" type="text/css" href="photos.css">
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Photo</title>
</head>
<body>
    <?php
        include("headerfile.php"); 
    ?>

    <div class="column center_align" id="col-1">
    </div>
    <div class="column" id="col-2">
        <div class="profile_top_div">
            <img src="<?php echo $rowAbout['coverpic']; ?>" class="cover_pic">
            <img src="<?php echo $rowAbout['propic']; ?>" class="pro_pic">
            <h1 class="text_angel big_font" id="user_name"> <b> <?php echo $username ?> </b> </h1>
            
        </div>
        <?php
                include("loadProfileBtns.php");
        ?>

        <div class="photo_album_pnl flex_container">
           <?php
                while($rowPhotos=$resultPhotos->fetch_assoc())
                {
                    
                    echo '<div class="photo_size"> <img src="'.$rowPhotos['path'].'"> </div>';
                }
           ?>
        </div>

        <div class="extra_space">
            
        </div>
        <div class="extra_space">
                
        </div>
    </div>
    <div class="column" id="col-3">
       <?php  include("loadChatList.php"); ?>
    </div>  

    <div>
    

</body>
</html>
