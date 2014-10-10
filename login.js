var EX2 = (function() {
  var ex2 = {};
  ex2.login = function(username, password, checked, callback) {
    $.ajax({
      type: 'POST',
      url: 'login.php',
      data: {
        username: username,
        password: password,
        checked: checked
      }
    }).done(function(result) {
      console.log(result);
      return;
      var errorMsg = '';
      switch (result) {
        // errors
        case '0':
          errorMsg = "Username is required.";
          break;
        case '1':
          errorMsg = "Password is required.";
          break;
        case '2':
          errorMsg = "Password must be at least six characters.";
          break;
        default:
          break;
      }
      callback(errorMsg);
    });
  }
  return ex2;
}());
