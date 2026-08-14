<?php
// Serves screenshots saved outside public_html (see submit.php) since they
// aren't reachable by a direct URL anymore.
$file = isset($_GET["file"]) ? basename($_GET["file"]) : "";

if ($file === "") {
    http_response_code(404);
    exit("Not found");
}

$path = dirname(__DIR__) . "/screenshot_storage/" . $file;

if (!is_file($path)) {
    http_response_code(404);
    exit("Not found");
}

$mimeType = function_exists("mime_content_type") ? mime_content_type($path) : "application/octet-stream";

header("Content-Type: " . $mimeType);
header("Content-Length: " . filesize($path));
header("Cache-Control: private, max-age=86400");
readfile($path);
