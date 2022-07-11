<?php
function loopcheckplatform($data,$findid){
    for($i=0;$i<=count($data)-1;$i++){
        if($findid == $data[$i]['id']){
            return $data[$i]['name'];
        }
    }
}
function getPlatformName($id){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>0,'name'=>'Offline'],
        ['id'=>1,'name'=>'Online'],

    ];
    $name = '';
    if($id >= 0 ){
        $name = loopcheckplatform($data,$id);
    }
    return $name;
}
function getPlatformData(){
    $data=[
        ['id'=>0,'name'=>'Offline'],
        ['id'=>1,'name'=>'Online'],
    ];
    return $data;
}
?>
