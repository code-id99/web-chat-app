// function _(element){
//   return document.getElementById(element);
// }


// function collect_data(){

//   var save_button = _("save_button");
//   save_button.disabled = true;
//   save_button.value = "Processing";

//   var myform = _("myform");
//   var inputs = myform.getElementsByTagName("INPUT");

//   var data = {};
//   for (var i = inputs.length - 1; i >= 0; i--)
//   {
//     var key = inputs[i].name;
  
//     switch(key){

//       case "username":
//         data.username = inputs[i].value;
//         break;

//       case "email":
//         data.email = inputs[i].value;
//         break;


//       case "gender_male":
//       case "gender_female":
//         if(inputs[i].checked){
//           data.gender = inputs[i].value;
//         }
//         break;

//       case "password":
//         data.password = inputs[i].value;
//         break;

//       case "password2":
//         data.password2 = inputs[i].value;
//         break;
//     }
//   }

//   send_data(data,"save_settings");
//   // alert(JSON.stringify(data));
// }

// function send_data(data,type)
// {
//   var XML = new XMLHttpRequest();
//   XML.onload = function()
//   {
//     if(XML.readyState == 4 || XML.status == 200)
//       {
//       handle_result(XML.responseText);
//       var save_button = _("save_button");
//       save_button.disabled = false;
//       save_button.value = "Save Changes";
  
//     }
//   }
//     data.data_type = type;
//     var data_string = JSON.stringify(data);

//     XML.open("POST", "api.php", true);
//     XML.send(data_string);
// }

// function handle_result(result)
// {

//   var data = JSON.parse(result);
//   if(data.data_type == "info")
//   {
//     alert("Changes saved!")
//   }else
//   {
//     var error = _("error");
//     error.innerHTML = data.message; 
//     error.style.display = "block";
//   }
// }