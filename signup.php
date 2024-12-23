<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stylish/signup.css">
  <title>SIGN-UP || Page</title>
</head>

<body>
<div id="wrapper">
  <form id="myform">
    <div id="head">MESSENGER APP 
      <br><div style="font-size:17px; margin:7px">
        SIGNUP
      </div> 
    </div>

    <input type="text" name="username" placeholder="Username"><br>
    <input type="email" name="email" placeholder="Email"><br>
    
      <div style="padding:10px;">
        <br>Gender:<br>
        <input type="radio" value="male" name="gender_male">Male <br>
        <input type="radio" value="female" name="gender_female">Female <br>
      </div>
    
    <input type="password" name="password" placeholder="Password"><br>
    <input type="password" name="password2" placeholder="Retype Password"><br>
    
    <input type="submit" value="Sign Up" id="signup_button"><br>

    <span class="separator">or</span><br>
    <a href="http://" class="password_restart">Forgot Password</a><br>
        
    <footer class="signup_footer">Already have an account?
          <a href="login.php" class="signhere" style="text-decoration:none;">Log-in here</a>
          <br>
    </footer>
    <div id="error"></div>
  </form>
</div>

  <!-- script -->
<script src="scripts/signup.js"></script>
</body>
</html>

