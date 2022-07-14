<?php
function loopcheckWalletstatus($data,$findid){
    for($i=0;$i<=count($data)-1;$i++){
        if($findid == $data[$i]['id']){
            return $data[$i]['name'];
        }
    }
}
function getWalletStatus($id){ //ชื่อฟังก์ชั่น
    $data=[
        ['id'=>0,'name'=>'รอดำเนินการ'],
        ['id'=>1,'name'=>'ดำเนินการสำเร็จ'],
        ['id'=>2,'name'=>'รายการถูกยกเลิก'],

    ];
    $name = '';
    if($id >= 0 ){
        $name = loopcheckWalletstatus($data,$id);
    }
    return $name;
}
function getWalletStatusData(){
    $data=[
        ['id'=>0,'name'=>'รอดำเนินการ'],
        ['id'=>1,'name'=>'ดำเนินการสำเร็จ'],
        ['id'=>2,'name'=>'รายการถูกยกเลิก'],
    ];
    return $data;
}
?>
