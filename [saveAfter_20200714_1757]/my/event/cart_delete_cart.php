<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\OrderManager;
use Common\classes\CheckManager;

$OrderManager							=	new OrderManager();
$Monolog								=	new MonologManager();
$CheckManager							=	new CheckManager();

$msg 									=	$OrderManager->delete_cart($_POST);
if($msg->isResult()){
	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	'',
		'url'							=>	'/my/cart',
		'token'							=>	$newToken
	);
	echo json_encode($data);
	exit;
} else {
	$Monolog->log_error($_SERVER['REQUEST_URI'] . '오류 발생', $_POST);
	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	'오류가 발생하였습니다. 관리자에게 문의해주세요.',
		'token'							=>	$newToken
	);
	echo json_encode($data);
	exit;
}

?>