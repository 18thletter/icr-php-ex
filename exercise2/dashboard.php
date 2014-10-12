<?php
/*
 * This file is a dashboard stub.
 */

session_start();
// check for session email
// can also check here for the cookie, if we want to use that
if (!isset($_SESSION['userEmail'])) {
  header('Location: index.php', true, 401);
  exit;
}

?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/base.min.css" />
  <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/skeleton.min.css" />
</head>
<body>
  <div class="container">
    <h1>Dashboard</h1>
    <?php
    if (isset($_SESSION['accountCreated'])) {
      echo '<p>Account created successfully!</p>';
      unset($_SESSION['accountCreated']);
    }
    if (isset($_SESSION['justLoggedIn'])) {
      echo '<p>Logged in successfully!</p>';
      unset($_SESSION['justLoggedIn']);
    } ?>
  </div>
</body>
</html>
