<?php


//Make sure call is from couldflare!
if(!isset($_SERVER['HTTP_CF_RAY'])){
	echo 'Resource cannot be displayed!';
	exit();
}


define('DS', DIRECTORY_SEPARATOR);
define('directAccess', TRUE);

$printJson = array();


function make_token($offset, $string){
	$date = new DateTime();
	$date->setTimezone(new DateTimeZone('Asia/Karachi'));
	$format = 'h';	//set default format
	return md5((int)$date->format($format)-$offset.'*o4{^9%hCNvkehMI+_,ts0,H|$B5v|'.$string);
}


function matchToken($token, $string){
	if(
		$token == make_token(0, $string)
		||
		$token == make_token(1, $string)
		||
		$token == make_token(-1, $string)
		
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




function onlyAuthorizedDomains(){
	if(strpos($_SERVER['HTTP_REFERER'], 'ytpak.com') 		!== FALSE)		return true;
	if(strpos($_SERVER['HTTP_REFERER'], 'ytpak.pk') 		!== FALSE)		return true;
	
	header('HTTP/1.0 403 Forbidden ad');
	exit();
}


function chekYtpakServer(){
	//first check if the server is ytpak.com or ytbits not heroku apps domain
	if(strpos($_SERVER['HTTP_HOST'], 'ytpak.com') 		!== FALSE)		return true;	//server name must be ytpak.com
	if(strpos($_SERVER['HTTP_HOST'], 'ytpak.pk') 		!== FALSE)		return true;	//server name must be ytpak.pk
	
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


chekYtpakServer(); //first check if the server is ytpak.com

//first of all check if the task is there.
if(isset($_GET['task'])){
	$task = $_GET['task'];
}else{
	header('HTTP/1.0 403 Forbidden no ta');
	exit();
}


if($task == 'healthcheck'){
	echo 'ok';
	exit();
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
	
	matchToken($token, $streamUrl.$fileName);
	
	//load the mainClass.php
	require_once('mainClass.php');
	$yt = new yt;
	$yt->convertMp3($streamUrl, $fileName);
}








if($task == 'cachevideo'){	//this is public task
	//only allow onlyAuthorizedDomains to access this task
	//we need to remove onlyAuthorizedDomains function because we are having issues with https and http referer using iframe.
	//onlyAuthorizedDomains();

	if(isset($_GET['token'])){
		$token = $_GET['token'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'token is required in cachevideo task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['streamurl'])){
		$streamUrl = $_GET['streamurl'];
	}else{
		$printJson['error'] = true;
		$printJson['msg'] = 'streamurl is required in cachevideo task';
		echo json_encode($printJson);
		exit();
	}
	
	if(isset($_GET['filename'])){
		$fileName = $_GET['filename'];
	}else{
		$fileName = '';
	}
	
	matchToken($token, $streamUrl.$fileName);
	
	//load the mainClass.php
	require_once('mainClass.php');
	$yt = new yt;
	$yt->cacheVideo($streamUrl, $fileName);
}




//if we are here it means we have provided wrong task
onlyAuthorizedCalls();
header('Content-type: application/json');
$printJson['error'] = true;
$printJson['msg'] = 'Task: "'.$task.'" is not registered';
echo json_encode($printJson);
exit();


?>
