var EX2 = (function() {
  var ex2 = {};
  ex2.login = function(email, password, checked, callback) {
    $.ajax({
      type: 'POST',
      url: 'login.php',
      data: {
        email: email,
        password: password,
        checked: checked
      },
    }).done(function(result) {
      if (result === 'success') {
        document.location = 'dashboard.php';
        return;
      }

      var errorMsg = '';
      switch (result) {
        // errors
        case '0':
          errorMsg = "Email address is required.";
          break;
        case '1':
          errorMsg = "Password is required.";
          break;
        case '2':
          errorMsg = "Password must be at least six characters.";
          break;
        case '3':
          errorMsg = "Email address format incorrect.";
          break;
        case '4':
          errorMsg = "The email address or password is incorrect.";
          break;
        default:
          break;
      }
      callback(errorMsg);
    });
  }
  return ex2;
}());
