<?php
ob_start();
session_start();

if(!isset($_SESSION['userid'])){
   // header("location:loginpage.php");
}
include("common/dbcon.php");
include("models/ProductTypeModel.php");
include("models/UnitModel.php");

$query_filter = '';
$query = "SELECT * FROM product WHERE id >0 ";
//if(isset($_POST["region_name"])){
//    $query .= 'region_name LIKE "%'.$_POST["region_name"].'%" AND ';
//}
//if(isset($_POST["type_name"])){
//    $query .= 'proj_type LIKE "%'.$_POST["type_name"].'%" AND ';
//}
//if(isset($_POST["university_name"])){
//    $query .= 'dept_name LIKE "%'.$_POST["university_name"].'%" AND ';
//}
if(isset($_POST["search"]["value"]))
{
    $query .= ' AND (name LIKE "%'.$_POST["search"]["value"].'%"';
    $query .= 'OR code LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR description LIKE "%'.$_POST["search"]["value"].'%") ';
}
if(isset($_POST["order"]))
{
    $query .= ' ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
    $query .= ' ORDER BY id ASC ';
}

$query_filter = $query;

if($_POST["length"] != -1)
{
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

$data = array();
$filtered_rows = $statement->rowCount();
$i = 0;
foreach ($result as $row){
    $i+=1;
    $islevel = 'No';
    $iscolor = 'red';
//    if($row['is_level2'] == 1){
//        $islevel='Yes';
//        $iscolor='Green';
//    }
    //$branch_name = $row['branch'];
    $sub_array = array();
    $sub_array[] = '<div class="btn btn-success btn-sm" onclick="getitem($(this))" data-var="'.$row['id'].'">เลือก</div>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['code'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['name'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.getTypename($connect,$row['cat_id']).'</p> <input type="hidden" class="price" value="'.$row['price_1'].'">';
   // $sub_array[] = '<p style="font-weight: ;text-align: left">'.getUnitname($connect,$row['unit_id']).'</p>';
//    $sub_array[] = '<p style="font-weight: ;text-align: right">'.number_format($row['stock_qty']).'</p>';
  //  $sub_array[] = '<div class="btn btn-secondary" data-id="'.$row['id'].'" onclick="showupdate($(this))"><i class="fas fa-edit"></i> Edit</div><span> </span><div class="btn btn-danger" data-id="'.$row['id'].'" onclick="recDelete($(this))"><i class="fas fa-trash-alt"></i> Delete</div>';

    $data[] = $sub_array;
}
$output = array(
    "draw"				=>	intval($_POST["draw"]),
    "recordsTotal"  	=>  $filtered_rows,
    "recordsFiltered" 	=> 	get_total_all_records($connect,$query_filter),
    "data"    			=> 	$data
);
echo json_encode($output);

function get_total_all_records($connect,$query)
{
    //   $statement = $connect->prepare("SELECT * FROM temp_test");
    $statement = $connect->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}
?>
