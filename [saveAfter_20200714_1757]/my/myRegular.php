<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';
if(!$User->userCode()){
	$CommonManager->goPage('/intro/login', '로그인 후, 사용가능합니다.');
}



?>

<body>
<div class="container">

	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/header.php';?> 

	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/topMenu.php';?> 

	<!-- :: 컨텐츠  파트 -->
	<div class="contents">

		<!-- :: 플로팅 내용 파트 -->
		<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/rightFloat.php';?> 

		<!-- :: 주요 내용 섹션 -->
		<div class="section userRegSect">
			<div class="mainTitle">정기배송 관리</div>
			<div class="listGroup">
				<ul class="regInfoList">
					<form name="frm" id="frm" accept-charset="UTF-8">
						<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
						<input type="hidden" name="userCode" value="<?= $User->userCode()?>">
						<input type="hidden" name="isRegular" value="">
						<input type="hidden" name="BillKey" value="">
						<input type="hidden" name="isOrgRegular" value="">
						<input type="hidden" name="Amt" value="39000">
					<li class="infoGroup">
				<!--		<div class="regularInfoBox">
							<div class="titleBox indicatorSort topFlat">금액</div>
							<input class="tbox full displayer" name="Amt" value="39000" readonly>
						</div>-->
						<div class="regularInfoBox">
							<!-- <div class="titleBox indicatorSort">구매자 이름</div> -->
							<input class="tbox full displayer" name="ordererName" value="" placeholder="이름을 입력해주세요.">
						</div>
						<div class="regularInfoBox">
							<!-- <div class="titleBox indicatorSort">구매자 연락처</div> -->
							<input class="tbox full displayer onlyNum" name="ordererMobile" value="" placeholder="연락처를 입력해주세요.">
						</div>
						<div class="regularInfoBox">
							<!-- <div class="titleBox indicatorSort">구매자 이메일</div> -->
							<input class="tbox full displayer" name="ordererEmail" value="" placeholder="이메일을 입력해주세요.">
						</div>
						<div class="regularInfoBox">
							<!-- <div class="titleBox indicatorSort">배송 메세지</div> -->
							<input class="tbox full displayer" name="deliveryMsg" value="" placeholder="배송메세지를 입력해주세요.">
						</div>
						<table class="infoRegTable morphRegular reSel">
							<tbody>
							<tr>
								<td class="fontReset">
									<div class="titleBox indicatorSort tAlignL">주소</div>
									<input class="tbox short f16 addrSort" placeholder="우편번호" name="receiveZip" readonly id="zip">
									<a href="javascript:mobileSearchAddress();" class="bg_yellow f_white rimlessBtn tAlignC vAlignT short addrSort" id="addrSearch_m">검색</a>
									<a href="javascript:openPostcode();" class="bg_yellow f_white rimlessBtn tAlignC vAlignT short addrSort" id="addrSearch">검색</a>
									<div id="wrap" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
										<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
									</div>
									<input class="tbox full f16 mt14 addrSort" placeholder="기본 주소" readonly name="receiveAddr" id="addr1">
								</td>
							</tr>
							<tr>
								<td>
									<input class="tbox full" placeholder="나머지 주소를 입력해주세요." name="receiveAddrDetail" id="addr2">
									<div class="inputTip">* 주소를 기입하지 않을 경우, 배송이 불가능 합니다.</div>
									<div class="inputTip">* 원활한 배송을 위해 정확한 주소를 입력해 주세요.</div>
									<div class="inputTip" id="corpPayInfo">* </div>
								</td>
							</tr>
							<!-- <div class="regularInfoBox">
								<div class="titleBox indicatorSort">카드 번호</div>
								<input class="tbox full displayer onlyNum" name="CardNo" value="">
							</div>
							<div class="regularInfoBox">
								<div class="titleBox indicatorSort">유효기간</div>
								<input name="ExpMonth" maxLength="2" size="3" type="text" placeholder="MONTH" value="" class="tbox full displayer onlyNum">/
								<input name="ExpYear" maxLength="2" size="3" type="text" placeholder="YEAR" value="" class=" tbox full displayer onlyNum">
							</div>
							<div class="regularInfoBox">
								<div class="titleBox indicatorSort">생년월일(YYMMDD)or사업자번호</div>
								<input class="tbox full displayer onlyNum" name="IDNo" value="">
							</div>
							<div class="regularInfoBox">
								<div class="titleBox indicatorSort">비밀번호 앞 두자리</div>
								<input class="tbox full displayer onlyNum" name="CardPw" value="" maxlength="2" type="password">
							</div> -->
							<tr>
								<td>
									<div class="titleBox indicatorSort">결제정보</div>
										<!-- <div class="radioGroup payMethod">
											<div class="radioCase">
												<label>
													<input type="radio" name="payMethod" value="1" checked onclick="setPayMethodStr(1)">
													<span>카드결제</span>
												</label>
											</div>
											<div class="radioCase">
												<label>
													<input type="radio" name="payMethod" value="2" onclick="setPayMethodStr(2)">
													<span>계좌이체</span>
												</label>
											</div>
										</div> -->
										<!-- :: hide 클래스를 사용하여 박스를 표시/숨김 할 수 있습니다. -->
										<div class="certInfoBox cardSort" id="payInfo">
											<div class="textBox" id="payName"></div>
											<div class="textBox" id="payNum"></div>
											<a href="javascript:delete_payMethod();" class="btn delSort">삭제</a>
										</div>
										<div class="certInfoBox cardSort noCertMod" id="noPayInfo">
											<div class="textBox" id="noPayInfoStr">등록된 결제수단이 없습니다.</div>
											<a href="javascript:void(0)" class="btn regSort" id="payButton">결제수단등록</a>
										</div>
									<div>
									<!-- <div class="payCertNone">* 결제정보를 인증해주세요.</div>
									<input class="tbox long f16 hide" placeholder="정기배송에 사용하실 결제 정보 인증" name="userID">
									<a href="javascript:keyRequest();" class="bg_yellow f_white rimlessBtn tAlignC vAlignT normal" id="processStr">인증받기</a> -->
								</td>
							</tr>
							</tbody>
						</table>
					</li>
					<li class="infoGroup reSel">
						<ul class="goodsList morphRegular" id="regularList">
						</ul>
						<!-- :: 선택 관련 버튼 파트 -->
						<!--<div class="btnGroup morphRegular">
							<a href="javascript:codeCheckAll();" class="plainBtn">전체선택</a>
							<a href="javascript:delete_regular();" class="plainBtn ml7">선택삭제</a>
						</div>-->
					</li>
					<li>
						<!-- :: 버튼 파트 -->
						<div class="btnGroup morphRegular tAlignC">
							<a href="javascript:update_isRegular();" class="plainBtn cancelBtn" id="regularStr">해지하기</a>
							<a href="javascript:set_regularInfo();" class="rimlessBtn regBtn">저장하기</a>
						</div>
					</li>
				</form>
				</ul>
			</div>
		</div>
	</div>
	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?> 
