<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);


use Common\classes\MonologManager;
use Common\classes\GoodsManager;
use Common\classes\CheckManager;
use Common\classes\BoardManager;

$GoodsManager			=	new GoodsManager();
$Monolog				=	new MonologManager();
$CheckManager			=	new CheckManager();
$BoardManager 			=	new BoardManager();

$banner4 				=	array();
$search 				=	array(
	'isUse'				=>	1,
	'bannerType'		=>	4,
	'isDel'				=>	1,
	'isWeb'				=>	1,
	'order'				=>	' bn.bannerOrder ASC'
);
$msg 					=	$BoardManager->get_banner('', '', '', $search);
if($msg->getData()){
	$banner4 			=	$msg->getData();
}

$recordPerPage 			=	16;
$pnoPerPage				=	5;
$pno					=	($_POST['pno']) == '' ? 1 : (int)($_POST['pno']);			//	페이지번호.
$temp 					=	($pno * $recordPerPage) - $recordPerPage;
$totalCount 			=	0;

$type 					=	$_POST['type'];				//1:정기배송,2:묶음배송,3:카테고리
$isRegular 				=	0;
if($type == 1){
	$isRegular			=	1;
}
$category				=	$_POST['category'];
$schWord 				=	$_POST['schWord'];
$title					=	'';
$list 					=	array();
if($type){
	if($type == 1){
		$search 			=	array(
			'isRegular'	=>	1,
			'goodsState'	=>	1,
			'isDel'			=>	1
		);
		$msg 				=	$GoodsManager->get_goods($temp, $recordPerPage, '', $search);
		if($msg->getData()){
			$list 				=	$msg->getData();
		}
		$totalCount			=	$msg->getMessage();
		$title 				=	'정기배송';
	}
	if($type == 2){
		$search 			=	array(
			'goodsState'	=>	1,
			'isDel'			=>	1,
			'isBundle'		=>	1,
			'notRegular'	=>	1
		);
		$msg 				=	$GoodsManager->get_goods($temp, $recordPerPage, '', $search);
		if($msg->getData()){
			$list 				=	$msg->getData();
		}
		$totalCount			=	$msg->getMessage();
		$title 				=	'묶음배송';
	}
}
// 수정필요
else if($category){
	$tempGoods 								=	array();
	$search 								=	array(
		'isDel'								=>	1,
		'categoryIdx'						=>	$category
	);
	$msg 									=	$GoodsManager->get_productCateList($search);
	if($msg->getData()){
		$cateList 							=	$msg->getData();
		$totalCount							=	$msg->getMessage();
		$k 									=	0;
		for($i = 0 ; $i < sizeof($cateList) ; $i ++){
			$cate 							=	$cateList[$i];
			$productCode					=	$cate['productCode'];
			$search 						=	array(
				'isDel'						=>	1,
				'goodsState'				=>	1
			);
			$msg							=	$GoodsManager->get_goods(1, '', $productCode, $search);
			if($msg->getData()){
				$goods 						=	$msg->getData();
				$goods 						=	$goods[0];
				if(!in_array($goods['goodsCode'], $tempGoods)){
					$list[$k]				=	$goods;
					$k++;
					$tempGoods[$k] 			=	$goods['goodsCode'];
				}
				//$list[$i]					=	$goods;
			}
		}
		$list 								=	array_filter($list);
		$totalCount							=	sizeof($list);
	}
	$msg 									=	$GoodsManager->get_category(1, '', $category);
	$cateData 								=	$msg->getData();
	$cateName 								=	$cateData[0]['cateName'];
	$title 									=	$cateName;
}
else if($schWord){

	//$totalCount					=	0;
	$search 					=	array(
		'searchType'			=>	1,
		'searchWord'			=>	$schWord,
		'isDel'					=>	1,
		'goodsState'			=>	1
	);
	$msg 						=	$GoodsManager->get_goods('', '', '', $search);
	if($msg->getData()){
		$list 					=	$msg->getData();
		$totalCount 			=	$msg->getMessage();
	}
	$title 						=	'"'.$schWord."'' 의 검색결과";
}

$data							=	array(
	'title'						=>	$title,
	'errCd'						=>	0,
	'errMsg'					=>	'',
	'list'						=>	$list,
	'totalCount'				=>	$totalCount,
	'recordPerPage'			=>	$recordPerPage,
	'pnoPerPage'				=>	$pnoPerPage,
	'token'						=>	$newToken,
	'temp'						=>	$temp,
	'isRegular'				=>	$isRegular,
	'banner4'					=>	$banner4
);
echo json_encode($data);
exit;


?>