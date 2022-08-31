<?php
function loopcheckworkorderstatus($data,$findid){
    for($i=0;$i<=count($data)-1;$i++){
        if($findid == $data[$i]['id']){
            return $data[$i]['name'];
        }
    }
}
function getWorkorderStatus($id){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>0,'name'=>'รับคำสั่งซ่อม'],
        ['id'=>1,'name'=>'ตรวจสอบรับเครื่อง'],
        ['id'=>2,'name'=>'เสนอราคา'],
        ['id'=>3,'name'=>'กำลังซ่อม'],
        ['id'=>4,'name'=>'ซ่อมเสร็จรอส่ง'],
        ['id'=>5,'name'=>'กำลังส่งคืน'],
        ['id'=>6,'name'=>'ซ่อมสำเร็จ'],
        ['id'=>7,'name'=>'ยกเลิก'],

    ];
    $name = '';
    if($id >= 0 ){
        $name = loopcheckworkorderstatus($data,$id);
    }
    return $name;
}
function getWorkorderStatusData(){
    $data=[
        ['id'=>0,'name'=>'รับคำสั่งซ่อม'],
        ['id'=>1,'name'=>'ตรวจสอบรับเครื่อง'],
        ['id'=>2,'name'=>'เสนอราคา'],
        ['id'=>3,'name'=>'กำลังซ่อม'],
        ['id'=>4,'name'=>'ซ่อมเสร็จรอส่ง'],
        ['id'=>5,'name'=>'กำลังส่งคืน'],
        ['id'=>6,'name'=>'ซ่อมสำเร็จ'],
        ['id'=>7,'name'=>'ยกเลิก'],
    ];
    return $data;
}
?>
