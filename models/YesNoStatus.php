<?php
function loopcheckYesNostatus($data,$findid){
    for($i=0;$i<=count($data)-1;$i++){
        if($findid == $data[$i]['id']){
            return $data[$i]['name'];
        }
    }
}
function getYesNoStatus($id){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>1,'name'=>'Yes'],
        ['id'=>0,'name'=>'No'],
    ];
    $name = '';
    if($id >= 0 ){
        $name = loopcheckYesNostatus($data,$id);
    }
    return $name;
}
function getYesNoStatusData(){
    $data=[
        ['id'=>1,'name'=>'Yes'],
        ['id'=>0,'name'=>'No'],
    ];
    return $data;
}
?>
