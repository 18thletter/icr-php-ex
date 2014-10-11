<?php
/*
 * This file is a dashboard stub.
 */

session_start();
if (!isset($_SESSION['userEmail'])) {
  header('Location: index.php', true, 401);
  exit;
}

echo '<h1>Dashboard</h1>';

if (isset($_SESSION['accountCreated'])) {
  echo '<p>Account created successfully!</p>';
  unset($_SESSION['accountCreated']);
}
if (isset($_SESSION['justLoggedIn'])) {
  echo '<p>Logged in successfully!</p>';
  unset($_SESSION['justLoggedIn']);
}

?>