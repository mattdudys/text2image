<?php

function showTransparentGif() {
    header('Content-Type: image/gif');
    // reference: http://stackoverflow.com/a/30664750
    die("\x47\x49\x46\x38\x39\x61\x01\x00\x01\x00\x90\x00\x00\xff\x00\x00\x00\x00\x00\x21\xf9\x04\x05\x10\x00\x00\x00\x2c\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x04\x01\x00\x3b");
}

$request_uri = $_SERVER['REQUEST_URI'];

$should_cache = strpos($request_uri, "cache") !== false;
$should_redirect = strpos($request_uri, "redirect/") !== false;

$last_modified = intval(time() / 60) * 60;
$header_last_modified = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) : null;
$header_if_none_matched = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? $_SERVER['HTTP_IF_NONE_MATCH'] : null;
$etag = '"' . md5($request_uri . $last_modified) . '"';

error_log(print_r($_SERVER, true));
error_log("should_cache: $should_cache");
error_log("should_redirect: $should_redirect");
error_log("last_modified: $last_modified");
error_log("ETag: $etag");

// Caching
if (!$should_cache || $should_redirect) {
    error_log("don't cache");
    header("Cache-Control: no-cache, no-store");
} else if (($header_last_modified != null && $last_modified <= $header_last_modified) || ($header_if_none_matched != null && $header_if_none_matched == $etag)) {
    error_log("304 not modified");
    header("HTTP/1.1 304 Not Modified");
    header("Cache-Control: max-age=0, s-maxage=60");
    header("ETag: $etag");
    exit;
} else {
    error_log("cache it");
    header("Cache-Control: max-age=0, s-maxage=60");
    header("ETag: $etag");
    header("Last-Modified: " . gmdate('D, d M Y H:i:s', $last_modified).' GMT');
}

// Redirect
if ($should_redirect) {
    header("Location: " . str_replace("redirect/", "", $request_uri));
    exit;
}

// Generate the image
//showTransparentGif();

header("Content-Type: image/gif");

$text = $request_uri;
$font = 3;
$width = imagefontwidth($font) * strlen($text);
$height = imagefontheight($font);

$im = imagecreate($width, $height);
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);

imagestring($im, $font, 0, 0, $text, $black);

imagegif($im);
