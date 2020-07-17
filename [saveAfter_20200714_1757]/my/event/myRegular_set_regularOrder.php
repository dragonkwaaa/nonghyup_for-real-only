<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";

foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

$ordererName 				=	$_POST['BuyerName'];
$ordererMobile 				=	$_POST['BuyerTel'];
$ordererEmail 				=	$_POST['BuyerEmail'];
$receiveName 				=	$ordererName;
$receiveAddr 				=	$_POST['receiveAddr'];;
$receiveAddrDetail 			=	$_POST['receiveAddrDetail'];
$receiveZip 				=	$_POST['receiveZip'];
$receiveMobile 				=	$ordererMobile;
$deliveryMsg 				=	$_POST['deliveryMsg'];
$MID 						=	$_POST['MID'];
$Moid						=	$_POST['Moid'];
$GoodsName 					=	$_POST['GoodsName'];
$CardQuota					=	$_POST['CardQuota'];
$BillKey 					=	$_POST['BillKey'];

$regularSet 				=	array(
	'ordererName'			=>	$ordererName,
	'ordererMobile'		=>	$ordererMobile,
	'ordererEmail'			=>	$ordererEmail,
	'receiveName'			=>	$receiveName,
	'receiveAddr'			=>	$receiveAddr,
	'receiveAddrDetail'	=>	$receiveAddrDetail,
	'receiveZip'			=>	$receiveZip,
	'receiveMobile'		=>	$receiveMobile,
	'deliveryMsg'			=>	$deliveryMsg,
	'MID'					=>	$MID,
	'Moid'					=>	$Moid,
	'GoodsName'			=>	$GoodsName,
	'CardQuota'			=>	$CardQuota,
	'BillKey'				=>	$BillKey
);


$arr_regularSet 			=	array();
foreach($regularSet as $key=>$_regularSet) $arr_regularSet[$key] = $SubFunction->encrypt($_regularSet);
$_SESSION['regularSet']	=	$arr_regularSet;

header("Content-Type:text/html; charset=utf-8;");

require( $_SERVER['DOCUMENT_ROOT'] . "/common/library/_theBill/lib/NicepayLite.php");
$nicepay = new NicepayLite;
//$nicepay->setParam("NICEPAY_LOG_HOME", $_SERVER['DOCUMENT_ROOT']."/_paylog");
$nicepay->m_LicenseKey   = "b+zhZ4yOZ7FsH8pm5lhDfHZEb79tIwnjsdA0FBXh86yLc6BJeFVrZFXhAoJ3gEWgrWwN+lJMV0W4hvDdbe4Sjw=="; //상점키
$nicepay->m_NicepayHome  =  $_SERVER['DOCUMENT_ROOT']."/_paylog";        // 로그 디렉토리*/
$nicepay->m_ssl          = "true";          // 보안접속 여부
$nicepay->m_ActionType   = "PYO";           // 서비스모드 설정(결제(PY0), 취소(CL0)
$nicepay->m_NetCancelPW  = "123456";        // 취소 패스워드
$nicepay->m_debug        = "DEBUG";         // 디버깅 모드
$nicepay->m_MID          = $MID;            // 상점아이디
$nicepay->m_Amt          = $Amt;            // 결제금액
$nicepay->m_Moid         = $Moid;           // 상품번호
$nicepay->m_MallIP       = '';         // 상점IP
$nicepay->m_PayMethod    = "BILL";          // 결제수단
$nicepay->m_BillKey      = $BillKey;        // 빌키
$nicepay->m_BuyerName    = $receiveName;      // 구매자이름
$nicepay->m_GoodsName    = $GoodsName;      // 상품이름
$nicepay->m_CardQuota    = 00;      // 할부개월
$nicepay->m_NetCancelAmt = $Amt;            // 결제 금액
$nicepay->m_charSet      = "UTF8";           // 인코딩

$nicepay->startAction();

use Common\classes\CorpManager;
use Common\classes\MemberManager;
use Common\classes\OrderManager;
$CorpManager			=	new CorpManager();
$MemberManager			=	new MemberManager();
$OrderManager			=	new OrderManager();

// 첫 결제시, 빌키 회원정기배송 테이블에 저장 이후 저장된 빌키 가지고 자동 결제시스템 구축
$regularSet 			=	$_SESSION['regularSet'];
unset($_SESSION['regularSet']);
$data 					=	array(
	'userCode'			=>	$User->userCode(),
	'BillKey'			=>	$SubFunction->decrypt($regularSet['BillKey']),
	'CardCode'			=>	$nicepay->m_ResultData["CardCode"],
	'CardNo'			=>	$nicepay->m_ResultData["CardNo"],
	'CardName'			=>	$nicepay->m_ResultData["CardName"],
	'amount'			=>	$Amt,
	'ordererName'		=>	$SubFunction->decrypt($regularSet['ordererName'])
);
$msg 					=	$MemberManager->set_regularInfo($data);
/*if($msg->isResult()){
	$data 				=	array(
		'userCode'		=>	$User->userCode(),
		'BillKey'		=>	$SubFunction->decrypt($regularSet['BillKey']),
		'AuthDate'		=>	$nicepay->m_ResultData["AuthDate"],
		'AuthCode'		=>	$nicepay->m_ResultData["AuthCode"],
		'TID'			=>	$nicepay->m_ResultData["TID"],
		'Moid'			=>	$Moid,
		'ActionType'	=>	'PYO',
		'MID'			=>	$MID,
		'Amt'			=>	$_POST['Amt'],
		'NetCancelPW'	=>	'',
		'MallIP'		=>	$SubFunction->decrypt($regularSet['MallIP']),
		'PayMethod'	=>	'BILL',
		'BuyerName'	=>	$SubFunction->decrypt($regularSet['BuyerName']),
		'GoodsName'	=>	$GoodsName,
		'CardQuota'	=>	$CardQuota,
		'CardCode'		=>	$nicepay->m_ResultData["CardCode"],
		'CardNo'		=>	$nicepay->m_ResultData["CardNo"],
		'CardName'		=>	$nicepay->m_ResultData["CardName"]
	);
	$msg 				=	$OrderManager->insert_regularOrder($data);
	if($msg->isResult()){
		$data								=	array(
			'errCd'							=>	1,
			'errMsg'						=>	'결제완료',
			'url'							=>	'/my/myRegular',
		);
		echo json_encode($data);
		exit;
	} else {
		$data								=	array(
			'errCd'							=>	1,
			'errMsg'						=>	print_r($msg->isResult())
		);
		echo json_encode($data);
		exit;
	}
}*/



?>

<?php echo $nicepay->m_ResultData["ResultCode"].' '.$nicepay->m_ResultData["ResultMsg"].' '.$_SESSION['regularSet']?>
