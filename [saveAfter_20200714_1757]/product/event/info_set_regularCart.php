<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\MemberManager;
use Common\classes\OrderManager;
use Common\classes\CheckManager;
$MemberManager							=	new MemberManager();
$OrderManager							=	new OrderManager();
$Monolog								=	new MonologManager();
$CheckManager							=	new CheckManager();

$type 									=	$_POST['type'];
$code 									=	$_POST['code'];
$isRegular 								=	$_POST['isRegular'];
$url 									=	'/product/bundleInfo?code='.$code.'&type='.$type.'&re='.$isRegular;
if($type == 1){
	$url 								=	'/product/info?code='.$code.'&type='.$type.'&re='.$isRegular;
}

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
} else {
	if($isRegular == 1){
		$search 						=	array(
			'userCode'					=>	$userCode
		);
		$msg 							=	$MemberManager->get_user(1, '', '', $search);
		$user 							=	$msg->getData();
		$userRegular 					=	$user[0]['isRegular'];

		if($userRegular != 1){
			$data								=	array(
				'errCd'							=>	1,
				'errMsg'						=>	'정기배송 회원만 사용가능합니다.',
				'url'							=>	$url,
				'token'							=>	$newToken
			);
			echo json_encode($data);
			exit;
		}
	}
}
$_POST['userCode']						=	$User->userCode();
$msg 									=	$OrderManager->set_cart($_POST);
if($msg->isResult()){
	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	'장바구니에 상품이 담겼습니다.',
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