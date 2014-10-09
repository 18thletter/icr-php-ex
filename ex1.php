<?php
/*
 * ex1.php
 *
 * CLI program which requests a YouTube URL upon startup.
 *
 * After validating the URL output a formatted JSON array containing title,
 * description, and view and rating statistics.
 *
 * Consumes the YouTube Data API.
 *
 */

// One optional argument that should be the URL
if ($argc > 2) {
  exit("Usage: ex1.php [YouTube Video URL]\n");
}

$url = '';

// Get the URL from the arguments passed in, or from stdin
if (array_key_exists(1, $argv)) {
  $url = $argv[1];
} else {
  echo "Please enter a YouTube URL: ";
  $fh = fopen("php://stdin", "r");
  $url = trim(fgets($fh));
  fclose($fh);
}


/**
 * Extract a YouTube video ID from a URL.
 *
 * Checks whether or not the URL passed is a valid YouTube video URL,
 * returning an error if the URL is not valid, and the video's ID
 * if it is.
 *
 * @param $url string the YouTube URL
 * @return the video ID if the URL is valid, FALSE if not
 */
function getVidId($url) {
  $regex = '/^https?:\/\/(?:www\.)?youtube\.com\/watch\?/';
  $parts = parse_url($url);

  // on really messed up URLs, parse_url can return FALSE
  if ($parts === false) {
    return false;
  }

  print_r($parts);

  // http:// or https://
  $regexScheme = '/^https?$/';
  if (!isset($parts['scheme']) || !preg_match($regexScheme, $parts['scheme'])) {
    return false;
  }

  // youtu.be or youtube.com with or without the www
  $regexHost = '/^(?:www\.)?(youtu\.be|youtube\.com)$/';
  if (!isset($parts['host']) || !preg_match($regexHost, $parts['host'])) {
    return false;
  }

  // /watch
  $regexPath = '/^\/watch$/';
  if (!isset($parts['path']) || !preg_match($regexPath, $parts['path'])) {
    return false;
  }

  // [optional_parameters &]v=[video-id][anything else]
  // video-id is 11 characters and can contain dashes (-)
  // a url may contain addition other options than v
  $regexQuery = '/^(?:.+&)?v=((\w|-){11,11})(?:\S+)?/';
  if (!isset($parts['query']) || !preg_match($regexQuery, $parts['query'], $matchesQuery)) {
    return false;
  }
  // preg_match should have stored the id in the match array
  return $matchesQuery[1];
}

$videoId = getVidId($url);

if (!$videoId) {
  exit("Please enter a valid YouTube URL.\n");
}

const API_KEY = "AIzaSyC2FMDLgP7s-EsuzoKtpipmYEw0BAVLwds";
?>
