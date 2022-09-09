<?php
ob_start();
session_start();

if(!isset($_SESSION['userid'])){
    // header("location:loginpage.php");
}
include("common/dbcon.php");
include("models/WalletStatus.php");
include("models/MemberModel.php");
$query_filter = '';
$query = "SELECT * FROM member_upgrade where id > 0";

//if(isset($_POST["type_name"])){
//    $query .= 'proj_type LIKE "%'.$_POST["type_name"].'%" AND ';
//}
//if(isset($_POST["university_name"])){
//    $query .= 'dept_name LIKE "%'.$_POST["university_name"].'%" AND ';
//}
//if(isset($_POST["search"]["value"]))
//{
//    $query .= '(name LIKE "%'.$_POST["search"]["value"].'%"';
//    $query .= 'OR description LIKE "%'.$_POST["search"]["value"].'%") ';
//}
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

$i =0;
$data = array();
$filtered_rows = $statement->rowCount();
foreach ($result as $row){

    //$branch_name = $row['branch'];
    $status_color = ';color: black';
    if($row['status'] == 0){
        $status_color = '<span class="m-1 badge bgc-dark-l2 radius-round text-dark-tp4 px-3 text-90">
						'.getWalletStatus($row['status']).'
					</span>';
    }else if($row['status'] == 1){
        $status_color = '<span class="m-1 badge bgc-green-d3 radius-round text-white-tp1 px-3 text-90">
						'.getWalletStatus($row['status']).'
					</span>';
    }else if($row['status']==2){
        $status_color = '<span class="m-1 badge bgc-red-l1 radius-round text-dark-tp4 px-3 text-90">
						'.getWalletStatus($row['status']).'
					</span>';
    }

    $doc_ref = '<a href="uploads/memberupgrade/'.$row['transfer_doc'].'" target="_blank"><i class="fa fa-paperclip"></i> ไฟล์แนบ</a>';
    $i++;
    $sub_array = array();

    $sub_array[] = '<p style="text-align: center;">'.$i.'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['trans_no'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['trans_date'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.getMembername($connect,$row['member_id']).'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">VIP-SHOP</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['upgrade_amount'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$doc_ref.'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$status_color.'</p>';
    if($row['status'] != 1){
        $sub_array[] = '<div class="btn btn-success btn-sm" data-id="'.$row['id'].'" onclick="recAccept($(this))"><i class="fas fa-check-circle"></i> Accept</div><span> </span><div class="btn btn-danger btn-sm" data-id="'.$row['id'].'" onclick="recDecline($(this))"><i class="fas fa-ban"></i> Decline</div>';
    }else{
        $sub_array[] = '';
    }

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
