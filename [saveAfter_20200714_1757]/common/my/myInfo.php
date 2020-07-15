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
		<div class="section userRegSect modifyMod">
			<div class="mainTitle">내 정보 수정</div>
			<!-- :: 회원정보 입력 파트 -->
			<div class="listGroup">
				<ul class="regInfoList">
					<form name="frm" id="frm" onkeypress="if(event.keyCode==13) {document.frm.submit(); return false;}">
						<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
					<li class="infoGroup">
						<!-- <div class="segmentTop f_bold f20">
							주문자 정보
						</div> -->
						<div class="mainCon">
							<table class="infoRegTable">
								<tbody>
								<tr>
									<td>
										<input class="tbox full" name="userName" value="" placeholder="이름을 입력해주세요.">
									</td>
								</tr>
								<tr>
									<td>
										<input class="tbox full" readonly value="" name="userID">
									</td>
								</tr>
								<tr>
									<td>
										<input class="tbox full" type="password" placeholder="비밀번호를 입력해주세요." value="" name="userPWD">
									</td>
								</tr>
								<tr>
									<td>
										<input class="tbox full" type="password" placeholder="비밀번호를 재입력해주세요." name="re_userPWD">
									</td>
								</tr>
								<tr>
                                    <td class="fontReset">
								    	<div class="titleBox indicatorSort tAlignL">주소</div>
								    	<input class="tbox short f16 addrSort" placeholder="우편번호" name="userZip" readonly id="zip">
								    	<a href="javascript:mobileSearchAddress();" class="bg_yellow f_white rimlessBtn tAlignC vAlignT short addrSort" id="addrSearch_m">검색</a>
								    	<a href="javascript:openPostcode();" class="bg_yellow f_white rimlessBtn tAlignC vAlignT short addrSort" id="addrSearch">검색</a>
								    	<div id="wrap" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
								    		<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
								    	</div>
								    	<input class="tbox full f16 mt14 addrSort" placeholder="기본 주소" readonly name="userAddr" id="addr1">
								    </td>

								</tr>
								<tr>
									<td>
										<input class="tbox full" value="" name="userAddrDetail" id="addr2" placeholder="상세주소를 입력해주세요.">
									</td>
								</tr>
								<tr>
									<td class="fontReset">
										<input class="tbox long f16 onlyNum" value="" name="userMobile" placeholder="핸드폰 번호를 입력해주세요.">
										<a href="javascript:send_mobileCode();" class="bg_yellow f_white rimlessBtn tAlignC vAlignT normal">재인증하기</a>
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
										<input class="tbox full" placeholder="이메일을 입력해주세요." value="" name="userEmail">
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
								</tbody>
							</table>
						</div>
					</li>
					<li>
						<!-- :: 버튼 파트 -->
						<div class="btnGroup">
							<a href="/my" class="plainBtn cancelBtn">취소</a>
							<a href="javascript:update_user();" class="rimlessBtn regBtn">저장</a>
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
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="/my/js/myInfo.js"></script>
</body>
</html>