<?php
function calmpoint($connect, $work_id)
{
    $member_id = 0;
    $center_id = 0;
    $res = 0;
    if ($work_id) {

        $member_id = findMember($connect, $work_id);
        $center_id = findMemberCenter($connect, $work_id);
        $percent_rate = findStandardPer($connect, $member_id);
        $totalamount = looptrans($connect, $work_id);
        $oldpoint = findMemberPoint($connect, $member_id);

        //return $center_id;

        $new_point = 0;
        if ($totalamount > 0 && $percent_rate > 0) {
            $x = ($totalamount * $percent_rate) / 100;
            $new_point = ($oldpoint + $x);
        }

        // return $new_point;//

        if ($new_point > 0) {
            $member_old_all_point = getOldParentAllmPoint($connect, $member_id);
            $new_all_point = ($member_old_all_point + $new_point);
            $sql = "UPDATE member SET point='$new_point',all_point='$new_all_point' WHERE id='$member_id'"; // update member who created workorder

            if ($connect->query($sql)) {
                if ($center_id > 0) {
                    //return "ok";
                    $sql2 = '';
                    $center_old_point = getOldParentmPoint($connect, $center_id);
                    $center_percent_rate = findStandardPer($connect, $center_id);

                    $center_new_point = 0;
                    if ($totalamount > 0 && $center_percent_rate > 0) {
                        $x = ($totalamount * $center_percent_rate) / 100;
                        $center_new_point = ($center_old_point + $x);
                    }
                    $center_old_all_point = getOldParentAllmPoint($connect, $center_id);
                    $center_all_point = ($center_old_all_point + $center_new_point);
                    if ($center_new_point > 0) {
                        $sql2 = "UPDATE member SET point='$center_new_point',all_point='$center_all_point' WHERE id='$center_id'";
                        if ($connect->query($sql2)) {
                            $res = 1;
                        }
                    }
                    // return $sql2;
                }
                $res = 1;
            } else {
                $res = 0;
            }
        } else {
            return 0;
        }

        // cal parent mpoint

        $parent = findParent1($connect, $member_id);
        $parent_2_id = findParent1($connect, $parent);

        if ($parent > 0 && $parent_2_id > 0) {
            //parent 1
            if(checkIsCenter($connect, $parent) == 0){ // check if not center
                $parent_old_point = getOldParentmPoint($connect, $parent);
                $parent_percent_rate = findPointStandardPer($connect, $member_id, $parent); // send created user for find rate of parent level 1

                $parent_new_point = 0;
                if ($totalamount > 0 && $parent_percent_rate > 0) {
                    $x = ($totalamount * $parent_percent_rate) / 100;
                    $parent_new_point = ($parent_old_point + $x);
                }
                if ($parent_new_point > 0) {
                    $parent_old_all_point = getOldParentAllmPoint($connect, $parent);
                    $parent_all_point = ($parent_old_all_point + $parent_new_point);
                    $sql = "UPDATE member SET point='$parent_new_point',all_point='$parent_all_point' WHERE id='$parent'";
                    if ($connect->query($sql)) {
                        if(createMpointTrans($connect,$parent,$parent_new_point,2)){
                            $res = 1;
                        }
                    }
                }
            }

            // parent 2
            if(checkIsCenter($connect, $parent_2_id) == 0) { // check if not center
                $parent2_old_point = getOldParentmPoint($connect, $parent_2_id);
                $parent2_percent_rate = findPointStandardPerLevel2($connect, $member_id, $parent_2_id); // send created user for find rate of parent level 2

                $parent2_new_point = 0;
                if ($totalamount > 0 && $parent2_percent_rate > 0) {
                    $x = ($totalamount * $parent2_percent_rate) / 100;
                    $parent2_new_point = ($parent2_old_point + $x);
                }
                if ($parent2_new_point > 0) {
                    $parent2_old_all_point = getOldParentAllmPoint($connect, $parent_2_id);
                    $parent2_all_point = ($parent2_old_all_point + $parent2_new_point);
                    $sql = "UPDATE member SET point='$parent2_new_point',all_point='$parent2_all_point' WHERE id='$parent_2_id'";
                    if ($connect->query($sql)) {
                        if(createMpointTrans($connect,$parent_2_id,$parent2_new_point,2)){
                            $res = 1;
                        }
                    }
                }
            }

        } elseif ($parent > 0 && $parent_2_id <= 0) {
            $parent_old_point = getOldParentmPoint($connect, $parent);
            $parent_percent_rate = findPointStandardPer($connect, $member_id, $parent); // send created user for find rate of parent level 1

            $parent_new_point = 0;
            if ($totalamount > 0 && $parent_percent_rate > 0) {
                $x = ($totalamount * $parent_percent_rate) / 100;
                $parent_new_point = ($parent_old_point + $x);
            }
            if ($parent_new_point > 0) {
                $parent_old_all_point = getOldParentAllmPoint($connect, $parent);
                $parent_all_point = ($parent_old_all_point + $parent_new_point);
                $sql = "UPDATE member SET point='$parent_new_point',all_point='$parent_all_point' WHERE id='$parent'";
                if ($connect->query($sql)) {
                    if(createMpointTrans($connect,$parent,$parent_new_point,2)){
                        $res = 1;
                    }
                }
            }
        }

        return $res;

    } else {
        return 0;
    }

}

