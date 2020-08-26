<?php
    session_start();
    $conn=new mysqli("localhost","root","","socialsite");
    if(!isset($_SESSION['adminUsername']))
    {
        header("location:../securityCode.php");
    }
    $sql = "select * from message"; 
    $res=$conn->query($sql);
    if(isset($_GET['warning']))
    {
        if(trim(htmlspecialchars($_GET['warning']))==true )
        {
            echo '<script>alert("Invalid Id")</script>';
        }
        else if(trim(htmlspecialchars($_GET['warning']))=="notChosen")
        {
            echo '<script>alert("Must Contain Id")</script>';
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../basicstyling.css">
    <link rel="stylesheet" href="../../css/adminTemplate.css">
    <link rel="stylesheet" href="../../css/adminDashboard.css">
    <link rel="stylesheet" href="../../css/adminData.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <script src="fontawesome/js/all.js"></script>
</head>
<body>
    <script>
       /*  function loadTable()
        {
            var key=document.getElementById("search").value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("ajax_data_load").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "ajaxMethods.php?postUsername="+key, true);
            xhttp.send();
        }
         */
        function deleteMessageId(id)
        {
            var xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("ajax_data_load").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "ajaxMethods.php?deleteMessageId="+id, true);
            xhttp.send();
        }
    </script>
    <div class="column" id="col-1">
        <?php include("../navigatormenu/sidebarNav.php"); ?>
    </div>
    <div class="column text_angel" id="col-2">

    <div class="table_wrapper">

        <h5><a style="color:white;" href="systemData.php">Back</a></h5>

        <header><h1>User Messages Table</h1></header>

        <div class="search form-input">
            <!-- <header class="text_danger" ><h4 style="font-weight:bold;">Search by username</h4></header> -->
            <input type="search" name="search" id="search" onkeyup="loadTable()" autocomplete="off">
        </div>

        <div id="ajax_data_load">
            <table>
                <tr>
                    <th style="width:10%;">Message Id</th>
                    <th>Content</th>
                    <th>Message Type</th>
                    <th>Sender Username</th>
                    <th>Receiver Username</th>
                    <th>Send Time</th>
                </tr>
                <?php
                    if($res->num_rows>0)
                    {
                        while($row=$res->fetch_assoc())
                        { 
                            if($row['messageType']=="text"){
                            echo'
                            <tr>
                                <td>'.$row['messageId'].'
                                <form action="" method="post">
                                    <div class="update_cancel_btn_container">
                                        <a href="updateUsers.php?messageId='.$row['messageId'].'&loadMessage=true"><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                                        <input type="button" onclick="deleteMessageId(\''.$row['messageId'].'\')" value="Delete" style="color:white; padding:8px; background-color:rgb(166, 18, 18);">
                                    </div>
                                </form>
                                </td>
                                <td>'.$row['content'].'</td>
                                <td>'.$row['messageType'].'</td>
                                <td>'.$row['senderUsername'].'</td>
                                <td>'.$row['receiverUsername'].'</td>
                                <td>'.$row['sendTime'].'</td>
                            </tr>';
                            }
                            else if($row['messageType']=="path")
                            {
                                echo'
                                    <tr>
                                        <td>'.$row['messageId'].'
                                        <form action="" method="post">
                                            <div class="update_cancel_btn_container">
                                                <a href="updateUsers.php?messageId='.$row['messageId'].'&loadMessage=true"><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                                                <input type="button" onclick="deleteMessageId(\''.$row['messageId'].'\')" value="Delete" style="color:white; padding:8px; background-color:rgb(166, 18, 18);">
                                            </div>
                                        </form>
                                        </td>
                                        <td><a href="../../../'.$row['content'].'" ><img src="../../../'.$row['content'].'" alt="" srcset="" style="object-fit:contain; width:100px;"> </a></td>
                                        <td>'.$row['messageType'].'</td>
                                        <td>'.$row['senderUsername'].'</td>
                                        <td>'.$row['receiverUsername'].'</td>
                                        <td>'.$row['sendTime'].'</td>
                                    </tr>';
                            }
                        }
                    } 
                ?>
            </table>
        </div>

    </div>
</body>
</html>