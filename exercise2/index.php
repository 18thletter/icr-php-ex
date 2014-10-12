<?php
// I'm not exactly sure what the Remember Me checkbox is supposed to do,
// but here, at this point in the script, we can redirect to dashboard
// if the cookie is active.
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/base.min.css" />
  <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/skeleton.min.css" />
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="login.js"></script>
  <script>
    function displayFlag(msg) {
      document.getElementsByTagName('p')[0].innerHTML = msg;
    }

    window.addEventListener('load', function() {
      var form = document.getElementsByTagName('form')[0];
      form.onsubmit = function() {
        var email = $('input[type=email]', this).val();
        var password = $('input[type=password]', this).val();
        var checked = $('input[type=checkbox]', this).is(':checked');
        EX2.login(email, password, checked, function(error) {
          error && displayFlag(error);
        });
      }
    });
  </script>
</head>
<body>
  <div class="container">
    <p></p>
    <form action="javascript:void(0);">
    <legend>Log In or Sign Up</legend>
    <fieldset>
      <input type="email" placeholder="Email Address" value="<?php
        if(isset($_COOKIE['rememberEmail'])) {
          echo $_COOKIE['rememberEmail'];
        } ?>"autofocus required />
        <input type="password" placeholder="Password" minlength="6" required />
        <label for="rememberme">
          <input type="checkbox" id="rememberme" value="0" <?php
            if(isset($_COOKIE['rememberEmail'])) {
              echo "checked";
            } ?>/>
          <span>Remember Me</span>
        </label>
        <input type="submit" value="Log In / Sign Up" />
      </fieldset>
    </form>
  </div>
</body>
</html>
