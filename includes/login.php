<?php

$info = (object)[];

  $data = false;

	// validating the info
	// validating an email
	$data['email'] = $DATA_OBJ->email;
	if(empty($DATA_OBJ->email))
  {
    $Error = "Email field is empty";
  }
  if(empty($DATA_OBJ->password))
  {
    $Error = "Password field is empty";
  }

	if($Error == "")
	{
			$query = "select * from users where email = :email limit 1";
			$result = $DB->read($query,$data);

			if(is_array($result))
			{
        $result = $result[0];
        if($result->password == $DATA_OBJ->password)
        {
          $_SESSION['userid'] = $result->userid;
          $info->message = "Log in sueccessful!";     
          $info->data_type = "info";
          echo json_encode($info);
        }else
        {
          $info->message = "Wrong password!";     
          $info->data_type = "error";
          echo json_encode($info);
        }
			}else
			{
        $info->message = "Invalid email!";
        $info->data_type = "error";
        echo json_encode($info);
			}
	}else
	{
    $info->message = $Error;
    $info->data_type = "error";
		echo json_encode($info);
	}