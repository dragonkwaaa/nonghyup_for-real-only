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
	'bbsCate'			=>	4
);

$msg 					=	$BoardManager->get_bbs($temp, $recordPerPage, '', $search);
$reviewList 			=	array();
$reviewTot 				=	0;
$reviewAvg 				=	0;
if($msg->getData()){
	$reviewList 		=	$msg->getData();
	$reviewTot 			=	$msg->getMessage();

	$search 				=	array(
		'select'			=>	' AVG(reviewScore) AS reviewAvg, ',
		'goodsCode'		=>	$goodsCode,
		'isUse'				=>	1,
		'isDel'				=>	1,
		'bbsCate'			=>	4
	);
	$msg 				=	$BoardManager->get_bbs('', '', '', $search);
	$review 			=	$msg->getData();
	$reviewAvg 			=	sprintf("%.1f",$review[0]['reviewAvg']);	//소수점 하나까지 나타내기위함
	$reviewRound 		=	round($review[0]['reviewAvg']);					//별 클래스 추가하기 위한 정수
}

$data					=	array(
	'errCd'						=>	0,
	'errMsg'					=>	'',
	'pno'						=>	$pno,
	'reviewList'				=>	$reviewList,
	'reviewTot'				=>	$reviewTot,
	'reviewAvg'				=>	$reviewAvg,
	'reviewRound'				=>	$reviewRound,
	'recordPerPage'			=>	$recordPerPage,
	'pnoPerPage'				=>	$pnoPerPage,
	'token'						=>	$newToken,
	'totalCount'				=>	$reviewTot,
	'temp'						=>	$temp
);
echo json_encode($data);
exit;

?>