<?php
include("../common/dbcon.php");

$province_id = 0;

if(isset($_POST['province_id'])){
    $province_id = $_POST['province_id'];
}
$html = '';
if($province_id > 0){
    $query = "SELECT * FROM amphur WHERE PROVINCE_ID='$province_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        $html.='<option value="-1">--เลือกอำเภอ--</option>';
        foreach($result as $row){
            $html.='<option value="'.$row['AMPHUR_ID'].'">'.$row['AMPHUR_NAME'];
            $html.='</option>';
        }
    }
}

echo $html;
?>