</div>

<div class="popup regCard">
		<input type="hidden" name="payMethod" value="1">
	<a href="javascript:void(0);" class="closePopBtn absoluteR"></a>
	<div class="popupTitleBox">
		<div class="mainTitle">결제수단 등록</div>
		<div class="subTitle">카드정보를 입력해주세요.</div>
	</div>
	<ul class="useSelector popupSort">
		<li class="activated">
			<a href="javascript:setPay_1()" class="script_regularTrue plainBtn cardMod">카드결제</a>
		</li>
		<li>
			<a href="javascript:setPay_2();" class="script_regularFalse plainBtn bankMod">계좌이체</a>
		</li>
	</ul>
	<ul class="regInfoList payTypeSort cardMod">
		<li class="infoGroup">
			<div class="mainCon">
				<input class="tbox displayer onlyNum" placeholder="카드번호를 입력해주세요." name="CardNo"/>
				<div class="cardDateBox">
					<input class="tbox" placeholder="유효기간(월)" maxLength="2" size="3" name="ExpMonth"/>
					<input class="tbox" placeholder="유효기간(년)" maxLength="2" size="3" name="ExpYear"/>
				</div>
				<input class="tbox displayer onlyNum" placeholder="생년월일(YYMMDD)or사업자번호" name="IDNo"/>
				<input class="tbox displayer onlyNum" placeholder="비밀번호 (앞 두자리)" name="CardPw" type="password" maxlength="2"/>
			</div>
		</li>
		<li>
			<div class="btnGroup bottomSort">
				<a href="javascript:void(0);" class="plainBtn cancelBtn f24">취소</a>
				<a href="javascript:keyRequest();" class="rimlessBtn regBtn f24">등록</a>
			</div>
		</li>
	</ul>
	<ul class="regInfoList payTypeSort bankMod hide">
		<input type="hidden" name="AccountBank" value="">
		<input type="hidden" name="AccountBankNo" value="0">
		<li class="infoGroup">
			<div class="mainCon">
				<div class="checkBoxGroup cardRegSort">
					<label>
						<input type="checkbox" name="checkOrg" value="1">
						<span class="f_semiBold">이미 정기배송을 사용하고 있습니다. (기존자동이체 임직원)</span>
					</label>
				</div>
				<span class="sbox">
					<a href="javascript:void(0);" class="" id="bankName">은행 선택</a>
					<ul id="opList">
						<li onclick="setBankName('기업은행', '003');">기업은행</li>
						<li onclick="setBankName('국민은행', '004');">국민은행</li>
						<li onclick="setBankName('외환은행', '005');">외환은행</li>
						<li onclick="setBankName('수협', '007');">수협</li>
						<li onclick="setBankName('농협', '011');">농협</li>
						<li onclick="setBankName('우리은행', '020');">우리은행</li>
						<li onclick="setBankName('제일은행', '023');">제일은행</li>
						<li onclick="setBankName('씨티은행', '027');">씨티은행</li>
						<li onclick="setBankName('대구은행', '031');">대구은행</li>
						<li onclick="setBankName('부산은행', '032');">부산은행</li>
						<li onclick="setBankName('광주은행', '034');">광주은행</li>
						<li onclick="setBankName('제주은행', '035');">제주은행</li>
						<li onclick="setBankName('전북은행', '037');">전북은행</li>
						<li onclick="setBankName('경남은행', '039');">경남은행</li>
						<li onclick="setBankName('새마을금고', '045');">새마을금고</li>
						<li onclick="setBankName('신협', '048');">신협</li>
						<li onclick="setBankName('우체국', '071');">우체국</li>
						<li onclick="setBankName('하나은행', '081');">하나은행</li>
						<li onclick="setBankName('신한은행', '088');">신한은행</li>
					</ul>
				</span>
				<input class="tbox displayer onlyNum" placeholder="계좌번호를 입력해주세요." name="AccountNo" id="bankNumSel"/>
				<input class="tbox displayer" placeholder="예금주명을 입력해주세요." name="AccountName" id="AccountName"/>
				<input class="tbox displayer" placeholder="예금주 생년월일 앞 6자리 또는 사업자 번호 10자리" name="bank_IDNo" id="idNo"/>
				<input class="tbox displayer" placeholder="예금주 전화번호를 입력해주세요" name="HPNo" id="HPNo"/>
			</div>
		</li>
		<li>
			<div class="btnGroup bottomSort">
				<a href="javascript:void(0);" class="plainBtn cancelBtn f24">취소</a>
				<a href="javascript:bankRequest();" class="rimlessBtn regBtn f24">등록</a>
			</div>
		</li>
	</ul>
</div>

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="/my/js/myRegular.js"></script>
<script>
// :: 카드 등록 팝업창 표시.
/*
$(document).on('click', '.certInfoBox .btn.regSort', function(){
	$('.popup.regCard').show();
    $('.container').addClass('overlay');
    
    // :: 팝업창 오픈 시, 현재 보고 있는 화면 위치에 표시하는 스크립트. 
    $('.popup.regCard').css({
        "top": (($(window).height()-$('.popup.regCard').outerHeight())/2+$(window).scrollTop())+"px",
        "left": (($(window).width()-$('.popup.regCard').outerWidth())/2+$(window).scrollLeft())+"px"
    }); 
});
*/

</script>
</body>
</html>