<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\OrderManager;
use Common\classes\CheckManager;
use Common\classes\GoodsManager;


$Monolog				=	new MonologManager();
$CheckManager			=	new CheckManager();
$GoodsManager			=	new GoodsManager();
$OrderManager 			=	new OrderManager();

$startDate				=	$_POST['startDate'];
$endDate				=	$_POST['endDate'];
$dateType 				=	$_POST['searchType'];			//1:개월선택,2:기간설정
$year 					=	$_POST['year'];
$month 					=	$_POST['month'];
$userCode 				=	$User->userCode();
$type 					=	$_POST['type']			?	$_POST['type']			:	2;
$state 					=	$_POST['state']			?	$_POST['state']			:	1;

$recordPerPage			=	5;
$pnoPerPage				=	5;						//	한 페이지당 최대 페이지번호 개수.
$pno					=	($_POST['pno']) == '' ? 1 : (int)($_POST['pno']);			//	페이지번호.
$temp					=	($pno * $recordPerPage) - $recordPerPage;

if($dateType == 2){
	if(strlen($month) == 1){
		$month 			=	'0'.$month;
	}
}

$fieldName 				=	'isRegular';
if($type == 2){
	$fieldName 			=	'notRegular';
}


if($state == 2){
	$orderState 		=	array(404,504,604);
}

$orderList 				=	array();
$search 				=	array(
	'userCode'			=>	$userCode,
	'orderState'		=>	$orderState,
	'startDate'		=>	$startDate,
	'endDate'			=>	$endDate,
	'year'				=>	$year,
	'month'				=>	$month,
	'dateType'			=>	$dateType,
	'orderType'		=>	2,
	$fieldName			=>	1
);
$msg 					=	$OrderManager->get_orderList($temp, $recordPerPage, '', $search);
$list					=	$msg->getData();
$totalCount				=	$msg->getMessage();
$data					=	array(
	'errCd'						=>	0,
	'errMsg'					=>	'',
	'list'						=>	$list,
	'totalCount'				=>	$totalCount,
	'recordPerPage'			=>	$recordPerPage,
	'pnoPerPage'				=>	$pnoPerPage,
	'token'						=>	$newToken,
	'temp'						=>	$temp,
	'pno'						=>	$pno,
	'state'						=>	$state
);
echo json_encode($data);
exit;

?>