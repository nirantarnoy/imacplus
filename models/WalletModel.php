<?php
function getWalletLastNo($connect){
    $query = "SELECT MAX(trans_no) as code FROM wallet_trans WHERE trans_no <>''";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $runno = substr(date('Y'),2,2);
    $new = 0;
    //return $filtered_rows;
    if($filtered_rows > 0){
        foreach($result as $row){
            if($row['code'] == ''){
                return $runno.'00001';
            }
            $new = (int)substr($row['code'],2,5) +1;
            $diff = 5-strlen($new);
            for($i=0;$i<=$diff-1;$i++){
                $runno = $runno.'0';
            }
        }
        return $num = $runno.$new;
    }else{
        return $runno.'00001';
    }
}
?>