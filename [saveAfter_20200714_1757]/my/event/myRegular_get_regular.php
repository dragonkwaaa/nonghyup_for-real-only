<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\MemberManager;
use Common\classes\GoodsManager;
use Common\classes\CheckManager;
use Common\classes\OrderManager;
use Common\classes\BasicManager;

$Monolog				=	new MonologManager();
$CheckManager			=	new CheckManager();
$MemberManager			=	new MemberManager();
$GoodsManager 			=	new GoodsManager();
$OrderManager 			=	new OrderManager();
$BasicManager 			=	new BasicManager();


$userCode 				=	$User->userCode();

$search 				=	array(
	'userCode'			=>	$userCode
);
$msg 					=	$MemberManager->get_user(1, '', '', $search);
$userData 				=	array();

if($msg->getData()){
	$userData 			=	$msg->getData();
	$userData 			=	$userData[0];
}

$search 				=	array(
	'isDel'				=>	1,
	'isRegular'		=>	1,
	'userCode'			=>	$userCode
);
$msg 					=	$OrderManager->get_cart('', '', '', $search);
$list 					=	array();
$totalCount 			=	0;
if($msg->getData()){
	$list 				=	$msg->getData();
}

$search 				=	array(
	'userCode'			=>	$userCode,
);
$msg 					=	$MemberManager->get_regularInfo(1, '', '', $search);
$regularInfo			=	'';
if($msg->getData()){
	$regularData 		=	$msg->getData();
	$regularInfo 		=	$regularData[0];
}

// 더빌 키 받기위한 매점아이디
$msg 					=	$BasicManager->get_config();
$merchantID				=	'';
$payDate 				=	0;
$deliveryDate 			=	0;
if($msg->getData()){
	$corp 				=	$msg->getData();
	$corp 				=	$corp[0];
	$merchantID 		=	$corp['merchantID'];
	$payDate 			=	$corp['payDate'];
	$deliveryDate 		=	$corp['deliveryDate'];
}

$data					=	array(
	'errCd'						=>	0,
	'errMsg'					=>	'',
	'token'						=>	$newToken,
	'regularInfo'				=>	$regularInfo,
	'userData'					=>	$userData,
	'merchantID'				=>	$merchantID,
	'payDate'					=>	$payDate,
	'deliveryDate'				=>	$deliveryDate
);
echo json_encode($data);
exit;

?>