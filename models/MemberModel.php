<?php
function getMembermodel($connect)
{
    $data = [];
    $query = "SELECT * FROM member";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, ['id' => $row['id'], 'name' => $row['first_name'], 'photo' => $row['photo'], 'is_verified' => $row['is_verified']]);
        }
    }

    return $data;
}

function getMemberIntroduceData($connect, $id)
{
    $data = [];
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, ['id' => $row['id'], 'name' => $row['first_name'], 'lname' => $row['last_name'], 'photo' => $row['photo']]);
        }
    }

    return $data;
}

function getMemberProfileData($connect, $id)
{
    $data = [];
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, [
                'fname' => $row['first_name'],
                'lname' => $row['last_name'],
                'engname'=>$row['engname'],
                'engsurname'=>$row['engsurname'],
                'gender'=> $row['gender'],
                'nation_type'=> $row['nation_type'],
                'dob'=>date('dmY',strtotime($row['dob'])),
                'is_verified'=> $row['is_verified'],
                'address_current_type'=>$row['address_current_type'],
                'agree_verified'=>$row['agree_verified'],
            ]);
        }
    }

    return $data;
}

function getMemberIncomeData($connect, $id)
{
    $data = [];
    $query = "SELECT * FROM member_income_type WHERE member_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, [
                'income_type_id' => $row['income_type_id'],
            ]);
        }
    }

    return $data;
}

function getMemberDatamodel($connect, $id)
{
    $data = [];
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, ['id' => $row['id'],
                'phone' => $row['phone'],
                'bank_id' => $row['bank_id'],
                'bank_account' => $row['bank_account'],
                'id_number' => $row['id_number'],
                'active_date' => $row['active_date'],
                'photo' => $row['photo'],

            ]);
        }
    }

    return $data;
}

function getMemberaccount($connect, $code)
{
    $query = "SELECT * FROM member WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['account_id'];
        }
    }

}

function getMemberBankaccount($connect, $id)
{
    $data = [];
    $query = "SELECT * FROM member_account WHERE member_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, [
                'bank_id' => $row['bank_id'],
                'account_no' => $row['account_no'],
                'account_name' => $row['account_name'],
            ]);
        }
    }
    return $data;
}

function getMemberBankAddress($connect, $id)
{
    $data = [];
    $query = "SELECT * FROM member_address WHERE member_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, [
                'address' => $row['address'],
                'street' => $row['street'],
                'province_id' => $row['province_id'],
                'city_id' => $row['city_id'],
                'district_id' => $row['district_id'],
                'zipcode' => $row['zipcode'],
            ]);
        }
    }
    return $data;
}

function getMembername($connect, $code)
{
    $query = "SELECT * FROM member WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['first_name'] == null ? $row['phone_number'] : $row['first_name'];
        }
    }

}

function getMemberurl($connect, $id)
{
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['url'];
        }
    }

}

function getMemberPhone($connect, $id)
{
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['phone_number'];
        }
    }

}

function getMemberEmail($connect, $id)
{
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['email'];
        }
    }

}

function getMemberPhoto($connect, $id)
{
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['photo'];
        }
    }

}

function getMemberNotify($connect, $id)
{
    $data = [];
    $member_id = getMemberIDFromUser($connect, $id);
    $query = "SELECT * FROM member_notify WHERE member_id='$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, ['id' => $row['id'], 'notify_type_id' => $row['message_type_id'], 'title' => $row['title'], 'detail' => $row['detail'], 'message_date' => $row['message_date']]);
        }
    }
    return $data;
}

function getMemberIDFromUser($connect, $id)
{
    $query = "SELECT * FROM user WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['member_ref_id'];
        }
    }
}

function getMemberBankId($connect, $id)
{
    $bank_id = 1;
    $query = "SELECT * FROM member_account WHERE member_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['bank_id'] == null ? 0 : $row['bank_id'];
        }
    }
    return $bank_id;
}

function getMemberAccountNo($connect, $id)
{
    $name = '';
    $query = "SELECT * FROM member_account WHERE member_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['account_no'];
        }
    }
    return $name;
}

function getMemberAccountName($connect, $id)
{
    $name = '';
    $query = "SELECT * FROM member_account WHERE member_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['account_name'];
        }
    }
    return $name;
}

function getMemberChildCount($connect, $id)
{
    $query = "SELECT * FROM member WHERE parent_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    return $filtered_rows;
//    if($filtered_rows > 0){
//        foreach($result as $row){
//            return $row['url'];
//        }
//    }

}

