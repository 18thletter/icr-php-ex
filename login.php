<?php
// Enums to hold return values
abstract class LoginError {
  const NO_USERNAME = 0;
  const NO_PASSWORD = 1;
  const BAD_PASSWORD = 2;
}

// check the post
if (!isset($_POST['username']) || empty($_POST['username'])) {
  echo LoginError::NO_USERNAME;
  exit;
}
if (!isset($_POST['password']) || empty($_POST['password'])) {
  echo LoginError::NO_PASSWORD;
  exit;
}

// maybe some password restrictions can go here. right now I'm only
// checking that the password is at least 6 characters
function passwordCheck($password) {
  return strlen($password) >= 6;
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
$query = $pdo->prepare("SELECT * FROM users WHERE username = ?");
if ($query->execute(array($_POST['username']))) {
  $row = $query->fetch();
  if ($row) {
    print_r($row);
  } else {
    echo "no account found";
  }
}
$pdo = null;

?>
