<?php

session_start();

$DATA_RAW = file_get_contents("php://input");
$DATA_OBJ = json_decode($DATA_RAW);

$info = (object)[];

// checking if user has logged in
if(!isset($_SESSION['userid']))
{
	if(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type != "login"&& $DATA_OBJ->data_type != "signup")
	{
		$info->logged_in = false;
		echo json_encode($info);
		die;
	}

}
require_once("classes/autoload.php");
$DB = new Database();



$Error = "";

// process the data
// conneting signup with daatabase 
if(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "signup")
{
	// signup file
	include("includes/signup.php");
}elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "login")
{
	// login file
	include("includes/login.php");
}
elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "logout")
{
	// logout file
	include("includes/logout.php");
}
	// user_info file
elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "user_info")
{
	include("includes/user_info.php");
}

	// contacts file
elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "contacts")
{
	include("includes/contacts.php");
}
elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "chat")
{
	// chat file
	include("includes/chat.php");
}
elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "settings")
{
	// settings file
	include("includes/settings.php");
}
elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "save_settings")
{
	// save_settings file
	include("includes/save_settings.php");
}

elseif(isset($DATA_OBJ->data_type) && $DATA_OBJ->data_type == "send_message")
{
	// send message file
	include("includes/send_message.php");
}

// left chats side function
function message_left($data,$row)
{
	return "
	<div id='message_left'
			style='
			margin: 2px;
			padding:2px;
			padding-right:5px;
			background-color:darkturquoise;
			color: white;
			border-top-right-radius: 45px;
  		border-bottom-right-radius: 37px;
			border-bottom-left-radius: 45px;
			width:70%;
			height: auto;
			float:left;
			box-shadow: 0px 0px 10px;
			position: relative;
			transtion:0.5s ease;'>

			<img src='$row->image'  
			style='	margin-right:70px;
			width: 60px;
			height: 60px;
			float:left;
			border-radius:50%'>
			<br>$data->message<br>
			<span style='font-size:12px; color:grey;'>".date("jS M Y H:i:s a", strtotime($data->date))."</span>
	</div>
";
}
// right side chats function
function message_right($data,$row)
{
	
	return"
	 <div id='message_right' 
                style='
                margin: 2px;
                padding:2px;
                padding-right:10px;
                background-color: midnightblue;
                color: white;
                width:70%;
								height:auto;
								border-top-left-radius: 45px;
								border-bottom-right-radius: 37px;
								border-bottom-left-radius: 45px;
                float:right;
                box-shadow: 0px 0px 10px;
                position: relative;
                transtion:0.5s ease;'>

                <img src='$row->image'  
                style='	margin-left:70px;
                width: 60px;
                height: 60px;
                float:right;
                border-radius:50%'>
								<br>$data->message<br>
			<span style='font-size:12px; color:grey;'>".date("jS M Y H:i:s a", strtotime($data->date))."</span>
	</div><br><br>
";
}

function message_controls()
{
	return "
	 </div>
        <div style='display:flex';width:100%; height:40px>
         <label for='message_file'><img src='gallery/icons/clip.png'
                        style='opacity:0.8; width:30px; margin:5px; cursor:pointer'></label>         
                <input type='file' id='message_file' name='file' style='display:none'/>
            
            <input type='text' onkeyup='enter_pressed(event)' id='message_text' class=''style='flex:6; height:35px; font-size:14; padding:5px; border-radius:7px; border:solid thin skyblue;border_bottom:none;'placeholder='Start typing message.'/>
            <input type='button' value='Send' onclick='send_message(event)' class='send_text' 
                            style= 'flex:1;	
                                    border: none;
                                    height:40px;
                                    border-radius:10px;
                                    background-color: #444;
                                    margin: 5px;
                                    cursor:pointer;'/>
        </div>
</div>";
}