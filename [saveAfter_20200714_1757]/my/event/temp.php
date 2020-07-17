<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\BasicManager;
use Common\classes\OrderManager;
use Common\classes\MemberManager;
use Common\classes\GoodsManager;


// 오로지 정기배송결제시에만 사용하는 컨트롤 (취소는 )

$Monolog				=	new MonologManager();
$BasicManager			=	new BasicManager();
$MemberManager			=	new MemberManager();
$GoodsManager			=	new GoodsManager();
$OrderManager 			=	new OrderManager();


$userCode 				=	$User->userCode();
$ActionType 			=	'PYO';						//결제:PYO,취소:CLO
$todayDate	 			=	date('Y-m');


$search 				=	array(
	'payRegDate'		=>	$todayDate,
	'userCode'			=>	$userCode,
	'ActionType'		=>	$ActionType,
	'order'				=>	' pl.payListIdx DESC'
);
$msg 					=	$OrderManager->get_payList(1, '', '', $search);
if($msg->getData()){
	$data 				=	array(
		'errCd'			=>	1,
		'errMsg'		=>	'이미 결제한 회원입니다.',
		'token'			=>	$newToken
	);
	echo json_encode($data);
	exit;
} else {

	//상점정보
	$msg 				=	$BasicManager->get_config();
	$config 			=	$msg->getData();
	$config 			=	$config[0];
	$merchantID 		=	$config['merchantID'];
	$amount 			=	$config['amount'];

	//사용자 정기배송 정보
	$search 			=	array(
		'userCode'		=>	$userCode
	);
	$msg 				=	$MemberManager->get_regularInfo(1, '', '', $search);
	if($msg->getData()){

		$user 			=	$msg->getData();
		$user 			=	$user[0];
		$BillKey 		=	$user['BillKey'];
		$ordererName 	=	$user['ordererName'];
		$GoodsName 		=	date('Y-m').'정기배송';
		$Moid 			=	$userCode.'_'.date('Ymdhis');
		$payMethod		=	$user['payMethod'];



		$result 				=	array(
			'userCode'			=>	$userCode,
			'payListState'		=>	1,
			'amount'			=>	$amount,
			'payMethod'		=>	1,
			'payRegDate'		=>	date('Y-m'),
			'BillKey'			=>	$BillKey,
			'CardCode'			=>	$user["CardCode"],
			'CardNo'			=>	$user["CardNo"],
			'CardName'			=>	$user["CardName"],
			'ExpMonth'			=>	$user['ExpMonth'],
			'ExpYear'			=>	$user['ExpYear'],
			'IDNo'				=>	$user['IDNo'],
			'CardPW'			=>	$user['CardPW'],
			'AuthCode'			=>	'',
			'AuthDate'			=>	'',
			'TID'				=>	'',
			'BuyerName'		=>	$ordererName,
			'GoodsName'		=>	$GoodsName,
			'CardQuota'		=>	'00',
			'AccountName'		=>	$user['AccountName'],
			'AccountBank'		=>	$user['AccountBank'],
			'AccountBankNo'	=>	$user['AccountBankNo'],
			'AccountNo'		=>	$user['AccountNo'],
			'isManager'		=>	1,
			'ActionType'		=>	$ActionType,
			'Moid'				=>	$Moid
		);

		$msg 					=	$OrderManager->insert_payList($result);
		if($msg->isResult()){
			$data 				=	array(
				'errCd'			=>	1,
				'errMsg'		=>	'결제가 완료되었습니다.',
				'token'			=>	$newToken
			);
			echo json_encode($data);
			exit;
		} else {
			$data 				=	array(
				'errCd'			=>	1,
				'errMsg'		=>	print_r($msg->isResult()),
				'token'			=>	$newToken
			);
			echo json_encode($data);
			exit;
		}

	} else {
		$data 				=	array(
			'errCd'			=>	1,
			'errMsg'		=>	'해당회원의 결제정보가 없습니다.',
			'token'			=>	$newToken
		);
		echo json_encode($data);
		exit;
	}

}


?>