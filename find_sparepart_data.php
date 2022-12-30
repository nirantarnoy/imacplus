<?php
ob_start();
session_start();
include("common/dbcon.php");

$html = '';

//if(isset($_POST['province_id'])){
//    $province_id = $_POST['province_id'];
//}

//if ($province_id > 0) {
    $query = "SELECT t1.id,t1.part_name,t1.cost_price,t1.sale_price,t1.description,t2.name,t3.qty FROM sparepart as t1 LEFT JOIN sparepart_type as t2 ON t1.part_type_id = t2.id LEFT JOIN sparepart_stock as t3 ON t1.id = t3.sparepart_id WHERE t1.id > 0 order by t1.part_type_id ASC ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
//    echo $query;return;
    if($filtered_rows > 0){
        foreach($result as $row){
            $html.='<tr>';
            $html .= '<td style="text-align: center">
                        <div class="btn btn-outline-success btn-sm" onclick="addselecteditem($(this))" data-var="' . $row['id'] . '">เลือก</div>
                        <input type="hidden" class="line-find-name" value="' . $row['part_name']. '">
                        <input type="hidden" class="line-find-description" value="' . $row['description']. '">
                        <input type="hidden" class="line-find-part-type" value="' . $row['name']. '">
                        <input type="hidden" class="line-find-qty" value="' . $row['qty'] . '">
                        <input type="hidden" class="line-find-price" value="' . $row['sale_price'] . '">
                        
                       </td>';
            $html .= '<td>' . $row['part_name'] . '</td>';
            $html .= '<td>' . $row['description'] . '</td>';
            $html .= '<td>' . $row['name'] . '</td>';
            $html .= '<td>' . $row['qty']. '</td>';
            $html .= '<td>' . $row['sale_price'] . '</td>';
            $html.='</tr>';
        }
    }else{
        $html.='<tr>';
        $html.='<td colspan="2" style="text-align: center;"><p style="color: red;">ไม่พบข้อมูล</p></td>';
        $html.='</tr>';
    }
//}
echo $html;
?>
