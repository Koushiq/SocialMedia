<?php
    session_start();
    $conn=new mysqli("localhost","root","","socialsite");
    if(!isset($_SESSION['adminUsername']))
    {
        header("location:../securityCode.php");
    }
    $sqlTotalUser="select * from userinfo";
    $resTotalUser=$conn->query($sqlTotalUser);
    
    $sqlTotalPost="select * from post";
    $resTotalPost=$conn->query($sqlTotalPost);

    $sqlTotalMessage="select * from message";
    $resTotalMessage=$conn->query($sqlTotalMessage);

    $sqlTotalComment="select * from postcomment";
    $resTotalComment=$conn->query($sqlTotalComment);

    $sqlMostPost="select username, count(*) from post group by username order by count(*) desc limit 1 ;";
    $resMostPost=$conn->query($sqlMostPost);
    $rowMostPost=$resMostPost->fetch_assoc();

    $sqlMostSentMessage="select senderUsername ,count(*) from message group by senderUsername order by count(*) desc limit 1 ";
    $resMostSentMessage=$conn->query($sqlMostSentMessage);
    $rowMostSentMessage=$resMostSentMessage->fetch_assoc();

    $sqlMostLike="select likedBy ,count(*) from postlike group by likedBy order by count(*) desc limit 1 ";
    $resMostLike=$conn->query($sqlMostLike);
    $rowMostLike=$resMostLike->fetch_assoc();

    $sqlMostComment="select commentBy,count(*) from postcomment group by commentby order by count(*) desc limit 1 ";
    $resMostComment=$conn->query($sqlMostComment);
    $rowMostComment=$resMostComment->fetch_assoc();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../basicstyling.css">
    <link rel="stylesheet" href="../../css/adminTemplate.css">
    <link rel="stylesheet" href="../../css/adminDashboard.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <script src="fontawesome/js/all.js"></script>
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    
  </head>
  <body>
    <div class="column" id="col-1">
        <?php include("../navigatormenu/sidebarNav.php"); ?>
    </div>
    <div class="column" id="col-2">
        <div id="display_username" class="text_angel">
            <h1>Welcome <?php echo $_SESSION['adminUsername']; ?></h1>
        </div>
        <div class="stat_container text_angel">
             <div class="section-1"> 
                 <h2>Total Users</h2>
                 <h2><?php echo $resTotalUser->num_rows; ?></h2>
             </div>
             <div class="vl-1">
             </div>
             <div class="section-2"> 
                 <h2>Total Posts</h2>
                 <h2><?php echo $resTotalPost->num_rows; ?></h2>
             </div>
             <div class="vl-2">
            </div>
            <div class="section-3"> 
                 <h2>Total Messages</h2>
                 <h2><?php echo $resTotalMessage->num_rows; ?></h2>
             </div>
             <div class="vl-3">
            </div>
            <div class="section-4"> 
                 <h2>Total Comments</h2>
                 <h2><?php echo $resTotalComment->num_rows; ?></h2>
             </div>
        </div>

        <div class="panel text_angel">
          <div class="section-1 push_down"> 
            <h1>Most Status By <?php echo $rowMostPost['username'];?></h1> 
            <h2>Total Status : <?php echo $rowMostPost['count(*)'];?></h2>
          </div>
          <div class="section-2 push_down"> 
            <h1>Most Message Sent By <?php echo $rowMostSentMessage['senderUsername']; ?> </h1> 
            <h2>Total Sent Message : <?php echo $rowMostSentMessage['count(*)'] ?> </h2>
          </div>
          <div class="section-3 push_down"> 
            <h1>Most Likes By <?php echo $rowMostLike['likedBy']; ?> </h1> 
            <h2>Total likes : <?php echo $rowMostLike['count(*)']; ?> </h2>
          </div>
          <div class="section-4 push_down"> 
            <h1>Most Commentes By <?php echo $rowMostComment['commentBy']; ?></h1> 
            <h2>Total Comments : <?php echo $rowMostComment['count(*)']; ?>  </h2>
          </div>
        </div>
    </div>
  </body>
</html>