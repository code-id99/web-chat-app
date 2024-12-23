<?php

$sql = "select * from users where userid = :userid limit 1";
$id = $_SESSION['userid'];
$data = $DB->read($sql,['userid'=>$id]);

$mydata = "";

if(is_array($data))
  {
    $data = $data[0];  
        
    // checking if profile exist
    $image = ($data->gender == "male") ? "gallery/images/man.png" : "gallery/images/woman.png";
    if(file_exists($data->image))
    {
        $image = $data->image;
    }

    // checking if gender is checked
    $gender_male = "";
    $gender_female = "";
    
    if($data->gender == "male"){   
        $gender_male = "checked";
    }else{
        $gender_female = "checked";
    }

    $mydata = '
<style>
@keyframes appear{
    0%{opacity:0;transform:translateX(100px)}
    50%{opacity:0.7;transform:translateX(50px)}
    100%{opacity:1;transform:translateX(0px)}
}
input[type=button]{
  padding: 7px;
  margin: 7px;
  width: 50%;
  border-radius: 7px;
  border: none;
  cursor: pointer;
  background-color:darkslategray;
  color: white;
}
</style>
        <link rel="stylesheet" href="stylish/settings.css">
        
        <div style="display:flex; animation: appear 0.7s ease">

  
        <div>
            <img class="profile_settings" src="'.$image.'"><br><br>
                <label for="change_image_input" id="upload_profile_button" style="background-color:darkslategray; display:inline-block; padding:0.5em; border-radius:7px; cursor:pointer;">
                Change Profile
                </label>
            <input type="file" onchange="upload_profile_image(this.files)" id="change_image_input" style="display:none;"><br>
        </div>

        <form id="myform">
        <div id="head">Profile Settings 
        </div>

        <input type="text" name="username" placeholder="Username" value="'.$data->username.'"><br>
        <input type="email" name="email" placeholder="Email" value="'.$data->email.'"><br>
        
        <div style="padding:10px;">
            <br>Gender:<br>
            <input type="radio" value="male" name="gender" '.$gender_male.'>Male <br>
            <input type="radio" value="female" name="gender" '.$gender_female.'>Female <br>
        </div>
        
        <input type="password" name="password" placeholder="Password" value="'.$data->password.'"><br>
        <input type="password" name="password2" placeholder="Retype Password" value="'.$data->password.'"><br>
        
        <input type="button" value="Save Changes" id="save_button" onclick="collect_data(event)"><br>


            <div id="error"></div>
        </form>
    <!-- script -->
    <script src="scripts/index.js"></script>
    </div>
';
     
    $info->message = $mydata;
    $info->data_type = "contacts";
    echo json_encode($info);
    
}else{
    $info->message = "No contacts found";     
    $info->data_type = "error";
    echo json_encode($info);
}
?>
