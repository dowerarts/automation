<?php

echo "\e[0;32m[+] \e[0;34mCreated Account Package Portal\e[0m\n";
echo "\e[0;32m[+] Apri \e[1;31mAmsyah\e[0m\n\n";
echo "Password Yang Diinginkan ? ";
$password = trim(fgets(STDIN));

echo "Mau Create Berapa Akun ? ";
$total = trim(fgets(STDIN));

for ($i=0; $i < $total; $i++) { 

echo "\n";
$nama = explode(" ", nama());
$nama1 = $nama[0];
$nama2 = $nama[1];

    $headers = [
        'POST /identitytoolkit/v3/relyingparty/signupNewUser?key=AIzaSyCX35qaNrESINLfA4qwfqPQb6cNHnEzAMs HTTP/1.1',
        'x-client-version: ReactNative/JsCore/7.7.0/FirebaseCore-web',
        'Content-Type: application/json',
        'Host: www.googleapis.com',
        'Connection: close',
        'User-Agent: okhttp/3.12.1',
    ];

    $data = '{"email":"'.$nama1.''.$nama2.'@haikak.my.id","password":"'.$password.'","returnSecureToken":true}';
    $create = curl('https://www.googleapis.com/identitytoolkit/v3/relyingparty/signupNewUser?key=AIzaSyCX35qaNrESINLfA4qwfqPQb6cNHnEzAMs', $data, $headers);
    if (strpos($create[1], 'EMAIL_EXISTS')) {
        echo "[+] $nama1$nama2@haikak.my.id|$password Email Has Been Used\n";
    } else if(strpos($create[1], 'idToken": "')) {
        $idtoken = get_between($create[1], 'idToken": "', '"');
        echo "[+] $nama1$nama2@haikak.my.id|$password Email Successfully Created\n";
    }

    $headers = [
        'x-client-version: ReactNative/JsCore/7.7.0/FirebaseCore-web',
        'Content-Type: application/json',
        'Host: www.googleapis.com',
        'Connection: close',
        'User-Agent: okhttp/3.12.1',
    ];

    $data = '{"requestType":"VERIFY_EMAIL","idToken":"'.$idtoken.'"}';
    $verif = curl('https://www.googleapis.com/identitytoolkit/v3/relyingparty/getOobConfirmationCode?key=AIzaSyCX35qaNrESINLfA4qwfqPQb6cNHnEzAMs', $data, $headers);
    if (strpos($verif[1], 'identitytoolkit#GetOobConfirmationCodeResponse')) {
        echo "[+] Successfully Send Verification Mail\n";
    } else {
        echo "[+] Failure Send Verification Mail\n";
    }

    sleep(5);
    $cookie = curl('http://haikak.my.id/secretya/user.php?user='.$nama1.''.$nama2.'@haikak.my.id%40haikak.my.id', null, null);
    $phpsessid = $cookie[2]['PHPSESSID'];

    $headers = [
        'Host: haikak.my.id',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:84.0) Gecko/20100101 Firefox/84.0',
        'Accept: */*',
        'Accept-Language: en-US,en;q=0.5',
        'X-Requested-With: XMLHttpRequest',
        'Connection: close',
        'Referer: http://haikak.my.id/',
        'Cookie: PHPSESSID='.$phpsessid.'; tmail-emails=a%3A1%3A%7Bi%3A0%3Bs%3A29%3A%22marutoasmrullah97%40haikak.my.id%22%3B%7D',
    ];
    $checkmail = curlget('http://haikak.my.id/secretya/mail.php', null, $headers);
    $hasil = get_between($checkmail[1], "Follow this link to verify your email address.\r\n", "en");
    $hasil = trim($hasil);
    $oob = get_between($hasil, 'oobCode=', '&');
    $headers = [
        'Host: auth.packageportal.com',
        'Connection: close',
        'Upgrade-Insecure-Requests: 1',
        'User-Agent: Mozilla/5.0 (Linux; Android 5.1.1; SM-N976N Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.136 Mobile Safari/537.36',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
        'Accept-Language: en-ID,en-US;q=0.9,en;q=0.8',
        'X-Requested-With: com.android.browser',
    ];

    $verifAsu = curl(''.$hasil.'', null, $headers);


    $headers = [
        'Host: www.googleapis.com',
        'Connection: close',
        'Origin: https://auth.packageportal.com',
        'X-Client-Version: Chrome/JsCore/3.7.5/FirebaseCore-web',
        'User-Agent: Mozilla/5.0 (Linux; Android 5.1.1; SM-N976N Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.136 Mobile Safari/537.36',
        'Content-Type: application/json',
        'Accept: */*',
        'Referer: '.$hasil.'',
        'Accept-Language: en-ID,en-US;q=0.9,en;q=0.8',
        'X-Requested-With: com.android.browser',
    ];
    
    $data = '{"oobCode":"'.$oob.'"}';
    $verifAccount = curl('https://www.googleapis.com/identitytoolkit/v3/relyingparty/setAccountInfo?key=AIzaSyBiGQSeXF0-NwgRWYyqoN7ru2CwFkwm2pM', $data, $headers);
    if (strpos($verifAccount[1], 'INVALID_OOB_CODE')) {
        echo "[+] Failure Verification Account\n";
    } else if (strpos($verifAccount[1], 'localId":')) {
        echo "[+] $nama1$nama2@haikak.my.id|$password Successfully Created Account\n";
        fwrite(fopen('package.txt', 'a'), "$nama1$nama2@haikak.my.id|$password\n");
    }
}

