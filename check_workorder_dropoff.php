<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");
include("models/MemberModel.php");

if (!isset($_SESSION['userid'])) {
    header("location:loginpage.php");
}

$work_no = '';


if (isset($_POST['work_no'])) {
    $work_no = $_POST['work_no'];
}


//print_r($action);return;
$data = [];
if ($work_no != '') {
    $query = "SELECT * FROM workorders WHERE work_no='$work_no' and status = 0";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $is_vip = getMemberTypeVIPSHOP($row['created_by']);
            array_push($data, ['is_vipshop' => $is_vip, 'has_order' => 1]);
        }
    } else {
        array_push($data, ['is_vipshop' => 0, 'has_order' => 0]);
    }

   // array_push($data, ['is_vipshop' => 0, 'has_order' => $query]);
}
echo json_encode($data);
?>
