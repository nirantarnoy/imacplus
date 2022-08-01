<?php
function getMembermodel($connect){
    $data = [];
    $query = "SELECT * FROM member";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($data,['id'=>$row['id'],'name'=>$row['name']]);
        }
    }

    return $data;
}
function getMemberDatamodel($connect, $id){
    $data = [];
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            array_push($data,['id'=>$row['id'],
                'phone'=>$row['phone'],
                'bank_id'=>$row['bank_id'],
                'bank_account'=>$row['bank_account'],
                'id_number'=>$row['id_number'],
                'active_date'=>$row['active_date'],

            ]);
        }
    }

    return $data;
}
function getMemberaccount($connect,$code){
    $query = "SELECT * FROM member WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['account_id'];
        }
    }

}
function getMembername($connect,$code){
    $query = "SELECT * FROM member WHERE id='$code'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['first_name'];
        }
    }

}
function getMemberurl($connect,$id){
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['url'];
        }
    }

}
function getMemberChildCount($connect,$id){
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
function getMemberPoint($connect, $id){
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['point'];
        }
    }
}
function getMemberWalletAmount($connect,$id){
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['wallet_amount'];
        }
    }

}
function getMemberType($connect,$id){
    $query = "SELECT * FROM member WHERE id='$id'";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if($filtered_rows > 0){
        foreach($result as $row){
            return $row['member_type_id'];
        }
    }

}
function findParentForRegister($connect,$token){
    $query = "SELECT * FROM member WHERE id>0";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    //return $filtered_rows;
    if($filtered_rows > 0){
        foreach($result as $row){
            $x = explode('=',$row['url']);
            if($x[1] == $token){
                return $row['id'];
            }
//            return $row['wallet_amount'];
        }
    }else{
        return 0;
    }

}
function getMaxid($connect){
    $query = "SELECT MAX(id) as id FROM member WHERE id > 0";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    $runno = '';
    $new = 0;
    //return $filtered_rows;
    if($filtered_rows > 0){
        foreach($result as $row){
            $num = $row['id'];
        }
        return $num;
    }else{
        return 0;
    }
}

?>
