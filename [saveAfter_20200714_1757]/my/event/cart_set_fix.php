<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\MemberManager;
use Common\classes\OrderManager;
use Common\classes\GoodsManager;
use Common\classes\CheckManager;

$MemberManager							=	new MemberManager();
$OrderManager							=	new OrderManager();
$GoodsManager 							=	new GoodsManager();
$Monolog								=	new MonologManager();
$CheckManager							=	new CheckManager();


if(!$User->userCode()){
	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	'로그인한 회원만 사용하실 수 있습니다.',
		'url'							=>	'/intro/login',
		'token'							=>	$newToken
	);
	echo json_encode($data);
	exit;
}
$userCode 									=	$User->userCode();


$search 								=	array(
	'userCode'							=>	$User->userCode()
);
$msg 									=	$MemberManager->get_user(1, '', '', $search);
$user 									=	$msg->getData();
$userRegular 							=	$user[0]['isRegular'];
$isOrgRegular 							=	$user[0]['isOrgRegular'];

if($userRegular != 1){
	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	'정기배송 회원만 사용가능합니다.',
		'url'							=>	'',
		'token'							=>	$newToken
	);
	echo json_encode($data);
	exit;
}

$search 								=	array(
	'userCode'							=>	$userCode
);
$msg									=	$MemberManager->get_regularInfo(1, '', '', $search);
if($msg->getData()){
	$regular 							=	$msg->getData();
	$regular 							=	$regular[0];
	$payMethod 							=	$regular['payMethod'];
	if($payMethod == 0){
		$data							=	array(
			'errCd'						=>	1,
			'errMsg'					=>	'결제정보를 등록해주세요.',
			'url'						=>	'/my/myRegular',
			'token'						=>	$newToken
		);
		echo json_encode($data);
		exit;
	}
} else {
	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	'정기배송 정보를 입력해주세요.',
		'url'							=>	'/my/myRegular',
		'token'							=>	$newToken
	);
	echo json_encode($data);
	exit;
}


$msg 									=	$OrderManager->update_cart_fix($_POST);
if($msg->isResult()){
	$data									=	array(
		'errCd'								=>	1,
		'errMsg'							=>	'정기배송상품이 담겼습니다.',
		'url'								=>	'/my/cart',
		'token'								=>	$newToken
	);
	echo json_encode($data);
	exit;
} else {
	$data									=	array(
		'errCd'								=>	1,
		'errMsg'							=>	'오류가 발생했습니다.',
		'url'								=>	'/order/orderReg',
		'token'								=>	$newToken
	);
	echo json_encode($data);
	exit;
}

?>