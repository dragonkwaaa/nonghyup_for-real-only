<?php
include $_SERVER['DOCUMENT_ROOT'] . "/common/pages/top.php";
$newToken 										=	$SubFunction->newTOKEN($_SERVER["HTTP_SERVER"]);
foreach($_POST as $key=>$post) $_POST[$key]	= $SubFunction->allTags($post);

use Common\classes\MonologManager;
use Common\classes\MemberManager;
use Common\classes\CheckManager;



$Monolog				=	new MonologManager();
$CheckManager			=	new CheckManager();
$MemberManager			=	new MemberManager();

// startDate 어떻게 할지 생각
$msg 									=	$MemberManager->set_regularInfo($_POST);
if($_POST['checkOrg'] == 1){
	$updateData 						=	array(
		'userCode'						=>	$User->userCode(),
		'isOrgRegular'					=>	2,
		'isRegular'					=>	1
	);
	$msg 								=	$MemberManager->update_user($updateData);
	$alertMsg 							=	'계좌가 등록되었습니다. 관리자의 승인을 기다려주세요.';
} else {
	$updateData 						=	array(
		'userCode'						=>	$User->userCode(),
		'isRegular'					=>	1
	);
	$msg 								=	$MemberManager->update_user($updateData);
	$alertMsg 							=	'계좌가 등록되었습니다. 증빙파일 제출 후 정상결제 됩니다.';
}
if($msg->isResult()){

	$result 							=	array(
		'AccountName'					=>	$_POST['AccountName'],
		'AccountNo'					=>	$_POST['AccountNo'],
		'AccountBank'					=>	$_POST['AccountBank'],
		''
	);

	$data								=	array(
		'errCd'							=>	0,
		'errMsg'						=>	'',
		'alertMsg'						=>	$alertMsg,
		'isSuccess'					=>	1,
		'result'						=>	$result
	);
	echo json_encode($data);
	exit;
} else {
	$Monolog->log_error($_SERVER['REQUEST_URI'] . '오류 발생', $_POST);
	$data								=	array(
		'errCd'							=>	1,
		'errMsg'						=>	print_r($msg),
		'token'							=>	$newToken
	);
	echo json_encode($data);
	exit;
}
?>