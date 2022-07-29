<?php
function getMaxidQuotation($connect){
    $query = "SELECT MAX(id) as id FROM quotation WHERE id > 0";
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
function checkQuotationHasrecord ($id,$connect){
    $query = "SELECT * FROM quotation_line WHERE id = $id";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $filtered_rows = $statement->rowCount();
    $num = '';
    $runno = '';
    $new = 0;
    //return $filtered_rows;
    if($filtered_rows > 0){
        return 1;
    }else{
        return 0;
    }
}

//function getOrderData($connect,$from_date,$to_date){
//
//    $query = '';
//    $f_date = null;
//    $t_date = null;
//    if($from_date!=null && $to_date!=null){
//        $a1 = explode('-',$from_date);
//        if(count($a1)){
//            $f_date = $a1[2].'/'.$a1[1].'/'.$a1[0];
//        }
//        $a2 = explode('-',$to_date);
//        if(count($a2)){
//            $t_date = $a2[2].'/'.$a2[1].'/'.$a2[0];
//        }
//    }
//    if($f_date!=null && $t_date!=null){
//        $f_date_filter = date('Y-m-d',strtotime($f_date));
//        $t_date_filter = date('Y-m-d',strtotime($t_date));
////        print_r($f_date_filter);return ;
//        $query = "SELECT * FROM orders WHERE id>0 AND date(quotation_date) >= '$f_date_filter' AND date(quotation_date) <= '$t_date_filter' ";
//    }else{
//        $query = "SELECT * FROM orders WHERE id>0";
//    }
//    $statement = $connect->prepare($query);
//
//    $statement->execute();
//    $result = $statement->fetchAll();
//
//    $cus_data = array();
//    $filtered_rows = $statement->rowCount();
//    foreach ($result as $row){
//        array_push($cus_data,[
//            'id'=>$row['id'],
//            'quotation_no'=>$row['quotation_no'],
//            'quotation_date'=>date('d-m-Y',strtotime($row['quotation_date'])),
//        ]);
//    }
////    print_r($cus_data);return ;
//    return $cus_data;
//
//}

function getQuotationData($connect,$from_date,$to_date){

    $query = '';
    $f_date = null;
    $t_date = null;
    if($from_date!=null && $to_date!=null){
        $a1 = explode('-',$from_date);
        if(count($a1)){
            $f_date = $a1[2].'/'.$a1[1].'/'.$a1[0];
        }
        $a2 = explode('-',$to_date);
        if(count($a2)){
            $t_date = $a2[2].'/'.$a2[1].'/'.$a2[0];
        }
    }
    if($f_date!=null && $t_date!=null){
        $f_date_filter = date('Y-m-d',strtotime($f_date));
        $t_date_filter = date('Y-m-d',strtotime($t_date));
//        print_r($f_date_filter);return ;
        $query = "SELECT t1.id,t1.quotation_no,t1.quotation_date,t2.item_id,t2.qty,t2.price,t2.line_total FROM orders as t1 INNER JOIN order_line as t2 ON t2.quotation_id = t1.id WHERE t1.id>0 AND date(t1.quotation_date) >= '$f_date_filter' AND date(t1.quotation_date) <= '$t_date_filter' ";
    }else{
        $query = "SELECT t1.id,t1.quotation_no,t1.quotation_date,t2.item_id,t2.qty,t2.price,t2.line_total FROM orders as t1 INNER JOIN order_line as t2 ON t2.quotation_id = t1.id WHERE t1.id>0";
    }
    $statement = $connect->prepare($query);

    $statement->execute();
    $result = $statement->fetchAll();

    $cus_data = array();
    $filtered_rows = $statement->rowCount();
    foreach ($result as $row){
        array_push($cus_data,[
            'id'=>$row['id'],
            'quotation_no'=>$row['quotation_no'],
            'quotation_date'=>date('d-m-Y',strtotime($row['quotation_date'])),
            'item_id'=> $row['item_id'],
            'qty' => $row['qty'],
            'price' => $row['price'],
            'line_total' =>$row['line_total'],
        ]);
    }
//    print_r($cus_data);return ;
    return $cus_data;

}

?>
