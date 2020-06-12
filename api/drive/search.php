<?php



//全掃描模式就是
//記得隱藏json


require_once "source.php";




// 取得 所有檔案 的清單

function retrieveAllFiles($service, $parameters) {
          
          $result = array();// result
          $pageToken = NULL;

          do {
            try {

              //成功
              
              if ($pageToken) {
                $parameters['pageToken'] = $pageToken;
              }
                $files = $service->files->listFiles($parameters);

                $result = array_merge($result, $files->getItems()); // result
                $pageToken = $files->getNextPageToken();


              } catch (Exception $e) {
                print "An error occurred: " . $e->getMessage();
                $pageToken = NULL;
              }
          } while ($pageToken);
          return $result; // result
        }

        try {


        $root_id=null;



        //參數
        $parameters = array();


        // echo gmdate("Y-m-d\TH:i:s\Z").'/'.$newUpdatetime;

        // exit();


        // [ 搜尋 ]
        // https://developers.google.com/drive/api/v2/search-parameters
        // ex:
        $parameters['q'] = "title contains 'N'"; //title 包含 N  


        // $parameters['q'] = " "; // T19台灣時區

        // $parameters['q'] = "modifiedDate > '2018-08-12T13:29:05Z'"; // modifiedTime > '2012-06-04T12:00:00-08:00'
        //2018-10-12T09:26:55.393Z

// 1B9We-i2IB29tRf3fJXpJ2tIogL3E5FrO

          // $parameters['q'] = " ";

         $parameters = null; //

        // $parameters['q'] = "modifiedDate > '2010-10-12T07:11:28Z'"; // 起始

        $service=buildService(); 
        $result=retrieveAllFiles($service, $parameters);









        // print_r($result);

        // exit();

        //開始
        //.....................................................
        $return_array = array(); 



        $return_array['originFolder']=array(); 


              

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

             


                  //顯示最父層資料夾
                  //..........................
                  if($value->parents==[]){

                       array_push($return_array['originFolder'],$value->title);
                  }
                  
                 


                  //
                  //..........................
                  if($value->mimeType=='application/vnd.google-apps.folder'){

                        $thetype='folders';
                  }
                  else{

                        $thetype='documents';

                  }


                        $return_array['list'][$thetype]['data'][$theid]['title']=$value->title;

                        $return_array['list'][$thetype]['data'][$theid]['alternateLink']=$value->alternateLink; //連結網址
                        $return_array['list'][$thetype]['data'][$theid]['iconLink']=$value->iconLink; //icon網址
                        $return_array['list'][$thetype]['data'][$theid]['title']=$value->title; //名稱
                        $return_array['list'][$thetype]['data'][$theid]['parents']=$value->parents; //父
                        $return_array['list'][$thetype]['data'][$theid]['embedLink']=$value->embedLink; //內嵌網址
                        $return_array['list'][$thetype]['data'][$theid]['thumbnailLink']=$value->thumbnailLink; //縮圖網址
                        $return_array['list'][$thetype]['data'][$theid]['mimeType']=$value->mimeType; //檔案類型
                        $return_array['list'][$thetype]['data'][$theid]['parents']=$parents; //上一層
                        $return_array['list'][$thetype]['data'][$theid]['modifiedDate']=$value->modifiedDate; //上一層
                        
                        $return_array['list']['modified'][$thetype]['total']++;
                        $return_array['list']['modified']['total']++;




                  

              }


        


             //..............................................
              $thepost=json_encode($return_array);

              echo  $thepost;








          } catch (Exception $e) {
          print "An error occurred1: " . $e->getMessage();
  }
?>