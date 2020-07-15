<?php
header("Content-Type:text/html; charset=UTF-8;");
/*
*******************************************************
* <결제요청 파라미터>
* 결제시 Form 에 보내는 결제요청 파라미터입니다.
* 샘플페이지에서는 기본(필수) 파라미터만 예시되어 있으며,
* 추가 가능한 옵션 파라미터는 연동메뉴얼을 참고하세요.
*******************************************************
*/
$ip = $_SERVER['REMOTE_ADDR'];          // 클라이언트 ip
?>
<!DOCTYPE html>
<html>
<head>
	<title>NICEPAY VBANK REQUEST(UTF-8)</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes, target-densitydpi=medium-dpi" />
	<link rel="stylesheet" type="text/css" href="./css/import.css"/>
	<script type="text/javascript">
		function nicepay(){
			document.getElementById("vExp").value = getTomorrow();
			document.payForm.submit();
		}

		function getTomorrow(){
			var today = new Date();

			var yyyy = today.getFullYear().toString();
			var mm = (today.getMonth()+1).toString();
			var dd = (today.getDate()+1).toString();
			if(mm.length < 2){mm = '0' + mm;}
			if(dd.length < 2){dd = '0' + dd;}
			return (yyyy + mm + dd);
		}
	</script>
</head>
<body>
<form name="payForm" method="post" action="/my/tempResult">
	<div class="payfin_area">
		<div class="top">NICEPAY VBANK REQUEST(UTF-8)</div>
		<div class="conwrap">
			<div class="con">
				<div class="tabletypea">
					<table>
						<colgroup><col width="30%" /><col width="*" /></colgroup>
						<tr>
							<th><span>은행선택</span></th>
							<td>
								<select name="BankCode">
									<option value="003">기업</option>
									<option value="004">국민</option>
									<option value="011">농협</option>
									<option value="020">우리</option>
									<option value="023">SC제일</option>
									<option value="031">대구</option>
									<option value="032">부산</option>
									<option value="088">신한</option>
								</select>
							</td>
						</tr>
						<tr>
							<th><span>상품명</span></th>
							<td><input type="text" name="GoodsName" value="나이스페이"></td>
						</tr>
						<tr>
							<th><span>상품가격</span></th>
							<td><input type="text" name="Amt" value="1004"></td>
						</tr>
						<tr>
							<th><span>상품주문번호</span></th>
							<td><input type="text" name="Moid" value="mnoid1234567890"></td>
						</tr>
						<tr>
							<th><span>구매자명</span></th>
							<td><input type="text" name="BuyerName" value="나이스"></td>
						</tr>
						<tr>
							<th><span>구매자 이메일</span></th>
							<td><input type="text" name="BuyerEmail" value="happy@day.co.kr"></td>
						</tr>
						<tr>
							<th><span>구매자 전화번호</span></th>
							<td><input type="text" name="BuyerTel" value="01000000000"></td>
						</tr>
						<tr>
							<th><span>상점아이디</span></th>
							<td><input type="text" name="MID" value="nictest00m"></td>
						</tr>
						<tr>
							<th><span>영수증 타입</span></th>
							<td>
								<select name="CashReceiptType">
									<option value="0">미발행</option>
									<option value="1">소득공제</option>
									<option value="2">지출증빙</option>
								</select>
							</td>
						</tr>
						<tr>
							<th><span>영수증 발행번호(핸드폰or주민번호)</span></th>
							<td><input type="text" name="ReceiptTypeNo" value="01000000000"></td>
						</tr>

						<!-- 옵션  -->
						<input type="hidden" name="VbankExpDate" id="vExp" value="">        <!-- 가상계좌입금만료일 -->
						<input type="hidden" name="TransType" value="0">                    <!-- 결제 일반(0),에스크로(1) -->
						<input type="hidden" name="UserIP" value="<?=$ip?>">                <!-- 고객ip -->
						<input type="hidden" name="GoodsCnt" value="1">                     <!-- 상품 갯수 -->
						<input type="hidden" name="VbankAccountName" value="홍길동통장이름">     <!-- 통장이름 -->

						<!-- 변경 불가 -->
						<input type="hidden" name="PayMethod" value="VBANK">                <!-- 결제방법 -->
						<input type="hidden" name="EdiDate" value="<?=$ediDate?>">          <!-- 전문 생성일시 -->
						<input type="hidden" name="EncryptData" value="<?=$hash_String?>">  <!-- 해쉬암호화 -->
						<input type="hidden" name="TrKey" value="">
					</table>
				</div>
			</div>
			<div class="btngroup">
				<a href="#" class="btn_blue" onClick="nicepay();">요 청</a>
			</div>
		</div>
	</div>
</form>
</body>
</html>