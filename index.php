<?php



phpinfo();

exit();


define('DS', DIRECTORY_SEPARATOR);
define('directAccess', TRUE);

$printJson = array();


function make_token($offset, $string){
	$date = new DateTime();
	$date->setTimezone(new DateTimeZone('Asia/Karachi'));
	$format = 'h';	//set default format
	return md5((int)$date->format($format)-$offset.'*o4{^9%hCNvkehMI+_,ts0,H|$B5v|'.$string);
}


function matchToken($token, $streamUrl){
	if(
		$token == make_token(0, base64UrlDecode($streamUrl)) 
		||
		$token == make_token(1, base64UrlDecode($streamUrl))
		||
		$token == make_token(-1, base64UrlDecode($streamUrl))
		
	){
		return true;
	}else{
		header('HTTP/1.0 403 Forbidden t');
		//$printJson['error'] = true;
		//$printJson['msg'] = 'Token already expired';
		//echo json_encode($printJson);
		exit();
	}
}

function matchTokenQuickView($token, $videoId){
	if(
		$token == make_token(0, $videoId)
		||
		$token == make_token(1, $videoId)
		||
		$token == make_token(-1, $videoId)
		
	){
		return true;
	}else{
		header('HTTP/1.0 403 Forbidden tq');
		//$printJson['error'] = true;
		//$printJson['msg'] = 'Token already expired';
		//echo json_encode($printJson);
		exit();
	}
}

function onlyAuthorizedCalls(){	//only authorized remote can make this call

	$allowedIps = array('182.180.148.53');

	if(in_array($_SERVER['HTTP_X_FORWARDED_FOR'], $allowedIps)){
		return true;
	}
	
	header('HTTP/1.0 403 Forbidden ac');
	exit();
	
}



function onlyAuthorizedDomains(){
	if(strpos($_SERVER['HTTP_REFERER'], 'ytpak.com') 		!== FALSE)		return true;
	if(strpos($_SERVER['HTTP_REFERER'], 'ytbits.com') 		!== FALSE)		return true;
	
	header('HTTP/1.0 403 Forbidden ad');
	exit();
}


function chekYtpakServer(){
	//first check if the server is ytpak.com or ytbits not heroku apps domain
	if(strpos($_SERVER['HTTP_HOST'], 'ytpak.com') 		!== FALSE)		return true;	//server name must be ytpak.com
	if(strpos($_SERVER['HTTP_HOST'], 'ytbits.com') 		!== FALSE)		return true;	//server name must be ytbits.com
	
	//now check the calling country:
	//if($_SERVER["HTTP_CF_IPCOUNTRY"] == 'PK') return true;
	
	header('HTTP/1.0 403 Forbidden sn');
	exit();
}



function base64UrlEncode($data){
  return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
}

function base64UrlDecode($base64){
  return base64_decode(strtr($base64, '-_', '+/'));
}


chekYtpakServer(); //first check if the server is ytpak.com not heroku apps domain

//first of all check if the task is there.
if(isset($_GET['task'])){
	$task = $_GET['task'];
}else{
	onlyAuthorizedCalls();
	header('Content-type: application/json');
	$printJson['error'] = true;
	$printJson['msg'] = 'Task is missing';
	echo json_encode($printJson);
	exit();
}




if($task == 'healthcheck'){
	echo 'ok';
	exit();
}



