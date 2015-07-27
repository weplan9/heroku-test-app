<?php if(!defined('directAccess'))   die('Direct access not permitted');

class yt{
	
	var $printJson = array();
	
	
	
	function playSecureStreamThree($videoId, $streamUrlOne, $streamUrlTwo){
		
		$downloadUrlOne 	= $this->base64UrlDecode($streamUrlOne);
		$downloadUrlTwo		= $this->base64UrlDecode($streamUrlTwo);
		
		if (strpos($downloadUrlOne, 'ratebypass=yes') === false) {
			$downloadUrlOne 	= $downloadUrlOne.'&ratebypass=yes';
		}
		
		if (strpos($downloadUrlTwo, 'ratebypass=yes') === false) {
			$downloadUrlTwo 	= $downloadUrlTwo.'&ratebypass=yes';
		}
		
		
		$downloadUrlOne = str_replace('.ytpak.com', '.googlevideo.com', $downloadUrlOne);
		$downloadUrlOne = str_replace('http://', 'https://', $downloadUrlOne);	//this is important now google uses https so make sure we use https
		$downloadUrlOne = str_replace('.c.docs.google.com', '.googlevideo.com', $downloadUrlOne);
		
		$downloadUrlTwo = str_replace('.ytpak.com', '.googlevideo.com', $downloadUrlTwo);
		$downloadUrlTwo = str_replace('http://', 'https://', $downloadUrlTwo);	//this is important now google uses https so make sure we use https
		$downloadUrlTwo = str_replace('.c.docs.google.com', '.googlevideo.com', $downloadUrlTwo);
		
		
		$checkUrl = parse_url($downloadUrlOne, PHP_URL_HOST);
		if(strpos(strtolower($checkUrl), '.googlevideo.com') !== false || strpos(strtolower($checkUrl), '.youtube.com') !== false){	//check if string host not contains .googlevideo.com
			
		}else{
			//alter do not download this!!!! string doesn't contain .googlevideo.com stop
			header('HTTP/1.0 403 Forbidden hethree');
			exit();
		}
		
		
		$checkUrl = parse_url($downloadUrlTwo, PHP_URL_HOST);
		if(strpos(strtolower($checkUrl), '.googlevideo.com') !== false || strpos(strtolower($checkUrl), '.youtube.com') !== false){	//check if string host not contains .googlevideo.com
			
		}else{
			//alter do not download this!!!! string doesn't contain .googlevideo.com stop
			header('HTTP/1.0 403 Forbidden he');
			exit();
		}
		
		$finalFile = 'quickview/'.$_ENV['HTTP_X_REQUEST_ID'].'-three-'.$videoId.'.mp4';
		$filesCache = glob('quickview/*-three-'.$videoId.'.mp4');
		
		if (isset($filesCache[0])) {// do not process if file exists already starts
			$fileToDownload = $filesCache[0];
		}else{
			/*
			$output = shell_exec('ffmpeg -i "'.$downloadUrlOne.'" -i "'.$downloadUrlTwo.'" -vcodec copy -acodec copy '.$finalFile.' 2>&1');
			
			echo '<pre>';
			print_r($output);
			echo '</pre>';
			die;
			*/
			shell_exec('ffmpeg -i "'.$downloadUrlOne.'" -i "'.$downloadUrlTwo.'" -vcodec copy -acodec copy '.$finalFile);
			$fileToDownload = $finalFile;
			
		}
		
		header('Location: '.$fileToDownload , true, 302);
		exit;

	}
	
	
	
	
	
	
	
	
	
