<?php

# Replace base with your ngrok domain. Use img and simg to generate http and https img tags.

$base = "b82f8eb6.ngrok.io";

function img($path) {
    global $base;
    echo "<img src=\"http://$base/$path\" /><br/>\n";
}

function simg($path) {
    global $base;
    echo "<img src=\"https://$base/$path\" /><br/>\n";
}

img("http");
simg("https");
