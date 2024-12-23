<?php
$arr['userid'] = "null";
if(isset($DATA_OBJ->find->userid))
{
    $arr['userid'] = $DATA_OBJ->find->userid;
}
// $refresh = false;

// if($DATA_OBJ->data_type == "chat_refresh"){
//     // $refresh = true;
// }

$sql = "select * from users where userid = :userid limit 1";
$result = $DB->read($sql, $arr);

if(is_array($result)){
    // user found
    $row = $result[0];

    $image = ($row->gender == "male") ? "gallery/images/man.png" : "gallery/images/woman.png";
    if(file_exists($row->image))
    {
        $image = $row->image;
    }
    $row->image = $image;

// if(!$refresh){ 
$mydata = "Now Chatting with: <br>
            <div id='active_contact' 
                style='
                height: 70px; 
                margin: 10px; 
                transtion:0.5s ease;
                border: solid thin grey;
                padding: 5px;
                background-color: rgba(47, 79, 79, 0.596);
                color: black;
                border-radius:7px;'>

                <img src='$image'  
                style='	width: 60px;
                height: 60px; 
                float:left;
                margin:2px;'>
                $row->username
            </div>";
        // }
// if(!$refresh){        
$messages = 
// first one is a left side  conversation 
// second one is for right side conversation
"
<div id='message_holder_parent' onclick='set_seen(event)' style=' height:500;'>
        <div id='message_holder' style=' height:350px; overflow-y:scroll; border:solid thin darkgrey'>";

    // read from database
        $a['sender'] = $_SESSION['userid'];
        $a['receiver'] = $arr['userid'];
      
        // sub query
        $sql = "select * from messages where (sender = :sender && receiver = :receiver) || (receiver = :sender && sender = :receiver) order by id desc limit 10";
        $result2 = $DB->read($sql, $a);
  
        if(is_array($result2))
        {
          $result2 = array_reverse($result2);
          foreach ($result2 as $data) {
            # code...
            $myuser = $DB->get_user($data->sender);
            
            // this condition n checkes if the message has been seen
            if($data->receiver == $_SESSION['userid']){
                $DB->write("update messages set received = 1 where id = '$data->id' limit 1");
            }

            if($_SESSION['userid'] == $data->sender){
              $messages .= message_right($data,$myuser);
            }else{
              $messages .= message_left($data,$myuser);
            }
          }
        }
    // }


    // if(!$refresh){
    $messages .=  message_controls();
    // }

    $info->user = $mydata;
    $info->messages = $messages;
    $info->data_type = "chat";
    echo json_encode($info);
    // if($refresh){
    //     $info->data_type = "chat_refresh";
    // }
    
}else{
    // user not found
    $info->message = "No user found";     
    $info->data_type = "chat";
    echo json_encode($info);
}



?>
