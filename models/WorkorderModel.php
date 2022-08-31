<?php
function getOrderMaxid($connect,$member_id){
    $query = "SELECT MAX(id) as id FROM workorders WHERE created_by = '$member_id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    $runno = '';
    $new = 0;
    //return $filtered_rows;
    if($filtered_rows > 0){
        foreach($result as $row){
            $num = $row['id'];
        }
        return $num;
    }else{
        return 0;
    }
}
function getOrderIdByNo($connect,$work_no){
    $query = "SELECT * FROM workorders WHERE work_no = '$work_no' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    if($filtered_rows > 0){
        foreach($result as $row){
            $num = $row['id'];
        }
        return $num;
    }else{
        return 0;
    }
}
function getOrderIdById($connect,$id){
    $query = "SELECT * FROM workorders WHERE id = '$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $data = [];
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($data,['id'=>$row['id'],
                'work_no'=>$row['work_no'],
                'work_date'=>$row['work_date'],
                'customer_name'=>$row['customer_name'],
                'device_type'=>$row['device_type'],
                'phone'=>$row['phone'],
                'brand'=>$row['brand_id'],
                'models'=>$row['phone_model_id'],
                'phone_color'=>$row['phone_color_id'],
                'customer_pass'=>$row['customer_pass'],
                'estimate_price'=>$row['estimate_price'],
                'pre_pay'=>$row['pre_pay'],
                'note'=>$row['note'],
                'status'=>$row['status'],
                'check_list'=> findchecklist($row['id'],$connect),
                'finish_date'=>date('d-m-Y', strtotime($row['estimate_finish'])),
            ]);
        }
        return $data;
    }else{
        return $data;
    }
}
function getOrderLastNo($connect){
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
    if($filtered_rows > 0){
        foreach($result as $row){
            if($row['code'] == ''){
                return $prefix.$runno.'000001';
            }
            $new = (int)substr($row['code'],5,6) +1;
            $diff = 5-strlen($new);
            for($i=0;$i<=$diff-1;$i++){
                $runno = $runno.'0';
            }
        }
        return $prefix.$runno.$new;
    }else{
        return $prefix.$runno.'000001';
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
        ['id' => 2, 'name'=>'ซ่อมเสร็จ']

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
        ['id' => 2, 'name'=>'ซ่อมเสร็จ']
    ];
    return $data;
}


function findchecklist($id, $connect){
    $data = [];
    $query = "SELECT * FROM workorder_line WHERE workorder_id='$id' ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        array_push($data,
            ['id'=>$row['id'],
                'check_list_id'=>$row['check_list_id'],
            ]);
    }
    return $data;
}
?>