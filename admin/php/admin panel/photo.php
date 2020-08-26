<?php
    session_start();
    $conn=new mysqli("localhost","root","","socialsite");
    if(!isset($_SESSION['adminUsername']))
    {
        header("location:../securityCode.php");
    }
    $sql = "select * from photos"; 
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
        function  loadPhotosTable()
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
            xhttp.open("GET", "ajaxMethods.php?photosUsername="+key, true);
            xhttp.send();
        }
        /* function deletePhoto(photoId)
        {
            console.log(photoId);
            var xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange = function()
            {
                if (this.readyState == 4 && this.status == 200)
                {
                    document.getElementById("ajax_load_data").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "ajaxMethods.php?deletePhotoId="+photoId, true);
            xhttp.send();
        } */
    </script>
    <div class="column" id="col-1">
        <?php include("../navigatormenu/sidebarNav.php"); ?>
    </div>
    <div class="column text_angel" id="col-2">
    <div class="table_wrapper">
                <h5><a style="color:white;" href="systemData.php">Back</a></h5>
                <header><h1>Photo Table</h1></header>
                <div class="search form-input">
                    <header class="text_danger" ><h4 style="font-weight:bold;">Search by username</h4></header>
                    <input type="search" name="search" id="search" onkeyup="loadPhotosTable()" autocomplete="off">
                </div>
        <div id="ajax_load_data">
            <table>
                <tr>
                    <th style="width:10%;">Photo ID </th>
                    <th  style="width:10%;">Username</th>
                    <th>Path</th>
                    <th>Type</th> 
                </tr>
                <?php
                    if($res->num_rows>0)
                    {
                        while($row=$res->fetch_assoc())
                        {
                            echo '
                                <tr>
                                    <td>'.$row['photoId'].'
                                    <form action="" method="post">
                                        <div class="update_cancel_btn_container">
                                            <a href="updateUsers.php?loadPhoto=true&photoId='.$row['photoId'].' "><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>
                                        </div>
                                    </form>
                                    </td>
                                    <td> '.$row['username'].'</td>
                                    <td> <a href="../../../'.$row['path'].'" ><img src="../../../'.$row['path'].'" alt="" srcset="" style="object-fit:contain; width:100px;"> </a></td>
                                    <td>'.$row['type'].'</td>
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
