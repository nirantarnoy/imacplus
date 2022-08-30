<?php
ob_start();
session_start();

if(!isset($_SESSION['userid'])){
    // header("location:loginpage.php");
}
include("common/dbcon.php");
include("models/StatusModel.php");
include("models/UserModel.php");

$query_filter = '';
$member_id = getMemberFromUser($_SESSION['userid'], $connect);

$query = "SELECT * FROM sparepart_stock WHERE id > 0 AND member_id='$member_id'";
//if(isset($_POST["member_id"])){
//    $query .= ' AND member_id'.$_POST["region_name"].'%" AND ';
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

$i = 0;
$data = array();
$filtered_rows = $statement->rowCount();
foreach ($result as $row){

    $i++;
    //$branch_name = $row['branch'];
    $sub_array = array();
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['sparepart_id'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['sparepart_id'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['description'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['qty'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.getStatus($row['status']).'</p>';

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
