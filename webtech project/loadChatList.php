
<ul>
    <?php
        $sql="select userinfo.username,userinfo.firstName,userinfo.lastName, about.propic from userinfo inner join about on userinfo.username=about.username";
        $result= $conn->query($sql);
        //$row = $result->fetch_assoc();
        while( $row = $result->fetch_assoc() )
        {
            echo
                '
                <a href="?username='.$row['username'].' " class="text_dark" >
                <li class="logo chat_box">
                
                <img src="'.$row['propic'].'">
                <p id="chat_head_panel">'.$row['firstName']." ".$row['lastName'].'</p>
                
                <span class="active_now"></span>
                 </li> 
                 </a>';
        }        
     ?>    
</ul>
