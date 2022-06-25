<?php
function loopcheckstatus($data,$findid){
    for($i=0;$i<=count($data)-1;$i++){
        if($findid == $data[$i]['id']){
            return $data[$i]['name'];
        }
    }
}
function getStatus($id){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>0,'name'=>'ไม่ใช้งาน'],
        ['id'=>1,'name'=>'ใช้งาน'],

    ];
    $name = '';
    if($id >= 0 ){
        $name = loopcheckstatus($data,$id);
    }
    return $name;
}
function getStatusData(){
    $data=[
        ['id'=>0,'name'=>'ไม่ใช้งาน'],
        ['id'=>1,'name'=>'ใช้งาน'],
    ];
    return $data;
}
?>
