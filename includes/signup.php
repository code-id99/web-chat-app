<?php

$info = (object)[];

  $data = false;
	$data['userid'] = $DB->generate_id(20);
	$data['date'] = date("Y-m-d H:i:s");

	// validating the username
	$data['username'] = $DATA_OBJ->username;
	if(empty($DATA_OBJ->username))
	{
		$Error .= "Username field is not filled! <br>";
	}else
	{
		if(strlen($DATA_OBJ->username) < 2)
		{
			$Error .= "Username is too short! <br>";
		}

		if(!preg_match("/^[a-z A-Z]*$/", $DATA_OBJ->username))
		{
			$Error .= "Username contains no numbers! <br>";
		}
	}

	// validating an email
	$data['email'] = $DATA_OBJ->email;
	if(empty($DATA_OBJ->email))
	{
		$Error .= "Email field is not filled! <br>";
	}else
	{
		if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $DATA_OBJ->email))
		{
			$Error .= "Email is not valid! <br>";
		}
	}

	// validating gender
	$data['gender'] = isset($DATA_OBJ->gender) ? $DATA_OBJ->gender : null;
	if(empty($DATA_OBJ->gender))
	{
		$Error .= "gender  is not filled! <br>";
	}else
	{
			if($DATA_OBJ->gender != "male" && $DATA_OBJ->gender != "female")
			{
				$Error .=  "gender is invalid <br>";
			}
		}
	
	
	// valiating password
	$data['password'] = $DATA_OBJ->password;
	$password = $DATA_OBJ->password2;
	if(empty($DATA_OBJ->password))
	{
		$Error .= "Password field is not filled! <br>";
	}else
	{
		if($DATA_OBJ->password != $DATA_OBJ->password2)
		{
			$Error .= "Passwords must match! <br>";
		}

		if(strlen($DATA_OBJ->password) < 8)
		{
			$Error .= "Password must be at least 8 characters long! <br>";
		}
	}
	
	if($Error == "")
	{
			$query = "insert into users (userid,username,email,gender,password,date)
			values(:userid,:username,:email,:gender,:password,:date)";
			$result = $DB->write($query,$data);

			if($result)
			{
        $info->message = "Profile successfully created!";        ;
        $info->data_type = "info";
        echo json_encode($info);
			}else
			{
        $info->message = "Profile failed to create!";
        $info->data_type = "error";
        echo json_encode($info);
			}
	}else
	{
    $info->message = $Error;
    $info->data_type = "error";
		echo json_encode($info);
	}