function getOldParentmPoint($connect, $parent_id)
{
    $point = 0;

    if ($parent_id > 0) {
        $query = "SELECT * FROM member WHERE id='$parent_id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            foreach ($result as $row) {
                $point = $row['point'];
            }
        }
    }
    return $point;
}

function getOldParentAllmPoint($connect, $parent_id)
{
    $point = 0;

    if ($parent_id > 0) {
        $query = "SELECT * FROM member WHERE id='$parent_id'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $filtered_rows = $statement->rowCount();
        if ($filtered_rows > 0) {
            foreach ($result as $row) {
                $point = $row['all_point'];
            }
        }
    }
    return $point;
}


function calmpointtrans($connect, $work_id)
{
    $member_id = 0;
    $point = 0;
    if ($work_id) {

        $member_id = findMember($connect, $work_id);
        $percent_rate = findStandardPer($connect, $member_id);
        $totalamount = looptrans($connect, $work_id);
        // $oldpoint = findMemberPoint($connect, $member_id);

        $new_point = 0;
        if ($totalamount > 0 && $percent_rate > 0) {
            $x = ($totalamount * $percent_rate) / 100;
            $point = ($x);
        }

    }
    return $point;
}

function createMpointTrans($connect, $parent_id, $new_point, $cal_from_type)
{
    $cdate = date('Y-m-d H:i:s');
    $res = 0;
    //cal_from_type
    // 1 = upgrade member type
    // 2 = point from workorder complete
    // 3 = member withdraw point


    $sql = "INSERT INTO point_trans(member_id,trans_date,trans_point,cal_from_type,activity_type,status)
    VALUES('$parent_id','$cdate','$new_point','$cal_from_type',1,1)";

    if ($connect->query($sql)) {
        $res += 1;
    }
    return $res;
}

function findMember($connect, $work_id)
{
    $member_id = 0;
    if ($work_id) {
        $query = "SELECT * FROM workorders WHERE id='$work_id'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $member_id = $row['created_by'];
        }

    }
    return $member_id;
}

function findMemberCenter($connect, $work_id)
{
    $member_id = 0;
    if ($work_id) {
        $query = "SELECT * FROM workorders WHERE id='$work_id'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $member_id = $row['center_id'];
        }

    }
    return $member_id;
}

function findMemberPoint($connect, $member_id)
{
    $point = 0;
    if ($member_id) {
        $query = "SELECT * FROM member WHERE id='$member_id'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $point = $row['point'];
        }

    }
    return $point;
}

