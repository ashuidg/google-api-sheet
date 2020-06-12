<?php

error_reporting(E_ALL);  //debug模式
ini_set("display_errors", 1);




require_once "../../library/google/google-api-php-client/src/Google_Client.php";
require_once "../../library/google/google-api-php-client/src/contrib/Google_DriveService.php";
require_once "../../library/google/google-api-php-client/src/contrib/Google_Oauth2Service.php";
require_once "../../library/google/vendor/autoload.php";

$DRIVE_SCOPE = 'https://www.googleapis.com/auth/drive';
$SERVICE_ACCOUNT_EMAIL = 'drivetest2@drivetest2-273716.iam.gserviceaccount.com';
$SERVICE_ACCOUNT_PKCS12_FILE_PATH = 'drivetest2-273716-375897b804c9.p12';

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

function insertFile($service, $title, $description, $parentId, $mimeType, $filename) {//function for insert a file
 
  $file = new Google_DriveFile();
  $file->setTitle($title);
  $file->setDescription($description);
  $file->setMimeType($mimeType);

  // Set the parent folder.
  if ($parentId != null) {
    $parent = new Google_ParentReference();
    $parent->setId($parentId);
    $file->setParents(array($parent));
  }

  try {
    $data = file_get_contents($filename);

    $createdFile = $service->files->insert($file, array(
      'data' => $data,
      'mimeType' => $mimeType,
    ));


//set the file with MIME
$permission = new Google_Permission();
$permission->setRole( 'writer' );
$permission->setType( 'anyone' );
//$permission->setValue( 'me' );
$service->permissions->insert( $createdFile->getId(), $permission );

//insert permission for the file


    
    return $createdFile;
  } catch (Exception $e) {
print "An error occurred1: " . $e->getMessage();
  }
}


function retrieveAllFiles($service) {
  $result = array();
  $pageToken = NULL;

  do {
    try {
      $parameters = array();
      if ($pageToken) {
        $parameters['pageToken'] = $pageToken;
      }
      $files = $service->files->listFiles($parameters);

      $result = array_merge($result, $files->getItems());
      $pageToken = $files->getNextPageToken();
    } catch (Exception $e) {
      print "An error occurred: " . $e->getMessage();
      $pageToken = NULL;
    }
  } while ($pageToken);
  return $result;
}

try {


$root_id=null;

$service=buildService();

// print_r(retrieveAllFiles($service));
// exit();



$result=retrieveAllFiles($service);


$return_array = array(); //開始

$i=0;

// $return_array['all']=$result;
foreach ($result as $value) {

    $theid=$value->id;


    //parents 父目錄
    if(isset($value->parents[0])){
        // $parents['id']=$value->parents[0]->id;
        // $parents['title']='yo';

        $parents=$value->parents[0]->id;
    }
    else{
        $parents=null;
    }

    $return_array['data'][$theid]['alternateLink']=$value->alternateLink; //連結網址
    $return_array['data'][$theid]['iconLink']=$value->iconLink; //icon網址
    $return_array['data'][$theid]['title']=$value->title; //名稱
    $return_array['data'][$theid]['embedLink']=$value->embedLink; //內嵌網址
    $return_array['data'][$theid]['thumbnailLink']=$value->thumbnailLink; //縮圖網址
    $return_array['data'][$theid]['mimeType']=$value->mimeType; //檔案類型
    $return_array['data'][$theid]['parents']=$parents; //上一層
    
    $i++;
  # code...
}




//..............................................

    // $thepost=json_encode($return_array);



  echo $i;

    // echo $thepost;

    // $thepath="../json/drive.json"; //path

    // $content = $thepost;
    // $fp = fopen($thepath,"wb");
    // fwrite($fp,$content);
    // fclose($fp);

/*$title="test";
$description='';
$parentId=$root_id;
$file="balance.png";
$mimeType="image/png";//For Excel File
$filename=$file;*/
//$parentId=insertFile($service, $title, $description, $parentId, $mimeType, $filename);

//print_r($parentId);
  } catch (Exception $e) {
  print "An error occurred1: " . $e->getMessage();
  }
?>