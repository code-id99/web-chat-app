<?php
$arr['userid'] = "null";

if(isset($DATA_OBJ->find->userid))
{
    $arr['userid'] = $DATA_OBJ->find->userid;
}

$sql = "select * from users where userid = :userid limit 1";
$result = $DB->read($sql, $arr);

if(is_array($result)){
// print_r($result);die;
  $arr['message'] = $DATA_OBJ->find->message;
// print_r($result);die;

  $arr['date'] = date("Y-m-d H:i:s");
  $arr['sender'] = $_SESSION['userid'];
  $arr['msgid'] = get_random_string_max(60);

      $arr2['sender'] = $_SESSION['userid'];
      $arr2['receiver'] = $arr['userid'];

      // sub query
      $sql = "select * from messages where (sender = :sender && receiver = :receiver) || (receiver = :sender && sender = :receiver) limit 1";
      $result2 = $DB->read($sql, $arr2);

      if(is_array($result2))
      {
        $arr['msgid'] = $result2[0]->msgid;
      }
// print_r($arr);die;
  $query = "insert into messages (sender, receiver, message, date, msgid) values(:sender,:userid,:message,:date,:msgid)";
  $DB->write($query, $arr);  
  
  // user found
    $row = $result[0];

    $image = ($row->gender == "male") ? "gallery/images/man.png" : "gallery/images/woman.png";
    if(file_exists($row->image))
    {
            $image = $row->image;
    }
    $row->image = $image;
$mydata = "Now Chatting with: <br>
            <div id='active_contact' 
                style='width: 100px;
                height: 150px; 
                margin: 10px; 
            
                transtion:0.5s ease;'>
                <img src='$image'  
                style='	width: 60px;
                height: 60px;'>
                $row->username
            </div>";
    
$messages = 
// first one is a left side chat and conversation 
// second one is for right side
"<div id='message_holder_parent' onclick='set_seen(event)' style=' height:500;'>
        <div id='message_holder' style=' height:350px; overflow-y:scroll; border:solid thin darkgrey'>";

      // read from database
      $a['msgid'] = $arr['msgid'];
    // sub query
      $sql = "select * from messages where msgid = :msgid order by id desc ";
      $result2 = $DB->read($sql, $a);

      if(is_array($result2))
      {
        $result2 = array_reverse($result2);
        foreach ($result2 as $data) {
          # code...
          $myuser = $DB->get_user($data->sender);
          if($_SESSION['userid'] == $data->sender){
            $messages .= message_right($data,$myuser);
          }else{
            $messages .= message_left($data,$myuser);
          }
        }
      }

$messages .= message_controls();



    $info->user = $mydata;
    $info->messages = $messages;
    $info->data_type = "chat";
    echo json_encode($info);
}else{
    // user not found
    $info->message = "No user found";     
    $info->data_type = "chat";
    echo json_encode($info);
}

function get_random_string_max($length)
{
  $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','X','Y','Z');
  $text = ""; 

  $length = rand(4,$length);

  for($i=0;$i<$length;$i++)
  {
      $random = rand(0,61);

      $text .= $array[$random];
  }
  return $text;
}

?>
