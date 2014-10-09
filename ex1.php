<?php
/*
 * ex1.php
 *
 * CLI program which requests a YouTube URL upon startup.
 *
 * After validating the URL output a formatted JSON array containing title,
 * description, and view and rating statistics.
 *
 * Consumes the YouTube Analytics API.
 *
 */
if ($argc > 2) {
  echo "Usage: ex1.php [youtube URL]\n";
  exit;
}
$url = '';
if (array_key_exists(1, $argv)) {
  $url = $argv[1];
} else {
  echo "Please enter a YouTube URL: ";
  $fh = fopen("php://stdin", "r");
  $url = trim(fgets($fh));
  fclose($fh);
}
echo $url;
?>
