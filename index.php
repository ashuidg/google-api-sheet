<!-- <script src="/library/jquery/jquery.min.js"></script> -->
<?php 




// require_once('source/sqldata.php');
// require_once('source/allneed.php'); 
// require_once('source/transfer.php'); 

//geturl
//...................................................

function geturl($url){

	//避免程式碼
	$url=strip_tags($_GET[$url]); 

	//移除符號
	// $url=str_replace('.','',$url);
	$url=str_replace('/','',$url);
	// $url=str_replace('-','',$url);
	$url=str_replace(',','',$url);

	return $url;
}

//url1
if(isset($_GET['url1'])){ 	$url1=geturl('url1'); } else{ 	$url1='home';  }

//url2
if(isset($_GET['url2'])){ 	$url2=geturl('url2'); } else{ 	$url2='';  }

//url3
if(isset($_GET['url3'])){ 	$url3=geturl('url3'); } else{ 	$url3='';  }

//url4
if(isset($_GET['url4'])){ 	$url3=geturl('url4'); } else{ 	$url3='';  }

//console
//..................
if($url1=='console'){

    	echo'<script>location.href="/console/main/login.php"</script>';
    	exit();
}

//pma
//..................
if($url1=='pma'){

    	echo'<script>location.href="/pma/index.php"</script>';
    	exit();
}

//排除符號
//..................
if (strpos ($url1, ".") OR strpos ($url1, "/")){

	echo $url1;
     //True
     exit('Error');
}


//載入分頁
//......................................................


if(!isset($_GET['url1'])){

	$url1='home';
}

//若不存在

if (file_exists('page/'.$url1.'.php')) {
    require_once('page/'.$url1.'.php');
} 
else{
	echo $_GET['url1'];
	echo 404;
	exit();
}


require_once('page/'.$url1.'.php');

 ?>