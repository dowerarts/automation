<?php
error_reporting(0);

echo "             _            _                     _                 _           
            | |          | |                   | |               | |          
  __ _ _   _| |_ ___   __| | _____      ___ __ | | ___   __ _  __| | ___ _ __ 
 / _` | | | | __/ _ \ / _` |/ _ \ \ /\ / / '_ \| |/ _ \ / _` |/ _` |/ _ \ '__|
| (_| | |_| | || (_) | (_| | (_) \ V  V /| | | | | (_) | (_| | (_| |  __/ |   
 \__,_|\__,_|\__\___/ \__,_|\___/ \_/\_/ |_| |_|_|\___/ \__,_|\__,_|\___|_|   
                                                                By Apri Amsyah\n\n";

echo "1.) Youtube MP4 Downloader\n2.) Youtube MP3 Downloader\n\n\n";
echo "Pilih Tools 1/2/dst : ";
$pilihan = trim(fgets(STDIN));

echo "\n";
if ($pilihan == 1) {
echo "[+] Url Youtube : ";
$url = trim(fgets(STDIN));
$url = urlencode($url);

$headers = [
    'Host: yt1s.com',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0',
    'Accept: */*',
    'Accept-Language: en-US,en;q=0.5',
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'X-Requested-With: XMLHttpRequest',
    'Origin: https://yt1s.com',
    'Referer: https://yt1s.com/youtube-to-mp4/id',
    'Connection: close',
];

$data = 'q='.$url.'&vt=mp4';
$getVideo = curl('https://yt1s.com/api/ajaxSearch/index', $data, $headers);
$vid = get_between($getVideo[1], '"vid":"', '","');
$kc = get_between($getVideo[1], '"kc":"', '"');
$author = get_between($getVideo[1], 'a":"', '"');
$kc = urlencode($kc);
$headers = [
    'Host: yt1s.com',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0',
    'Accept: */*',
    'Accept-Language: en-US,en;q=0.5',
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'X-Requested-With: XMLHttpRequest',
    'Origin: https://yt1s.com',
    'Referer: https://yt1s.com/youtube-to-mp4/id',
    'Connection: close',
];

$data = 'vid='.$vid.'&k='.$kc.'';
$getVideo = curl('https://yt1s.com/api/ajaxConvert/convert', $data, $headers);
$linkdownloadVideo = get_between($getVideo[1], '"dlink":"', '"');
$linkdownloadVideo = str_replace('\\','',$linkdownloadVideo);
$title = get_between($getVideo[1], '"title":"\"', '\"');
$title2 = get_between($getVideo[1], '"title":"', '"');

if ($title) {
echo "[+] Sedang Download $title Author : $author\n";
$downloadVideo = trim(file_get_contents($linkdownloadVideo));
if ($downloadVideo === false ) {
    throw new Exception('Failed to download file at: ' . $url);
}

mkdir("video");
$filename = 'video/'.$title.'.mp4';
$save = file_put_contents($filename, $downloadVideo);
echo "[+] Sukses Save File Name $title.mp4 Di Folder Video\n";
$bytes = filesize('audio/'.$title.'.mp3');
$videoSize= formatSizeUnits($bytes);
echo "[+] Total Size $videoSize\n";
} else if ($title2) {
    echo "[+] Sedang Download $title2 Author : $author\n";
    $downloadVideo = trim(file_get_contents($linkdownloadVideo));
    if ($downloadVideo === false ) {
        throw new Exception('Failed to download file at: ' . $url);
    }
    
    mkdir("video");
    $filename = 'video/'.$title2.'.mp4';
    $save = file_put_contents($filename, $downloadVideo);
    echo "[+] Sukses Save File Name $title2.mp4 Di Folder Video\n";
    $bytes = filesize('audio/'.$title2.'.mp3');
    $videoSize= formatSizeUnits($bytes);
    echo "[+] Total Size $videoSize\n";
}
} else if ($pilihan == 2) {
echo "[+] Url Youtube : ";


$url = trim(fgets(STDIN));
$url = urlencode($url);

$headers = [
    'Host: yt1s.com',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0',
    'Accept: */*',
    'Accept-Language: en-US,en;q=0.5',
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'X-Requested-With: XMLHttpRequest',
    'Origin: https://yt1s.com',
    'Referer: https://yt1s.com/youtube-to-mp3/id',
    'Connection: close',
];

$data = 'q='.$url.'&vt=mp3';
$getAudio = curl('https://yt1s.com/api/ajaxSearch/index', $data, $headers);
$auid = get_between($getAudio[1], '"vid":"', '","');
$kc = get_between($getAudio[1], '"kc":"', '"');
$kc = urlencode($kc);
$author = get_between($getAudio[1], 'a":"', '"');

$title = get_between($getAudio[1], '"title":"\"', '\"');
$title2 = get_between($getAudio[1], '"title":"', '"');
$headers = [
    'Host: yt1s.com',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:86.0) Gecko/20100101 Firefox/86.0',
    'Accept: */*',
    'Accept-Language: en-US,en;q=0.5',
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'X-Requested-With: XMLHttpRequest',
    'Origin: https://yt1s.com',
    'Referer: https://yt1s.com/youtube-to-mp3/id',
    'Connection: close',
];

$data = 'vid='.$auid.'&k='.$kc.'';
$getAudio = curl('https://yt1s.com/api/ajaxConvert/convert', $data, $headers);
$linkdownloadAudio = get_between($getAudio[1], '"dlink":"', '"');
$linkdownloadAudio = str_replace('\\','',$linkdownloadAudio);


if ($title) {
    echo "[+] Sedang Download $title Author : $author\n";
$downloadAudio = trim(file_get_contents($linkdownloadAudio));
if ($downloadAudio === false ) {
    throw new Exception('Failed to download file at: ' . $url);
}
mkdir("audio");
$filename = 'audio/'.$title.'.mp3';
$save = file_put_contents($filename, $downloadAudio);
echo "[+] Sukses Save File Name $title.mp3 Di Folder Audio\n";
$bytes = filesize('audio/'.$title.'.mp3');
echo "[+] Total Size $audioSize\n";
} else if($title2) {
    echo "[+] Sedang Download $title2 Author : $author\n";
    $downloadAudio = trim(file_get_contents($linkdownloadAudio));
if ($downloadAudio === false ) {
    throw new Exception('Failed to download file at: ' . $url);
}
mkdir("audio");
$filename = 'audio/'.$title2.'.mp3';
$save = file_put_contents($filename, $downloadAudio);
echo "[+] Sukses Save File Name $title2.mp3 Di Folder Audio\n";
sleep(5);
$bytes = filesize('audio/'.$title2.'.mp3');
$audioSize= formatSizeUnits($bytes);
echo "[+] Total Size $audioSize\n";
}
}

function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
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
