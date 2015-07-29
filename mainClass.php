<?php if(!defined('directAccess'))   die('Direct access not permitted');

class yt{
	
	var $printJson = array();
	
	
	function convertMp3($streamUrl, $fileName){	//function convertMp3 starts
		
		$streamUrl 	= $this->base64UrlDecode(str_replace('http://', 'https://', $streamUrl));	///make http to https and decode the string

		//validate the URL.
		$checkUrl = parse_url($streamUrl, PHP_URL_HOST);
		if(strpos(strtolower($checkUrl), '.googlevideo.com') !== false || strpos(strtolower($checkUrl), '.googleusercontent.com') !== false || strpos(strtolower($checkUrl), '.youtube.com') !== false){
			
		}else{
			//alter do not download this!!!! string doesn't contain .googlevideo.com stop
			header('HTTP/1.0 403 Forbidden he');
			exit();
		}
		
		
		if (strpos($streamUrl, 'ratebypass=yes') === false) {
			$streamUrl 	= $streamUrl.'&ratebypass=yes';
		}
		
		
		if(isset($_GET['min'])){
			$min = $_GET['min']+1;
		}else{
			$min = 0;
		}
		
		if(isset($_GET['max'])){	//set to maximum 10 minutes = 600
			$max = $_GET['max'] - $min;
			if($max > 600){
				$max = 600;
			}
		}else{
			$max = 600;
		}
		
			
		$finalFile = 'quickview/'.$_ENV['HTTP_X_REQUEST_ID'].'-'.$fileName.$min.$max.'.mp3';
		
		$filesCache = glob('quickview/*-'.$fileName.$min.$max.'.mp3');
		
		echo '<pre>';
		print_r($filesCache);
		echo '</pre>';
		die;

		
		
		if (isset($filesCache[0])) {// do not process if file exists already starts
			$fileToDownload = $filesCache[0];
		}else{
			
			//$output = shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame '.$finalFile.' 2>&1');
			//$output = shell_exec('ffmpeg -i "'.$streamUrl.'" -c:a libmp3lame -aq 2 '.$finalFile.' 2>&1');
			//$output = shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame -aq 2 '.$finalFile.' 2>&1');
			
			//shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame '.$finalFile);
			shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame -aq 2 '.$finalFile);
			$fileToDownload = $finalFile;
		}
		
		if(strpos($_SERVER['HTTP_REFERER'], 'ytbits.com')	!== FALSE){
			$fileNameToSet = $fileName.'-YTBits.com.mp3';
		}else{
			$fileNameToSet = $fileName.'-YTPak.com.mp3';
		}

		
		header('Content-Disposition: attachment; filename= "' . $fileNameToSet . '"');
		
		header("Content-Transfer-Encoding: binary");
		header("Content-Type: audio/mpeg");
		header('Content-Length: ' . filesize($fileToDownload));
		
		readfile($fileToDownload);
		exit();
	}//function convertMp3 ends
	
	
	
	
	function base64UrlEncode($data){
	  return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
	}
	
	function base64UrlDecode($base64){
	  return base64_decode(strtr($base64, '-_', '+/'));
	}
	
	
	
}//main yt class ends here
?>