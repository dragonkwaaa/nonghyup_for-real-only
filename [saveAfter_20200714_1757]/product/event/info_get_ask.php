<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\BoardManager;
use Common\classes\CheckManager;
use Common\classes\GoodsManager;


$Monolog				=	new MonologManager();
$CheckManager			=	new CheckManager();
$GoodsManager			=	new GoodsManager();
$BoardManager 			=	new BoardManager();

$goodsCode 				=	$_POST['code'];

$recordPerPage			=	5;
$pnoPerPage				=	5;										//	한 페이지당 최대 페이지번호 개수.
$pno					=	($_POST['pno']) == '' ? 1 : (int)($_POST['pno']);			//	페이지번호.
$temp					=	($pno * $recordPerPage) - $recordPerPage;

$search 				=	array(
	'goodsCode'		=>	$goodsCode,
	'isUse'				=>	1,
	'isDel'				=>	1,
	'bbsCate'			=>	5
);

$msg 					=	$BoardManager->get_bbs($temp, $recordPerPage, '', $search);
$askList 				=	array();
$askTot					=	0;
if($msg->getData()){
	$askList 			=	$msg->getData();
	$askTot 			=	$msg->getMessage();
}

$data					=	array(
	'errCd'						=>	0,
	'errMsg'					=>	'',
	'askList'					=>	$askList,
	'askTot'					=>	$askTot,
	'recordPerPage'			=>	$recordPerPage,
	'pnoPerPage'				=>	$pnoPerPage,
	'token'						=>	$newToken,
	'temp'						=>	$temp,
	'pno'						=>	$pno,
	'totalCount'				=>	$askTot
);
echo json_encode($data);
exit;

?>