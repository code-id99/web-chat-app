function _(element){
  return document.getElementById(element);
}

var login_button = _("login_button");
login_button.addEventListener("click", collect_data);

function collect_data(){

  login_button.disabled = true;
  login_button.value = "Processing";

  var myform = _("myform");
  var inputs = myform.getElementsByTagName("INPUT");

  var data = {};
  for (var i = inputs.length - 1; i >= 0; i--)
  {
    var key = inputs[i].name;
  
    switch(key){
      case "email":
      data.email = inputs[i].value;
      break;

      case "password":
      data.password = inputs[i].value;
      break;

    } 
  }

  send_data(data,"login");
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
      login_button.disabled = false;
      login_button.value = "Login";
  
    }
  }
    data.data_type = type;
    var data_string = JSON.stringify(data);

    XML.open("POST","api.php", true);
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