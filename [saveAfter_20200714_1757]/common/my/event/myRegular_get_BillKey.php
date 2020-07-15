<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\MemberManager;
$Monolog				=	new MonologManager();
$MemberManager			=	new MemberManager();

require_once  $_SERVER['DOCUMENT_ROOT'].'/common/library/_theBill/lib/NicepayLite.php';
$nicepay = new NicepayLite;
$nicepay->m_LicenseKey  = "b+zhZ4yOZ7FsH8pm5lhDfHZEb79tIwnjsdA0FBXh86yLc6BJeFVrZFXhAoJ3gEWgrWwN+lJMV0W4hvDdbe4Sjw=="; // 상점키
$nicepay->m_NicepayHome  =  $_SERVER['DOCUMENT_ROOT']."/_paylog";         // 로드 디렉토리
$nicepay->m_MID         = "nictest04m";     // 상점아이디
$nicepay->m_PayMethod   = "BILLKEY";        // 결제수단
$nicepay->m_ssl         = "true";           // 보안접속 여부
$nicepay->m_ActionType  = "PYO";            // 서비스모드 설정(결제(PY0), 취소(CL0)
$nicepay->m_CardNo      = $_POST['CardNo'];          // 카드번호
$nicepay->m_ExpYear     = $_POST['ExpYear'];         // 카드만료(년)
$nicepay->m_ExpMonth    = $_POST['ExpMonth'];        // 카드만료(월)
$nicepay->m_IDNo        = $_POST['IDNo'];            // 생년월일or사업자번호
$nicepay->m_CardPw      = $_POST['CardPw'];          // 카드비밀번호
$nicepay->m_MallIP      = $MallIP;          // 가맹점ip
$nicepay->m_charSet     = "UTF8";           // 인코딩

$nicepay->startAction();

if($nicepay->m_ResultData["ResultCode"] == 'F100'){

	$payMethod 				=	$_POST['payMethod'];

	$data 					=	array(
		'userCode'			=>	$User->userCode(),
		'BillKey'			=>	$nicepay->m_ResultData["BID"],
		'CardCode'			=>	$nicepay->m_ResultData["CardCode"],
		'CardNo'			=>	$nicepay->m_ResultData["CardNo"],
		'CardName'			=>	$nicepay->m_ResultData["CardName"],
		'ExpMonth'			=>	$_POST['ExpMonth'],
		'ExpYear'			=>	$_POST['ExpYear'],
		'IDNo'				=>	$_POST['IDNo'],
		'CardPW'			=>	$_POST['CardPw'],
		'amount'			=>	$_POST['Amt'],
		'AuthDate'			=>	$nicepay->m_ResultData["AuthDate"],
		'ResultCode'		=>	$nicepay->m_ResultData["ResultCode"],
		'ResultMsg'		=>	$nicepay->m_ResultData["ResultMsg"],
		'regDt'				=>	date('Y-m-d h:i:s'),
		'payMethod'		=>	$payMethod,
		'serviceName'		=>	'[NH친꾸]정기배송결제',
		'serviceCd'		=>	'CARD',
		'status'			=>	1
	);
	$msg 					=	$MemberManager->insert_theBill_keyLog($data);

	if($msg->isResult()){
		$data 					=	array(
			'userCode'			=>	$User->userCode(),
			'BillKey'			=>	$nicepay->m_ResultData["BID"],
			'CardCode'			=>	$nicepay->m_ResultData["CardCode"],
			'CardNo'			=>	$nicepay->m_ResultData["CardNo"],
			'CardName'			=>	$nicepay->m_ResultData["CardName"],
			'ExpMonth'			=>	$_POST['ExpMonth'],
			'ExpYear'			=>	$_POST['ExpYear'],
			'IDNo'				=>	$_POST['IDNo'],
			'CardPW'			=>	$_POST['CardPw'],
			'amount'			=>	$_POST['Amt'],
			'AuthDate'			=>	$nicepay->m_ResultData["AuthDate"],
			'payMethod'		=>	$payMethod,
			'isApprove'		=>	1
		);
		$msg 					=	$MemberManager->set_regularInfo($data);
		if($msg->isResult()){
			$result 			=	array(
				'CardName'		=>	$nicepay->m_ResultData["CardName"],
				'CardNo'		=>	$nicepay->m_ResultData["CardNo"]
			);
			$data				=	array(
				'errCd'			=>	0,
				'errMsg'		=>	'인증이 완료되었습니다.',
				'isSuccess'	=>	1,
				'result'		=>	$result
			);
			echo json_encode($data);
			exit;
		} else {
			$data				=	array(
				'errCd'			=>	1,
				'errMsg'		=>	'오류가 발생했습니다.',
				'isSuccess'	=>	0
			);
			echo json_encode($data);
			exit;
		}
	} else {
		$data				=	array(
			'errCd'			=>	1,
			'errMsg'		=>	'오류가 발생했습니다.',
			'isSuccess'	=>	0
		);
		echo json_encode($data);
		exit;
	}

} else {
	$data					=	array(
		'errCd'				=>	1,
		'errMsg'			=>	$nicepay->m_ResultData["ResultMsg"],
		'isSuccess'		=>	0
	);
	echo json_encode($data);
	exit;
}


?>