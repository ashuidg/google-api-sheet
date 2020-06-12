<?php

error_reporting(E_ALL);  //debug模式
ini_set("display_errors", 1); 

require_once('../../source/sqldata.php');



	//列出已存在的
	
	// $hasArray = array();

	// $result=mysqli_query($conn, "SELECT * FROM `data` ORDER BY `id` DESC     ");
	// while($row = mysqli_fetch_array($result)){

	// 		array_push($hasArray,$row['name']);

 //    }

    //json

	$json = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/json/drive.json');
    $data = json_decode($json, true)['data'];




    $i=0;
    foreach ($data as $name => $value) {

    		 $i++;
             
    		 //判斷若無，新增
             $getsame = mysqli_fetch_array(mysqli_query($conn , "SELECT * FROM `data` WHERE `name`='".$name."' "));

		     if(is_null($getsame)){


		             mysqli_query($conn,"INSERT INTO `data` (`name`) VALUES ('".$name."')");
		     }

		     //若有了
		     else{

		     	//	不同才更新

		     	// alternateLink
		     	if($getsame['alternateLink']!=$value['alternateLink']){
		     		mysqli_query($conn,"UPDATE `data` SET `alternateLink`= '".$value['alternateLink']."'  WHERE `name`='".$name."' ");
		     	}

		     	// iconLink
		     	if($getsame['iconLink']!=$value['iconLink']){
		     		mysqli_query($conn,"UPDATE `data` SET `iconLink`= '".$value['iconLink']."'  WHERE `name`='".$name."' ");
		     	}

		     	// title
		     	if($getsame['title']!=$value['title']){
		     		mysqli_query($conn,"UPDATE `data` SET `title`= '".$value['title']."'  WHERE `name`='".$name."' ");
		     	}
		     	// parents
		     	if($getsame['parents']!=$value['parents']){
		     		mysqli_query($conn,"UPDATE `data` SET `parents`= '".$value['parents']."'  WHERE `name`='".$name."' ");
		     	}
		     	// mimeType
		     	if($getsame['mimeType']!=$value['mimeType']){
		     		mysqli_query($conn,"UPDATE `data` SET `mimeType`= '".$value['mimeType']."'  WHERE `name`='".$name."' ");
		     	}


		     	//..........................

		     	// datatype
		     	$formatExplode=explode('.',$value['title']);
				if(count($formatExplode)==1){ //資料夾
				    $format=null;
				}
				else{
				    $formatN=count($formatExplode)-1;
    				$format=$formatExplode[$formatN]; 
				}


		     	if($getsame['format']!=$format){
		     		mysqli_query($conn,"UPDATE `data` SET `format`= '".$format."'  WHERE `name`='".$name."' ");
		     	}


		     		
		     }


		     // array_remove($hasArray,$name);

		     // unset($hasArray[$name]);
    }


    //更新總數量
    mysqli_query($conn,"UPDATE `_console_setting` SET `col01`= '".$i."'  WHERE `type`='memo' LIMIT 1 ");


    // echo json_encode($hasArray);


     echo json_encode(array("status" => "success","total" => $i));


?>
