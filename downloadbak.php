<?php
ob_start();
session_start();
$id= $_GET['id'];
if ($id != '') {
    $filepath = "uploads/db_backup/" . $id;

    // Process download
    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        die();
    } else {
        // echo "no";return;
        http_response_code(404);
        die();
    }
}
header('location:backuplist.php');

?>
