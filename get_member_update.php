<?php
include("common/dbcon.php");
//include("models/MemberModel.php");

$id = '';
$data = [];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

if ($id) {
    $query = "SELECT * FROM member WHERE id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $filtered_rows = $statement->rowCount();
//    foreach ($result as $row) {
//       array_push($data,['id'=>$row['id'],'display_name'=>$row['display_name'],'username'=>$row['username'],'status'=>$row['status'],'use_start'=>$row['use_start'],'use_end'=>$row['use_end'],
//           'branch_price'=>$row['branch_price'],'is_dash'=>$row['is_dashboard'],'is_prod'=>$row['is_product']
//           ,'is_return'=>$row['is_return'],'is_history'=>$row['is_history'],'is_customer'=>$row['is_customer']
//           ,'is_tool'=>$row['is_tool'],'is_user'=>$row['is_user'],'is_all'=>$row['is_all']]);
//    }
    foreach ($result as $row) {
        $last_turnover = getLastTurnoverAmt($id,$connect);
        $last_turnover_date = getLastTurnoverDate($id,$connect);
        $count_turnover = getTurnovercount($id,$connect);

        $last_pro_name = getLastProName($id,$connect);
        $last_pro = getLastProDate($id,$connect);
        $last_pro_count = getProcount($id,$connect);

        $cash_total = getCash($id,$connect);

        array_push($data,[
            'id'=>$row['id'],
            'fname'=>$row['first_name'],
            'lname'=>$row['last_name'],
            'zone_id'=>$row['zone_id'],
            'parent_id'=>$row['parent_id'],
            'member_type_id'=>$row['member_type_id'],
            'phone'=>$row['phone_number'],
            'email'=>$row['email'],
            'line_id'=>$row['line_id'],
            'url'=>$row['url'],
            'point'=>$row['point'],
            'status'=>$row['status'],
            'address_data' => getCenterAddress($connect, $row['id']),

        ]);
    }

    echo json_encode($data);
}else{
    echo json_encode($data);
}

function getCenterAddress($connect, $center_id){
    $data = [];
    if($center_id > 0){
        if(checkIsCenter($connect, $center_id) == 1){
            $query = "SELECT t1.address,t1.street,t1.district_id,t1.city_id,t1.province_id,t1.zipcode FROM center_address as t1 WHERE member_id='$center_id'";
            $statement = $connect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            $filtered_rows = $statement->rowCount();
            if ($filtered_rows > 0) {
                foreach ($result as $row) {
                   array_push($data,[
                       'address'=>$row['address'],
                       'street'=>$row['street'],
                       'district_id'=>$row['district_id'],
                       'city_id'=>$row['city_id'],
                       'province_id'=>$row['province_id'],
                       'zipcode'=>$row['zipcode'],
                       'phone'=>$row['phone'],
                   ]);
                }

            }
        }else{
            array_push($data,[
                'address'=>'xx',
                'street'=>'',
                'district_id'=>'',
                'city_id'=>'',
                'province_id'=>'',
                'zipcode'=>'',
                'phone'=>'',
            ]);
        }

    }

    return $data;
}
function checkIsCenter($connect, $member_id)
{
    $iscenter = 0;
    $member_type_id = 0;
    $query = "SELECT * FROM member WHERE id = '$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $member_type_id = $row['member_type_id'];
        }

        $query2 = "SELECT * FROM member_type WHERE id = '$member_type_id'";
        $statement2 = $connect->prepare($query2);
        $statement2->execute();
        $result2 = $statement2->fetchAll();
        $filtered_rows2 = $statement2->rowCount();
        //return $filtered_rows;
        if ($filtered_rows2 > 0) {
            $find_word = 'MINI';
            foreach ($result2 as $row2) {
                $is_mini = strpos($row2['name'], $find_word)!== false?1:0;
                if($row2['is_center'] == 1 || $is_mini > 0 ){
                    $iscenter = 1;
                }

            }
        }
    }


    return $iscenter;
}

function getLastTurnoverAmt($member_id, $connect)
{
    $last_turnover = 0;
    $query = "SELECT turnover FROM member_account WHERE member_id='$member_id' and turnover > 0 ORDER BY id DESC LIMIT 1 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $last_turnover = $row['turnover'];
    }

    return $last_turnover;
}
function getLastTurnoverDate($member_id, $connect)
{
    $last_turnover = '';
    $query = "SELECT trans_date FROM member_account WHERE member_id='$member_id' and turnover > 0 ORDER BY id DESC LIMIT 1 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $last_turnover = $row['trans_date'];
    }

    return $last_turnover;
}
function getTurnovercount($member_id, $connect)
{
    $cnt = 0;
    $query = "SELECT count(*) as cnt FROM member_account WHERE member_id='$member_id' and turnover > 0 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $cnt = $row['cnt'];
    }

    return $cnt;
}


function getLastProName($member_id, $connect)
{
    $last_turnover = '';
    $query = "SELECT promotion_id FROM member_account WHERE member_id='$member_id' and cash_in > 0 and promotion_id > 0 ORDER BY id DESC LIMIT 1 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $last_turnover = getPromotionname($connect,$row['promotion_id']);
    }

    return $last_turnover;
}
function getLastProDate($member_id, $connect)
{
    $last_turnover = '';
    $query = "SELECT trans_date FROM member_account WHERE member_id='$member_id' and cash_in > 0 and promotion_id > 0 ORDER BY id DESC LIMIT 1 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $last_turnover = $row['trans_date'];
    }

    return $last_turnover;
}
function getProcount($member_id, $connect)
{
    $cnt = 0;
    $query = "SELECT count(*) as cnt FROM member_account WHERE member_id='$member_id' and cash_in > 0 and promotion_id > 0 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $cnt = $row['cnt'];
    }

    return $cnt;
}

function getCash($member_id, $connect)
{
    $data = [];
    $query = "SELECT SUM(cash_in) as cash_in,SUM(cash_out) as cash_out,SUM(net_win) as net_win FROM member_account WHERE member_id='$member_id'";
//    if ($promotion_id > 0) {
//        $query .= " AND promotion_id='$promotion_id' ";
//    }
//    if ($f_date != null && $t_date != null) {
//        $query .= " AND (date(trans_date) >='$f_date' AND date(trans_date) <='$t_date') ";
//    }
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        array_push($data, ['cash_in' => number_format($row['cash_in']), 'cash_out' => number_format($row['cash_out']), 'net_win' => number_format($row['net_win'])]);
    }

    return $data;
}


?>
