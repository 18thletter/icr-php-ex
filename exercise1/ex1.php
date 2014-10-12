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

if (!isset($argc) || !isset($argv) && isset($_GET['url'])) {
  $url = $_GET['url'];
  // using a goto!! haha I couldn't resist. didn't want to refactor too much
  goto usingGET;
}

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

usingGET:
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
  if (!isset($parts['query']) ||
    !preg_match($regexQuery, $parts['query'], $matchesQuery)) {
      return false;
    }
  // preg_match should have stored the id in the match array
  return $matchesQuery[1];
}

$videoId = getVidId($url);

if (!$videoId) {
  exit("Please enter a valid YouTube URL.\n");
}

const YOUTUBE_DATA_API_URL = "https://www.googleapis.com/youtube/v3/";
define(
  'API_VIDEO_PARTS',
  "videos?part=" . urlencode("snippet,statistics") . "&fields=items(" .
  urlencode("snippet,statistics") . ")"
);
const API_KEY = "AIzaSyC2FMDLgP7s-EsuzoKtpipmYEw0BAVLwds";

$apiRequestUrl = YOUTUBE_DATA_API_URL . API_VIDEO_PARTS .
  "&id=" . $videoId .
  "&key=" . API_KEY;

// send the get request to the Google YouTube API and decode the resulting
// JSON
$data = json_decode(file_get_contents($apiRequestUrl));
if (empty($data->items)) {
  exit("No Result (probably invalid video ID)\n");
}

// form an array to encode into JSON
$jsonOutput = array();
$jsonOutput['title'] = $data->items[0]->snippet->title;
$jsonOutput['description'] = $data->items[0]->snippet->description;
$jsonOutput['viewCount'] = $data->items[0]->statistics->viewCount;
$jsonOutput['likeCount'] = $data->items[0]->statistics->likeCount;
$jsonOutput['dislikeCount'] = $data->items[0]->statistics->dislikeCount;

// output the results
echo json_encode($jsonOutput);
?>