	function playSecureStreamTwo($videoId, $streamUrlOne, $streamUrlTwo){
		
		$downloadUrlOne 	= $this->base64UrlDecode($streamUrlOne);
		$downloadUrlTwo		= $this->base64UrlDecode($streamUrlTwo);
		
		if (strpos($downloadUrlOne, 'ratebypass=yes') === false) {
			$downloadUrlOne 	= $downloadUrlOne.'&ratebypass=yes';
		}
		
		if (strpos($downloadUrlTwo, 'ratebypass=yes') === false) {
			$downloadUrlTwo 	= $downloadUrlTwo.'&ratebypass=yes';
		}
		
		
		$downloadUrlOne = str_replace('.ytpak.com', '.googlevideo.com', $downloadUrlOne);
		$downloadUrlOne = str_replace('http://', 'https://', $downloadUrlOne);	//this is important now google uses https so make sure we use https
		$downloadUrlOne = str_replace('.c.docs.google.com', '.googlevideo.com', $downloadUrlOne);
		
		$downloadUrlTwo = str_replace('.ytpak.com', '.googlevideo.com', $downloadUrlTwo);
		$downloadUrlTwo = str_replace('http://', 'https://', $downloadUrlTwo);	//this is important now google uses https so make sure we use https
		$downloadUrlTwo = str_replace('.c.docs.google.com', '.googlevideo.com', $downloadUrlTwo);
		
		
		$checkUrl = parse_url($downloadUrlOne, PHP_URL_HOST);
		if(strpos(strtolower($checkUrl), '.googlevideo.com') !== false || strpos(strtolower($checkUrl), '.youtube.com') !== false){	//check if string host not contains .googlevideo.com
			
		}else{
			//alter do not download this!!!! string doesn't contain .googlevideo.com stop
			header('HTTP/1.0 403 Forbidden he');
			exit();
		}
		
		
		$checkUrl = parse_url($downloadUrlTwo, PHP_URL_HOST);
		if(strpos(strtolower($checkUrl), '.googlevideo.com') !== false || strpos(strtolower($checkUrl), '.youtube.com') !== false){	//check if string host not contains .googlevideo.com
			
		}else{
			//alter do not download this!!!! string doesn't contain .googlevideo.com stop
			header('HTTP/1.0 403 Forbidden he');
			exit();
		}
		
		$finalFile = 'quickview/'.$_ENV['HTTP_X_REQUEST_ID'].'-two-'.$videoId.'.mp4';
		$filesCache = glob('quickview/*-two-'.$videoId.'.mp4');
		
		
		
		if (isset($filesCache[0])) {// do not process if file exists already starts
			$fileToDownload = $filesCache[0];
		}else{
			/*
			$output = shell_exec('ffmpeg -i "'.$downloadUrlOne.'" -i "'.$downloadUrlTwo.'" -vcodec copy -acodec copy '.$finalFile.' 2>&1');
			
			echo '<pre>';
			print_r($output);
			echo '</pre>';
			die;
			*/
			shell_exec('ffmpeg -i "'.$downloadUrlOne.'" -i "'.$downloadUrlTwo.'" -vcodec copy -acodec copy '.$finalFile);
			$fileToDownload = $finalFile;
			
		}
		
		header('Location: '.$fileToDownload , true, 302);
		exit;

	}
	
	
	
	
	
