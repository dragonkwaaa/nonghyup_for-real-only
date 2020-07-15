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

// 해지기능
$userCode 				=	$User->userCode();
$search 				=	array(
	'userCode'			=>	$userCode
);
$msg 					=	$MemberManager->get_user(1, '', '', $search);
$fieldName 				=	'isRegular';
if($msg->getData()){
	$user 				=	$msg->getData();
	$user 				=	$user[0];
	$userRegular 		=	$user['isRegular'];
	if($userRegular == 1){
		$fieldName 		=	'notRegular';
	}
}

$info 									=	array(
	'userCode'							=>	$userCode,
	$fieldName							=>	1
);
$msg 									=	$MemberManager->update_user($info);
if($msg->isResult()){
	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	'',
		'url'							=>	'/my/myRegular',
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