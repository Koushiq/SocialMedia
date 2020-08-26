<?php
    session_start();
    $conn=new mysqli("localhost","root","","socialsite");
    if(!isset($_SESSION['adminUsername']))
    {
        header("location:../securityCode.php");
    }
    $sql = "select * from userinfo inner join about on userinfo.username=about.username"; 
    $res=$conn->query($sql);

    $sqlCheck="select * from userdatapermission where username='".$_SESSION['adminUsername']."' ;";
    $resCheck=$conn->query($sqlCheck);
    $rowCheck=$resCheck->fetch_assoc();

    if($rowCheck['r']=="false")
    {
        echo'<script>alert("You do not have permission to read");
        window.location.href="systemData.php";
        </script>';
    }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../../basicstyling.css">
    <link rel="stylesheet" href="../../css/adminTemplate.css">
    <link rel="stylesheet" href="../../css/adminDashboard.css">
    <link rel="stylesheet" href="../../css/adminData.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <script src="fontawesome/js/all.js"></script>
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    
  </head>
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
        xhttp.open("GET", "ajaxMethods.php?key="+key, true);
        xhttp.send();
    }
    function deleteUser(username)
    {
        var xhttp=new XMLHttpRequest();
        xhttp.open("GET", "ajaxMethods.php?key="+username+"&deleteFlag=1", true);
        xhttp.send();
        window.location.replace("userData.php");
    }
</script>

  <body>
    <div class="column" id="col-1">
        <?php include("../navigatormenu/sidebarNav.php"); ?>
    </div>
    <div class="column" id="col-2">

        <div class="column" style="color:rgb(224, 220, 220);" id="col-2">
            <div class="table_wrapper">
                <h5><a style="color:white;" href="systemData.php">Back</a></h5>
                <header><h1>User Data Table</h1></header>
                <div class="search form-input">
                    <header class="text_danger" ><h4 style="font-weight:bold;">Search by username</h4></header>
                    <input type="search" name="search" id="search" onkeyup="loadTable()" autocomplete="off">
                </div>
                <div id="ajax_data_load">
                <table>
                <tr>
                    <th style="width:10%;">Username</th>
                    <th>User First Name</th>
                    <th>User Last Name</th>
                    <th>User Date Of Birth</th>
                    <th>User Sequrity Question Ans</th>
                    <th>User Gender</th>
                    <th>User Education</th>
                    <th>User Subject</th>
                    <th>User Phonenumber</th>
                    <th>User Profile Picture Path</th>
                    <th>User Cover Picture Path</th>
                </tr>
                
                <?php
                    if($res->num_rows>0)
                    {
                        while($row=$res->fetch_assoc())
                        {
                            echo '
                                <tr>
                                    <td>'.$row['username'].'
                                    <form action="" method="post">
                                        <div class="update_cancel_btn_container">';
                                            if($rowCheck['u']=="true")
                                            {
                                                echo '<a href="getInfoUpdatePanel.php?key='.$row['username'].' "><input type="button" value="Update" style="color:white; padding:8px; background-color:green;"></a>';
                                            }
                                            if($rowCheck['d']=="true")
                                            {
                                                echo '<input type="button" onclick="deleteUser(\''.$row['username'].'\')" value="Delete" style="color:white; padding:8px; margin-left:5px; background-color:rgb(166, 18, 18);">';
                                            }
                                        echo '</div>
                                    </form>
                                    </td>
                                    <td>'.$row['firstName'].'</td>
                                    <td>'.$row['lastName'].'</td>
                                    <td>'.$row['dateOfBirth'].'</td>
                                    <td>'.$row['securityQuestion'].'</td>
                                    <td>'.$row['gender'].'</td>
                                    <td>'.$row['education'].'</td>
                                    <td>'.$row['subject'].'</td>
                                    <td>'.$row['phonenumber'].'</td>
                                    <td> <a href="../../../'.$row['propic'].'" ><img src="../../../'.$row['propic'].'" alt="" srcset="" style="object-fit:contain; width:100px;"> </a></td>
                                    <td> <a href="../../../'.$row['coverpic'].'" ><img src="../../../'.$row['coverpic'].'" alt="" srcset="" style="object-fit:contain; width:100px;"> </a></td>
                                </tr>
                            ';
                        }
                    }
                ?>
                </table>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>