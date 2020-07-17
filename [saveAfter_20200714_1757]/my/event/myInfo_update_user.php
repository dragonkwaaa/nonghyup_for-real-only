<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\MemberManager;
use Common\classes\CheckManager;



$Monolog				=	new MonologManager();
$CheckManager			=	new CheckManager();
$MemberManager			=	new MemberManager();

$userCode 				=	$User->userCode();

if($_POST['userPWD'] && $_POST['userPWD'] != ''){
	$data 						=	array(
		'userCode'				=>	$userCode,
		'userPWD'				=>	$_POST['userPWD'],
		'procType'				=>	4
	);
	$msg 						=	$MemberManager->update_user($data);
	if(!$msg->isResult()){
		$data					=	array(
			'errCd'				=>	1,
			'errMsg'			=>	print_r($msg),
			'token'				=>	$newToken
		);
		echo json_encode($data);
		exit;
	}
}
$_POST['procType']						=	3;
$_POST['userCode']						=	$userCode;
$msg 									=	$MemberManager->update_user($_POST);
if($msg->isResult()){
	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	'',
		'url'							=>	'/my/myInfo',
		'token'							=>	$newToken
	);
	echo json_encode($data);
	exit;
} else {

	$Monolog->log_error($_SERVER['REQUEST_URI'] . '오류 발생', $_POST);
	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	print_r($msg),
		'token'							=>	$newToken
	);
	echo json_encode($data);
	exit;
}
?>