	function convertMp3($streamUrl, $fileName){	//function convertMp3 starts

		
		$streamUrl 	= $this->base64UrlDecode($streamUrl);
		$streamUrl = str_replace('.ytpak.com', '.googlevideo.com', $streamUrl);
		
		$streamUrl = str_replace('http://', 'https://', $streamUrl);	//this is important now google uses https so make sure we use https
		$streamUrl = str_replace('.c.docs.google.com', '.googlevideo.com', $streamUrl);
		
		//I think someone is abusing this loophole in a way that if the download url is changed my script will start to download that url without validating it.
		//we need to fix this.
		$checkUrl = parse_url($streamUrl, PHP_URL_HOST);
		if(strpos(strtolower($checkUrl), '.googlevideo.com') !== false || strpos(strtolower($checkUrl), '.youtube.com') !== false){	//check if string host not contains .googlevideo.com
			
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
	
	
	
	
	
	
	
	function quickVideoView($videoId){	//function getYtStream starts

		$finalFile = 'quickview/'.$_ENV['HTTP_X_REQUEST_ID'].'-'.$videoId.'.flv';
		
		$filesCache = glob('quickview/*-'.$videoId.'.flv');
		//if (file_exists($filesCache[0])) {// do not process if file exists already starts
		if (isset($filesCache[0])) {// do not process if file exists already starts
			
			$printJson['error'] 		= false;
			$printJson['fromCache'] 	= true;
			$printJson['quickVideoFLV'] = 'http://'.$_ENV['HTTP_HOST'].'/'.$filesCache[0];
			echo json_encode($printJson);
			exit();
			
		}// do not process if file exists already ends

		
	
		$formats = $this->getYtStream($videoId, true);

		$itag17 = array();
		foreach($formats['formats'] as $format){//start foreach $formats
		
			if($format['itag'] == '17'){
				$itag17['type'] 		= $format['type'];
				$itag17['videoSize'] 	= $format['videoSize'];
				$itag17['downloadURL'] 	= str_replace('http://', 'https://', str_replace('.c.docs.google.com', '.googlevideo.com', str_replace('.ytpak.com', '.googlevideo.com', $format['downloadUrl'])));

				if (strpos($itag17['downloadURL'], 'ratebypass=yes') === false) {
					$itag17['downloadURL']	= $itag17['downloadURL'].'&ratebypass=yes';
				}
			}
		}
		
		//to check ffmpeg output use the following code.
		//$output = shell_exec('ffmpeg -y -i "'.$itag17['downloadURL'].'" -c:v flv1 -b:v 32k -filter:v "crop=120:68:28:38" -r 2 -c:a copy '.$finalFile.' 2>&1');
		shell_exec('ffmpeg -y -i "'.$itag17['downloadURL'].'" -c:v flv1 -b:v 32k -filter:v "crop=120:68:28:38" -r 3 -c:a copy '.$finalFile);
		
		
		
		$printJson['error'] = false;
		$printJson['quickVideoFLV'] = 'http://'.$_ENV['HTTP_HOST'].'/'.$finalFile;
		
		echo json_encode($printJson);
		exit();
		
	}

	
	function getYtStream($videoId, $quickVideoView = false){	//function getYtStream starts
	
		require_once('lib'.DS.'new-curl'.DS.'new-curl.php');
		$curl = new Curl();	// instantiate the Curl class
		
		$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		//$curl->setOpt(CURLOPT_HTTPHEADER, array("REMOTE_ADDR: $ip", "HTTP_X_FORWARDED_FOR: $ip"));
		//$curl->setOpt(CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36');
		$curl->get('https://www.youtube.com/get_video_info?video_id='.$videoId.'&el=vevo');
		//parse the body to ytbody
		parse_str($curl->response, $ytBody);
		
		//check for restrictions
		$this->checkYtRestrictions($ytBody);
		
		//now check if the cipher is used
		if($ytBody['use_cipher_signature'] === 'True'){	//vevo or other secure video detected!
			$useCipherSig = true;
		}else{
			$useCipherSig = false;
		}
		
		//get the formats nows
		if($iTag == NULL){
			$iTag = array();
			$iTag[] = '22';	//22 is for mp4 720p
			$iTag[] = '18';	//$iTag = 18 = video/mp4	medium
			$iTag[] = '17';	 //17 is for 3gp 240
			$iTag[] = '140'; //140 is for audio/mp4; codecs="mp4a.40.2"
			$iTag[] = '135'; //135 video/mp4; codecs="avc1.4d401e" MP4 640 x 480 VO
			$iTag[] = '137'; //137 video/mp4; codecs="avc1.640028"  MP4 1920 x 1080 VO
			$iTag[] = '171'; //171 is for audio/webm; codecs="vorbis"
		}
		
		$formats = $this->getYtFormats($ytBody, $iTag, $useCipherSig, $videoId, $curl);
		
		if(empty($formats)){
			$printJson['error'] = true;
		}
		
		
		if( ($ytBody['has_cc'] == 'True') && ($ytBody['cc_asr'] == '1')){
			$has_cc = true;
		}else{
			$has_cc = false;
		}
		
		$printJson['error'] = false;
		$printJson['useCipherSig'] 	= $useCipherSig;
		$printJson['formats'] 		= $formats;
		$printJson['has_cc'] 		= $has_cc;
		
		if($quickVideoView){
			return $printJson;
		}else{
			echo json_encode($printJson);
			exit();
		}
		
	}	//function getYtStream ends
	
	
	
	
	function checkYtRestrictions($ytBody){// function checkYtRestrictions start
	
		if($ytBody['status'] == 'fail' && $ytBody['errorcode'] == '150'){	//could not get video information maybe the wrong id?
			$printJson['error'] = true;
			$printJson['msg'] = $ytBody['reason'];
			echo json_encode($printJson);
			exit();
		}

		if($ytBody['status'] == 'fail'){	//could not get video information maybe the wrong id?
			$printJson['error'] = true;
			$printJson['msg'] = 'Something went wrong. Maybe the video ID is not correct.';
			echo json_encode($printJson);
			exit();
		}

		if(isset($ytBody['ypc_video_rental_bar_text']) && $ytBody['ypc_video_rental_bar_text'] == 'This video requires payment to watch.'){
			$printJson['error'] = true;
			$printJson['msg'] = 'Stupid publisher has restricted this video in our country. We don\'t need to watch this video anyway! right?';
			echo json_encode($printJson);
			exit();
		}
		
		return true;
	}// function checkYtRestrictions ends
	
	
	
	
	
	
	
	
	function checkSecureStream($url){	//function getVideoSize start
		
		$my_ch = curl_init();
		curl_setopt($my_ch, CURLOPT_URL,$url);
		curl_setopt($my_ch, CURLOPT_HEADER,         true);
		curl_setopt($my_ch, CURLOPT_NOBODY,         true);
		curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($my_ch, CURLOPT_TIMEOUT,        10);
		$result = curl_exec($my_ch);
		$result = explode("\n", $result);	//note that '\n' will not work, Try avoiding single quotes in curl objects
		
		
		if(strpos($result[0], 'HTTP/1.1 200 OK') === 0) {
			return true;
		}else{
			header('HTTP/1.0 403 Forbidden cs');
			exit();
		}
		
		

	}//function getVideoSize ends
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function playSecureStream($videoSize, $streamUrl, $downloadVideo, $fileName, $extension){	//function playSecureStream starts
	
		$size			= $videoSize;
		$downloadUrl 	= $this->base64UrlDecode($streamUrl);
		
		if (strpos($downloadUrl, 'ratebypass=yes') === false) {
			$downloadUrl 	= $downloadUrl.'&ratebypass=yes';
		}
		
		$downloadUrl = str_replace('.ytpak.com', '.googlevideo.com', $downloadUrl);
		//I think someone is abusing this loophole in a way that if the download url is changed my script will start to download that url without validating it.
		//we need to fix this.
		
		$checkUrl = parse_url($downloadUrl, PHP_URL_HOST);
		if(strpos(strtolower($checkUrl), '.googlevideo.com') !== false || strpos(strtolower($checkUrl), '.youtube.com') !== false){	//check if string host not contains .googlevideo.com
			
		}else{
			//alter do not download this!!!! string doesn't contain .googlevideo.com stop
			header('HTTP/1.0 403 Forbidden he');
			exit();
		}
		
		
		
		//$this->checkSecureStream($downloadUrl);	//check url again.
		
		
		
		//get the last-modified-date of this very file
		$lastModified=filemtime(__FILE__);
		//get a unique hash of this file (etag)
		$etagFile = md5_file(__FILE__);
		//get the HTTP_IF_MODIFIED_SINCE header if set
		$ifModifiedSince=(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
		//get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
		$etagHeader=(isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);
		
		//set last-modified header
		header("Last-Modified: ".gmdate("D, d M Y H:i:s", $lastModified)." GMT");
		//set etag-header
		header("Etag: $etagFile");
		//make sure caching is turned on
		header('Cache-Control: public');
		
		//check if page has changed. If not, send 304 and exit
		if (@strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'])==$lastModified || $etagHeader == $etagFile)
		{
			   header("HTTP/1.1 304 Not Modified");
			   exit;
		}
		//set the exipre date to at least one week.
		$expires = 480*60*24; // how long to cache in secs..
		
		header("Pragma: public");
		header("Cache-Control: maxage=".$expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
		
		
		
		header('Accept-Ranges: bytes');
		//header('Accept-Ranges: 0-'.$size);
		
		
		//header("Content-Disposition: inline;");
		//header("Content-Transfer-Encoding: binary\n");
		//header('Connection: close');
		
		
		
		if($downloadVideo){
			$fileNameToSet = $fileName.'-ytPAK.com.'.$extension;
			header('Content-Disposition: attachment; filename= "' . $fileNameToSet . '"');
			header('Content-Type: video/'.$extension);
			//header('Content-Length: '.$size);
			//readfile($downloadUrl);
			//$this->readfile_chunked($downloadUrl, true);
			
		}else{
			header('Content-Type: video/mp4');
		}
		
		
		if(isset($_SERVER['HTTP_RANGE']))  { // do it for any device that supports byte-ranges not only iPhone
			
		
			$length = $size;           // Content length
			$start  = 0;               // Start byte
			$end    = $size - 1;       // End byte
			
		
			$c_start = $start;
			$c_end   = $end;
			// Extract the range string
			list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
			// Make sure the client hasn't sent us a multibyte range
			if (strpos($range, ',') !== false) {
	 
				// (?) Shoud this be issued here, or should the first
				// range be used? Or should the header be ignored and
				// we output the whole content?
				header('HTTP/1.1 416 Requested Range Not Satisfiable');
				header("Content-Range: bytes $start-$end/$size");
				// (?) Echo some info to the client?
				exit;
			}
			// If the range starts with an '-' we start from the beginning
			// If not, we forward the file pointer
			// And make sure to get the end byte if spesified
			if ($range0 == '-') {
	 
				// The n-number of the last bytes is requested
				$c_start = $size - substr($range, 1);
			}
			else {
	 
				$range  = explode('-', $range);
				$c_start = $range[0];
				$c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
			}
			/* Check the range and make sure it's treated according to the specs.
			 * http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
			 */
			// End bytes can not be larger than $end.
			$c_end = ($c_end > $end) ? $end : $c_end;
			// Validate the requested range and return an error if it's not correct.
			if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
	 
				header('HTTP/1.1 416 Requested Range Not Satisfiable');
				header("Content-Range: bytes $start-$end/$size");
				// (?) Echo some info to the client?
				exit;
			}
			$start  = $c_start;
			$end    = $c_end;
			$length = $end - $start + 1; // Calculate new content length
			
  			header('HTTP/1.1 206 Partial Content');
			header("Content-Range: bytes $start-$end/$size");
			header("Content-Length: $length");
			
			$context = stream_context_create(array(
				'http' => array(
					'method' => 'GET',
					'header' => "Range: bytes=".$start."-"
				)
			));

			//readfile($downloadUrl, false, $context);
			$this->readfile_chunked($downloadUrl, true, $context);
		}else{
			header('Content-Length: '.$size);
			//readfile($downloadUrl);
			$this->readfile_chunked($downloadUrl, true);
		}
		
		exit();
	}//function playSecureStream ends
	
	
	
	
	
	
	
	function readfile_chunked($filename,$retbytes=true, $context = NULL) {
		
	   $chunksize = 1*(1024*1024); // how many bytes per chunk
	   $buffer = '';
	   $cnt =0;
	
		if($context != NULL){
			$handle = fopen($filename, 'rb', false, $context);
		}else{
			$handle = fopen($filename, 'rb');
		}
	   
	   if ($handle === false) {
		   return false;
	   }
	   while (!feof($handle)) {
		   $buffer = fread($handle, $chunksize);
		   echo $buffer;
		   ob_flush();
		   flush();
		   if ($retbytes) {
			   $cnt += strlen($buffer);
		   }
	   }
		   $status = fclose($handle);
	   if ($retbytes && $status) {
		   return $cnt; // return num. bytes delivered like readfile() does.
	   }
	   return $status;
	
	} 
	
	
	
	
	
	
	
	function getYtFormats($ytBody, $iTag, $useCipherSig, $videoId, $curl){	//function getYtFormats start
	
		
		if($useCipherSig){
			$json 					= $this->getCipherJson($videoId, $curl);	//this will make additional call to the same page.
			$streamMapArray 		= explode(',',$json->args->url_encoded_fmt_stream_map);
			$adaptiveStreamArray 	= explode(',',$json->args->adaptive_fmts);
		}else{
			$streamMapArray 		= explode(',',$ytBody['url_encoded_fmt_stream_map']);
			$adaptiveStreamArray 	= explode(',',$ytBody['adaptive_fmts']);
		}
		
		
		$ytAdaptiveFormatsData = array();
		foreach($adaptiveStreamArray as $adaptiveStream){
			parse_str($adaptiveStream, $ytAdaptiveFormatsData[]);
		}
		
		$ytFormatsData = array();
		foreach($streamMapArray as $streamMap){
			parse_str($streamMap, $ytFormatsData[]);
		}
		
		
		
		foreach($ytAdaptiveFormatsData as $array){
			$ytFormatsData[] = $array;
		}
		
		
		$formats = array();	//write in videoData Array
		foreach($ytFormatsData as $key => $value){
			
			if(in_array($value['itag'], $iTag)){
				
				$url = urldecode($value['url']);
				$checkAllStreams = true;
				
				if($useCipherSig){
					
					$formats[$key]['encoded-sig'] 			= $value['s'];
					$formats[$key]['encoded-sig-length'] 	= strlen($formats[$key]['encoded-sig']);
					
					$formats[$key]['decoded-sig'] 			= $this->DecryptYouTubeCypher($formats[$key]['encoded-sig']);
					$formats[$key]['decoded-sig-length'] 	= strlen($formats[$key]['decoded-sig']);
					
					
					$formats[$key]['downloadUrl'] 			= $url.'&signature='.$formats[$key]['decoded-sig'];
					$formats[$key]['useCipherSig'] 			= true;
					
					//before it was content_owner_name
					//$formats[$key]['content_owner_name'] 	= $json->args->content_owner_name;	//we will use this to select different drive accounts
					//$formats[$key]['content_owner_name'] 	= $json->args->ptk;	//we will use this to select different drive accounts
					

				}else{
					
					if(strpos($url, 'gcr=') !== false || strpos($url, 'youtube.com/') !== false){	//check the formats for gcr=us
						
						$formats[$key]['gcr'] 	= true;
						$formats[$key]['downloadUrl'] 	= $url;
						
					}else{
						
						$checkAllStreams = false;
						$url = str_replace('http://', 'https://', str_replace('.googlevideo.com', '.c.docs.google.com', $url));
						$formats[$key]['downloadUrl'] 	= $url;
					}
				
				}
				
				
				
				//we need to test the download URL if it is really working on not.
				$formats[$key]['videoSize'] 			= $this->getVideoSize($formats[$key]['downloadUrl'], $videoId, $value['itag'], $checkAllStreams);
				
				if(is_array($formats[$key]['videoSize'])){	//this is an array it means video is being redirected to different location
					$formats[$key]['downloadUrl'] = $formats[$key]['videoSize']['downloadUrl'];
					//check the size again:
					$formats[$key]['videoSize']   = $this->getVideoSize($formats[$key]['downloadUrl'], $videoId, $value['itag'], $checkAllStreams);
				}
				
				if($useCipherSig || isset($formats[$key]['gcr'])){
					$formats[$key]['downloadUrl'] = str_replace('.googlevideo.com', '.ytpak.com', $formats[$key]['downloadUrl']);
				}
				
				
				$formats[$key]['quality'] 				= $value['quality'];
				$formats[$key]['itag'] 					= $value['itag'];
				$formats[$key]['type'] 					= $value['type'];
				
				
			}// endif iTag
		}
		
		
		$formats = array_values($formats);	//reindex array
		return $formats;
	}//function getYtFormats ends
	
	
	
	
	
	
	
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	function getVideoSize($url, $videoId, $iTag, $useCipherSig){	//function getVideoSize start
		
		//if( ($iTag != '18' || $iTag != '135') && $useCipherSig == false){//only for itag 18 because we cannot check all streams but we need the size in byets for all the streams if the video is secure
			//return 'null';
		//}
		$my_ch = curl_init();
		curl_setopt($my_ch, CURLOPT_URL,$url);
		curl_setopt($my_ch, CURLOPT_HEADER,         true);
		curl_setopt($my_ch, CURLOPT_NOBODY,         true);
		curl_setopt($my_ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($my_ch, CURLOPT_TIMEOUT,        10);
		$result = curl_exec($my_ch);
		$result = explode("\n", $result);	//note that '\n' will not work, Try avoiding single quotes in curl objects
		
		
		if(strpos($result[0], 'HTTP/1.1 403 Forbidden') === 0) {
			$this->FixYouTubeDecryption($videoId, $query);	//this will also redirect the script to the same page.
		}
		
		
		if(strpos($result[0], 'HTTP/1.1 302 Found') === 0) {	//download video is moved to different location
			$returnArray = array();
			$returnArray['status'] = 'redirect';
			$returnArray['downloadUrl'] = trim(substr($result[5],10));
			return $returnArray;
		}
		
		
		if(strpos($result[0], 'HTTP/1.1 503 Service Unavailable') === 0) {	//simply try again
			$printJson['error'] = true;
			$printJson['heading'] = 'Oh snap!';
			$printJson['msg'] = 'Something went wrong, Please try again later. Exit Code #148';
			echo json_encode($printJson);
			exit();
		}
		
		
		if(strpos($result[7], 'Content-Length:') === 0) {
			if($useCipherSig == false){
				return $this->convertToMb(trim(substr($result[7],16)));	//convert Bytes to Megabytes 
			}else{
				return trim(substr($result[7],16));	//convert Bytes to Megabytes 
			}
		}
		
		
		//something is really strange going on. Redirect to home page.
		$printJson['error'] = true;
		$printJson['heading'] = 'Oh snap!';
		$printJson['msg'] = 'Something went wrong, Please try again later. Exit Code #149';
		echo json_encode($printJson);
		exit();
		
	}//function getVideoSize ends
	
	
	
	
	
	
	
	function FixYouTubeDecryption($ytVideoId, $query = NULL){
		
		$softwareInfo = file_get_contents('software.xml');
		$sxe = new SimpleXMLElement($softwareInfo);
		$info = $sxe->xpath('/software/info');
		$version = $info[0]->version;
		$updateResponse = file_get_contents('http://rajwebconsulting.com/update-video-converter-v2/v:'.$version);
		if ($updateResponse != 'You have the newest version.'){
			$sxe2 = new SimpleXMLElement($updateResponse);
			$sxe2->info[0]->lasterror = $currentTime;
			$newXmlContent = $sxe2->asXML();
			$fp = fopen('software2.xml', 'w');
			$lockSucceeded = false;
			
			if (flock($fp, LOCK_EX)){
				$lockSucceeded = true;
				fwrite($fp, $newXmlContent);
				flock($fp, LOCK_UN);
			}
			fclose($fp);
			if ($lockSucceeded){
				rename('software2.xml', 'software.xml');
				chmod('software.xml', 0777);
			}
			//redirect to the same page.
			$url = 'http://'.$_ENV['HTTP_HOST'].'/?task='.$_GET['task'].'&videoid='.$_GET['videoid'];
			header('Location: ' . $url);
			exit();
			
		}else{
			//at the point we have the latest version of the Decryption from rajwebconsulting.com but still not able to decrypt we need to wait.
			//but for now send an error msg that due to some error we could not get the video. Please try again.
			$printJson['error'] = true;
			$printJson['heading'] = 'Ohh snap!';
			$printJson['msg'] = 'An error occurred, please report this video, or try again later.';
			echo json_encode($printJson);
			exit();
		}
		
	}
	
	
	
	
	
	
	
	
	
	function getCipherJson($videoId, $curl){	//function getCipherJson start
		
		$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		//$curl->setOpt(CURLOPT_HTTPHEADER, array('REMOTE_ADDR: '.$ip, 'HTTP_X_FORWARDED_FOR: '.$ip));
		//$curl->setOpt(CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36');
		$curl->get('https://www.youtube.com/watch?v='.$videoId);	//get information directly from the page.
		
		if ($curl->error) {
			$printJson['error'] = true;
			$printJson['heading'] = 'Application Error';
			$printJson['msg'] = 'Could not get video info :(';
			echo json_encode($printJson);
			exit();
		}
		
		if (preg_match('/;ytplayer\.config = ({.*?});/s', $curl->response, $matches) == 1){
			$jsonObj = json_decode($matches[1]);
		}else{
			$printJson['error'] = true;
			$printJson['heading'] = 'Application Error';
			$printJson['msg'] = 'Player configuration not found';
			echo json_encode($printJson);
			exit();
		}
		
		if (!isset($jsonObj->args->url_encoded_fmt_stream_map)){
			$printJson['error'] = true;
			$printJson['heading'] = 'Oh snap!';
			$printJson['msg'] = 'Something went wrong, Please report the this video link so that we can improve our services.';
			echo json_encode($printJson);
			exit();
		}
		
		//return explode(',',$jsonObj->args->url_encoded_fmt_stream_map);
		return $jsonObj;
	}	//function getCipherJson ends
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function DecryptYouTubeCypher($signature){
		
		//$jsonData = json_decode(file_get_contents('http://data.yt.invokers.net/?sig='.$signature), true);
		//return $jsonData['sigDecoded'];

			$s = $signature;
			$softwareXmlFile = 'software.xml';
			
			
			if (is_file($softwareXmlFile))
			{
				$algos = file_get_contents($softwareXmlFile);
				$sxe = new SimpleXMLElement($algos);
				$algo = $sxe->xpath('/software/decryption/funcgroup[@siglength="' . strlen($s) . '"]/func');
				if ($algo !== false && !empty($algo))
				{
					//die(print_r($algo));
					foreach ($algo as $func)
					{	
						$funcName = (string)$func->name;

						if (!function_exists($funcName))
						{
							eval('function ' . $funcName . '(' . (string)$func->args . '){' . preg_replace('/self::/', "", (string)$func->code) . '}');
						}
					}
					
					$s = call_user_func((string)$algo[0]->name, $s);					
				}
			}
			
			$s = ($s == $signature) ? $this->LegacyDecryptYouTubeCypher($s) : $s;
			return $s;
		}

        // Deprecated - Will be removed in future versions!
        function LegacyDecryptYouTubeCypher($signature)
        {
			
            $s = $signature;
            $sigLength = strlen($s);
            switch ($sigLength)
            {
                case 93:
                	$s = strrev(substr($s, 30, 57)) . substr($s, 88, 1) . strrev(substr($s, 6, 23));
                	break;
                case 92:
                    $s = substr($s, 25, 1) . substr($s, 3, 22) . substr($s, 0, 1) . substr($s, 26, 16) . substr($s, 79, 1) . substr($s, 43, 36) . substr($s, 91, 1) . substr($s, 80, 3);
                    break;
                case 90:
                	$s = substr($s, 25, 1) . substr($s, 3, 22) . substr($s, 2, 1) . substr($s, 26, 14) . substr($s, 77, 1) . substr($s, 41, 36) . substr($s, 89, 1) . substr($s, 78, 3);
                	break;
                case 89:
                	$s = strrev(substr($s, 79, 6)) . substr($s, 87, 1) . strrev(substr($s, 61, 17)) . substr($s, 0, 1) . strrev(substr($s, 4, 56));
                	break;
                case 88:
                    $s = substr($s, 7, 21) . substr($s, 87, 1) . substr($s, 29, 16) . substr($s, 55, 1) . substr($s, 46, 9) . substr($s, 2, 1) . substr($s, 56, 31) . substr($s, 28, 1);
                    break;
                case 87:
                	$s = substr($s, 6, 21) . substr($s, 4, 1) . substr($s, 28, 11) . substr($s, 27, 1) . substr($s, 40, 19) . substr($s, 2, 1) . substr($s, 60);
                    break;
                case 84:
                    $s = strrev(substr($s, 71, 8)) . substr($s, 14, 1) . strrev(substr($s, 38, 32)) . substr($s, 70, 1) . strrev(substr($s, 15, 22)) . substr($s, 80, 1) . strrev(substr($s, 0, 14));
                    break;
                case 81:
					$s = substr($s, 56, 1) . strrev(substr($s, 57, 23)) . substr($s, 41, 1) . strrev(substr($s, 42, 14)) . substr($s, 80, 1) . strrev(substr($s, 35, 6)) . substr($s, 0, 1) . strrev(substr($s, 30, 4)) . substr($s, 34, 1) . strrev(substr($s, 10, 19)) . substr($s, 29, 1) . strrev(substr($s, 1, 8)) . substr($s, 9, 1);
                    break;
                case 80:
					$s = substr($s, 1, 18) . substr($s, 0, 1) . substr($s, 20, 48) . substr($s, 19, 1) . substr($s, 69, 11);
                    break;
                case 79:
					$s = substr($s, 54, 1) . strrev(substr($s, 55, 23)) . substr($s, 39, 1) . strrev(substr($s, 40, 14)) . substr($s, 78, 1) . strrev(substr($s, 35, 4)) . substr($s, 0, 1) . strrev(substr($s, 30, 4)) . substr($s, 34, 1) . strrev(substr($s, 10, 19)) . substr($s, 29, 1) . strrev(substr($s, 1, 8)) . substr($s, 9, 1);
                	break;
                default:
                    $s = $signature;
            }
            return $s;
        }
		#endregion
	
	
	function convertToMb($number){
		return round(($number/1024/1024), 3);
	}



	function base64UrlEncode($data){
	  return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
	}
	
	function base64UrlDecode($base64){
	  return base64_decode(strtr($base64, '-_', '+/'));
	}
	
	
}//main class ends here


?>