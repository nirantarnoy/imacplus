<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}

$id = 0;
$photo = null;


if (isset($_POST['recid'])) {
    $id = $_POST['recid'];
}


//print_r($action);return;

if ($id != null || $id !='') {
    $filename_final = '';
    if(isset($_FILES['photo_profile'])){
        $errors = array();
        $file_name = $_FILES['photo_profile']['name'];
        $file_tmp = $_FILES['photo_profile']['tmp_name'];
        $sourceProperties=getimagesize($file_tmp);
        $file_ex = explode(".", $file_name);
        $ext = end($file_ex);
        $file_name_new = time();
        $imageType=$sourceProperties[2];

        //print_r($sourceProperties);return;

        $imageSrc= imagecreatefromjpeg($file_tmp);
        $tmp= imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
        $filename_final = $file_name_new."_thump.".$ext;
        imagejpeg($tmp,'uploads/member_photo/'.$filename_final);


//        if (empty($errors) == true) {
//            // echo $file_name;return;
//            move_uploaded_file($file_tmp, 'uploads/member_photo/'.$file_name_new);
//            // echo "Success";return;
//        } else {
//            print_r($errors);
//        }
    }
    $created_at = time();
    $created_by = $userid;
    $sql = "UPDATE member set photo='$filename_final' WHERE id='$id'";
    if ($result = $connect->query($sql)) {
        $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
        header('location:profile.php');
    }
}

function imageResize($imageSrc,$imageWidth,$imageHeight) {

$newImageWidth=200;
$newImageHeight=250;

$newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

return $newImageLayer;
}

?>
