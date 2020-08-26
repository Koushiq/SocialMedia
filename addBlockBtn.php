<?php
    $generateRejectBtn=false;
    if(session_status()==PHP_SESSION_NONE)
    {
        session_start();
    }
    if(!isset($_SESSION['username']))
    {
        session_destroy();
        header("location:login.php");
    }
    $conn = new mysqli("localhost","root","","socialsite");
    $sql="select status,username from friend where (username='".$_SESSION['username']."' and receivername='".trim(htmlspecialchars($_GET['username']))."') or (username='".trim(htmlspecialchars($_GET['username']))."' and receivername='".$_SESSION['username']."')  ";
    $result=$conn->query($sql) or die($sql);
    $row=$result->fetch_assoc();
    $buttonValue="Add Friend";
    if($result->num_rows>0)
    {
        if($row['status']=="requested")
        {
            if($row['username']==$_SESSION['username'])
            {
                $buttonValue="Cancel Request";
            }
            else
            {
                $buttonValue="Accept";
                $generateRejectBtn=true;
            }
            
        }
        else if($row['status']=="accepted")
        {
            $buttonValue="Friends";
        }
    }

?>
<script>
    var addFriendBtnValue="<?php echo $buttonValue?>";
    var scriptLoaded=false;
    function loadSendFriendReqAjax(status)
    {
        var username="<?php echo $viewUsername; ?>";
        var xhttp= new XMLHttpRequest();
        xhttp.open("get","sendFriendRequest.php?username="+username+"&status="+status,true);
        xhttp.send();
    }
    function sendFriendRequest()
    {   
       if(!scriptLoaded)
       {
           scriptLoaded=true;
       }
       if(scriptLoaded)
       {
            addFriendBtnValue=document.getElementById("add_friend_btn_id").value;
       }
       if(addFriendBtnValue=="Add Friend")
       {
           addFriendBtnValue="Cancel Request";
           loadSendFriendReqAjax("requested");
       }
       else if(addFriendBtnValue=="Friends")
       {
            addFriendBtnValue="Add Friend";
            loadSendFriendReqAjax("unfriended");
       }
       else if(addFriendBtnValue=="Cancel Request")
       {
            addFriendBtnValue="Add Friend";
            loadSendFriendReqAjax("cancelled");
       }
       else if(addFriendBtnValue=="Accept")
       {
            addFriendBtnValue="Friends";
            document.getElementById("reject_friend_btn_id").remove();
            loadSendFriendReqAjax("accepted");
       }
       else
       {
           console.log("hre");
       }
       document.getElementById("add_friend_btn_id").value=addFriendBtnValue;
       console.log(document.getElementById("add_friend_btn_id").value);
    }
    function rejectFriendRequest()
    {
        document.getElementById("reject_friend_btn_id").remove();
        loadSendFriendReqAjax("cancelled");
        document.getElementById("add_friend_btn_id").value="Add Friend";
    }
    function sendMessageTo()
    {
        var username= "<?php echo trim(htmlspecialchars($_GET['username'])); ?>";
        window.location.href="messenger.php?username="+username;
    }
    function blockUser()
    {
        loadSendFriendReqAjax("blocked");
    }
    
</script>

<div id="add_block_btn_id">
    <div class="add_friend_btn btn btn_primary">
        <input type="button" value="<?php echo $buttonValue; ?>" onclick="sendFriendRequest()" id="add_friend_btn_id">
    </div>
    <?php
        if($generateRejectBtn==true)
        {
            echo'
                <div class="add_friend_btn btn btn_primary">
                    <input type="button" value="Reject" onclick="rejectFriendRequest()" id="reject_friend_btn_id">
                </div>
            ';
        }
    ?>
    <div class="message_btn btn btn_danger">
        <input type="button" value="Message" onclick='sendMessageTo()'  id="message_btn_id">
    </div>

    <div class="block_btn btn btn_primary">
        <input type="button" value="Block" onclick="blockUser()" id="block_btn_id">
    </div>
</div>