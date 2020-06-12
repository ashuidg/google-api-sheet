<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/1.0.3/jquery.csv.min.js"></script>
<script src="../library/jquery/jquery.min.js"></script>
<?php

//curl_init方式
$ori = curl_init(); 
curl_setopt($ori, CURLOPT_URL, "https://docs.google.com/spreadsheets/d/e/2PACX-1vThwMLOfv4kM8jcSvKligWK8nz21Edfmn0IUncBXayhjySkl-BYY_FoOS4M_mozgOka2Vu_Nw1AKCK6/pub?gid=0&single=true&output=csv"); 
$agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
// 驗證伺服器憑證 
curl_setopt($ori, CURLOPT_SSL_VERIFYPEER, false); 
//如果你想CURL報告每一件意外的事情，設置這個選項為一個非零值
curl_setopt($ori, CURLOPT_VERBOSE, true); 
//在HTTP請求中包含一個「user-agent」頭的字符串，設置用戶代理
curl_setopt($ori, CURLOPT_USERAGENT, $agent); 
//獲取的訊息以文件流的形式返回傳給
curl_setopt($ori, CURLOPT_RETURNTRANSFER, true);
//超時設定
curl_setopt($ori, CURLOPT_CONNECTTIMEOUT, 15); 
$csv = curl_exec($ori); 
curl_close($ori);
print json_encode($csv);

//
$csv= file_get_contents('https://docs.google.com/spreadsheets/d/e/2PACX-1vThwMLOfv4kM8jcSvKligWK8nz21Edfmn0IUncBXayhjySkl-BYY_FoOS4M_mozgOka2Vu_Nw1AKCK6/pub?gid=0&single=true&output=csv');
$array = array_map("str_getcsv", explode("\n", $csv));
// $array = array_map("str_getcsv", explode(",", $csv));
print json_encode($array);

// print json_encode($array);
?>
