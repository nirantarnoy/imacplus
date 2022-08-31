<?php
ob_start();
session_start();

//if(!isset($_SESSION['userid'])){
//    header("location:loginpage.php");
//}

include("common/dbcon.php");
include("models/StatusModel.php");
include("models/CustomerModel.php");
include("models/UserModel.php");

//$current_branch = '';
//if(isset($_SESSION['branch'])){
//    $current_branch = $_SESSION['branch'];
//}



$stock_type = 0;
$query_filter = '';
$query = "SELECT * FROM quotation ";
//if(isset($_POST["searchByName"])){
//    $query .= ' AND (quotation_no LIKE "%'.$_POST["searchByName"].'%" OR customer_name LIKE "%'.$_POST["searchByName"].'%")';
//}


if(isset($_POST["order"]))
{
//    if($_POST['order']['0']['column'] == 1){
//        $query .= ' ORDER BY quotation_no '.$_POST['order']['0']['dir'].' ';
//    }
//    if($_POST['order']['2']['column'] == 2){
//        $query .= ' ORDER BY quotation_date '.$_POST['order']['0']['dir'].' ';
//    }
//    if($_POST['order']['0']['column'] == 3){
//        $query .= ' ORDER BY status '.$_POST['order']['0']['dir'].' ';
//    }
//    if($_POST['order']['0']['column'] == 4){
//        $query .= ' ORDER BY created_by '.$_POST['order']['0']['dir'].' ';
//    }
//    if($_POST['order']['0']['column'] == 4){
//        $query .= ' ORDER BY index2 '.$_POST['order']['0']['dir'].' ';
//    }
//    if($_POST['order']['0']['column'] == 5){
//        $query .= ' ORDER BY index3 '.$_POST['order']['0']['dir'].' ';
//    }
//    if($_POST['order']['0']['column'] == 6){
//        $query .= ' ORDER BY grandtotal '.$_POST['order']['0']['dir'].' ';
//    }

    //   $query .= ' '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
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
$i=0;
foreach ($result as $row){
    $i+=1;
    $sub_array = array();

//    $sub_array[] = '<p style="font-weight: bold;text-align: left">'.$row['prod_code'].'</p>';
//    $sub_array[] = '<p style="font-weight: bold;text-align: left">'.$row['prod_name'].'</p>';
//    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['code'].'<input type="hidden" class="tool-code" value="'.$row['id'].'"></p>';
//    $sub_array[] = '<p style="font-weight: ;text-align: center">'.$i.'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['quotation_no'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.date('d/m/Y',strtotime($row['quotation_date'])).'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['customer_name'].'</p>';
//    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['customer_name'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.getStatus($row['status']).'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.getUserDisplayname($row['created_by'],$connect).'</p>';

//    $sub_array[] = '<p style="font-weight: bold;text-align: left">'.date('d/m/Y',strtotime($row['trans_date'])).'</p>';
    $sub_array[] = '<a class="btn btn-secondary" href="quotation_create.php?update_id='.$row['id'].'"><i class="fas fa-edit"></i> แก้ไข</a><span> </span><div class="btn btn-danger" data-id="'.$row['id'].'" onclick="recDelete($(this))"><i class="fas fa-trash-alt"></i> ลบ</div>';

    //asort($sub_array);
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
