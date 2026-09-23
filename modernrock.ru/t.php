<?
// Запрос к url через Curl со смещением $cut, если нужно)
function getCurl($url = '', $cut = ''){
	// ip и порт прокси
	$proxy = '46.3.20.167:8000';
	// если требуется авторизация на прокси-сервере
	$proxyauth = '$rmWhQe:Z1YKUt';
	
	$proxy2 = '185.231.244.238:65233';
	$proxyauth2 = 'sansog:H0v9JpP';
	
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $url);
	curl_setopt($curl_handle, CURLOPT_PROXY, $proxy2);
	curl_setopt($curl_handle, CURLOPT_HTTPPROXYTUNNEL,0);
	curl_setopt($curl_handle, CURLOPT_PROXYUSERPWD,$proxyauth2);
	curl_setopt($curl_handle, CURLOPT_PROXYAUTH,CURLAUTH_ANY);
	curl_setopt($curl_handle, CURLOPT_FRESH_CONNECT,true);
	
	//curl_setopt($curl_handle, CURLOPT_PROXY, '194.186.38.82:1080');
	
	//curl_setopt($curl_handle, CURLOPT_PROXY, '37.110.66.21:9050');
	//curl_setopt($curl_handle, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	
	
	echo 'ddd2';
	curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, 0);

	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36');
	$query = curl_exec($curl_handle);
	curl_close($curl_handle);
	
	if($cut){
		$query = stream_get_contents($query, -1, $cut);
	}
	return $query;
}
echo getCurl('https://www.litres.ru/');


?>