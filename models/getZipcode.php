<?php
include("../common/dbcon.php");

$city_id = 0;

if(isset($_POST['city_id'])){
    $city_id = $_POST['city_id'];
}
$html = '';
if($city_id > 0){
    $query = "SELECT * FROM amphur WHERE AMPHUR_ID='$city_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            $html = $row['POSTCODE'];

        }
    }
}

echo $html;
?>