<?php
function loopcheckDeliveryType($data,$findid){
    for($i=0;$i<=count($data)-1;$i++){
        if($findid == $data[$i]['id']){
            return $data[$i]['name'];
        }
    }
}
function getDeliverTypeName($id){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>0,'name'=>'ส่งซ่อมเอง'],
        ['id'=>1,'name'=>'เรียกรถเข้ารับ'],

    ];
    $name = '';
    if($id >= 0 ){
        $name = loopcheckDeliveryType($data,$id);
    }
    return $name;
}
function getDeliveryTypeData(){
    $data=[
        ['id'=>0,'name'=>'ส่งซ่อมเอง'],
        ['id'=>1,'name'=>'เรียกรถเข้ารับ'],
    ];
    return $data;
}
?>
