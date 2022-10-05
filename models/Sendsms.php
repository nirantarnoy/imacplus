<?php
$curl = curl_init();

$otp_number = '';
$message = '';
$response = [];
if(isset($_POST['otp_number'])){
    $otp_number = $_POST['otp_number'];
}
if(isset($_POST['verify_code'])){
    $message = $_POST['verify_code'];
}

if($otp_number !='' && $message !=''){

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://thsms.com/api/send-sms',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
    "sender": "SMS PRO",
    "msisdn": ["'.$otp_number.'"],
    "message": "รหัสยืนยันตัวตนระบบ iMacplus ของคุณคือ '.$message.'"
}',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC90aHNtcy5jb21cL21hbmFnZVwvYXBpLWtleSIsImlhdCI6MTY2MzIyNjY4NCwibmJmIjoxNjY0OTY5NDczLCJqdGkiOiJ5c05wTFJFb1FWY1FaaHI4Iiwic3ViIjoxMDczNTIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.5I1SasMTUwq1u7rT4vyAyi-VXlzkAeMXh44xwBCXiJ4',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;

//$curl = curl_init();
//
//curl_setopt_array($curl, array(
//    CURLOPT_URL => 'https://thsms.com/api/rest?username=Napakorn&password=Sng885xcvbbbb&method=send&from=SMS&to=0887692818&message=hi',
//    CURLOPT_RETURNTRANSFER => true,
//    CURLOPT_ENCODING => '',
//    CURLOPT_MAXREDIRS => 10,
//    CURLOPT_TIMEOUT => 0,
//    CURLOPT_FOLLOWLOCATION => true,
//    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//    CURLOPT_CUSTOMREQUEST => 'GET',
//));
//
//$response = curl_exec($curl);
//
//curl_close($curl);
//echo $response;
}

?>