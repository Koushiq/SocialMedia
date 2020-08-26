<?php
    session_start();
    $conn=new mysqli("localhost","root","","socialsite");
    if(!isset($_SESSION['adminUsername']))
    {
        header("location:../securityCode.php");
    }
    $sql = "select * from post"; 
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
        function loadTable()
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
        function deletePost(id)
        {
            var xhttp=new XMLHttpRequest();
            xhttp.open("GET", "ajaxMethods.php?deletePostId="+id, true);
            xhttp.send();
            window.location.replace("post.php");
        }
    </script>
    <div class="column" id="col-1">
        <?php include("../navigatormenu/sidebarNav.php"); ?>
    </div>
    <div class="column text_angel" id="col-2">

    <div class="table_wrapper">

        <h5><a style="color:white;" href="systemData.php">Back</a></h5>

        <header><h1>User Posts Table</h1></header>

        <div class="search form-input">
            <header class="text_danger" ><h4 style="font-weight:bold;">Search by username</h4></header>
            <input type="search" name="search" id="search" onkeyup="loadTable()" autocomplete="off">
        </div>

        <div id="ajax_data_load">
            <table>
                <tr>
                    <th style="width:10%;">Post ID</th>
                    <th>Username</th>
                    <th>Content</th>
                    <th>Picture</th>
                </tr>
                <?php
                    if($res->num_rows>0)
                    {
                        while($row=$res->fetch_assoc())
                        { 
                            echo'
                            <tr>
                                <td>'.$row['postid'].'
                                <form action="" method="post">
                                    <div class="update_cancel_btn_container">
                                        <a href="updateUsers.php?postid='.$row['postid'].'&loadPost=true"><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                                        <input type="button" onclick="deletePost(\''.$row['postid'].'\')" value="Delete" style="color:white; padding:8px; background-color:rgb(166, 18, 18);">
                                    </div>
                                </form>
                                </td>
                                <td>'.$row['username'].'</td>
                                <td>'.$row['content'].'</td>
                                <td> <a href="../../../'.$row['picture'].'" ><img src="../../../'.$row['picture'].'" alt="" srcset="" style="object-fit:contain; width:100px;"> </a></td>
                            </tr>';
                        }
                    } 
                ?>
            </table>
        </div>

    </div>
</body>
</html>