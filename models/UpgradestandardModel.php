<?php
function getUpgradeStandardModel($connect, $id)
{
    $data = [];
    $query = "SELECT * FROM upgrade_standard";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data,
                [
                    'id' => $row['id'],
                    'member_type_id' => $row['member_type_id'],
                    'parent_1' => $row['parent_1'],
                    'parent_1_rate' => $row['parent_1_rate'],
                    'parent_2' => $row['parent_2'],
                    'parent_2_rate' => $row['parent_2_rate'],
                ]);
        }
    }

    return $data;
}
function getPointStandardModel($connect, $id)
{
    $data = [];
    $query = "SELECT * FROM point_cal_standard";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data,
                [
                    'id' => $row['id'],
                    'member_type_id' => $row['member_type_id'],
                    'parent_1' => $row['parent_type_id'],
                    'parent_2' => $row['parent_type_2_id'],
                ]);
        }
    }

    return $data;
}
?>
