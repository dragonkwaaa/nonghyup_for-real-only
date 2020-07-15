<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';

print_r($User->userCode());

?>

<body>
<div class="container">
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/header.php';?>
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/topMenu.php';?>

	<div class="contents">
		<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/joinRightFloat.php';?>
		<div class="section loginSect">
			<form id="frm" onkeypress="if(event.keyCode==13) {login(); return false;}">
				<input type="hidden" name="auto" value="0">
				<input type="hidden" name="auto_id" value="">
				<input type="hidden" name="auto_pwd" value="">
				<input type="hidden" name="isLogout" value="1">
				<div class="mainTitle">로그인</div>
				<div class="listGroup">
					<ul class="regInfoList">
						<li class="infoGroup">
							<div class="mainCon">
								<table class="infoRegTable">
									<tbody>
									<tr>
										<td>
											<input class="tbox full" placeholder="아이디를 입력해주세요" value="" name="id">
										</td>
									</tr>
									<td>
										<input class="tbox full" type="password" placeholder="비밀번호를 입력해주세요." value="" name="pwd">
									</td>
									</tr>

									<tr>
										<td>
											<label>
												<input type="checkbox" name="autoLogin" value="1">
												<span class="f_semiBold">자동로그인</span>
												<div class="floatR">
													<a href="/intro/findID" class="f_underlined f14">아이디˙비밀번호 찾기</a>
													<a href="/intro/join" class="f_underlined f14 ml13">회원가입</a>
												</div>
											</label>
										</td>
									</tr>

									</tbody>
								</table>
							</div>
						</li>
						<li>
							<!-- :: 버튼 파트 -->

							<a href="javascript:login();" class="rimlessBtn full bg_yellow f_white f_bold">로그인</a>

						</li>
					</ul>
				</div>

			</form>


		</div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/joinFooter.php';?>
</div>
<script src="/intro/js/login.js"></script>
<script>

	// :: 셀렉트박스 스크립트(공용)
	$(document).on('click', '.sbox a', function(){
		$(this).siblings('ul').slideToggle();
	})


</script>
</body>
</html>