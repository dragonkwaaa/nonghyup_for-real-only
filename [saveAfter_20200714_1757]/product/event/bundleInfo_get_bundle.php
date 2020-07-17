<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);


use Common\classes\MonologManager;
use Common\classes\GoodsManager;
use Common\classes\MemberManager;
use Common\classes\BoardManager;
use Common\classes\CheckManager;

$GoodsManager			=	new GoodsManager();
$BoardManager 			=	new BoardManager();
$MemberManager 			=	new MemberManager();
$Monolog				=	new MonologManager();
$CheckManager			=	new CheckManager();

// 묶음상품정보
// tbl_bundle, tbl_bundleList
$type 					=	$_POST['type'];
$bundleCode				=	$_POST['code'];
$bundleList 			=	array();
$search 				=	array(
	'isDel'				=>	1,
	'bundleState'		=>	1
);
$msg 					=	$GoodsManager->get_bundle(1, '', $bundleCode, $search);
if($msg->getData()){
	//묶음선택상품 리스트
	$bundleInfo 		=	$msg->getData();
	$bundle 			=	$bundleInfo[0];

	$search 			=	array(
		'bundleCode'	=>	$bundleCode,
		'isDel'			=>	1
	);
	$msg 				=	$GoodsManager->get_bundleList('', '', '', $search);
	$bundleList 		=	$msg->getData();
	$isOn 				=	0;
	if($User->userCode()){
		$search 			=	array(
			'productType'	=>	2,
			'productCode'	=>	$bundleCode,
			'userCode'		=>	$User->userCode()
		);
		$msg				=	$MemberManager->get_favorite(1, '', '', $search);
		if($msg->getData()){
			$isOn 			=	1;
		}
	}

	$bundle['bundleInfo']		=	html_entity_decode($bundle['bundleInfo']);

	$data							=	array(
		'errCd'						=>	0,
		'errMsg'					=>	'',
		'bundle'					=>	$bundle,
		'bundleList'				=>	$bundleList,
		'isOn'						=>	$isOn,
		'token'						=>	$newToken
	);
	echo json_encode($data);
	exit;

} else {
	$data							=	array(
		'errCd'						=>	1,
		'errMsg'					=>	'존재하지 않는 상품정보입니다.',
		'url'						=>	1,
		'token'						=>	$newToken
	);
	echo json_encode($data);
	exit;
}

?>
