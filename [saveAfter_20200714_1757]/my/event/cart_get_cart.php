<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\OrderManager;
use Common\classes\CheckManager;
use Common\classes\GoodsManager;
use Common\classes\MemberManager;
use Common\classes\BasicManager;


$Monolog				=	new MonologManager();
$CheckManager			=	new CheckManager();
$GoodsManager			=	new GoodsManager();
$OrderManager 			=	new OrderManager();
$MemberManager 			=	new MemberManager();
$BasicManager 			=	new BasicManager();

$isRegular 				=	$_POST['isRegular'];
$userCode 				=	$User->userCode();


$deleteCartArr 					=	$BasicManager->check_cart($userCode);
if(sizeof($deleteCartArr)){
	$OrderManager->delete_cartArr($deleteCartArr);
}

$errMsg 				=	'';


$search 				=	array(
	'userCode'			=>	$userCode
);
$msg 					=	$MemberManager->get_user(1, '', '', $search);
$user 					=	$msg->getData();
$userRegular 			=	$user[0]['isRegular'];


// 정기배송장바구니

$search 				=	array(
	'isRegular'		=>	1,
	'isDel'				=>	1,
	'userCode'			=>	$userCode
);
$msg 					=	$OrderManager->get_cart('', '', '', $search);
$regular 				=	array();
$regularTot				=	$msg->getMessage();
if($msg->getData()){
	$regular 			=	$msg->getData();
	for($i = 0 ; $i < sizeof($regular) ; $i ++){
		$li 			=	$regular[$i];
		$goodsCode 		=	$li['goodsCode'];
		$cartCode 		=	$li['cartCode'];
		$goodsOpIdx 	=	$li['goodsOpIdx'];

		$goodsOp 		=	array();

		$search 					=	array(
			'isDel'					=>	1,
			'goodsState'			=>	1
		);
		$msg 		=	$GoodsManager->get_goods(1, '', $goodsCode, $search);
		if($msg->getData()){
			$goods 							=	$msg->getData();
			$goods 							=	$goods[0];
			$regular[$i]['goods'] 			=	$goods;
			$isOption 						=	$goods['isOption'];

			if($goodsOpIdx > 0 && $isOption == 1){
				$search 							=	array(
					'isDel'							=>	1,
					'goodsOpState'					=>	1
				);
				$msg 								=	$GoodsManager->get_goodsOp(1, '', $goodsOpIdx, $search);
				if($msg->getData()){
					$goodsOpData 					=	$msg->getData();
					$goodsOp 						=	$goodsOpData[0];
				}
			} else {
				$goodsOp['goodsOpPrice']		=	0;
			}
			$regular[$i]['opData']				=	$goodsOp;

		}
	}
}
// 일반배송장바구니
$search 				=	array(
	'notRegular'		=>	1,
	'isDel'				=>	1,
	'userCode'			=>	$userCode
);
$msg 					=	$OrderManager->get_cart('', '', '', $search);
$notRegular 			=	array();
$notRegularTot			=	$msg->getMessage();

if($msg->getData()){
	$notRegular 		=	$msg->getData();
	for($i = 0 ; $i < sizeof($notRegular) ; $i ++){
		$li 			=	$notRegular[$i];
		$goodsCode 		=	$li['goodsCode'];
		$cartCode 		=	$li['cartCode'];
		$goodsOpIdx 	=	$li['goodsOpIdx'];

		$goodsOp 		=	array();

		$search 					=	array(
			'isDel'					=>	1,
			'goodsState'			=>	1
		);
		$msg 		=	$GoodsManager->get_goods(1, '', $goodsCode, $search);
		if($msg->getData()){
			$goods 							=	$msg->getData();
			$goods 							=	$goods[0];
			$notRegular[$i]['goods'] 		=	$goods;
			$isOption 						=	$goods['isOption'];

			if($goodsOpIdx > 0 && $isOption == 1){
				$search 							=	array(
					'isDel'							=>	1,
					'goodsOpState'					=>	1
				);
				$msg 								=	$GoodsManager->get_goodsOp(1, '', $goodsOpIdx, $search);
				if($msg->getData()){
					$goodsOpData 					=	$msg->getData();
					$goodsOp 						=	$goodsOpData[0];
				}
			} else {
				$goodsOp['goodsOpPrice']		=	0;
			}
			$notRegular[$i]['opData']			=	$goodsOp;

		}
	}
}

$data					=	array(
	'errCd'						=>	0,
	'errMsg'					=>	$errMsg,
	'userRegular'				=>	$userRegular,
	'regular'					=>	$regular,
	'notRegular'				=>	$notRegular
);
echo json_encode($data);
exit;

?>