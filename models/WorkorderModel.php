<?php
//include "models/ItemModel.php";
include "models/PointCalculator.php";

function getOrderMaxid($connect, $member_id)
{
    $query = "SELECT MAX(id) as id FROM workorders WHERE created_by = '$member_id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    $runno = '';
    $new = 0;
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $num = $row['id'];
        }
        return $num;
    } else {
        return 0;
    }
}

function getOrderIdByNo($connect, $work_no)
{
    $query = "SELECT * FROM workorders WHERE work_no = '$work_no' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $num = $row['id'];
        }
        return $num;
    } else {
        return 0;
    }
}

function getWorkorderNo($connect, $id){
    $query = "SELECT * FROM workorders WHERE id = '$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $num = $row['work_no'];
        }
        return $num;
    } else {
        return '';
    }
}

function getOrderIdById($connect, $id)
{
    $query = "SELECT * FROM workorders WHERE id = '$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $data = [];
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, ['id' => $row['id'],
                'work_no' => $row['work_no'],
                'work_date' => $row['work_date'],
                'customer_name' => $row['customer_name'],
                'device_type' => $row['device_type'],
                'phone' => $row['phone'],
                'brand' => $row['brand_id'],
                'models' => $row['phone_model_id'],
                'phone_color' => $row['phone_color_id'],
                'customer_pass' => $row['customer_pass'],
                'estimate_price' => $row['estimate_price'],
                'pre_pay' => $row['pre_pay'],
                'note' => $row['note'],
                'status' => $row['status'],
                'center_id' => $row['center_id'],
                'delivery_type_id' => $row['delivery_type_id'],
                'check_list' => findchecklist($row['id'], $connect),
                'finish_date' => date('d-m-Y', strtotime($row['estimate_finish'])),
            ]);
        }
        return $data;
    } else {
        return $data;
    }
}

function getOrderLastNo($connect)
{
    $query = "SELECT MAX(work_no) as code FROM workorders WHERE work_no <>''";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    // $runno = substr(date('Y'),2,2);
    $runno = '';
    $new = 0;
    //return $filtered_rows;
    $prefix = 'iMPO-';
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            if ($row['code'] == '') {
                return $prefix . $runno . '000001';
            }
            $new = (int)substr($row['code'], 5, 6) + 1;
            $diff = 6 - strlen($new);
            for ($i = 0; $i <= $diff - 1; $i++) {
                $runno = $runno . '0';
            }
        }
        return $prefix . $runno . $new;
    } else {
        return $prefix . $runno . '000001';
    }
}

function loopcheckworkstatus($data, $findid)
{
    for ($i = 0; $i <= count($data) - 1; $i++) {
        if ($findid == $data[$i]['id']) {
            return $data[$i]['name'];
        }
    }
}

function getWOrkStatus($id)
{ //ชื่อฟังก์ชั่น
    $data = [
        ['id' => 0, 'name' => 'รับคำสั่งซ่อม'],
        ['id' => 1, 'name' => 'กำลังซ่อม'],
        ['id' => 2, 'name' => 'ซ่อมเสร็จ']

    ];
    $name = '';
    if ($id >= 0) {
        $name = loopcheckworkstatus($data, $id);
    }
    return $name;
}

function getWorkStatusData()
{
    $data = [
        ['id' => 0, 'name' => 'รับคำสั่งซ่อม'],
        ['id' => 1, 'name' => 'กำลังซ่อม'],
        ['id' => 2, 'name' => 'ซ่อมเสร็จ']
    ];
    return $data;
}

function getWorkorderData($connect, $id)
{
    $data = [];
    $member_id = getMemberIDFromUser($connect, $id);
    $query = "SELECT * FROM workorders WHERE created_by='$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, ['id' => $row['id'], 'work_no' => $row['work_no'], 'work_date' => $row['work_date'], 'status' => $row['status']]);
        }
    }
    return $data;
}

function getWorkorder($connect, $id)
{
    $data = [];
    $query = "SELECT * FROM workorders WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, [
                'id' => $row['id'],
                'work_no' => $row['work_no'],
                'work_date' => $row['work_date'],
                'phone_model_id' => getItemName($row['phone_model_id'], $connect),
                'status' => $row['status'],
            ]);
        }
    }
    return $data;
}

