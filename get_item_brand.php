<?php
ob_start();
session_start();

if (!isset($_SESSION['userid'])) {
    // header("location:loginpage.php");
}
include("common/dbcon.php");
//include("models/ServiceModel.php");

$model_id = $_POST['id'];
$html = '';

if ($model_id != null) {
    $query = "SELECT * FROM item WHERE id='$model_id' ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $data = array();
    $filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        $html = $row["brand_id"];
    }

}
echo $html;

?>
