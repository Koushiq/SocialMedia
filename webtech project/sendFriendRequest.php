<?php
    if(session_status()==PHP_SESSION_NONE)
    {
        session_start();
    }
    if(!isset($_SESSION['username']))
    {
        header("location:login.php");
    }
    $conn = new mysqli("localhost","root","","socialsite");
    $status=trim(htmlspecialchars($_GET['status']));
    $receiver=trim(htmlspecialchars($_GET['username']));
    
    $usernameSql="select userinfo.username,userinfo.firstName,userinfo.lastName, about.propic from userinfo inner join about on userinfo.username=about.username where userinfo.username='".$_SESSION['username']."'";
    echo $usernameSql;
    $resultUsername=$conn->query($usernameSql);
    $rowUsername=$resultUsername->fetch_assoc();

    $receivernameSql="select userinfo.username,userinfo.firstName,userinfo.lastName, about.propic from userinfo inner join about on userinfo.username=about.username where userinfo.username='".$receiver."';";
    echo $receivernameSql;
    $resultReceivername=$conn->query($receivernameSql);
    $rowReceivername=$resultReceivername->fetch_assoc();

    $flag=false;
    if($status=="requested")
    {
        $sql="insert into friend (username,receivername,usernameFirstName,usernameLastName,receivernameFirstName,receivernameLastName,usernamePropic,receivernamePropic,status) values('".$_SESSION['username']."','".$receiver."','".$rowUsername['firstName']."','".$rowUsername['lastName']."','".$rowReceivername['firstName']."','".$rowReceivername['lastName']."', '".$rowUsername['propic']."','".$rowReceivername['propic']."','requested')";
        echo 'hre';
    }
    else if($status=="unfriended" || $status=="cancelled")
    {
        $sql=" delete from friend WHERE (username='".$_SESSION['username']."' and receivername='".$receiver."') or (receivername='".$_SESSION['username']."' and username='".$receiver."') ";
    }
    else if($status=="accepted")
    {
        $sql="update friend set status='accepted' where (username='".$_SESSION['username']."' and receivername='".$receiver."') or (receivername='".$_SESSION['username']."' and username='".$receiver."') ";
    }
    else if($status=="blocked")
    {
        $sql="update friend set status='blocked' where (username='".$_SESSION['username']."' and receivername='".$receiver."') or (receivername='".$_SESSION['username']."' and username='".$receiver."') ";
    }
    else
    {
        die("Invalid Request");
        echo "here3";
        $flag=true;
    }
    if($flag==false)
    {
        $conn->query($sql) or die($sql);
    }
?>