function findchecklist($id, $connect)
{
    $data = [];
    $query = "SELECT * FROM workorder_line WHERE workorder_id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        array_push($data,
            ['id' => $row['id'],
                'check_list_id' => $row['check_list_id'],
            ]);
    }
    return $data;
}

function getOrderNobyId($connect, $id)
{
    $query = "SELECT * FROM workorders WHERE id = '$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $num = $row['work_no'];
        }
        return $num;
    } else {
        return 0;
    }
}

function getCustomerfromOrderId($connect, $workorder_id)
{
    $query = "SELECT * FROM workorders WHERE id = '$workorder_id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $data = '';
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $data = $row['customer_name'];
        }
        return $data;
    } else {
        return '';
    }
}

function getPointtoday($connect, $member_id)
{
    $total = 0;
    $c_month = date('Y-m-d');
    $query = "SELECT * FROM workorders WHERE created_by = '$member_id' and date(work_date) ='$c_month' and status>=6 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $total = ($total + calmpointtrans($connect, $row['id']));
        }
    }
    return $total;
}

function getPointsevenday($connect, $member_id)
{
    $total = 0;
    $today = date('Y-m-d');
    $start_date = date('Y-m-d', strtotime(date('Y-m-d') . " -7 day"));
    $query = "SELECT * FROM workorders WHERE created_by = '$member_id' and date(work_date) >='$start_date' and date(work_date)<='$today' and status>=6  ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $total = ($total + calmpointtrans($connect, $row['id']));
        }
    }
    return $total;
}

function getPointthismonth($connect, $member_id)
{
    $total = 0;
    $c_month = date('m');
    $c_year = date('Y');
    $query = "SELECT * FROM workorders WHERE created_by = '$member_id' and month(work_date) ='$c_month' and year(work_date)='$c_year' and status>=6 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $total = ($total + calmpointtrans($connect, $row['id']));
        }
    }
    return $total;
}


function getPointTranstoday($connect, $member_id)
{
    $total = 0;
    $today = date('Y-m-d');
    $query = "SELECT SUM(trans_point) as trans_point FROM point_trans WHERE member_id = '$member_id' and date(trans_date) ='$today' and  activity_type = 1";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $total = $row['trans_point'];
        }
    }
    return $total;
}


function getPointTransSevenDay($connect, $member_id)
{
    $total = 0;
    $today = date('Y-m-d');
    $start_date = date('Y-m-d', strtotime(date('Y-m-d') . " -7 day"));
    $query = "SELECT SUM(trans_point) as trans_point FROM point_trans WHERE member_id = '$member_id' and date(trans_date) >='$start_date' and date(trans_date)<='$today' and activity_type = 1 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $total = $row['trans_point'];
        }
    }
    return $total;
}

function getPointTransthismonth($connect, $member_id)
{
    $total = 0;
    $c_month = date('m');
    $c_year = date('Y');
    $query = "SELECT SUM(trans_point) as trans_point FROM point_trans  WHERE member_id = '$member_id' and month(trans_date) ='$c_month' and year(trans_date)='$c_year' and activity_type = 1";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $total = $row['trans_point'];
        }
    }
    return $total;
}

function getPointall($connect, $member_id)
{
    $total = 0;
    $query = "SELECT * FROM workorders WHERE created_by = '$member_id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $total = ($total + calmpointtrans($connect, $row['id']));
        }
    }
    return $total;
}

function getCurrentPoint($connect, $member_id)
{
    $balance = 0;
    $query = "SELECT point FROM member WHERE id = '$member_id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();

    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $balance = $row['point'];
        }
    }
    return $balance;
}


function getPointbalance($connect, $member_id)
{

}

function getWorkorderPhoto($connect, $id)
{
    $data = [];
    $query = "SELECT * FROM workorder_photo WHERE workorder_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, ['id' => $row['id'], 'photo' => $row['photo']]);
        }
    }
    return $data;
}
function getQuotationId($connect, $id)
{
    $quotation_id = 0;
    $query = "SELECT * FROM quotation WHERE workorder_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $quotation_id =  $row['id'];
        }
    }
    return $quotation_id;
}
function getWorkorderVideo($connect, $id)
{
    $data = [];
    $query = "SELECT * FROM workorder_video WHERE workorder_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, ['id' => $row['id'], 'video' => $row['video']]);
        }
    }
    return $data;
}

?>