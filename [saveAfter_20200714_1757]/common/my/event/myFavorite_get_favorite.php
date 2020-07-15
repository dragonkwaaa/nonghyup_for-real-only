<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\MemberManager;
use Common\classes\CheckManager;
use Common\classes\GoodsManager;


$Monolog				=	new MonologManager();
$CheckManager			=	new CheckManager();
$GoodsManager			=	new GoodsManager();
$MemberManager 			=	new MemberManager();

$recordPerPage			=	10;
$pnoPerPage				=	5;						//	한 페이지당 최대 페이지번호 개수.
$pno					=	($_POST['pno']) == '' ? 1 : (int)($_POST['pno']);			//	페이지번호.
$temp					=	($pno * $recordPerPage) - $recordPerPage;

$list 					=	array();
$search 				=	array(
	'userCode'			=>	$User->userCode(),
	'order'				=>	' fa.regDate DESC'
);
$msg 					=	$MemberManager->get_favorite($temp, $recordPerPage, '', $search);
$list					=	$msg->getData();
$totalCount				=	$msg->getMessage();
$goods					=	array();
if($list){
	for($i = 0 ; $i < sizeof($list) ; $i ++){
		$li 				=	$list[$i];
		$search 			=	array(
			'goodsState'	=>	1,
			'isDel'			=>	1
		);
		$msg 				=	$GoodsManager->get_goods(1, '', $li['goodsCode'], $search);

		if($msg->getData()){
			$goods 			=	$msg->getData();
			$goods 			=	$goods[0];
		} else {
			$deleteData 	=	array(
				'userCode'		=>	$User->userCode(),
				'goodsCode'	=>	$li['goodsCode']
			);
			$msg 			=	$MemberManager->set_favorite($deleteData);
			if(!$msg->isResult()){
				$data					=	array(
					'errCd'					=>	1,
					'errMsg'				=>	print_r($msg)
				);
			}
		}
		$list[$i]['goods']		=	$goods;
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