function updateMemberPoint($connect, $member_id, $point)
{
    if ($member_id && $point > 0) {
        $sql = "UPDATE member SET point='$point' WHERE id='$member_id'";
        if ($connect->query($sql)) {
            return 1;
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function findPointStandardPer($connect, $member_id, $parent_id)
{
    $per = 0;
    //$member_type = getMemberType($connect, $member_id); // find type of member who created workorder
    $member_parent_type = getMemberType($connect, $parent_id); // find type of member who created workorder
    $member_type_for = 0;
    $member_type_name = '';

//    $query1 = "SELECT parent_type_id FROM point_cal_standard WHERE member_type_id = '$member_type'";
//    $statement1 = $connect->prepare($query1);
//
//    $statement1->execute();
//    $result1 = $statement1->fetchAll();
//    foreach ($result1 as $row1) {
//        $member_type_for = $row1['parent_type_id'];
//    }

    if ($member_parent_type > 0) {
        $member_type_name = findMemberTypeNameCal($connect, $member_parent_type);
        if ($member_type_name != '') {
            $member_type_name = trim($member_type_name)."1"; // online 1

            $query = "SELECT * FROM member_type WHERE name = '$member_type_name'";
            $statement = $connect->prepare($query);

            $statement->execute();
            $result = $statement->fetchAll();

            foreach ($result as $row) {
                $per = $row['percent_rate'];
            }
        }
    }
    return $per;
}

function findMemberTypeNameCal($connect, $member_type_for)
{
    $name = '';
    $query = "SELECT * FROM member_type WHERE id = '$member_type_for'";
    $statement = $connect->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll();

    foreach ($result as $row) {
        $name = $row['name'];
    }

    return $name;
}
//function findMemberTypeIdCal($connect, $member_type_name)
//{
//    $id = '';
//    $query = "SELECT * FROM member_type WHERE name = '$member_type_name'";
//    $statement = $connect->prepare($query);
//
//    $statement->execute();
//    $result = $statement->fetchAll();
//
//    foreach ($result as $row) {
//        $id = $row['id'];
//    }
//
//    return $id;
//}

function findPointStandardPerLevel2($connect, $member_id, $parent_id)
{
    $per = 0;
    //$member_type = getMemberType($connect, $member_id); // find type of member who created workorder
    $member_parent_type = getMemberType($connect, $parent_id); // find type of member who created workorder
    $member_type_for = 0;
    $member_type_name = '';

//    $query1 = "SELECT parent_type_2_id FROM point_cal_standard WHERE member_type_id = '$member_type'";
//    $statement1 = $connect->prepare($query1);
//
//    $statement1->execute();
//    $result1 = $statement1->fetchAll();
//    foreach ($result1 as $row1) {
//        $member_type_for = $row1['parent_type_2_id'];
//
//    }

    if ($member_parent_type > 0) {
        $member_type_name = findMemberTypeNameCal($connect, $member_parent_type);
        if ($member_type_name != '') {
            $member_type_name = trim($member_type_name)."2"; // online 2

            $query = "SELECT * FROM member_type WHERE name = '$member_type_name'";
            $statement = $connect->prepare($query);

            $statement->execute();
            $result = $statement->fetchAll();

            foreach ($result as $row) {
                $per = $row['percent_rate'];
            }
        }
//        $query = "SELECT * FROM member_type WHERE id = '$member_type_for'";
//        $statement = $connect->prepare($query);
//
//        $statement->execute();
//        $result = $statement->fetchAll();
//
//        foreach ($result as $row) {
//            $per = $row['percent_rate'];
//        }
    }


    return $per;
}

function findStandardPer($connect, $member_id)
{
    $per = 0;
    $member_type = getMemberType($connect, $member_id);
    $query = "SELECT * FROM member_type WHERE id = '$member_type'";
    $statement = $connect->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll();

    //$cus_data = array();
    //$filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        $per = $row['percent_rate'];
        //  array_push($cus_data,['id'=>$row['id'],'name'=>$row['name'],'percent_rate'=>$row['percent_rate']]);
    }
    return $per;
}

function looptrans($connect, $work_id)
{
    $amount_cal = 0;
    if ($work_id) {
        $query = "SELECT t2.item_id FROM quotation as t1 INNER JOIN quotation_line as t2 ON t1.id = t2.quotation_id WHERE t1.workorder_id = '$work_id'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            //  $findcalprice = findItemSalePrice($connect, $row['item_id']);
            $findcalprice = findSparePartSalePrice($connect, $row['item_id']);
            $amount_cal = ($amount_cal + $findcalprice);
        }
    }
    return $amount_cal;
}

function findItemSalePrice($connect, $itemid)
{
    $price = 0;
    if ($itemid) {
        $query = "SELECT * FROM item WHERE id='$itemid'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $price = $row['sale_price'];
        }

    }
    return $price;
}

function findSparePartSalePrice($connect, $itemid)
{
    $price = 0;
    if ($itemid) {
        $query = "SELECT * FROM sparepart WHERE id='$itemid'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $price = $row['cal_price'];
        }

    }
    return $price;
}


function findParent1($connect, $member_id)
{
    $parent_id = 0;
    if ($member_id) {
        $query = "SELECT * FROM member WHERE id='$member_id'";
        $statement = $connect->prepare($query);

        $statement->execute();
        $result = $statement->fetchAll();

        foreach ($result as $row) {
            $parent_id = $row['parent_id'];
        }

    }
    return $parent_id;
}

function findParentPercent($connect, $parent_id)
{
    $percent_rate = 0;
    if ($parent_id) {
        $percent_rate = findStandardPer($connect, $parent_id);
    }
    return $percent_rate;
}

function findParentMpointPercent($connect, $parent_id)
{
    $percent_rate = 0;
    if ($parent_id) {
        $percent_rate = findStandardPer($connect, $parent_id);
    }
    return $percent_rate;
}

function findIntroducePer($connect, $member_id)
{
    $per = 0;
    $member_type = getMemberType($connect, $member_id);
    $query = "SELECT * FROM member_type WHERE id = '$member_type'";
    $statement = $connect->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll();

    //$cus_data = array();
    //$filtered_rows = $statement->rowCount();
    foreach ($result as $row) {
        $per = $row['introduce_percent'];
        //  array_push($cus_data,['id'=>$row['id'],'name'=>$row['name'],'percent_rate'=>$row['percent_rate']]);
    }
    return $per;
}

function checkIsCenter($connect, $member_id)
{
    $iscenter = 0;
    $query = "SELECT * FROM member WHERE id = '$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $member_type_id = $row['member_type_id'];
            if ($member_type_id > 0) {
                $query2 = "SELECT * FROM member_type WHERE id = '$member_type_id'";
                $statement2 = $connect->prepare($query2);
                $statement2->execute();
                $result2 = $statement2->fetchAll();
                $filtered_rows2 = $statement2->rowCount();
                if ($filtered_rows2 > 0) {
                    foreach ($result2 as $row2) {
                        $iscenter = $row2['is_center'];
                    }
                }
            }
        }
    }
    return $iscenter;
}

?>