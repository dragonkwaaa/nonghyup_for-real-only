<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\MemberManager;
use Common\classes\OrderManager;
use Common\classes\CheckManager;
use Common\classes\GoodsManager;
$MemberManager							=	new MemberManager();
$OrderManager							=	new OrderManager();
$Monolog								=	new MonologManager();
$CheckManager							=	new CheckManager();
$GoodsManager							=	new GoodsManager();
$type 									=	$_POST['type'];
$code 									=	$_POST['code'];
$isRegular 								=	$_POST['isRegular'];
$url 									=	'/product/info?code='.$code.'&type='.$type;
if($type == 1){
	$url 								=	'/product/info?code='.$code.'&type='.$type;
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
	$msg 									=	$GoodsManager->get_goods('', '', $code);
	if($msg->getData()){
		$goods 								=	$msg->getData();
		$goods 								=	$goods[0];
	}
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
		if($isRegular == 1 && $goods['isOption'] != 1){
			$search 					=	array(
				'userCode'				=>	$userCode,
				'isRegular'			=>	1,
				'isDel'					=>	1,
				'goodsCode'			=>	$code
			);
			$msg 						=	$OrderManager->get_cart('', '', '', $search);
			if($msg->getData()){
				$data								=	array(
					'errCd'							=>	1,
					'errMsg'						=>	'이미 담겨져있는 정기배송상품입니다.',
					'url'							=>	$url,
					'token'							=>	$newToken
				);
				echo json_encode($data);
				exit;
			}
		}
	}
}

// 재고확인
// 정기배송상품이 아닌경우 재고확인만 하면되고, 정기배송일 경우 재고확인후 차감해줘야함



$_POST['userCode']							=	$User->userCode();
if($_POST['isBundle'] == 1){
	$msg 									=	$OrderManager->set_cart($_POST);
} else {
	$msg 									=	$OrderManager->set_cart_normal($_POST);
}
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