function get(){
	return trim(fgets(STDIN));
}

function get_between($string, $start, $end) 
    {
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }

function nama()
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$ex = curl_exec($ch);
	// $rand = json_decode($rnd_get, true);
	preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
	return $name[2][mt_rand(0, 14) ];
	}
function acak($panjang)
{
    $karakter= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for ($i = 0; $i < $panjang; $i++) {
  $pos = rand(0, strlen($karakter)-1);
  $string .= $karakter{$pos};
    }
    return $string;
}

function angka($panjang)
{
    $karakter= '1234567890';
    $string = '';
    for ($i = 0; $i < $panjang; $i++) {
  $pos = rand(0, strlen($karakter)-1);
  $string .= $karakter{$pos};
    }
    return $string;
}
// function curl($url,$post,$headers, $socks)
// {
// 	$ch = curl_init();
// 	curl_setopt($ch, CURLOPT_URL, $url);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 	curl_setopt($ch, CURLOPT_HEADER, 1);
// 	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     if ($post !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
//     if ($socks):
//         curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true); 
//         curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); 
//         curl_setopt($ch, CURLOPT_PROXY, $socks);
//       endif; 
// 	$result = curl_exec($ch);
// 	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
// 	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
// 	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
// 	$cookies = array()
// ;	foreach($matches[1] as $item) {
// 	  parse_str($item, $cookie);
// 	  $cookies = array_merge($cookies, $cookie);
// 	}
// 	return array (
// 	$header,
// 	$body,
// 	$cookies
// 	);
// }


function curl($url,$post,$headers)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if ($post !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array()
;	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}

function curlget($url,$post,$headers)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $headers == null ? curl_setopt($ch, CURLOPT_POST, 1) : curl_setopt($ch, CURLOPT_HTTPGET, 1);
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array()
;	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}

function curlproxy($url,$post,$headers, $socks)
{
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if ($post !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    if ($socks):
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true); 
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); 
        curl_setopt($ch, CURLOPT_PROXY, $socks);
      endif; 
	$result = curl_exec($ch);
	$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
	$cookies = array()
;	foreach($matches[1] as $item) {
	  parse_str($item, $cookie);
	  $cookies = array_merge($cookies, $cookie);
	}
	return array (
	$header,
	$body,
	$cookies
	);
}


class Colors {
    private $foreground_colors = array();
    private $background_colors = array();

