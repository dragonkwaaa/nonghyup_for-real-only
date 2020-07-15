<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\BoardManager;
use Common\classes\OrderManager;
use Common\classes\CheckManager;
use Common\classes\GoodsManager;

$Monolog				=	new MonologManager();
$CheckManager			=	new CheckManager();
$OrderManager			=	new OrderManager();
$BoardManager 			=	new BoardManager();
$GoodsManager 			=	new GoodsManager();

$cate 					=	$_POST['cate']			?	$_POST['cate']			:	4;	//4:구매후기,2:1:1
$recordPerPage			=	10;
$pnoPerPage				=	5;						//	한 페이지당 최대 페이지번호 개수.
$pno					=	($_POST['pno']) == '' ? 1 : (int)($_POST['pno']);			//	페이지번호.
$temp					=	($pno * $recordPerPage) - $recordPerPage;

$searchType 			=	$_POST['searchType'];
$searchWord 			=	$_POST['searchWord'];

$list 					=	array();
$search 				=	array(
	'userCode'			=>	$User->userCode(),
	'bbsCate'			=>	$cate,
	'order'				=>	' bbs.regDate DESC',
	'isDel'				=>	1,
	'isUse'				=>	1,
	'searchType'		=>	$searchType,
	'searchWord'		=>	$searchWord
);
$msg 					=	$BoardManager->get_bbs($temp, $recordPerPage, '', $search);
$list					=	$msg->getData();
$totalCount				=	$msg->getMessage();
$review					=	array();
if($cate == 4){
	if($list){
		for($i = 0 ; $i < sizeof($list) ; $i ++){
			$li 				=	$list[$i];
			$orderCode 			=	$li['orderCode'];
			$orderListCode 		=	$li['orderListCode'];

			$search 			=	array(
				'orderCode'	=>	$orderCode
			);
			$msg 							=	$OrderManager->get_orderList(1, '', $orderListCode, $search);
			$orderList 						=	$msg->getData();
			$review 						=	$orderList[0];
			$list[$i]['review']			=	$review;

			//1:정기배송상품,2:묶음배송상품(정기배송아님),3:일반상품
			if($review['isBundle'] == 1){
				$type 						=	2;
				if($review['isRegular'] == 1){
					$type 					=	1;
				}
			} else {
				$type 						=	3;
			}
			$list[$i]['type']				=	$type;
		}
	}
}


$data					=	array(
	'errCd'						=>	0,
	'errMsg'					=>	'',
	'list'						=>	$list,
	'totalCount'				=>	$totalCount,
	'recordPerPage'			=>	$recordPerPage,
	'pnoPerPage'				=>	$pnoPerPage,
	'token'						=>	$newToken,
	'temp'						=>	$temp,
	'pno'						=>	$pno
);
echo json_encode($data);
exit;

?>