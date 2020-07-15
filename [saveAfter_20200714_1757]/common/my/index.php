<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';
if(!$User->userCode()){
	$CommonManager->goPage('/intro/login', '로그인 후, 사용가능합니다.');
}
$userID 								=	$User->userID();
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
		<div class="section myMainSect">
			<div class="mainTitle">마이페이지</div>
			<div class="myMenuBox">
				<div class="menuBoxHeadLine relative">
					<div class="greetingText">
						<span>안녕하세요</span>
						<span class="userName"><?= $userID?></span>
						<span>님!</span>
					</div>
					<div class="btnBox absoluteMR">
                        <!-- :: ksg_20200707_1503 single : 쿠폰목록 버튼 보존하기. (사용 예정.) -->
                        <!-- <a href="/my/myCoup" class="plainBtn">내 쿠폰 목록</a> -->
						<a href="/my/myRegular" class="plainBtn ml10">정기배송 관리</a>
						<a href="/my/myInfo" class="plainBtn ml10">회원정보 수정</a>
					</div>
				</div>
				<div class="menuBoxMainCon">
					<a href="/my/myOrder?state=1" class="cardBox">
						<i class="cardIconDelivery"></i>
						<span>주문배송조회</span>
					</a>
					<a href="/my/myOrder?state=2" class="cardBox">
						<i class="cardIconRefund"></i>
						<span>취소/교환/반품 조회</span>
					</a>
					<a href="/my/myFavorite" class="cardBox">
						<i class="cardIconFavorite"></i>
						<span>찜 목록</span>
					</a>
					<a href="/my/myPost" class="cardBox">
						<i class="cardIconMyPost"></i>
						<span>나의 글 목록</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?> 
</div>
<script></script>
</body>
</html>