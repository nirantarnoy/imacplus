<?php
function calmpoint($connect, $work_id){
   $member_id = 0;
   if($work_id){
       $member_id = findMember($connect, $work_id);
       $oldpoint = findMemberPoint($connect, $member_id);
   }
}
function findMember($connect, $work_id){
    $member_id = 0;
    if($work_id){
        $query = "SELECT * FROM workorders WHERE id='$work_id'";
        if ($result2 = $connect->query($query)) {
            foreach ($result2 as $row) {
                $member_id = $row['created_by'];
            }
        }
    }
    return $member_id;
}
function findMemberPoint($connect, $member_id){
    $point = 0;
    if($member_id){
        $query = "SELECT * FROM member WHERE id='$member_id'";
        if ($result2 = $connect->query($query)) {
            foreach ($result2 as $row) {
                $point = $row['point'];
            }
        }
    }
    return $point;
}
function updateMemberPoint($connect, $member_id, $point){
    if($member_id && $point >0){
        $sql = "UPDATE member SET point='$point' WHERE id='$member_id'";
        if ($connect->query($sql)) {
            return 1;
        } else {
            return 0;
        }
    }else{
        return 0;
    }
}
function findStandard($connect,$member_id, $work_id){
    $member_type = getMemberType($connect,$member_id);
    $query = "SELECT * FROM standard_part_price WHERE id='$member_id'";
    if ($result2 = $connect->query($query)) {
        foreach ($result2 as $row) {
            $point = $row['point'];
        }
    }
}
?>