<?php
ob_start();
session_start();

if(!isset($_SESSION['userid'])){
    // header("location:loginpage.php");
}
include("common/dbcon.php");
//include("models/ServiceModel.php");

$brand_id = $_POST['id'];
$html = '';

if($brand_id!=null){
    $query = "SELECT * FROM item WHERE brand_id='$brand_id' ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $data = array();
    $filtered_rows = $statement->rowCount();
    $html.='<option>--เลือกรุ่น--</option>';
    foreach ($result as $row){
       $html.='<option value="'.$row["id"].'">';
       $html.=$row["model"];
       $html.='</option>';
    }

}
echo $html;

?>
