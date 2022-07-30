<?php
include("common/dbcon.php");
include("models/ItemModel.php");
$id = '';
$data = [];
$html= '';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

//if () {
    $query = "SELECT * FROM item WHERE id > 0 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        $html .= '<tr>';
        $html .= '<td style="text-align: center">
                        <div class="btn btn-outline-success btn-sm" onclick="addselecteditem($(this))" data-var="' . $row['id'] . '">เลือก</div>
                        <input type="hidden" class="line-find-model" value="' . $row['model']. '">
                        <input type="hidden" class="line-find-name" value="' . $row['name'] . '">
                        <input type="hidden" class="line-find-type" value="' . $row['device_type'] . '">
                        <input type="hidden" class="line-find-brand" value="' . $row['brand_id'] . '">
                       </td>';
        $html .= '<td>' . $row['model'] . '</td>';
        $html .= '<td>' . $row['name'] . '</td>';
        $html .= '<td>' . getDeviceTypeName($row['device_type'],$connect) . '</td>';
        $html .= '<td>' . getItemBrandName($row['brand_id'],$connect) . '</td>';
        $html .= '</tr>';
    }

    echo $html;
//}else{
//    echo $html;
//}


?>
