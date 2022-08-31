<?php
function loopcheckquotationStatus($data,$findid){
    for($i=0;$i<=count($data)-1;$i++){
        if($findid == $data[$i]['id']){
            return $data[$i]['name'];
        }
    }
}
function getQuotationStatus($id){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>0,'name'=>'เปิด'],
        ['id'=>1,'name'=>'ยืนยัน'],
        ['id'=>2,'name'=>'ยกเลิก'],

    ];
    $name = '';
    if($id >= 0 ){
        $name = loopcheckquotationStatus($data,$id);
    }
    return $name;
}
function getQuotationStatusData(){
    $data=[
        ['id'=>0,'name'=>'เปิด'],
        ['id'=>1,'name'=>'ยืนยัน'],
        ['id'=>2,'name'=>'ยกเลิก'],
    ];
    return $data;
}
?>
