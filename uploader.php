<?php

session_start();

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

$data_type = "";
if(isset($_POST['data_type']))
{
  $data_type = $_POST['data_type'];
}
// print_r($_POST);

// here we upload an image
$destination = "";
if(isset($_FILES['file']) && $_FILES['file']['name'] != ""){
  if($_FILES['file']['error'] == 0)
  {
    // good to proced 
    $folder = "uploads/";
    if(!file_exists($folder))
    {
      // if the folder does noyt existi, we create a file
      mkdir($folder,0777, true);
    }
    $destination = $folder .  $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], $destination);
    $info->message = "Profile updated";
    $info->data_type = $data_type;
    echo json_encode($info);
  }   
}


if($data_type == "change_profile")
{
  if($destination != "")
  {
    // save to database
    $id = $_SESSION['userid'];
    $query = "update users set image = '$destination' where userid = '$id' limit 1";
    $DB->write($query,[]);
  }
}

?>