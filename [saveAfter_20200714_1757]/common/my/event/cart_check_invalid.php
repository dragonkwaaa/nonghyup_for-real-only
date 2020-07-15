<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\GoodsManager;
use Common\classes\CheckManager;

$GoodsManager 							=	new GoodsManager();
$Monolog								=	new MonologManager();
$CheckManager							=	new CheckManager();

//재고 개수 확인
$cartCode 								=	$_POST['cartCode'];
$isRegular 								=	$_POST['isRegular'];
$productType 							=	$_POST['productType'];
$productCode 							=	$_POST['productCode'];


if(!$cartCode){
	$data 								=	array(
		'errCd'							=>	0,
		'errMsg'						=>	'주문할 상품을 선택해주세요.',
		'token'							=>	$newToken
	);
	echo json_encode($data);
	exit;
}

// 여기서 가능한 주문 확인

$_SESSION['orderFrm']					=	$_POST;
$data									=	array(
	'errCd'								=>	1,
	'errMsg'							=>	'',
	'url'								=>	'/order/orderReg',
	'token'								=>	$newToken
);
echo json_encode($data);
exit;

?>