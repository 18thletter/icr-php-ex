<?php
// Enums to hold return values
abstract class LoginError {
  const NO_EMAIL = 0;
  const NO_PASSWORD = 1;
  const BAD_PASSWORD = 2;
  const BAD_EMAIL = 3;
  const INVALID_CREDENTIALS = 4;
}
const SUCCESS = 'success';

// check the post
if (!isset($_POST['email']) || empty($_POST['email'])) {
  echo LoginError::NO_EMAIL;
  exit;
}
if (!isset($_POST['password']) || empty($_POST['password'])) {
  echo LoginError::NO_PASSWORD;
  exit;
}

// email validation can be done here. For this exercise I'm not
// validating
function emailCheck($email) {
  return true;
}

// maybe some password restrictions can go here. right now I'm only
// checking that the password is at least 6 characters
function passwordCheck($password) {
  return strlen($password) >= 6;
}

if (!emailCheck($_POST['email'])) {
  echo LoginError::BAD_EMAIL;
  exit;
}

if (!passwordCheck($_POST['password'])) {
  echo LoginError::BAD_PASSWORD;
  exit;
}

// validation done
require_once 'database.php';

try {
  $pdo = new PDO(
    "mysql:host=localhost;" .
    "dbname=" . $db['database'],
    $db['user'],
    $db['password']
  );
} catch (PDOException $e) {
  exit("Error:" . $e->getMessage());
}

// get the user by the email address
$query = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$query->execute(array($_POST['email']));

$row = $query->fetch();
$query->closeCursor();
$query = null;

if ($row) {
  // if there is a user, check the password
  if (isset($row['password']) &&
    password_verify($_POST['password'], $row['password'])) {
      // if the password is good, redirect to dashboard
      session_start();
      $_SESSION['userEmail'] = $_POST['email'];
      $_SESSION['justLoggedIn'] = true;
      echo SUCCESS;
      exit;
    } else {
      echo LoginError::INVALID_CREDENTIALS;
      exit;
    }
} else {
  // no account was found so create a new one
  $query = $pdo->prepare(
    "INSERT INTO users (email, password, createdDate, lastLoginDate) " .
    "VALUES (?, ?, NOW(), NOW())"
  );
  $query->execute(array(
    // consider emails to be unique and case-insensitive
    strtolower($_POST['email']),
    password_hash($_POST['password'], PASSWORD_DEFAULT)
  ));
  $query->closeCursor();
  $query = null;

  // redirect to dashboard page
  session_start();
  $_SESSION['userEmail'] = $_POST['email'];
  $_SESSION['justLoggedIn'] = true;
  $_SESSION['accountCreated'] = true;
  echo SUCCESS;
  exit;
}
$pdo = null;

?>
