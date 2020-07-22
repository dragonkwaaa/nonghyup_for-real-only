<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';


if(!$User->userCode() || !$_SESSION['isRegular']){
	$CommonManager->goPage('/','잘못된 접근입니다.');
}

$isRegular 					=	$_SESSION['isRegular'];
unset($_SESSION['isRegular']);

?>

<body>
<div class="container">

	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/header.php';?>
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/topMenu.php';?>
	<div class="contents">
		<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/rightFloat.php';?>
		<div class="section orderRegSect">
			<form name="frm" id="frm" onkeypress="if(event.keyCode==13) {document.frm.submit(); return false;}" accept-charset="EUC-KR">
			<div class="mainTitle">주문하기</div>
			<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
			<input type="hidden" name="isRegular" value="<?= $isRegular?>">
			<input type="hidden" name="orgAmount" value="0">
			<input type="hidden" name="amount" value="0">
			<input type="hidden" name="payMethod" value="1">
			<input type="hidden" name="directOrder" value="0">
			<input type="hidden" name="chkType" value="PC">
			<input type="hidden" name="userCode" value="<?= $User->userCode()?>">
			<div class="separatedLeft">
				<div class="listGroup">
					<ul class="regInfoList">
						<li class="infoGroup">
							<div class="segmentTop f_bold f20" id="title1">
							</div>
							<div class="mainCon">
								<!-- :: 내부 리스트 파트 -->
								<ul class="subList">
									
								</ul>
							</div>
						</li>
						<!-- :: 주문자 정보 파트 -->
						<li class="infoGroup">
							<div class="segmentTop f_bold f20">
								주문자 정보
							</div>
							<div class="mainCon">
								<table class="infoRegTable">
									<colgroup>
										<col width="29%">
										<col width="71%">
									</colgroup>
									<tbody>
									<tr>
										<th>이름</th>
										<td>
											<input class="tbox" name="ordererName" id="ordererName" maxlength="10">
										</td>
									</tr>
									<tr>
										<th>연락처</th>
										<td>
											<input class="tbox onlyNum" name="ordererMobile" id="ordererMobile">
										</td>
									</tr>
									<tr>
										<th>이메일</th>
										<td>
											<input class="tbox" name="ordererEmail" id="ordererEmail">
										</td>
									</tr>
									</tbody>
								</table>
							</div>
						</li>
						<!-- :: 배송지 정보 파트 -->
						<li class="infoGroup">
							<div class="segmentTop f_bold f20">
								배송지 정보
							</div>
							<div class="mainCon">
								<!-- :: 주문자 정보 동일 버튼 -->
								<a href="javascript:paste_order();" class="plainBtn">주문자 정보와 동일</a>
								<table class="infoRegTable mt20">
									<colgroup>
										<col width="29%">
										<col width="82%">
									</colgroup>
									<tbody>
									<tr>
										<th>수령인</th>
										<td>
											<input class="tbox" name="receiveName" id="receiveName">
										</td>
									</tr>
									<tr>
										<th>연락처</th>
										<td>
											<input class="tbox onlyNum" name="receiveMobile" id="receiveMobile">
										</td>
									</tr>
									<tr>
										<th>배송주소</th>
										<td>
											<div class="combinedInputGroup">
												<input  class="tbox" readonly placeholder="우편번호" id="zip" name="receiveZip">
												<a href="javascript:openPostcode();" class="bg_yellow f_white rimlessBtn tAlignC addrSort" id="addrSearch">검색</a>
												<a href="javascript:mobileSearchAddress();" class="bg_yellow f_white rimlessBtn tAlignC addrSort" id="addrSearch_m">검색</a>
												<div id="wrap" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
													<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
												</div>
											</div>
											<input class="tbox mt14 addrSort" readonly placeholder="주소" name="receiveAddr" id="addr1" onclick="openPostcode();">
											<input class="tbox mt14" placeholder="상세주소" name="receiveAddrDetail" id="addr2">
										</td>
									</tr>
									<tr>
										<th>배송 메세지</th>
										<td>
											<input class="tbox" name="deliveryMsg">
										</td>
									</tr>
									</tbody>
								</table>
							</div>
						</li>
						<!-- :: 결제 수단 파트 -->
						<li class="infoGroup" id="payMethodSel0">
							<div class="segmentTop f_bold f20">
								결제 수단
							</div>
							<div class="mainCon tAlignC">
								<!-- :: 주문자 정보 동일 버튼 -->
								<a href="javascript:setPayMethod('1');" class="plainBtn methodSelector">
									<i class="iconCard"></i>
									<span>신용/체크카드</span>
								</a>
								<a href="javascript:setPayMethod('3');" class="plainBtn methodSelector ml9">
									<i class="iconCash"></i>
									<span>무통장 입금</span>
								</a>
								<a href="javascript:setPayMethod('4');" class="plainBtn methodSelector ml9">
									<i class="iconPhone"></i>	
									<span>휴대폰 결제</span>
								</a>
							</div>
                        </li>
                        


                        <!-- :: 모바일 주문하기 버튼 -->
                        <li class="mobileViewGroup">
                            <div class="mt40">
								<label>
									<input type="checkbox" name="agree_check" value="1" id="agree1_m">
									<span class="">개인정보 수집/이용약관 (필수)</span>
									<a href="javascript:void(0);" class="floatR f_underlined mobF14">내용보기</a>
								</label>
							</div>
                            <div class="mt13">
								<label>
									<input type="checkbox" name="agree_check" value="1" id="agree2_m">
									<span class="checkTxtLong">주문상품 및 주문 정보를 확인하였고, 결제 진행에 동의합니다. (필수)</span>
								</label>
                            </div>
                            <a href="javascript:insert_order(2);" class="rimlessBtn full mt80 bg_yellow f_white f_bold" id="checkPay1"></a>
                        </li>



						<!-- :: 정기배송 결제정보 -->
						<!--<li class="infoGroup" id="payMethodSel1">
							<div class="segmentTop f_bold f20">
								정기배송 결제정보
							</div>
							<div class="mainCon">
								<table class="infoRegTable">
									<colgroup>
										<col width="127px">
										<col width="582px">
									</colgroup>
									<tbody>
									<tr>
										<th>은행명</th>
										<td>
											<input class="tbox" name="bankName" id="bankName">
										</td>
									</tr>
									<tr>
										<th>계좌번호</th>
										<td>
											<input class="tbox onlyNum" name="bankAccountNum" id="bankAccountNum">
										</td>
									</tr>
									</tbody>
								</table>
							</div>
						</li>-->
					</ul>
				</div>
			</div>
			<!-- :: 우측 주문정보 졸졸이 파트 -->
			<div class="separatedRight rightFloat innerFloat">
				<div class="boxTitle">
					<span class="f17 f_bold">결제정보</span>
					<span class="f14 ml3" id="title2">(상품3개)</span>
				</div>
				<!-- :: 금액정보 표시 파트 -->
				<div class="mt20 f14">
					<div>
						<span>총 상품 금액</span>
						<span class="floatR f_bold" id="total"></span>
					</div>
					<div class="mt20">
						<span>총 배송비</span>
						<span class="floatR">무료</span>
					</div>
					<div class="mt20">
						<span>총 할인금액</span>
						<span class="floatR f_bold" id="discountTotal"></span>
					</div>
				</div>
				<div class="bg_lightGrey mt20 priceBox">
					<span class="f14">결제 예정 금액</span>
					<span class="floatR f_red f24 f_bold" id="orderPrice"></span>
				</div>
				<div class="mt16 f14">
					<label>
						<input class="tbox" type="checkbox" value="1" name="agree" id="agree1">
						<span>개인정보 수집/이용약관 (필수)</span>
					</label>
					<a href="javascript:void(0);" class="floatR f_underlined">내용보기</a>
				</div>
				<div class="mt13 f14">
					<label>
						<input class="tbox" type="checkbox" name="agree" id="agree2">
						<span>주문상품 및 주문 정보를 확인하였고, 결제 진행에</br> 동의합니다. (필수)</span>
					</label>
				</div>
				<a href="javascript:insert_order(1)" class="rimlessBtn bg_yellow f_white mt20 f_bold" id="checkPay2"></a>
			</div>
			</form>
			<!--<form id="frmPG" method="post" target="_self" action="https://web.nicepay.co.kr/v3/smart/smartPayment.jsp" accept-charset="euc-kr"></form>-->
		</div>
	</div>

	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?> 

</div>
<script src="/order/js/orderReg.js"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="https://web.nicepay.co.kr/flex/js/nicepay_tr_utf.js" type="text/javascript"></script>
<script>
// :: 결제수단 선택 시, 해당 버튼에 노란색 테두리 표시되게 하는 스크립트. 
$(document).on('click','.plainBtn.methodSelector', function(){
	$(this).siblings('.plainBtn').removeClass('activated');
	$(this).addClass('activated');
})
</script>
</body>
</html>