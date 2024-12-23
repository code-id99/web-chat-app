<?php

// 
$myid = $_SESSION['userid'];
$sql = "select * from users where userid != '$myid' limit 10";
$myusers = $DB->read($sql,[]);

$mydata = '
<style>
@keyframes appear{
        0%{opacity:0;transform:translateX(100px)}
        50%{opacity:0.7;transform:translateX(50px)}
        100%{opacity:1;transform:translateX(0px)}
}
#contact{
cursor:pointer;
transition: all 0.5s cubic-bezier(0.68, -2, 0.265, 1.55);
}
#contact:hover{
transform: scale(1.1);
}
#contact:active{
background-color:lightgreen;
}
</style>
        <div style="text-align:center; animation:appear 0.7s ease">';
if(is_array($myusers))
{
        foreach ($myusers as $row) {

        $image = ($row->gender == "male") ? "gallery/images/man.png" : "gallery/images/woman.png";
        if(file_exists($row->image))
        {
                $image = $row->image;
        }
        $mydata .= "
        <div id='contact' userid ='$row->userid' onclick='start_chat(event)' 
                style='width: 100px;
                height: 150px; 
                margin: 10px; 
                display: inline-block;
                vertical-align: top;
                transtion:0.5s ease;'>

                <img src='$image'  
                        style='	width: 100%;
                        height: 100px;'>
                        $row->username
        </div>";
        }
}

$mydata .= '</div>';

$info->message = $mydata;
$info->data_type = "settings";
echo json_encode($info);
die;
$info->message = "No contacts found";     
$info->data_type = "error";
echo json_encode($info);
?>
