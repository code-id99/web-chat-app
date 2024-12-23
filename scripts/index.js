var CURRENT_CHAT_USER = "";
var SEEN_STATUS = "false";

function _(element){
  return document.getElementById(element)
}

// these add event listener dets data from the server
// for chats
var label_chat = _("label_chat");
label_chat.addEventListener("click",get_chats);

// for settings
var label_settings = _("label_settings");
label_settings.addEventListener("click",get_settings);

// for contacts 
var label_contacts = _("label_contacts");
label_contacts.addEventListener("click", get_contacts);

// for logout
var logout = _("logout");
logout.addEventListener("click",logout_user);

// this function gets user's data from the database 
function get_data(find,type)
{
  var XML = new XMLHttpRequest();
  XML.onload = function(){
    if(XML.readyState == 4 || XML.status == 200)
    {
// alert(this.responseText);
      handle_result(XML.responseText,type);
    }
  }

  var data = {};
  data.find = find;
  data.data_type = type;
  data = JSON.stringify(data);

  XML.open("POST", "api.php", true);
  XML.send(data);
}

function handle_result(result){
// alert(result);

  if(result.trim() != "")
  {  
    var inner_right_pannel = _("inner_right_pannel");
    inner_right_pannel.style.overflow = "visible";

    var obj = JSON.parse(result);
    if(typeof(obj.logged_in) != "undefined" && !obj.logged_in)
    {
      window.location = "login.php";
    }else
    {
      switch(obj.data_type)
      {
        case "user_info":
          var username = _("username");
          var email = _("email");
          var profile_img = _("profile_img")
          
          username.innerHTML = obj.username;
          email.innerHTML = obj.email;
          profile_img.src = obj.image;
          break;


        case "contacts":
          SEEN_STATUS = false;
          
          var inner_left_pannel = _("inner_left_pannel");
          var inner_right_pannel = _("inner_right_pannel");

          inner_right_pannel.style.overflow = "hidden";
          inner_left_pannel.innerHTML = obj.message;
          break;  
        
        // case "chat_refresh":
        //   var message_holder = _("message_holder");
        //   message_holder.innerHTML = obj.messages;
        //   break;

        case "chat":
          SEEN_STATUS = false;

          var inner_left_pannel = _("inner_left_pannel");
          inner_left_pannel.innerHTML = obj.user;
          inner_right_pannel.innerHTML = obj.messages;

          var message_holder = _("message_holder");

          setTimeout(function(){
            message_holder.scrollTo(0,message_holder.scrollHeight);
            message_text.focus();
          },0);
          
          break; 
        
        case "settings":
          var inner_left_pannel = _("inner_left_pannel");
          inner_left_pannel.innerHTML = obj.message;
          break;   

        case "save_settings":
          alert(obj.message);
          get_data({},"user_info");
          get_settings(true);
          break; 
          
    }
    }
  }
}
function logout_user()
{
  var warning = confirm("Confirm to procced logging out?")
  if(warning)
    {
      get_data({},"logout");
    } 
}
get_data({},"user_info");
get_data({},"contacts");

var radio_contacts = _("radio_contacts");
radio_contacts.checked = true;

// this function gets contatcs from the database
function get_contacts(e)
{
  get_data({},"contacts");
}

// this function gets chats from the database 
function get_chats(e)
{
  get_data({},"chat");
}

// // this function gets settings from the database
function get_settings(e)
{
  get_data({},"settings");
}

// this function sends message
function send_message(e)
{
  // collecting data before sending it
  var message_text =  _("message_text");
  // checking if the message is not empty
  if(message_text.value.trim()== "")
    {
      alert("Cannot send empty message!")
      return
    }
  // alert(message_text.value); 
   get_data({

    message:message_text.value.trim(),
    userid:CURRENT_CHAT_USER 

   },"send_message");
}

// this function allows to send message using enter
function enter_pressed(event)
{
  if(event.keyCode == 13)
  {
    send_message(event);
  }
}

// this function cheacks for the message forom the database after 7 seconds 
setInterval(function()
{
  if(CURRENT_CHAT_USER != "")
    {
    get_data({
      userid:CURRENT_CHAT_USER
    },"chat_refresh");
  };

},7000);

function set_seen(e)
{
  SEEN_STATUS = true;
}

// setting script
function collect_data(){

  var save_button = _("save_button");
  save_button.disabled = true;
  save_button.value = "Processing";

  var myform = _("myform");
  var inputs = myform.getElementsByTagName("INPUT");

  var data = {};
  for (var i = inputs.length - 1; i >= 0; i--)
  {
    var key = inputs[i].name;
  
    switch(key){

      case "username":
        data.username = inputs[i].value;
        break;

      case "email":
        data.email = inputs[i].value;
        break;


      case "gender":
        if(inputs[i].checked){
          data.gender = inputs[i].value;
        }
        break;

      case "password":
        data.password = inputs[i].value;
        break;

      case "password2":
        data.password2 = inputs[i].value;
        break;
    }
  }

  send_data(data,"save_settings");
  // alert(JSON.stringify(data));
}

function send_data(data,type)
{
// alert(data,type);
  var XML = new XMLHttpRequest();
  XML.onload = function()
  {
    if(XML.readyState == 4 || XML.status == 200)
      {
      handle_result(XML.responseText);
      var save_button = _("save_button");
      save_button.disabled = false;
      save_button.value = "Save Changes";
  
    }
  }
    data.data_type = type;
    var data_string = JSON.stringify(data);

    XML.open("POST", "api.php", true);
    XML.send(data_string);
}

function upload_profile_image(files)
{
  var change_image_input = _("change_image_input");
  change_image_input.disabled = false;
  change_image_input.innerHTML = "Uploading picture...wait";
  
  var myform = new FormData();
  var XML = new XMLHttpRequest();
  XML.onload = function()
  {
    if(XML.readyState == 4 || XML.status == 200)
      {
      // alert(XML.responseText);
      get_data({},"user_info");
      get_settings(true);
      change_image_input.disabled = false;
      change_image_input.innerHTML = "Change Image";
    }
  }
    myform.append('file', files[0]); 
    myform.append('data_type', "change_profile");

    XML.open("POST", "uploader.php", true);
    XML.send(myform);
}

// this function open conversation and chats
function start_chat(e)
{
  var userid = e.target.getAttribute("userid");
  if(e.target.id == ""){
    userid = e.target.parentNode.getAttribute("userid");
  }

  // alert(userid);
  CURRENT_CHAT_USER = userid;
  var radio_chat = _("radio_chat");
  radio_chat.checked = true;
  get_data({userid:CURRENT_CHAT_USER},"chat");
}
