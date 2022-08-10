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
function getOrderLastNo($connect){
    $query = "SELECT MAX(work_no) as code FROM workorders WHERE work_no <>''";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    $runno = substr(date('Y'),2,2);
    $new = 0;
    //return $filtered_rows;
    if($filtered_rows > 0){
        foreach($result as $row){
            if($row['code'] == ''){
                return $runno.'00001';
            }
            $new = (int)substr($row['code'],2,5) +1;
            $diff = 5-strlen($new);
            for($i=0;$i<=$diff-1;$i++){
                $runno = $runno.'0';
            }
        }
        return $num = $runno.$new;
    }else{
        return $runno.'00001';
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


?>