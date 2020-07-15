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

$search 				=	array(
	'userCode'			=>	$User->userCode()
);
$msg 					=	$MemberManager->get_user(1, '', '', $search);
$userInfo 				=	$msg->getData();
$user 					=	$userInfo[0];

$data					=	array(
	'errCd'				=>	0,
	'errMsg'			=>	'',
	'token'				=>	$newToken,
	'user'		=>	$user
);
echo json_encode($data);
exit;

?>