<?php




error_reporting(E_ALL);  //debug模式
ini_set("display_errors", 1);


 date_default_timezone_set("Asia/Taipei");


require_once $_SERVER['DOCUMENT_ROOT']."/source/sqldata.php";



// 資源

require_once $_SERVER['DOCUMENT_ROOT']."/library/google/google-api-php-client/src/Google_Client.php";
require_once $_SERVER['DOCUMENT_ROOT']."/library/google/google-api-php-client/src/contrib/Google_DriveService.php";
require_once $_SERVER['DOCUMENT_ROOT']."/library/google/google-api-php-client/src/contrib/Google_Oauth2Service.php";
require_once $_SERVER['DOCUMENT_ROOT']."/library/google/vendor/autoload.php";


// 帳密與金鑰

// $DRIVE_SCOPE = 'https://www.googleapis.com/auth/drive';
// $SERVICE_ACCOUNT_EMAIL = 'test-32@drive-test-199216.iam.gserviceaccount.com';
// $SERVICE_ACCOUNT_PKCS12_FILE_PATH = 'drive-test-199216-fd90fc3144e5.p12';

$DRIVE_SCOPE = 'https://www.googleapis.com/auth/drive';
$SERVICE_ACCOUNT_EMAIL = 'rallydb@drive-test-199216.iam.gserviceaccount.com';
$SERVICE_ACCOUNT_PKCS12_FILE_PATH = 'drive-test-199216-f0fc05bab116.p12';



// 建立服務

function buildService() {//function for first build up service
global $DRIVE_SCOPE, $SERVICE_ACCOUNT_EMAIL, $SERVICE_ACCOUNT_PKCS12_FILE_PATH;

  $key = file_get_contents($SERVICE_ACCOUNT_PKCS12_FILE_PATH);
  $auth = new Google_AssertionCredentials(
      $SERVICE_ACCOUNT_EMAIL,
      array($DRIVE_SCOPE),
      $key);
  $client = new Google_Client();
  $client->setUseObjects(true);
  $client->setAssertionCredentials($auth);
  return new Google_DriveService($client);
}




?>