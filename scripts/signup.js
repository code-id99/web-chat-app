function _(element){
  return document.getElementById(element);
}

var signup_button = _("signup_button");
signup_button.addEventListener("click", collect_data);

function collect_data(){

  signup_button.disabled = true;
  signup_button.value = "Processing";

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


      case "gender_male":
      case "gender_female":
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

  send_data(data,"signup");
  // alert(JSON.stringify(data));
}

function send_data(data,type)
{
  var XML = new XMLHttpRequest();
  XML.onload = function()
  {
    if(XML.readyState == 4 || XML.status == 200)
      {
      handle_result(XML.responseText);
      signup_button.disabled = false;
      signup_button.value = "Signup";
  
    }
  }
    data.data_type = type;
    var data_string = JSON.stringify(data);

    XML.open("POST", "api.php", true);
    XML.send(data_string);
}

function handle_result(result)
{
  var data = JSON.parse(result);
  if(data.data_type == "info")
  {
    window.location = "index.php";
  }else
  {
    var error = _("error");
    error.innerHTML = data.message; 
    error.style.display = "block";
  }
}