/* function sendMessage()
{
    var xhttp = new XMLHttpRequest();
    var formData= new FormData();
    //var msg_content_txt=document.getElementById("msg_content").value;
    //var picture_content_txt=document.getElementById("picture").value;
    //alert(picture_content_txt);
    xhttp.onreadystatechange=function()
    {
        if(xhttp.readyState==4 && xhttp.status==200)
        {
            document.getElementById("msg_pnl_id").innerHTML=xhttp.responseText;
        }
    }
    xhttp.open("post","sendMessage.php",true);
    xhttp.send();
}
 */


