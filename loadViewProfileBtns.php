<?php
    $viewUserName=$_GET['username'];
?>

<div class="profile_btns">
    <ul>
        <li>
            <a href="<?php echo 'viewAbout.php?username='.$viewUserName;  ?>" ><p class="med_font text_primary">About</p></a>
        </li>
        <li>
        <a href="<?php echo 'viewProfile.php?username='.$viewUserName; ?>"><p class="med_font text_primary">Profile</p></a>
        </li>
            <li>
            <a href="<?php echo 'viewFriendList.php?username='.$viewUserName; ?>"><p class="med_font text_primary">Friends</p></a>
        </li>
        <li>
            <a href="<?php echo 'viewPhotos.php?username='.$viewUserName; ?>"><p class="med_font text_primary">Photos</p></a>
        </li>
    </ul>
</div>