if($task == 'quickvideoview'){	//this is public task
	//only allow onlyAuthorizedDomains to access this task
	onlyAuthorizedDomains();
	
	header('Content-type: application/json');
	
	if(isset($_GET['token'])){
		$token = $_GET['token'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'token is required in quickvideoview task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['videoid'])){
		$videoId = $_GET['videoid'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'videoid is required in quickvideoview task';
		echo json_encode($printJson);
		exit();
	}
	
	matchTokenQuickView($token, $videoId);
	
	if(strpos($_SERVER['HTTP_REFERER'], 'local-bc.ytpak.com') !== FALSE){
		header("Access-Control-Allow-Origin: http://local-bc.ytpak.com");
		
	}elseif(strpos($_SERVER['HTTP_REFERER'], 'local-bc.ytbits.com') !== FALSE){
		header("Access-Control-Allow-Origin: http://local-bc.ytbits.com");
		
	}elseif(strpos($_SERVER['HTTP_REFERER'], 'ytbits.com') !== FALSE){
		header("Access-Control-Allow-Origin: http://www.ytbits.com");
		
	}else{
		header("Access-Control-Allow-Origin: http://www.ytpak.com");
	}
	
	//load the mainClass.php
	require_once('mainClass.php');
	$yt = new yt;
	$yt->quickVideoView($videoId);
}









if($task == 'convertmp3'){	//this is public task
	//only allow onlyAuthorizedDomains to access this task
	onlyAuthorizedDomains();

	if(isset($_GET['token'])){
		$token = $_GET['token'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'token is required in convertmp3 task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['streamurl'])){
		$streamUrl = $_GET['streamurl'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'streamurl is required in convertmp3 task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['filename'])){
		$fileName = $_GET['filename'];
	}else{
		$fileName = '';
	}
	
	matchTokenQuickView($token, $streamUrl.$fileName);
	
	//load the mainClass.php
	require_once('mainClass.php');
	$yt = new yt;
	$yt->convertMp3($streamUrl, $fileName);
}





if($task == 'playsecurestreamthree'){	//this is public task

	if(isset($_GET['token'])){
		$token = $_GET['token'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'token is required in playSecureStream task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['streamurlone'])){
		$streamUrlOne = $_GET['streamurlone'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'streamurlone is required in playsecurestreamtwo task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['streamurltwo'])){
		$streamUrlTwo = $_GET['streamurltwo'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'streamurltwo is required in playsecurestreamtwo task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['id'])){
		$videoId = $_GET['id'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'id is required in playsecurestreamtwo task';
		echo json_encode($printJson);
		exit();
	}
	
	
	if(isset($_GET['videosize'])){
		$videoSize = $_GET['videosize'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'videosize is required in playSecureStream task';
		echo json_encode($printJson);
		exit();
	}
	
	
	matchTokenQuickView($token, $videoSize.$videoId);	//in this task token is matched with videosize and videoId
	
	
	//load the mainClass.php
	require_once('mainClass.php');
	$yt = new yt;
	$playSecureStreamTwo = $yt->playSecureStreamThree($videoId, $streamUrlOne, $streamUrlTwo);	//if successful script will not come out of it.
	exit();
}





if($task == 'playsecurestreamtwo'){	//this is public task

	if(isset($_GET['token'])){
		$token = $_GET['token'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'token is required in playSecureStream task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['streamurlone'])){
		$streamUrlOne = $_GET['streamurlone'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'streamurlone is required in playsecurestreamtwo task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['streamurltwo'])){
		$streamUrlTwo = $_GET['streamurltwo'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'streamurltwo is required in playsecurestreamtwo task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['id'])){
		$videoId = $_GET['id'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'id is required in playsecurestreamtwo task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['videosize'])){
		$videoSize = $_GET['videosize'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'videosize is required in playSecureStream task';
		echo json_encode($printJson);
		exit();
	}
	
	
	matchTokenQuickView($token, $videoSize.$videoId);	//in this task token is matched with videosize and videoId
	
	
	//load the mainClass.php
	require_once('mainClass.php');
	$yt = new yt;
	$playSecureStreamTwo = $yt->playSecureStreamTwo($videoId, $streamUrlOne, $streamUrlTwo);	//if successful script will not come out of it.
	exit();
}












if($task == 'playsecurestream'){	//this is public task

	if(isset($_GET['token'])){
		$token = $_GET['token'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'token is required in playSecureStream task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['streamurl'])){
		$streamUrl = $_GET['streamurl'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'streamurl is required in playSecureStream task';
		echo json_encode($printJson);
		exit();
	}
	
	matchToken($token, $streamUrl);
	
	
	if(isset($_GET['downloadvideo'])){
		$downloadVideo = true;
	}else{
		$downloadVideo = false;
	}
	
	if(isset($_GET['filename'])){
		$fileName = $_GET['filename'];
	}else{
		$fileName = false;
	}
	
	if(isset($_GET['extension'])){
		$extension = $_GET['extension'];
	}else{
		$extension = false;
	}
	
	
	
	if(isset($_GET['videosize'])){
		$videoSize = $_GET['videosize'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'videosize is required in playSecureStream task';
		echo json_encode($printJson);
		exit();
	}
	

	
	//load the mainClass.php
	require_once('mainClass.php');
	$yt = new yt;
	$playSecureStream = $yt->playSecureStream($videoSize, $streamUrl, $downloadVideo, $fileName, $extension);	//if successful script will not come out of it.
	exit();
}






















if($task == 'newvideo'){
	
	//onlyAuthorizedDomains();	//cannot add authorization as we are calling this task from video.php controller.
	
	
	header('Content-type: application/json');
	
	if(isset($_GET['token'])){
		$token = $_GET['token'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'token is required!';
		echo json_encode($printJson);
		exit();
	}

	
	if(isset($_GET['videoid'])){
		$videoId = $_GET['videoid'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'videoid is required!';
		echo json_encode($printJson);
		exit();
	}
	
	matchTokenQuickView($token, $videoId);
	
	
	//load the mainClass.php
	require_once('mainClass.php');
	$yt = new yt;
	
	$ytStream = $yt->getYtStream($videoId);	//if successful script will not come out of it.
}


//if we are here it means we have provided wrong task
onlyAuthorizedCalls();
header('Content-type: application/json');
$printJson['error'] = true;
$printJson['msg'] = 'Task: "'.$task.'" is not registered';
echo json_encode($printJson);
exit();


?>