<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\MemberManager;
use Common\classes\CheckManager;

$MemberManager							=	new MemberManager();
$Monolog								=	new MonologManager();
$CheckManager							=	new CheckManager();

$type 									=	$_POST['type'];				//url 돌려주기위해서
$code 									=	$_POST['code'];
$userCode 								=	$User->userCode();

if(!$userCode){
	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	'로그인한 회원만 사용하실 수 있습니다.',
		'url'							=>	'/intro/login',
		'token'							=>	$newToken
	);
	echo json_encode($data);
	exit;
}

$url 									=	'/product/info?code='.$code.'&type='.$type;
$data 									=	array(
	'userCode'							=>	$userCode,
	'goodsCode'						=>	$code
);
$msg 									=	$MemberManager->set_favorite($data);

if($msg->isResult()){
	$msg								=	$MemberManager->get_favorite(1, '', '', $data);
	$isOn 								=	0;
	if($msg->getData()){
		$isOn 							=	1;
	}

	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	'',
		'url'							=>	$url,
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