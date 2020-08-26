
<ul>
    <?php
        $conn=new mysqli("localhost","root","","socialsite");
        //$sqlFriendRequest="select * from friend where (username='".$_SESSION['username']."' or receivername='".$_SESSION['username']."') and status ='accepted' ;";
        $sql="select * from friend where (username='".$_SESSION['username']."' or receivername='".$_SESSION['username']."') and status ='accepted' ;";
        $result= $conn->query($sql);
        
        while( $row = $result->fetch_assoc() )
        {
            if($row['username']!=$_SESSION['username'])
            {
                echo
                '
                    <a href="messenger.php?username='.$row['username'].' " class="text_dark" >
                    <li class="logo chat_box">
                    
                    <img src="'.$row['usernamePropic'].'">
                    <p id="chat_head_panel">'.$row['usernameFirstName']." ".$row['usernameLastName'].'</p>
                    
                    <span class="active_now"></span>
                    </li> 
                    </a>
                ';
            }
            else
            {
                echo
                '
                    <a href="messenger.php?username='.$row['receivername'].' " class="text_dark" >
                    <li class="logo chat_box">
                    
                    <img src="'.$row['receivernamePropic'].'">
                    <p id="chat_head_panel">'.$row['receivernameFirstName']." ".$row['receivernameLastName'].'</p>
                    
                    <span class="active_now"></span>
                    </li> 
                    </a>
                ';
            }
            
        }
     ?>    
</ul>
