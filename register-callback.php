<?php
ob_start();
session_start();
require_once __DIR__ . '/vendor/php-graph-sdk-5.x/src/Facebook/autoload.php';
include("common/dbcon.php");
include("models/MemberModel.php");
include("models/UserModel.php");

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
//   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();
use \Facebook\FacebookSession;
use \Facebook\FacebookRequest;
use \Facebook\GraphUser;
use \Facebook\FacebookRedirectLoginHelper;

$fb = new \Facebook\Facebook([
    'app_id' => '5164069763715357',
    'app_secret' => '0d7b1e93385cd8f48a98385217983bf2',
    'default_graph_version' => 'v2.10',
    'persistent_data_handler' => 'session',
    //'default_access_token' => 'EAALxTH5oaSABACSTjEkKoHWG9MmngRUNZAtCAjHzq9UH0AlWWXyDTePgWOKtcYvopbfy0wLQfVx6aFy5HGOdWNFZBfovguf1Fs0aFwje7ZBfyxZBQj41hKoJzGx6V20VIIZB816rAj0zlxo7Xc76IUSReFelpMIAl9MpOZCakXBIjj2H0uFqdQnhp9taWRm5h68RmX9dj1zbMZBCVzszuQdbsZC1bnQH3ZAebjcE8txpZA1BHkCo9hatnh', // optional
]);
$parent_id = '';
if (isset($_SESSION['parent_member_id'])) {
    $parent_id = $_SESSION['parent_member_id'];
}

try {
    $helper = $fb->getRedirectLoginHelper();
    if (isset($_GET['state'])) {
        $helper->getPersistentDataHandler()->set('state', $_GET['state']);
    }
    $accessToken = $helper->getAccessToken();


} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (isset($accessToken)) {
    // Logged in!
    $_SESSION['facebook_access_token'] = (string)$accessToken;

    // Now you can redirect to another page and use the
    // access token from $_SESSION['facebook_access_token']

    $response = $fb->get('/me?fields=id,name,gender,email', $accessToken);

    $user = $response->getGraphUser();

    // $strPicture = "https://graph.facebook.com/".$user['id']."/picture?type=large";
    $strPicture = "https://graph.facebook.com/" . $user['id'] . "/picture?type=normal";


//    echo'<pre>';
//    print_r($user);
//    echo'</pre>';
//
//    echo $strPicture;

    if ($user['email'] != '' && checkhasuser($user['email'], $connect) <= 0) {

        $user_regis_email = $user['email'];
       // $parent_id = findParentForRegister($connect, $parent_id);
//    echo $phone;
        $bytes = openssl_random_pseudo_bytes(8);
        $member_url = 'https://www.imacplus.app/loginpage.php?ref='. bin2hex($bytes);
        $cdate = date("Y-m-d H:i:s");
        $ctimestamp = time();
        //echo bin2hex($bytes);
        $sql_member = "INSERT INTO member(phone_number,email,url,parent_id,agree_read,agree_date,created_at,member_type_id,status)VALUES('','$user_regis_email','$member_url','$parent_id',1,'$cdate','$ctimestamp',30,1)";
        if ($connect->query($sql_member)) {
            $newpass = md5($user_regis_email);
            $maxid = getMaxid($connect);
            $sql = "INSERT INTO user (username,password,status,member_ref_id)
           VALUES ('$user_regis_email','$newpass',1,'$maxid')";

            if ($result = $connect->query($sql)) {
                $_SESSION['userid'] = getCurrenUserId($connect,$maxid);

                if (!empty($_POST["remember"])) {
                    setcookie("member_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
                } else {
                    if (isset($_COOKIE["member_login"])) {
                        setcookie("member_login", "");
                    }

                    $_SESSION['start'] = time();
                    $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
                }
                $_SESSION['msg-success'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                // header('location:registersuccess.php');
                header('location:profile.php');
            } else {
                $_SESSION['msg-error'] = 'พบข้อผิดพลาด';
                header('location:loginpage.php');
            }
        }else{
            echo "พบข้อผิดพลาด";
        }


    } else {
        header('location: https://www.imacplus.app/loginpage.php');
    }

    //echo 'ID: ' . $user['id'];
    //echo 'Name: ' . $user['name'];
    //echo 'Gener: ' . $user['gener'];
    //echo 'Email: ' . $user['email'];
    //echo 'Link: ' . $user['link'];

}
//
//$me = $response->getGraphUser();
//echo 'Logged in as ' . $me->getName().'<br />';
//print_r($me);
?>

