<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed");
}

header("Content-Type: application/json");

if (!file_exists(__DIR__ . "/db_connect.php")) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Server isn't configured yet."]);
    exit;
}

require_once __DIR__ . "/db_connect.php";

function fail($msg) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => $msg]);
    exit;
}

$full_name      = isset($_POST["full_name"])      ? trim($_POST["full_name"])      : "";
$purdue_email   = isset($_POST["purdue_email"])   ? trim($_POST["purdue_email"])   : "";
$professor_name = isset($_POST["professor_name"]) ? trim($_POST["professor_name"]) : "";
$course_name    = isset($_POST["course_name"])    ? trim($_POST["course_name"])    : "";
$venmo_handle   = isset($_POST["venmo_handle"])   ? trim($_POST["venmo_handle"])   : "";

if ($full_name === "")      fail("Full name is required.");
if ($purdue_email === "")   fail("Purdue email is required.");
if (!filter_var($purdue_email, FILTER_VALIDATE_EMAIL)) fail("Please enter a valid email address.");
if ($professor_name === "") fail("Professor name is required.");
if ($course_name === "")    fail("Course name is required.");

if (empty($_FILES["screenshot"]["tmp_name"]) || $_FILES["screenshot"]["error"] !== UPLOAD_ERR_OK) {
    fail("A screenshot of the office hours is required.");
}

$file = $_FILES["screenshot"];

if ($file["size"] > 5 * 1024 * 1024) {
    fail("Screenshot must be under 5MB.");
}

$allowedTypes = [
    "image/jpeg" => "jpg",
    "image/png"  => "png",
    "image/gif"  => "gif",
    "image/webp" => "webp",
    "application/pdf" => "pdf",
];
$mimeType = mime_content_type($file["tmp_name"]);
if (!isset($allowedTypes[$mimeType])) {
    fail("Screenshot must be an image or PDF.");
}
$ext = $allowedTypes[$mimeType];

$uploadDir = __DIR__ . "/uploads/screenshots/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$safeName = preg_replace("/[^A-Za-z0-9_-]/", "_", pathinfo($file["name"], PATHINFO_FILENAME));
$filename = time() . "_" . $safeName . "." . $ext;
$destPath = $uploadDir . $filename;

if (!move_uploaded_file($file["tmp_name"], $destPath)) {
    fail("Could not save the uploaded screenshot.");
}

$screenshot_path = "uploads/screenshots/" . $filename;

try {
    $stmt = $conn->prepare(
        "INSERT INTO submissions (full_name, purdue_email, professor_name, course_name, screenshot_path, venmo_handle)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    if (!$stmt) {
        throw new Exception($conn->error);
    }
    $stmt->bind_param(
        "ssssss",
        $full_name,
        $purdue_email,
        $professor_name,
        $course_name,
        $screenshot_path,
        $venmo_handle
    );
    $stmt->execute();
    $stmt->close();
    $conn->close();
    echo json_encode(["success" => true]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => "Database error: " . $e->getMessage()]);
}
?>
