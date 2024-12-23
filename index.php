<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylish/index.css">
  <title>Home || Page</title>
</head>
<body>
  <div id="wrapper">
    <div id="left_pannel">
      <div id="user_info">
        <img id="profile_img" src="gallery/images/man.png" style="">
        <br>
          <span id="username">Username</span>
        <br>
        <span id="email" style="opacity:0.5; font-size:14px">
          Username@gmail.com
        </span>
      </div>
        <br><br>
          <div>
            <label id="label_chat" for="radio_chat">CHAT <img src="gallery/icons/chat-bubble.png" alt=""></label>
            <label id="label_contacts" for="radio_contacts">CONTACTS <img src="gallery/icons/contact-book.png" alt=""></label>
            <label id="label_status">UPDATES <img src="gallery/" alt=""></label>
            <label id="label_settings"  for="radio_settings">SETTINGS <img src="gallery/icons/setting.png" alt=""></label>
            <label id="logout" for="radio_logout">LOGOUT <img src="gallery/icons/logout.png"></label>
          </div>
      </div>

      <div id="right_pannel">
        <div id="header">
         <span id="topper"> MESSENGER APP</span>

          <!-- <div id="load_page_off">
            <img id="load_page" style="width:60px" src="gallery\icons\loading-7528_256.gif">
          </div>   -->
        </div>

          <div id="container" style="display:flex;">

            <div id="inner_left_pannel">
            </div>

              <input type="radio" id="radio_chat" name="myradio" style="display:none">
              <input type="radio" id="radio_contacts" name="myradio" style="display:none">
              <input type="radio"  style="display:none">
              <input type="radio" id="radio_settings" name="myradio" style="display:none">
            
            
            <div id="inner_right_pannel"></div>
          </div>
      </div>
  </div>
<script src="scripts/index.js"></script>
</body>
</html>