    public function __construct() {
        // Set up shell colors
        $this->foreground_colors['black'] = '0;30';
        $this->foreground_colors['dark_gray'] = '1;30';
        $this->foreground_colors['blue'] = '0;34';
        $this->foreground_colors['light_blue'] = '1;34';
        $this->foreground_colors['green'] = '0;32';
        $this->foreground_colors['light_green'] = '1;32';
        $this->foreground_colors['cyan'] = '0;36';
        $this->foreground_colors['light_cyan'] = '1;36';
        $this->foreground_colors['red'] = '0;31';
        $this->foreground_colors['light_red'] = '1;31';
        $this->foreground_colors['purple'] = '0;35';
        $this->foreground_colors['light_purple'] = '1;35';
        $this->foreground_colors['brown'] = '0;33';
        $this->foreground_colors['yellow'] = '1;33';
        $this->foreground_colors['light_gray'] = '0;37';
        $this->foreground_colors['white'] = '1;37';

        $this->background_colors['black'] = '40';
        $this->background_colors['red'] = '41';
        $this->background_colors['green'] = '42';
        $this->background_colors['yellow'] = '43';
        $this->background_colors['blue'] = '44';
        $this->background_colors['magenta'] = '45';
        $this->background_colors['cyan'] = '46';
        $this->background_colors['light_gray'] = '47';
    }

    // Returns colored string
    public function getColoredString($string, $foreground_color = null, $background_color = null) {
        $colored_string = "";

        // Check if given foreground color found
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset($this->background_colors[$background_color])) {
            $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
        }

        // Add string and end coloring
        $colored_string .=  $string . "\033[0m";

        return $colored_string;
    }

    // Returns all foreground color names
    public function getForegroundColors() {
        return array_keys($this->foreground_colors);
    }

    // Returns all background color names
    public function getBackgroundColors() {
        return array_keys($this->background_colors);
    }
}

function multicurl($arrayreq){
	$mh = curl_multi_init();
    $curl_array = array();
	for($i=0;$i<count($arrayreq);$i++){
		$curl_array[$i] = curl_init();
		curl_setopt($curl_array[$i], CURLOPT_URL, $arrayreq[$i][0]);
		curl_setopt($curl_array[$i], CURLOPT_RETURNTRANSFER, true);
		if($arrayreq[$i][1]!=null){
			curl_setopt($curl_array[$i], CURLOPT_POSTFIELDS, $arrayreq[$i][1]);
		}
		curl_setopt($curl_array[$i], CURLOPT_CUSTOMREQUEST, $arrayreq[$i][2]);
		if($arrayreq[$i][3]!=null){
			curl_setopt($curl_array[$i], CURLOPT_HTTPHEADER, $arrayreq[$i][3]);
		}
		
		curl_setopt($curl_array[$i], CURLOPT_HEADER, true);	
		curl_setopt($curl_array[$i], CURLOPT_HEADER, true);	
		curl_setopt($curl_array[$i], CURLOPT_ENCODING, 'gzip');
		curl_multi_add_handle($mh, $curl_array[$i]);
	}
	$running = NULL;
    do{
        curl_multi_exec($mh,$running);
    }
	while($running > 0);
	for($i=0;$i<count($arrayreq);$i++){
		$header_size = curl_getinfo($curl_array[$i], CURLINFO_HEADER_SIZE);
		$body []= substr(curl_multi_getcontent($curl_array[$i]),$header_size);
	}
	for($i=0;$i<count($arrayreq);$i++){
	 curl_multi_remove_handle($mh, $curl_array[$i]);
    }
	return $body;		
}
function request($url, $param, $headers=null, $request = 'POST',$cookie=null,$followlocation=0,$proxy=null,$port=null) {
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
		if($param!=null){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		}
		if($headers!=null){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		}	
		if($port!=null){
			curl_setopt($ch, CURLOPT_PORT, $port);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		}
		elseif($port==null){
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
		if($cookie!=null){
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
		}
		if($proxy!=null){
			curl_setopt($ch, CURLOPT_PROXY, $proxy);
			curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
		}
		if($followlocation==1){
			curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 100);
		}
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
        curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$execute = curl_exec($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($execute, 0, $header_size);
		$body = substr($execute, $header_size);
		curl_close($ch);
		return [$header,$body];
}
