<?php
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/base.min.css" />
  <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/skeleton.min.css" />
  <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
  <script>
    $(function() {
      $('form').submit(function(event) {
        var url = $('#youtube-url').val().trim();
        if (!url) {
          return;
        }
        $.ajax({
          type: 'GET',
          url: 'ex1.php',
          data: {
            url: url
          },
        }).done(function(result) {
          $('.result > p').html(result);
          $('.result').show();
        });
      });
    });
  </script>
</head>
<body>
<div class="container">
  <h1>Exercise 1</h1>
  <form action="javascript:void(0);">
  <fieldset>
    <label for="youtube-url">Enter a YouTube link</label>
    <input id="youtube-url" type="text" />
    <input type="submit" value="Get JSON" />
  </fieldset>
  </form>
  <div class="result" style="display:none">
    <h2>Result:</h2>
    <p></p>
  </div>
</div>
</body>
</html>
