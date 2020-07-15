<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';?>
<body>
<div class="container">
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/header.php';?>
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/topMenu.php';?>
	<div class="contents">
        <?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/joinRightFloat.php';?>
		<div class="section userRegSect">
			<form name="frm" id="frm" onsubmit="return false;">
				<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
				<input type="hidden" name="AccountBank" value="">
				<input type="hidden" name="AccountBankNo" value="0">
				<input type="hidden" name="isRegular" value="0">

			<div class="mainTitle">회원가입</div>
			<div class="listGroup">
				<ul class="regInfoList">
					<li class="infoGroup">
						<div class="mainCon">
							<table class="infoRegTable">
								<tbody>
								<tr>
									<td>
										<input class="tbox full" placeholder="이름을 입력해주세요." name="userName">
									</td>
								</tr>
								<tr>
									<td class="fontReset">
										<input class="tbox long f16" placeholder="아이디를 입력해주세요." name="userID">
										<a href="javascript:check_userID();" class="bg_yellow f_white rimlessBtn tAlignC vAlignT normal">중복확인</a>
									</td>
								</tr>
								<tr>
									<td>
										<input class="tbox full" type="password" placeholder="비밀번호를 입력해주세요." name="userPWD" onkeyup="checkPW(this)">
										<div class="inputTip" id="pwdWarning">6자리 이상 20자 미만의 대소문자, 숫자 또는 특수문자가 포함된 비밀번호</div>

									</td>
								</tr>
								<tr>
									<td>
										<input class="tbox full" type="password" placeholder="비밀번호를 재입력해주세요." name="re_userPWD">
									</td>
								</tr>
								<tr>
									<td class="fontReset">
										<input class="tbox short f16 addrSort" placeholder="우편번호" id="zip" name="userZip" readonly>
										<a href="javascript:mobileSearchAddress();" class="bg_yellow f_white rimlessBtn tAlignC vAlignT short addrSort" id="addrSearch_m">검색</a>
										<a href="javascript:openPostcode();" class="bg_yellow f_white rimlessBtn tAlignC vAlignT short addrSort" id="addrSearch">검색</a>
										<div id="wrap" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
											<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
										</div>
                                        <!-- <input class="tbox normal f16" placeholder="기본 주소" id="addr1" name="userAddr" readonly> -->
                                        <input class="tbox full f16 mt14 addrSort" placeholder="기본 주소" id="addr1" name="userAddr" readonly>
									</td>
								</tr>
								<tr>
									<td>
										<input class="tbox full" placeholder="나머지 주소를 입력해주세요." id="addr2" name="userAddrDetail">
									</td>
								</tr>
								<tr>
									<td class="fontReset">
										<input class="tbox long f16 onlyNum" placeholder="휴대폰번호를 입력해주세요." name="userMobile">
										<a href="javascript:send_mobileCode();" class="bg_yellow f_white rimlessBtn tAlignC vAlignT normal">인증하기</a>
									</td>
								</tr>
								<tr>
									<td class="fontReset">
										<input class="tbox long f16 onlyNum" placeholder="인증번호를 입력해주세요." name="mobileCheckNum">
										<a href="javascript:complete_mobileCode();" class="f_yellow plainBtn tAlignC vAlignT normal">인증확인</a>
									</td>
								</tr>
								<tr>
									<td>
										<label>
											<input type="checkbox" name="isSMS" value="1">
											<span class="f_semiBold">휴대폰 수신동의</span>
										</label>
									</td>
								</tr>
								<tr>
									<td>
										<input class="tbox full" placeholder="이메일을 입력해주세요." name="userEmail">
									</td>
								</tr>
								<tr>
									<td>
										<label>
											<input type="checkbox" name="isEmail" value="1">
											<span class="f_semiBold">이메일 수신동의</span>
										</label>
									</td>
								</tr>
								<!-- :: 정기배송 이용여부 파트 -->
								<tr>
									<td class="fontReset">
										<div class="regularUsage">
											<span class="title">정기배송 이용여부</span>
											<div class="floatR">
												<ul class="useSelector">
													<li>
														<a href="javascript:setRegular(1);" class="script_regularTrue plainBtn">이용</a>
													</li>
													<li class="activated">
														<a href="javascript:setRegular(0);" class="script_regularFalse plainBtn">이용안함</a>
													</li>
												</ul>
											</div>
										</div>
										<div class="mt9 regularInfoReg">
											<label>
												<input type="checkbox" name="isOrgRegular" onclick="checkOrgRegular()" value="2">
												<span class="checkTxtLong">이미 정기배송을 사용하고 있습니다. (기존자동이체 임직원)</span>
											</label>
											<ul class="script_regularDuration useSelector mt9">
											<!--	<li class="activated">
													<a href="javascript:setPayMethod(1);" class="plainBtn">카드결제</a>
												</li>-->
											<!--	<li>
													<a href="javascript:setPayMethod(2);" class="plainBtn">계좌이체</a>
												</li>-->
												<!--<li>
													<a href="javascript:setMonth(9);" class="plainBtn">9개월</a>
												</li>-->
											</ul>
											<span class="sbox mr8 hide" id="bankSel">
												<a href="javascript:void(0);" class="f16" id="bankName">은행 선택</a>
												<ul>
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
											<input class="tbox normal mt9 f16 hide onlyNum" placeholder="계좌번호 입력" name="AccountNo" id="bankNumSel">
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<input class="tbox full hide" placeholder="예금주명을 입력해주세요." name="AccountName" id="AccountName">
									</td>
								</tr>
								<tr>
									<td>
										<div>
											<label>
												<input type="checkbox" id="chAll" name="checkAll">
												<span class="">전체 동의</span>
											</label>
										</div>
										<div class="mt13">
											<label>
												<input type="checkbox" name="agree_check" value="1" id="agree1">
												<span class="">서비스 이용약관 (필수)</span>
												<a href="/intro/terms" class="floatR f_underlined">내용보기</a>
											</label>
										</div>
										<!-- <div class="mt13">
											<label>
												<input type="checkbox" name="agree_check" value="1" id="agree2">
												<span class="">전자금융거래 이용약관 (필수)</span>
												<a href="javascript:void(0);" class="floatR f_underlined">내용보기</a>
											</label>
										</div> -->
										<div class="mt13">
											<label>
												<input type="checkbox" name="agree_check" value="1" id="agree3">
												<span class="">개인정보 수집/이용약관 (필수)</span>
												<a href="/intro/privacyTerm" class="floatR f_underlined">내용보기</a>
											</label>
										</div>
									</td>
								</tr>
								</tbody>
							</table>
						</div>
					</li>
					<li>
						<!-- :: 버튼 파트 -->
						<a href="javascript:insert_user();" class="rimlessBtn full mt80 bg_yellow f_white f_bold">회원가입</a>
					</li>
				</ul>
			</div>
			</form>
		</div>
	</div>
	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/joinFooter.php';?>
</div>
<script src="/intro/js/join.js"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<!--<script>

	function openPostcode() {
		new daum.Postcode({
			oncomplete: function(data) {
				// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
				var userSelectedType		=	data.userSelectedType;
				if (userSelectedType == 'R') {																			//	사용자가 도로명 주소를 선택한 경우
					var address				=	data.roadAddress;
				} else {																								//	사용자가 지번 주소를 선택한 경우
					var address				=	data.jibunAddress;
				}

				/*	document.getElementById('userSido').value				=	data.sido;
					document.getElementById('userSigungu').value			=	data.sigungu;*/
				document.getElementById('zip').value					=	data.zonecode;
				document.getElementById('addr1').value					=	address;
				document.getElementById('addr2').focus();
				//getXY(address);
			}
		}).open();
	}
</script>-->

</body>
</html>