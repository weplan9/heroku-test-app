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
		
		
		//set the host name
		if(strpos($_SERVER['HTTP_REFERER'], 'ytbits.com')	!== FALSE){
			$fileNameAndHost = $fileName.'-YTBits.com.mp3';
		}else{
			$fileNameAndHost = $fileName.'-YTPak.com.mp3';
		}
		
		
		//first of all check for cache folder.
		$fileCacheFolderFind = glob('quickview/*-'.$fileName.$min.$max);
		
		if (isset($fileCacheFolderFind[0])) {// check if folder already exists
		
			$finalFile = $fileCacheFolderFind[0].'/'.$fileNameAndHost;
			header('Location: '.'https://'.$_ENV['HTTP_HOST'].'/'.$finalFile); //do a temporary 302 redirect to the final file.
			//header('Location: '.'http://'.$_ENV['HTTP_HOST'].'/'.$finalFile, true, 301);  //for 301 Moved Permanently
			exit;
			
		}
		
		
		
		//if we are here it means we dont have the file in cache folder.
		$fileCacheFolder = 'quickview/'.$_ENV['HTTP_X_REQUEST_ID'].'-'.$fileName.$min.$max.'/';
		$finalFile = $fileCacheFolder.$fileNameAndHost;
		
		
		//before calling ffmpeg we need to test the video
		$videoTest = $this->testVideoDownload($streamUrl);
		
		if($videoTest == false){
			echo 'We were unable to access the video, please try again later.';
			exit();
		}
		
		//we are now read to call the ffmpeg but first create the folder
		mkdir($fileCacheFolder);
		
		//$output = shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame '.$finalFile.' 2>&1');
		//$output = shell_exec('ffmpeg -i "'.$streamUrl.'" -c:a libmp3lame -aq 2 '.$finalFile.' 2>&1');
      		//$output = shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame -aq 2 '.$finalFile.' 2>&1');
		
		//shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame '.$finalFile);
		shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame -aq 2 '.$finalFile);
		
		
		if(!file_exists($finalFile)) { //sometimes we do get 403 errors this will not save any file
			echo 'We could not process your mp3 at this time, please try again later.';
			exit();
		}
		
		header('Location: '.'https://'.$_ENV['HTTP_HOST'].'/'.$finalFile); //do a temporary 302 redirect to the final file.
		//header('Location: '.'http://'.$_ENV['HTTP_HOST'].'/'.$finalFile, true, 301);  //for 301 Moved Permanently
		exit;
		
		
		


		
		
		
		/*
		if(strpos($_SERVER['HTTP_REFERER'], 'ytbits.com')	!== FALSE){
			
			
			$finalFile = 'quickview/'.$_ENV['HTTP_X_REQUEST_ID'].'-'.$fileName.$min.$max.'-YTBits.com.mp3';
			$filesCache = glob('quickview/*-'.$fileName.$min.$max.'-YTBits.com.mp3');
			$fileNameToSet = $fileName.'-YTBits.com.mp3';

		}else{
			
			$finalFile = 'quickview/'.$_ENV['HTTP_X_REQUEST_ID'].'-'.$fileName.$min.$max.'-YTPak.com.mp3';
			$filesCache = glob('quickview/*-'.$fileName.$min.$max.'-YTPak.com.mp3');
			$fileNameToSet = $fileName.'-YTPak.com.mp3';
		}
		
		
		if (isset($filesCache[0])) {// do not process if file exists already starts
			$fileToDownload = $filesCache[0];
		}else{
			
			//before calling ffmpeg we need to test the video
			$videoTest = $this->testVideoDownload($streamUrl);
			
			if($videoTest == false){
				echo 'We were unable to access the video, please try again later.';
				exit();
			}
			
			//$output = shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame '.$finalFile.' 2>&1');
			//$output = shell_exec('ffmpeg -i "'.$streamUrl.'" -c:a libmp3lame -aq 2 '.$finalFile.' 2>&1');
			//$output = shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame -aq 2 '.$finalFile.' 2>&1');
			
			//shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame '.$finalFile);
			shell_exec('ffmpeg -ss '.$min.' -y -i "'.$streamUrl.'" -t '.$max.' -c:a libmp3lame -aq 2 '.$finalFile);
			$fileToDownload = $finalFile;
			
			if(!file_exists($fileToDownload)) { //sometimes we do get 403 errors this will not save any file
				echo 'We cannot process your mp3 at this time, please try again later.';
				exit();
			}
		}
		
		
		header('Location: '.'http://'.$_ENV['HTTP_HOST'].'/'.$fileToDownload); //do a temporary 302 redirect to the final file.
		//header('Location: '.'http://'.$_ENV['HTTP_HOST'].'/'.$finalFile, true, 301);  //for 301 Moved Permanently
		exit;
		*/
		
		
		
		
	}//function convertMp3 ends
	
	
	
	


	function cacheVideo($streamUrl, $fileName){	//function cacheVideo
		
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
		

		//set the host name
		if(strpos($_SERVER['HTTP_REFERER'], 'ytbits.com')	!== FALSE){
			$fileNameAndHost = $fileName.'-YTBits.com.mp4';
		}else{
			$fileNameAndHost = $fileName.'-YTPak.com.mp4';
		}
		
		
		//first of all check for cache folder.
		$fileCacheFolderFind = glob('quickview/*-'.$fileName);
		
		if (isset($fileCacheFolderFind[0])) {// check if folder already exists
		
			$finalFile = $fileCacheFolderFind[0].'/'.$fileNameAndHost;
			header('Location: '.'https://'.$_ENV['HTTP_HOST'].'/'.$finalFile); //do a temporary 302 redirect to the final file.

			exit;
		}
		
		//if we are here it means we dont have the file in cache folder.
		$fileCacheFolder = 'quickview/'.$_ENV['HTTP_X_REQUEST_ID'].'-'.$fileName.'/';
		$finalFile = $fileCacheFolder.$fileNameAndHost;
		
		
		//we need to test the video if our server can download it or not
		$videoTest = $this->testVideoDownload($streamUrl);
		
		if($videoTest == false){
			echo 'We were unable to access the video, please try again later.';
			exit();
		}
		
		//we are now read to call the ffmpeg but first create the folder
		mkdir($fileCacheFolder);
		
		//file_put_contents($finalFile, file_get_contents($streamUrl));
		file_put_contents($finalFile, fopen($streamUrl, 'r')); //Since PHP 5.1.0, file_put_contents() supports writing piece-by-piece by passing a stream-handle as the $data parameter
		
		/* //curl is not working making mp4 corrupt
		$ch = curl_init($streamUrl);
		$fp = fopen($finalFile, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER,         true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //do not verify peer
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //do not verify host
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //follow 302 redirects
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		*/
		
		if(!file_exists($finalFile)) { //sometimes we do get 403 errors this will not save any file
			echo 'We could not process your video at this time, please try again later.';
			exit();
		}
		
		header('Location: '.'https://'.$_ENV['HTTP_HOST'].'/'.$finalFile); //do a temporary 302 redirect to the final file.
		//header('Location: '.'http://'.$_ENV['HTTP_HOST'].'/'.$finalFile, true, 301);  //for 301 Moved Permanently
		exit;
	
	}//function cacheVideo

	
	
	
	
	
	
	
	function testVideoDownload($url){	//function getVideoSize start
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HEADER,         true);
		curl_setopt($ch, CURLOPT_NOBODY,         true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT,        10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //do not verify peer
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //do not verify host

		$result = curl_exec($ch);
		$result = explode("\n", $result);	//note that '\n' will not work, Try avoiding single quotes in curl objects
		
		
		if(strpos($result[0], 'HTTP/1.1 403 Forbidden') === 0) {
			return false;
		}

		
		if(strpos($result[0], 'HTTP/1.1 503 Service Unavailable') === 0) {
			return false;
		}
		
		if(strpos($result[0], 'HTTP/1.1 302 Found') === 0) { //video is downloadable its just getting redirect to new location, we think ffmpeg can handel this.
			return true;
		}
		
		
		if(strpos($result[7], 'Content-Length:') === 0) {	//seems like everything is fine
			return true;
		}

		//for everything else return false;
		return false;
		
	}//function getVideoSize ends
	
	
	
	
	
	
	
	function base64UrlEncode($data){
	  return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
	}
	
	function base64UrlDecode($base64){
	  return base64_decode(strtr($base64, '-_', '+/'));
	}
	
	
	
}//main yt class ends here
?>
