<?php
awal:
echo "[+] Created By Apri Amsyah\n\n";
echo "{1} Wahana Resi Validator And Extrap\n{2} USPS Resi Validator And Extrap\n{3} Fedex Resi Validator And Extrap\n\n";
echo "Pilih Apa ? ";
$pilihan = trim(fgets(STDIN));
echo "\n";
if ($pilihan == 1){
while(true) {
$angka = acak(8);

    $headers = [
        'Host: www.wahana.com',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Accept-Language: en-US,en;q=0.5',
        'Accept-Encoding: gzip, deflate',
        'Connection: close',
        'Referer: https://www.wahana.com/',
    ];

    $wahana = curlget('https://www.wahana.com/lacak-kiriman?noresi='.$angka.'', null, $headers);
    $info = get_between($wahana[1], 'Diterima oleh ', '</div>');
    if (strpos($wahana[1], 'Status Terakhir')) {
        echo "[+] No Resi $angka Valid Penerima Adalah $info\n";
        fwrite(fopen('wahana.txt', 'a'), "$angka\n");
    } else {
        echo "[+] No Resi $angka Tidak Valid\n";
    }
}
} else if ($pilihan == 2) {
    while(true) {
    $angka = angka(9);
    $rand = ['LX', 'LY'];
    $resi = ''.$rand[rand(0,1)].''.$angka.'US';
    $getCookie = curlget('https://global.cainiao.com/detail.htm?mailNoList='.$resi.'', null, null);
    if (strpos($getCookie[1], 'Depart From')) {
        echo "[+] No Resi $resi Valid\n";
        fwrite(fopen('USPS.txt', 'a'), "$resi\n");
    } else {
        echo "[+] No Resi $resi Tidak Valid\n";
    }
}
} else if($pilihan == 3) {
    while(true) {
    $resi = angka(12);
    $headers = [
        'Host: www.fedex.com',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0',
        'Accept: */*',
        'Accept-Language: en-US,en;q=0.5',
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
        'X-Requested-With: XMLHttpRequest',
        'Origin: https://www.fedex.com',
        'Connection: close',
        'Referer: https://www.fedex.com/en-us/home.html',
    ];

    $data = 'data=%7B%22TrackPackagesRequest%22%3A%7B%22appType%22%3A%22WTRK%22%2C%22appDeviceType%22%3A%22%22%2C%22supportHTML%22%3Atrue%2C%22supportCurrentLocation%22%3Atrue%2C%22uniqueKey%22%3A%22%22%2C%22processingParameters%22%3A%7B%7D%2C%22trackingInfoList%22%3A%5B%7B%22trackNumberInfo%22%3A%7B%22trackingNumber%22%3A%22'.$resi.'%22%2C%22trackingQualifier%22%3A%22%22%2C%22trackingCarrier%22%3A%22%22%7D%7D%5D%7D%7D&action=trackpackages&locale=en_US&version=1&format=json';
    $check = curl('https://www.fedex.com/trackingCal/track', $data, $headers);
    $content = $check[0];
    $content = get_between($content, 'Content-Length: ', "\n");
    if ($content > 10100) {   
        echo "[+] No Resi $resi Valid\n";
        fwrite(fopen('fedex.txt', 'a'), "$resi\n");
    } else {
        echo "[+] No Resi $resi Tidak Valid\n";
    }
}
}else if($pilihan > 3) {
    echo "[+] Pilihan Tidak Ada\n\n";
    goto awal;
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
    $karakter= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
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
