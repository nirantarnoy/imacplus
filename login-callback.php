<?php
ob_start();
session_start();
require_once __DIR__ . '/vendor/php-graph-sdk-5.x/src/Facebook/autoload.php';
include("common/dbcon.php");

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
//    $strPicture = "https://graph.facebook.com/" . $user['id'] . "/picture?width=200&height=600&redirect=false";
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, $strPicture);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//    $avatarInfo = curl_exec($ch);
//    curl_close($ch);
//
//    $avatarInfo = json_decode($avatarInfo);


//    echo'<pre>';
//    print_r($user);
//    echo'</pre>';
//
//    echo $strPicture;

    if ($user['email'] != '') {
        $user_email_login = $user['email'];
        $query1 = "SELECT * FROM member WHERE email='$user_email_login'";
        $statement1 = $connect->prepare($query1);
        $statement1->execute();
        $result1 = $statement1->fetchAll();
        $filtered_rows1 = $statement1->rowCount();

        if ($filtered_rows1 > 0) {
            foreach ($result1 as $row1) {
                $member_id = $row1['id'];
                $query = "SELECT * FROM user WHERE member_ref_id='$member_id'";
                $statement = $connect->prepare($query);
                $statement->execute();
                $result = $statement->fetchAll();
                $filtered_rows = $statement->rowCount();
                if ($filtered_rows > 0) {
                    foreach ($result as $row) {
                        $_SESSION['userid'] = $row['id'];

                        if (!empty($_POST["remember"])) {
                            setcookie("member_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
                        } else {
                            if (isset($_COOKIE["member_login"])) {
                                setcookie("member_login", "");
                            }

                            $_SESSION['start'] = time();
                            $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
                        }
                    }
                    // if(checktime($_SESSION['userid'] , $connect)){
                    header('location: profile.php');
                    // }else{
                    //   $_SESSION['msg_err'] = 'ไม่ได้อยู่ในเวลาทำการ';
                    //    header("location:loginpage.php");
                    //}
                } else {
                    //   echo "no";return;
                    $_SESSION['msg_err'] = 'Usernam หรือ Password ไม่ถูกต้อง';
                    header("location:loginpage.php");
                }
                header('location: https://www.imacplus.app/profile.php');
            }
        }else{
            $_SESSION['msg_err'] = 'Usernam หรือ Password ไม่ถูกต้อง';
            header('location: https://www.imacplus.app/loginpage.php');
        }


    } else {
        $_SESSION['msg_err'] = 'Usernam หรือ Password ไม่ถูกต้อง';
        header('location: https://www.imacplus.app/loginpage.php');
    }



}
//
//$me = $response->getGraphUser();
//echo 'Logged in as ' . $me->getName().'<br />';
//print_r($me);
//print_r($avatarInfo);
//print_r($avatarInfo->data->url);
?>
<img src='".<?= $avatarInfo->data->url ?>."' border='0'></a><br><br>
