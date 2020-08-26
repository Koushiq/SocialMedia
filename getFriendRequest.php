<?php
    if(session_status()==PHP_SESSION_NONE)
    {
        session_start();
    }
    if(!isset($_SESSION['username']))
    {
        session_abort();
        hearder("location:login.php");
    }
    $conn=new mysqli("localhost","root","","socialsite");
    $sql="select *, userinfo.firstName,userinfo.lastName from friend inner join userinfo on friend.username=userinfo.username where friend.receivername = '".$_SESSION['username']."' and friend.status='requested' order by friend.friendid desc";
    $result=$conn->query($sql);
    if($result->num_rows>0)
    {
        while($row=$result->fetch_assoc())
        {
           echo '<h5>'.$row['firstName'].' '.$row['lastName'].' sent you a friend request</h5> <a href="viewProfile.php?username='.$row['username'].'" style="margin-left:10px;">Visit Profile</a>';
        }
    }
    else
    {
        echo "<h5>No Friend Request Available </h5>";
    }
?>