function getMemberPoint($connect, $id)
{
    $point = 0;
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $point = $row['point'] == null ? 0 : $row['point'];
        }
    }
    return $point;
}

function getMemberWalletAmount($connect, $id)
{
    $amount = 0;
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $amount = $row['wallet_amount'] == null ? 0 : $row['wallet_amount'];
        }
    }
    return $amount;
}

function getMemberType($connect, $id)
{
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['member_type_id'];
        }
    }

}

function getMemberTypeVIP($connect, $id)
{
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            if ($row['member_type_id'] == 28) {
                return 1;
            }

        }
    } else {
        return 0;
    }

}

function getMemberTypeVIPSHOP($connect, $id)
{
    $isvipshop = 0;
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $isvipshop = findIsVip($connect, $row['member_type_id']);
        }
    } else {
        return 0;
    }
    return $isvipshop;
}

function findIsVip($connect, $member_type_id)
{
    $isvip = 1;
    $query = "SELECT * FROM member_type WHERE id = '$member_type_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $isvip = $row['is_vipshop'];
        }
    } else {
        return 0;
    }
    return $isvip;
}

function findIsCenter($connect, $member_id)
{
    $iscenter = 1;
    $query = "SELECT * FROM member WHERE id = '$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $iscenter = $row['is_center'];
        }
    } else {
        return 0;
    }
    return $iscenter;
}

function findParentForRegister($connect, $token)
{
    $new_filter = "=" . $token;
    $query = "SELECT * FROM member WHERE url LIKE " . "'%" . $new_filter . "'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
//            $x = explode('=', $row['url']);
//            if ($x[1] == $token) {
            return $row['id'];
            // }
//            return $row['wallet_amount'];
        }
    } else {
        return 0;
    }

}

function findParentForRegisterold($connect, $token)
{
    $query = "SELECT * FROM member WHERE id>0";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $x = explode('=', $row['url']);
            if ($x[1] == $token) {
                return $row['id'];
            }
//            return $row['wallet_amount'];
        }
    } else {
        return 0;
    }

}

function findCurrentParentId($connect, $member_id)
{
    $query = "SELECT * FROM member WHERE id = '$member_id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            return $row['parent_id'];
        }
    } else {
        return 0;
    }

}

function getMaxid($connect)
{
    $query = "SELECT MAX(id) as id FROM member WHERE id > 0";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    $runno = '';
    $new = 0;
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $num = $row['id'];
        }
        return $num;
    } else {
        return 0;
    }
}

function checkHasRow($connect, $id)
{
    $query = "SELECT * FROM member_account WHERE member_id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    return $filtered_rows;
//    if($filtered_rows > 0){
//        foreach($result as $row){
//            return $row['url'];
//        }
//    }

}

function checkDuplicateMember($connect, $email, $phone)
{
    $query = "SELECT * FROM member WHERE email='$email' OR phone_number='$phone'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    return $filtered_rows;
//    if($filtered_rows > 0){
//        foreach($result as $row){
//            return $row['url'];
//        }
//    }

}

function getMemberLastNo($connect)
{
    $query = "SELECT MAX(member_no) as code FROM member WHERE member_no <>''";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    $runno = substr(date('Y'), 2, 2);
    $new = 0;
    //return $filtered_rows;
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            if ($row['code'] == '') {
                return $runno . '00001';
            }
            $new = (int)substr($row['code'], 2, 5) + 1;
            $diff = 5 - strlen($new);
            for ($i = 0; $i <= $diff - 1; $i++) {
                $runno = $runno . '0';
            }
        }
        return $num = $runno . $new;
    } else {
        return $runno . '00001';
    }
}

function getMemberCenterData($connect)
{
    $data = [];
    $query = "SELECT * FROM member WHERE member_type_id=30";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            array_push($data, ['id' => $row['id'], 'name' => $row['first_name'], 'photo' => $row['photo']]);
        }
    }

    return $data;
}

function getMemberverifiedstatus($connect, $id)
{
    $data = 0;
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if ($filtered_rows > 0) {
        foreach ($result as $row) {
            $data = $row['is_verified'];
        }
    }

    return $data;
}

//function getMemberByuserid($connect, $id)
//{
//    $name = '';
//    $query = "SELECT * FROM member_account WHERE member_id='$id'";
//    $statement = $connect->prepare($query);
//    $statement->execute();
//    $result = $statement->fetchAll();
//    $filtered_rows = $statement->rowCount();
//    if ($filtered_rows > 0) {
//        foreach ($result as $row) {
//            return $row['account_name'];
//        }
//    }
//    return $name;
//}

?>
