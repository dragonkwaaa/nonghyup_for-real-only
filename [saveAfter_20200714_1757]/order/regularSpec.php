<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';
$orderCode				=	$SubFunction->allTags($_GET['no']);

if(!$orderCode){
	$CommonManager->goPage('/','잘못된 접근입니다.');
}

?>

<body>
<div class="container">

	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/header.php';?>

	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/topMenu.php';?>
	<div class="contents">
		<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/rightFloat.php';?>

		<div class="section orderRegSect orderSpecMod">
			<form name="frm" id="frm" onkeypress="if(event.keyCode==13) {document.frm.submit(); return false;}">
				<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
				<input type="hidden" name="orderCode" value="<?= $orderCode?>">
				<input type="hidden" name="state" value="1">
				<div class="mainTitle">이번달 정기배송 상세조회</div>

				<div class="listGroup">
					<ul class="regInfoList">
						<!-- :: 주문자 정보 파트 -->
						<li class="infoGroup">
							<div class="segmentTop f_bold f20">
								주문자 정보
							</div>
							<ul class="infoList">
								<li class="relative">
									<span>주문번호</span>
									<span class="absoluteR" id="orderCode"></span>
								</li>
								<li class="relative">
									<span>해당 정기배송 날짜</span>
									<span class="absoluteR" id="regDate"></span>
								</li>
								<li class="relative">
									<span>주문이름</span>
									<span class="absoluteR" id="orderTitle"></span>
								</li>
								<li class="relative">
									<span>주문자 이름</span>
									<span class="absoluteR" id="ordererName"></span>
								</li>
								<li class="relative">
									<span>주문자 연락처</span>
									<span class="absoluteR" id="ordererMobile"></span>
								</li>
								<li class="relative">
									<span>주문자 이메일</span>
									<span class="absoluteR" id="ordererEmail"></span>
								</li>
							</ul>
						</li>
						<!-- :: 결제정보 파트 -->
						<li class="infoGroup">
							<div class="segmentTop f_bold f20">
								결제정보
							</div>
							<ul class="infoList payMentInfoList">
								<li class="relative">
									<span>총 주문금액</span>
									<span class="absoluteR" id="orgAmount"></span>
								</li>
								<!--		<li class="relative">
											<span>총 할인금액</span>
											<span class="absoluteR">2,000원</span>
										</li>-->
								<li class="relative">
									<span>총 결제금액</span>
									<span class="absoluteR totalPriceText f_bold" id="amount"></span>
								</li>
								<li class="relative">
									<span>결제수단</span>
									<span class="absoluteR f_normal" id="payMethodStr"></span>
								</li>
							</ul>
						</li>

						<!-- :: 상품 카드박스 -->
						<li class="infoGroup">
							<div class="segmentTop f_bold f20" id="isRegularSel">
								주문상품
							</div>
							<ul class="goodsList orderSpecGroup orderGoodsMod">
							</ul>
						</li>
						<!-- :: 배송지 정보 파트 -->
						<li class="infoGroup">
							<div class="segmentTop f_bold f20">
								배송지 정보
							</div>
							<ul class="infoList">
								<li class="relative">
									<span>받으시는 분</span>
									<span class="absoluteR" id="receiveName"></span>
								</li>
								<li class="relative">
									<span>우편번호</span>
									<span class="absoluteR" id="receiveZip"></span>
								</li>
								<li class="relative addressGroup">
									<span>주소</span>
									<span class="absoluteR" id="receiveAddr"></span>
								</li>
								<li class="relative">
									<span>휴대전화</span>
									<span class="absoluteR" id="receiveMobile"></span>
								</li>
								<li class="relative">
									<span>배송메세지</span>
									<span class="absoluteR" id="deliveryMsg"></span>
								</li>
							</ul>
						</li>
						<li>
							<!-- :: 버튼 파트 -->
							<div class="btnGroup orderSpecGroup">
								<a href="/my/myOrder" class="plainBtn cancelBtn">주문목록보기</a>
								<!--	<a href="javascript:openReviewPop();" class="rimlessBtn regBtn">상품후기작성</a>-->
							</div>
						</li>
					</ul>
				</div>
			</form>
		</div>
	</div>
	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?>
</div>


<!-- :: ksg_20200327_1121 open  -->
<!-- :: 상품 후기 등록 팝업. -->
<div class="popup inquiry reviewMod">
	<a href="javascript:void(0);" class="closePopBtn absoluteR"></a>
	<div class="popupTitleBox">
		<div class="mainTitle">후기 등록하기</div>
	</div>
	<ul class="regInfoList">
		<li class="infoGroup">
			<div class="mainCon">

				<div class="ratingBox">

					<span class="f20">별점</span>
					<div class="absoluteMR">
						<div class="rating selectable">
							<a href="javascript:void(0);" class="rateStar"></a>
							<a href="javascript:void(0);" class="rateStar"></a>
							<a href="javascript:void(0);" class="rateStar"></a>
							<a href="javascript:void(0);" class="rateStar"></a>
							<a href="javascript:void(0);" class="rateStar"></a>
						</div>
					</div>
				</div>
				<textarea class="tArea inquiryWrite" placeholder="상품 후기를 입력해 주세요."></textarea>
			</div>
		</li>
		<li>
			<div class="btnGroup">
				<a href="javascript:void(0);" class="plainBtn cancelBtn f24">취소</a>
				<a href="javascript:void(0);" class="rimlessBtn regBtn f24">등록</a>
			</div>
		</li>
	</ul>
</div>
<!-- :: ksg_20200327_1121 close  -->



<script src="/order/js/regularSpec.js"></script>

<script>
	// :: 후기 작성 팝업 오픈 스크립트
	function openReviewPop(){
		$('.popup.inquiry').show();
		$('.container').addClass('overlay');
	}

	// :: 별점 평가 스크립트(공용)
	$(document).on('click', '.rating.selectable a', function(){
		$(this).parent('.rating.selectable').children('a.rateStar').removeClass('on');
		$(this).addClass('on');
		$(this).prevAll('a.rateStar').addClass('on');
	})
</script>

</body>
</html>