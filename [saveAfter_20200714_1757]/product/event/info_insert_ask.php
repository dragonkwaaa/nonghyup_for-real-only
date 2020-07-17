<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\BoardManager;
use Common\classes\CheckManager;

$BoardManager							=	new BoardManager();
$Monolog								=	new MonologManager();
$CheckManager							=	new CheckManager();

$type 									=	$_POST['type'];			//1:정기배송,2:일반묶음상품,0:일반상품
$code 									=	$_POST['code'];
$contents 								=	$_POST['contents'];
$userCode 								=	$User->userCode();
$userID 								=	$User->userID();
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
	'userID'							=>	$userID,
	'goodsCode'						=>	$code,
	'contents'							=>	$contents,
	'bbsCate'							=>	5
);
$msg 									=	$BoardManager->insert_bbs($data);
if($msg->isResult()){
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