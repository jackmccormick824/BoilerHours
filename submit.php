<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed");
}

$to      = "contact@boilerhours.com";
$course  = isset($_POST["course"]) ? strip_tags(trim($_POST["course"])) : "";
$name    = isset($_POST["name"])   ? strip_tags(trim($_POST["name"]))   : "Anonymous";

if (!$course) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "Course is required"]);
    exit;
}

$subject = "Office Hours Submission: $course";

// ── Handle optional photo attachment ─────────────────────────────────────────
$boundary = md5(time());
$headers  = "From: contact@boilerhours.com\r\n";
$headers .= "Reply-To: contact@boilerhours.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";

if (!empty($_FILES["photo"]["tmp_name"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
    $filename    = basename($_FILES["photo"]["name"]);
    $filetype    = mime_content_type($_FILES["photo"]["tmp_name"]);
    $filedata    = chunk_split(base64_encode(file_get_contents($_FILES["photo"]["tmp_name"])));

    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    $body  = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
    $body .= "Course: $course\r\n";
    $body .= "Submitted by: $name\r\n";
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: $filetype; name=\"$filename\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$filename\"\r\n\r\n";
    $body .= "$filedata\r\n";
    $body .= "--$boundary--";
} else {
    // No photo — plain text email
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body  = "Course: $course\r\n";
    $body .= "Submitted by: $name\r\n";
    $body .= "(No photo attached)\r\n";
}

$sent = mail($to, $subject, $body, $headers);

header("Content-Type: application/json");
if ($sent) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Mail failed to send"]);
}
?>
