<?php
    $key=$_GET['search'];
    $conn= new mysqli("localhost","root","","socialsite");
    $query="select username,concat(firstName,' ',lastName) as name from userinfo where concat(firstName,' ',lastName) like '%$key%' ";
    $resultSearch=$conn->query($query);
    if($resultSearch->num_rows==0)
    {
        echo '<h5 class="search_res_pnl"> No Result Found</h5>';
    }
    while($rowSearch=$resultSearch->fetch_assoc())
    {
        echo '<a href="viewProfile.php?username='.$rowSearch['username'].'"><h5 class="search_res_pnl"> '.$rowSearch['name'].'</h5> </a>';
    }

?>