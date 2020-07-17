<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);


use Common\classes\MonologManager;
use Common\classes\GoodsManager;
use Common\classes\CheckManager;
use Common\classes\BasicManager;
use Common\classes\BoardManager;
use Common\classes\MemberManager;
use Common\classes\OrderManager;

$GoodsManager			=	new GoodsManager();
$Monolog				=	new MonologManager();
$CheckManager			=	new CheckManager();
$BasicManager 			=	new BasicManager();
$BoardManager 			=	new BoardManager();
$MemberManager 			=	new MemberManager();
$OrderManager 			=	new OrderManager();
// 일반상품정보
// tbl_goods, tbl_goodsOp
$goodsCode				=	$_POST['code'];
$type 					=	$_POST['type'];
$userCode 				=	$User->userCode();
$userRegular 			=	0;
$regularLimit 			=	0;

$deleteCartArr 					=	$BasicManager->check_cart($userCode);
if(sizeof($deleteCartArr)){
	$OrderManager->delete_cartArr($deleteCartArr);
}

$msg 					=	$BasicManager->get_config();
$config 				=	$msg->getData();
$config 				=	$config[0];
$regularLimit			=	$config['regularAmount'];

if($userCode){
	$search 			=	array(
		'userCode'		=>	$User->userCode()
	);
	$msg 				=	$MemberManager->get_user(1, '', '', $search);
	if($msg->getData()){
		$user 			=	$msg->getData();
		$user 			=	$user[0];
		$userRegular 	=	$user['isRegular'];
	}

	$deleteCartArr 					=	$BasicManager->check_cart($userCode);
	if(sizeof($deleteCartArr)){
		$OrderManager->delete_cartArr($deleteCartArr);
	}
}

	$goodsOp1				=	array();
	$search 				=	array(
		'isDel'				=>	1,
		'goodsState'		=>	1
	);
	$msg 					=	$GoodsManager->get_goods(1, '', $goodsCode, $search);
	if($msg->getData()){
		$goodsData 			=	$msg->getData();
		$goods 				=	$goodsData[0];


		$isOption 			=	$goods['isOption'];
		$search 		=	array(
			'goodsCode'	=>	$goodsCode,
			'goodsOpType'	=>	1,
			'isDel'			=>	1,
			'isStock'		=>	1
		);
		$msg2 			=	$GoodsManager->get_goodsOp('', '', '', $search);
		if($msg2->getData()){
			$goodsOp1 		=	$msg2->getData();
		}

		$isOn 				=	0;
		if($User->userCode()){
			$search 			=	array(
				'goodsCode'	=>	$goodsCode,
				'userCode'		=>	$User->userCode()
			);
			$msg				=	$MemberManager->get_favorite(1, '', '', $search);
			if($msg->getData()){
				$isOn 			=	1;
			}
		}
		$goods['goodsInfo']		=	html_entity_decode($goods['goodsInfo']);

		// 정기배송상품, 정기배송회원일시, 정기배송장바구니에 있는 상품값이 같을 경우 장바구니에 있는 옵션값 뿌려주기
		$cartOp 						=	array();
		if($User->userCode() > 0){
			if($type == 1){
				if($goods['isOption'] == 1){
					$search 				=	array(
						'goodsCode'		=>	$goodsCode,
						'userCode'			=>	$User->userCode(),
						'isRegular'		=>	1,
						'isDel'				=>	1
					);
					$msg 					=	$OrderManager->get_cart('', '', '', $search);
					if($msg->getData()){
						$cartOp 			=	$msg->getData();
						for($k = 0 ; $k < sizeof($cartOp) ; $k ++){
							$cOp 			=	$cartOp[$k];
							$search 		=	array(
								'goodsCode'	=>	$goodsCode,
								'isDel'			=>	1,
								'goodsOpType'	=>	1
							);
							$msg 			=	$GoodsManager->get_goodsOp(1, '', $cOp['goodsOpIdx'], $search);
							if($msg->getData()){
								$op 		=	$msg->getData();
								$op 		=	$op[0];
								$cartOp[$k]['opInfo']				=	$op['goodsOpInfo'];
								$cartOp[$k]['opPrice']				=	$op['goodsOpPrice'];
							} else {
								$msg 		=	$OrderManager->delete_cart($cOp['cartCode']);
							}
						}
					}
				}
			}
		}
		$data							=	array(
			'errCd'						=>	0,
			'errMsg'					=>	'',
			'goods'						=>	$goods,
			'opList'					=>	$goodsOp1,
			'isOn'						=>	$isOn,
			'token'						=>	$newToken,
			'isOption'					=>	$isOption,
			'userRegular'				=>	$userRegular,
			'regularLimit'				=>	$regularLimit,
			'cartOp'					=>	$cartOp
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
