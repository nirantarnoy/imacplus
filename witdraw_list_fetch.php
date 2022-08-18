<?php
ob_start();
session_start();

if(!isset($_SESSION['userid'])){
    // header("location:loginpage.php");
}
include("common/dbcon.php");
include("models/WalletStatus.php");
include("models/MemberModel.php");
include("models/UserModel.php");

$userid = $_SESSION['userid'];
$member_id = getMemberIDFromUser($connect, $userid);
$query_filter = '';
$query = '';

if(checkUserAdmin($connect , $userid) == 1){
    $query = "SELECT * FROM witdraw_trans WHERE id > 0";
}else{
    $query = "SELECT * FROM witdraw_trans where member_id=".$member_id;
}


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
    $i++;
    $sub_array = array();

    $sub_array[] = '<p style="text-align: center;">'.$i.'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['trans_no'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['trans_date'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$row['witdraw_amount'].'</p>';
    $sub_array[] = '<p style="font-weight: ;text-align: left">'.$status_color.'</p>';
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
