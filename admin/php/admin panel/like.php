<?php
    session_start();
    $conn=new mysqli("localhost","root","","socialsite");
    if(!isset($_SESSION['adminUsername']))
    {
        header("location:../securityCode.php");
    }
    $sql = "select * from postlike"; 
    $res=$conn->query($sql);

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
        function loadLike()
        {
            var key=document.getElementById("search").value;
            var xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("ajax_load_data").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "ajaxMethods.php?likedUsername="+key, true);
            xhttp.send();
        }
        function deleteLike(id)
        {
            var xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("ajax_load_data").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "ajaxMethods.php?likeId="+id, true);
            xhttp.send();
        }
        
    </script>
    <div class="column" id="col-1">
        <?php include("../navigatormenu/sidebarNav.php"); ?>
    </div>
    <div class="column text_angel" id="col-2">
    <div class="table_wrapper">
                <h5><a style="color:white;" href="systemData.php">Back</a></h5>
                <header><h1>Likes Table</h1></header>
                <div class="search form-input">
                    <header class="text_danger" ><h4 style="font-weight:bold;">Search by username</h4></header>
                    <input type="search" name="search" id="search" onkeyup="loadLike()" autocomplete="off">
                </div>
        <div id="ajax_load_data">
            <table>
                <tr>
                    <th style="width:10%;"> ID </th>
                    <th>POST ID</th>
                    <th>Liked By</th>
                </tr>
                <?php
                    if($res->num_rows>0)
                    {
                        while($row=$res->fetch_assoc())
                        {
                            echo '
                                <tr>
                                    <td>'.$row['id'].'
                                    <div class="update_cancel_btn_container">
                                        <a href="updateUsers.php?likeId='.$row['id'].' "><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                                        <input type="button" value="Delete" onclick="deleteLike(\''.$row['id'].'\')"" style="color:white; padding:8px; background-color:rgb(223,40,35);">
                                    </div>
                                    </td>
                                    <td>'.$row['postId'].'</td>
                                    <td> '.$row['likedBy'].'</td>
                                </tr>
                            ';
                        }
                        
                    }
                ?>
            </table>
            </div>
        </div>
    </div>
</body>
</html>
