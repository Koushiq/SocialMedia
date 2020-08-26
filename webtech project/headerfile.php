<?php
    $conn=new mysqli("localhost","root","","socialsite");
    $getFirstNameQuery="select firstName from userinfo where username ='".$_SESSION['username']."';";
    $getFirstNameRes=$conn->query($getFirstNameQuery);
    $getFirstNameRow=$getFirstNameRes->fetch_assoc();
?>
<script>
    var friendRequestPanelClicked=false;
    function search()
    {
        var xhttp = new XMLHttpRequest();
        var search_txt=document.getElementById("search").value;
        xhttp.onreadystatechange=function()
        {
            if(xhttp.readyState==4 && xhttp.status==200)
            {
                document.getElementById("search_result").innerHTML=xhttp.responseText;
            }
            if(search_txt=="")
            {
                document.getElementById("search_result").style.display="none";
            }
            else
            {
                document.getElementById("search_result").style.display="inline-block";
            }
        }
        xhttp.open("GET","getSearchResult.php?search="+search_txt,true);
        xhttp.send();
    }
    function friendRequest()
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange=function()
        {
            if(xhttp.readyState==4 && xhttp.status==200)
            {
                document.getElementById("friend_request").innerHTML=xhttp.responseText;
            }
        }
        if(!friendRequestPanelClicked)
        {
            document.getElementById("friend_request").style.display="inline-block";
        }
        else
        {
            document.getElementById("friend_request").style.display="none";
        }
        xhttp.open("GET","getFriendRequest.php",true);
        xhttp.send();
        friendRequestPanelClicked=!friendRequestPanelClicked;
    }
        
    
   
</script>

<div class="form-input" id="top">
    <uL class="top_nav">
        <li class="top_search">
            <input type="search" placeholder="Search" autocomplete=off id="search" onkeyup="search()">
        </li>
        <li class="first_element" id="item_upper_space">
            <a href="profile.php" class="text_angel"><?php echo $getFirstNameRow['firstName']."'s Profile"; ?></a>
        </li>
        <li id="item_upper_space">
            <a href="homepage.php" class="text_angel">Home</a>
        </li>
        <?php
            $conn=new mysqli("localhost","root","","socialsite");
            $sql="select * from friend where receivername='".$_SESSION['username']."' and status='requested'";
            $res=$conn->query($sql);
            if($res->num_rows==0)
            {
                echo '
                <li class="logo top_nav_pic" id="item_upper_space">
                    <a href="#" onclick="friendRequest()"><img src="friendRequest.png"></a>
                </li>';
            }
            else
            {
                echo '
                <li class="logo top_nav_pic" id="item_upper_space">
                    <a href="#" onclick="friendRequest()"><img src="friendRequestActive.png"></a>
                </li>';
            }
        ?>
        <li class="logo top_nav_pic" id="item_upper_space">
                <a href="messenger.php"><img src="message.png"></a>
        </li>
        <!-- <li class="logo top_nav_pic" id="item_upper_space">
            <a href="#"><img src="notification.png"></a>
        </li> -->
        <li class="logo top_nav_pic" id="item_upper_space">
            <a href="logout.php"><img src="logout.png"></a>
        </li>
    </uL>
</div>

<?php
    include("searchBarResultPanel.php");
    include('friendRequestPanel.php');
?>
