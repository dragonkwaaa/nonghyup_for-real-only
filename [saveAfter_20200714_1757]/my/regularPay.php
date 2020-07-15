<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';
if(!$User->userCode()){
	$CommonManager->goPage('/intro/login', '로그인 후, 사용가능합니다.');
}
require($_SERVER['DOCUMENT_ROOT'] . "/common/library/_theBill/lib/NicepayLite.php");
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
$nicepay->m_MallIP       = $MallIP;         // 상점IP
$nicepay->m_PayMethod    = "BILL";          // 결제수단
$nicepay->m_BillKey      = $BillKey;        // 빌키
$nicepay->m_BuyerName    = $BuyerName;      // 구매자이름
$nicepay->m_GoodsName    = $GoodsName;      // 상품이름
$nicepay->m_CardQuota    = $CardQuota;      // 할부개월
$nicepay->m_NetCancelAmt = $Amt;            // 결제 금액
$nicepay->m_charSet      = "UTF8";           // 인코딩

$nicepay->startAction();
?>
<!DOCTYPE html>
<html>
<head>
	<title>BILLPAY RESULT(UTF-8)</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes, target-densitydpi=medium-dpi" />
	<link rel="stylesheet" type="text/css" href="./css/import.css"/>
</head>
<body>
<div class="payfin_area">
	<div class="top">BILLPAY RESULT(UTF-8)</div>
	<div class="conwrap">
		<div class="con">
			<div class="tabletypea">
				<table>
					<colgroup><col width="30%"/><col width="*"/></colgroup>
					<tr>
						<th><span>결과 내용</th>
						<td>[<?php echo($nicepay->m_ResultData["ResultCode"]);?>]<?php echo($nicepay->m_ResultData["ResultMsg"]);?></td>
					</tr>
					<tr>
						<th><span>거래 아이디</th>
						<td><?php echo($nicepay->m_ResultData["TID"]);?></td>
					</tr>
					<tr>
						<th><span>거래 시간</th>
						<td><?php echo($nicepay->m_ResultData["AuthDate"]);?></td>
					</tr>
					<tr>
						<th><span>승인 번호</th>
						<td><?php echo($nicepay->m_ResultData["AuthCode"]);?></td>
					</tr>
					<tr>
						<th><span>카드 번호</th>
						<td><?php echo($nicepay->m_ResultData["CardNo"]);?></td>
					</tr>
					<tr>
						<th><span>카드사명</th>
						<td><?php echo($nicepay->m_ResultData["CardName"]);?></td>
					</tr>
				</table>
			</div>
		</div>
		<p>*테스트 아이디인경우 당일 오후 11시 30분에 취소됩니다.</p>
	</div>
</div>
</body>
</html>




