<?php
ob_start();
session_start();
include("common/dbcon.php");

$province_id = 0;
$html = '';

if(isset($_POST['province_id'])){
    $province_id = $_POST['province_id'];
}

if ($province_id > 0) {
    $query = "SELECT t2.id,t2.first_name,t2.last_name FROM member_address as t1 LEFT JOIN member as t2 ON t1.member_id = t2.id WHERE province_id='$province_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            $html.='<tr>';
            $html .= '<td style="text-align: center">
                        <div class="btn btn-outline-success btn-sm" onclick="addselecteditem($(this))" data-var="' . $row['id'] . '">เลือก</div>
                        <input type="hidden" class="line-find-name" value="' . $row['first_name'].' '.$row['last_name']. '">
                       </td>';
            $html.='<td><input type="hidden" class="line-center-id" value="'.$row['id'].'">'.$row['first_name'].$row['last_name'].'</td>';
            $html.='</tr>';
        }
    }else{
        $html.='<tr>';
        $html.='<td colspan="2" style="text-align: center;"><p style="color: red;">ไม่พบข้อมูล</p></td>';
        $html.='</tr>';
    }
}
echo $html;
?>
