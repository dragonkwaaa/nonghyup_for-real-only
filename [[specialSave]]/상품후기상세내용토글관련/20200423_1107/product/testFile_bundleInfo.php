<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';

$code 							=	$SubFunction->allTags($_GET['code']);
$type 							=	$SubFunction->allTags($_GET['type']);
$isRegular 						=	$SubFunction->allTags($_GET['re']);
if(!$code){
	$CommonManager->goBack('잘못된 접근입니다.');
}

?>

<body>
<div class="container">
	
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/header.php';?> 

	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/topMenu.php';?> 

	<!-- :: 컨텐츠  파트 -->
	<div class="contents goodsSpecMod">

		<!-- :: 플로팅 내용 파트 -->
		<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/rightFloat.php';?> 

		<!-- :: 주요 내용 섹션 -->
		<div class="section goodsSect">
			<form name="frm" id="frm" onkeypress="if(event.keyCode==13) {document.frm.submit(); return false;}">
			<div class="goodsTop">
				<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
				<input type="hidden" name="type" value="2">
				<input type="hidden" name="code" value="<?= $code?>">
				<input type="hidden" name="isRegular" value="<?= $isRegular?>">
				<input type="hidden" name="price" value="0">				<!-- 상품가격 -->
				<input type="hidden" name="qty" value="1">					<!-- 상품개수 -->
				<input type="hidden" name="total" value="0">				<!-- 개수 * 가격 -->
				
				<!-- :: 웹 슬라이드 이미지 파트 open -->
				<div class="imgGroup">
					<div class="goodsSpecSlider webViewGroup customSlider">
						<div class="sliderImgSingle">
							<a href="javascript:void(0);">
								<img src="/common/img/goodsBig.png" class="imgMain">
							</a>
						</div>
						<div class="sliderImgSingle">
							<a href="javascript:void(0);">
								<img src="/common/img/goodsBig.png" class="imgMain">
							</a>
						</div>
						<div class="sliderImgSingle">
							<a href="javascript:void(0);">
								<img src="/common/img/goodsBig.png" class="imgMain">
							</a>
						</div>
						<div class="sliderImgSingle">
							<a href="javascript:void(0);">
								<img src="/common/img/mainLongBanner.png" class="imgMain">
							</a>
						</div>
					</div>
					<!-- :: 웹 슬라이드 이미지 파트 close -->

					<!-- :: 모바일 슬라이드 이미지 파트 open -->
					<div class="goodsSpecSlider mobileViewGroup customSlider">
						<div class="sliderImgSingle">
							<a href="javascript:void(0);">
								<img src="/common/img/goodsBig.png" class="imgMain">
							</a>
						</div>
						<div class="sliderImgSingle">
							<a href="javascript:void(0);">
								<img src="/common/img/goodsBig.png" class="imgMain">
							</a>
						</div>
						<div class="sliderImgSingle">
							<a href="javascript:void(0);">
								<img src="/common/img/mainLongBanner.png" class="imgMain">
							</a>
						</div>
						<div class="sliderImgSingle">
							<a href="javascript:void(0);">
								<img src="/common/img/mainLongBanner.png" class="imgMain">
							</a>
						</div>
					</div>
					<!-- :: 모바일 슬라이드 이미지 파트 close -->

					<!-- ::  슬라이드 섬네일 이미지 파트 open   -->
					<ul class="imgTab script_thumbnail">
						<li>
							<a href="javascript:void(0)">
								<img src="/common/img/goodsBig.png">
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<img src="/common/img/goodsBig.png">
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<img src="/common/img/goodsBig.png">
							</a>
						</li>
						<li>
							<a href="javascript:void(0)">
								<img src="/common/img/mainLongBanner.png">
							</a>
						</li>
					</ul>
					<!-- ::  슬라이드 섬네일 이미지 파트 close   -->
				</div>

				<!-- :: 웹 화면 상품 제목 및 옵션 선택 파트 open -->
				<div class="textGroup webViewGroup">
					<div class="f30 f_bold" id="name">

					</div>
					<div class="f30 f_bold f_red mt9" id="price">

					</div>
					<div class="goodsInfo">
						<span>원산지</span>
						<span id="originInfo"></span>
					</div>
					<div class="goodsInfo">
						<span>규격정보</span>
						<span id="standardInfo"></span>
					</div>
					<div class="goodsInfo">
						<span>배송정보</span>
						<span id="deliveryInfo"></span>
					</div>
					<?php if($isRegular != 1){ ?>
					<div class="goodsInfo selectGroup">
						<span>옵션선택</span>
						<span class="sbox">
							<a href="javascript:void(0);" class="f16">옵션선택</a>
							<ul>
								<li>옵션1</li>
								<li>옵션2</li>
							</ul>
						</span>
					</div>
					<div class="goodsInfo opControlGroup relative" id="orderList">
						<span id="subName">옵션명</span>
						<div class="absoluteMR">
							<span class="quantityBox">
								<a href="javascript:updateQty('M');" class="decreaseIcon">-</a>
								<input value="1" class="quantity onlyNum" id="qty1" onchange="calculation(this.value)">
								<a href="javascript:updateQty('P');" class="increaseIcon">+</a>
							</span>
							<span class="f_bold" id="perPrice"></span>
							<!--<a href="javascript:void(0);" class="rimlessBtn">삭제</a>-->
						</div>
					</div>
					<div class="goodsSumInfo">
						<span class="f14">총 합계금액</span>
						<span class="ml14 f24 f_red f_bold" id="total1">0 원</span>
					</div>
					<div class="btnGroup">
						<a href="javascript:set_cart();" class="rimlessBtn cartBtn">장바구니</a>
						<a href="javascript:directOrder()" class="plainBtn buyBtn">바로구매</a>
						<a href="javascript:set_favorite()" class="script_favorite rimlessBtn favoriteBtn">
							<i class="heartIcon"></i>
						</a>
					</div>
					<?php } ?>
				</div>
				<!-- :: 웹 화면 상품 제목 및 옵션 선택 파트 close -->


				<!-- :: 모바일 화면 상품 제목 파트 open  -->
				<div class="textGroup mobileGoodsTitle">
					<div class="f30 f_bold">
						새벽에 수확한 딸기 500g
					</div>
					<div class="f30 f_bold f_red mt9">
						17,900 원
					</div>
					<div class="goodsInfo">
						<span>원산지</span>
						<span>국내산</span>
					</div>
					<div class="goodsInfo">
						<span>규격정보</span>
						<span>500g</span>
					</div>
					<div class="goodsInfo">
						<span>배송정보</span>
						<span>택배배송/배송비 무료</span>
					</div>
				</div>
				<!-- :: 모바일 화면 상품 제목 파트 close  -->

				<!-- :: 모바일 하단 상품 구매 슬라이드 파트 open -->
				<?php if($isRegular != 1){ ?>
				<div class="textGroup mobilePurchaseGroup">
					<div class="goodsBuyInfoGroup">
						<a href="javascript:void(0);" class="slideBottomCloseBtn bundleSlideMod">
							<i></i>
						</a>
						<!-- <div class="f30 f_bold">
							새벽에 수확한 딸기 500g
						</div>
						<div class="f30 f_bold f_red mt9">
							17,900 원
						</div>
						<div class="goodsInfo">
							<span>원산지</span>
							<span>국내산</span>
						</div>
						<div class="goodsInfo">
							<span>규격정보</span>
							<span>500g</span>
						</div>
						<div class="goodsInfo">
							<span>배송정보</span>
							<span>택배배송/배송비 무료</span>
						</div> -->
						<!-- <div class="goodsInfo selectGroup">
							<span>옵션선택</span>
							<span class="sbox">
								<a href="javascript:void(0);" class="f16">옵션선택</a>
								<ul>
									<li>옵션1</li>
									<li>옵션2</li>
								</ul>
							</span>
						</div> -->
						<div class="goodsInfo opControlGroup">
							<div class="singleOptionBox">
								<span>옵션명</span>
								<div class="absoluteMR">
									<span class="quantityBox">
										<a href="javascript:void(0);" class="decreaseIcon">-</a>
										<input value="1" class="quantity">
										<a href="javascript:void(0);" class="increaseIcon">+</a>
									</span>
									<span class="f_bold"> 17,900원</span>
									<a href="javascript:void(0);" class="rimlessBtn">삭제</a>
								</div>
							</div>
							<div class="singleOptionBox">
								<span>옵션명</span>
								<div class="absoluteMR">
									<span class="quantityBox">
										<a href="javascript:void(0);" class="decreaseIcon">-</a>
										<input value="1" class="quantity">
										<a href="javascript:void(0);" class="increaseIcon">+</a>
									</span>
									<span class="f_bold"> 17,900원</span>
									<a href="javascript:void(0);" class="rimlessBtn">삭제</a>
								</div>
							</div>
						</div>
						<div class="goodsSumInfo">
							<span class="f14">총 합계금액</span>
							<span class="ml14 f24 f_red f_bold">17,900 원</span>
						</div>
					</div>
					<div class="btnGroup">
						<a href="/nonghyup/cart" class="rimlessBtn cartBtn">장바구니</a>
						<a href="/nonghyup/order/orderReg" class="plainBtn buyBtn">바로구매</a>
						<a href="javascript:void(0)" class="rimlessBtn buyPopBtn">구매하기</a>
						<a href="javascript:void(0)" class="script_favorite rimlessBtn favoriteBtn">
							<i class="heartIcon"></i>
						</a>
					</div>
				</div>
				<?php } ?>
				<!-- :: 모바일 하단 상품 구매 슬라이드 파트 close -->
			</div>
			</form>
			<ul class="findPageTab goodsInfoTypeTab goodsSpecGroup mt50">
				<li class="activated">
					<a href="javascript:void(0);">상품정보</a>
				</li>
				<li>
					<a href="javascript:void(0);">구매후기</a>
				</li>
				<li>
					<a href="javascript:void(0);">상품문의</a>
				</li>
				<li>
					<a href="javascript:void(0);">배송/교환/반품</a>
				</li>
			</ul>
			<!-- :: 상품정보 내용 파트 -->
			<div class="separatedLeft goodsInfoGroup">
				<div class="listGroup">
					<ul class="regInfoList">
						<!-- :: 묶음 내 상품들 표시 파트 -->
						<li>
							<!-- ::묶음 내 상품 리스트 -->
							<ul class="bundleInsideList">
							</ul>
						</li>

						<li class="infoGroup imgGroup" id="info">
							<!--<img src="/common/img/goodsSpecImg.png">-->
							<!-- 에디터 상품 정보 -->
						</li>
						<li>
							<ul class="findPageTab goodsInfoTypeTab goodsReviewSub">
								<li>
									<a href="javascript:void(0);">상품정보</a>
								</li>
								<li class="activated">
									<a href="javascript:void(0);">구매후기</a>
								</li>
								<li>
									<a href="javascript:void(0);">상품문의</a>
								</li>
								<li>
									<a href="javascript:void(0);">배송/교환/반품</a>
								</li>
							</ul>
						</li>

						<!-- :: 구매후기 파트 -->	
						<li class="infoGroup reviewGroup">
							<!-- :: 모든 사용자 구매 만족도 평균 표시 파트 open -->
							<div class="totalSatisfaction relative">
								<span class="f20" id="reviewTot"></span>
								<span class="f20 f_semiBold" id="reviewerNum"></span>
								<div class="absoluteMR">
									<div class="rating selectable">
										<a href="javascript:void(0);" class="rateStar" id="avgStar1"></a>
										<a href="javascript:void(0);" class="rateStar" id="avgStar2"></a>
										<a href="javascript:void(0);" class="rateStar" id="avgStar3"></a>
										<a href="javascript:void(0);" class="rateStar" id="avgStar4"></a>
										<a href="javascript:void(0);" class="rateStar" id="avgStar5"></a>
									</div>
									<span class="f30 ml15 f_bold" id="reviewAvg"></span>
								</div>
							</div>
							<!-- :: 모든 사용자 구매 만족도 평균 표시 파트 close -->
							<input type="hidden" name="pno1" value="1">
							




							<!-- :: ksg_20200422_2227 single : 리뷰 내용 작업 파트 -->
							<!-- <ul class="infoList" id="reviewList"> -->
							<ul class="infoList">
								<li class="relative">
									<a href="javascript:void(0);" class="reviewHeadline">
										<span class="indexNumBox">'+i+'</span>
										<div class="rating rigid">
											<span href="javascript:void(0);" class="rateStar '+(score >= 1 ? " on" : "")+'"></span>
											<span href="javascript:void(0);" class="rateStar '+(score >= 2 ? " on" : "")+'"></span>
											<span href="javascript:void(0);" class="rateStar '+(score >= 3 ? " on" : "")+'"></span>
											<span href="javascript:void(0);" class="rateStar '+(score >= 4 ? " on" : "")+'"></span>
											<span href="javascript:void(0);" class="rateStar '+(score >= 5 ? " on" : "")+'"></span>
										</div>
										<span class="reviewTitle">'+re.subject+'</span>
										<span class="reviewerID">'+re.userID+'</span>
										<span class="absoluteMR">'+re.regDate.substring(0,10)+'</span>
									</a>



									<!-- :: ksg_20200423_1105 single : 하이드/쇼 되는 내용 파트  -->
									<div class="reviewDetailGroup">
										<div class="reviewText">딸기가 정말 달고 시원해요. 크기도 크고, 설익은것도 없어서 너무 좋아요.</div>
										<div class="reviewImgGroup">
											<img src="/common/img/mainSliderImg.png"/>
											<img src="/common/img/mainSliderImg.png"/>
											<img src="/common/img/mainSliderImg.png"/>
											<img src="/common/img/mainSliderImg.png"/>
											<img src="/common/img/mainSliderImg.png"/>
										</div>
									</div>




								</li>


							</ul>




							
							<ul class="pagingGroup" id="pagingGroup1">
							</ul>
						</li>
						<!-- :: 상품문의 파트  -->
						<li>
							<ul class="findPageTab goodsInfoTypeTab goodsReviewSub">
								<li>
									<a href="javascript:void(0);">상품정보</a>
								</li>
								<li>
									<a href="javascript:void(0);">구매후기</a>
								</li>
								<li class="activated">
									<a href="javascript:void(0);">상품문의</a>
								</li>
								<li>
									<a href="javascript:void(0);">배송/교환/반품</a>
								</li>
							</ul>
						</li>
						<li class="infoGroup inquiryGroup">
							<a href="javascript:void(0);" class="script_goodsInquiry rimlessBtn inquiryReg absoluteR bg_yellow">상품 문의하기</a>
							<input type="hidden" name="pno2" value="1">
 							<ul class="infoList" id="askList">
							</ul>
							<ul class="pagingGroup" id="pagingGroup2">
							</ul>
						</li>

						<!-- :: 배송 교환 반품 파트 -->
						<li>
							<ul class="findPageTab goodsInfoTypeTab goodsReviewSub">
								<li>
									<a href="javascript:void(0);">상품정보</a>
								</li>
								<li>
									<a href="javascript:void(0);">구매후기</a>
								</li>
								<li>
									<a href="javascript:void(0);">상품문의</a>
								</li>
								<li class="activated">
									<a href="javascript:void(0);">배송/교환/반품</a>
								</li>
							</ul>
						</li>


						<li class="infoGroup deliveryInfoGroup">
							<div class="segmentTop f_bold f12">
								배송 안내
							</div>
							<ul class="infoList">
								<li class="relative">
									<span class="separatedLeft">배송방법</span>
									<span class="separatedRight">
<pre>상품을 제공받은 날로부터 7일이내 교환, 반품이 가능합니다.
단, 과일, 채소, 양곡, 냉동, 냉장과 같은 신선식품은 시간의 경과에 따라 재판매가 곤란하므로 고객의 단순변심에 의한 교환&반품은 불가능합니다. 	(농협몰 이용약관 15조에 의함)
표시내용과 다른 상품이 배달된 경우 30일이내 교환(동일상품) 및 취소가 가능합니다.</pre>
									</span>
								</li>
								<li class="relative">
									<span class="separatedLeft">배송시간</span>
									<span class="separatedRight">	
<pre>평균 2~5일 이내 배송 (공휴일, 연휴 제외 / 날짜선택 불가능)</pre>
									</span>
								</li>
								<li class="relative">
									<span class="separatedLeft">배송지역</span>
									<span class="separatedRight">	
<pre>전국배송 (단, 일부 상품은 제주도 및 도서산간지역 배송 불가)</pre>
									</span>
								</li>
								<li class="relative">
									<span class="separatedLeft">배송비</span>
									<span class="separatedRight">	
<pre>무료배송 / 조건별 배송
업체별, 상품별로 배송비가 다름
일부상품은 제주도 및 도서산간지역의 경우 추가 배송비가 발생할 수 있음</pre>
									</span>
								</li>
							</ul>
						</li>
						<li class="infoGroup refundInfoGroup">
							<div class="segmentTop f_bold f12">
								교환 및 반품 안내
							</div>
							<ul class="infoList">
								<li class="relative">
									<span class="separatedLeft">교환/반품/신청기간</span>
									<span class="separatedRight">
<pre>상품을 제공받은 날로부터 7일이내 교환, 반품이 가능합니다.
단, 과일, 채소, 양곡, 냉동, 냉장과 같은 신선식품은 시간의 경과에 따라 재판매가 곤란하므로 고객의 단순변심에 의한 교환&반품은 불가능합니다. (농협몰 이용약관 15조에 의함)
표시내용과 다른 상품이 배달된 경우 30일이내 교환(동일상품) 및 취소가 가능합니다.</pre>
									</span>
								</li>
								<li class="relative">
									<span class="separatedLeft">교환/반품 회수 (배송) 비용</span>
									<span class="separatedRight">	
<pre>고객님 변심에 의한 반송 시 왕복배송비는 고객님 부담입니다.</pre>
									</span>
								</li>
								<li class="relative">
									<span class="separatedLeft">교환/반품 불가안내</span>
									<span class="separatedRight">	
<pre>상품을 사용하였거나 고객의 부주의로 인한 상품의 훼손 및 파손의 경우
일부제품 (가전 등)의 경우, 포장을 개봉하거나 설치, 사용했을 경우
과일, 채소, 양곡, 냉동, 냉장과 같은 신선식품은 고객의 단순변심에 의한 반품은 불가능합니다.</pre>
									</span>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			<!-- :: 우측 주문정보 졸졸이 파트 -->
			<?php if($isRegular != 1){ ?>
			<div class="separatedRight rightFloat innerFloat goodsInfoGroup">
				<div>
					<span class="f14">수량</span>
					<span class="quantityBox ml30">
						<a href="javascript:updateQty('M');" class="decreaseIcon">-</a>
						<input value="1" class="quantity onlyNum" id="qty2" onchange="calculation(this.value)">
						<a href="javascript:updateQty('P');" class="increaseIcon">+</a>
					</span>
				</div>
				<div class="goodsSumPrice">
					<span class="f14 vAlignM">총 합계금액</span>
					<span class="f_red f24 f_bold ml14 vAlignM" id="total2">0원</span>
				</div>
				<a href="javascript:set_cart()" class="rimlessBtn cartBtn">장바구니</a>
				<a href="javascript:directOrder()" class="plainBtn buyBtn">바로구매</a>
			</div>
			<?php } ?>
		</div>
	</div>
	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?> 
</div>


<!-- :: 상품 문의하기 팝업 -->
<div class="popup inquiry">
	<a href="javascript:void(0);" class="closePopBtn absoluteR"></a>
	<div class="popupTitleBox">
		<div class="mainTitle">상품 문의하기</div>
	</div>
	<ul class="regInfoList">
		<li class="infoGroup">
			<div class="mainCon">
				<textarea class="tArea inquiryWrite" id="contents"></textarea>
			</div>
		</li>
		<li>
		<div class="btnGroup">
			<a href="javascript:void(0);" class="plainBtn cancelBtn f24">취소</a>
			<a href="javascript:insert_ask();" class="rimlessBtn regBtn f24">등록</a>
		</div>
		</li>
	</ul>
</div>

<script src="/product/js/testFile_bundleInfo.js"></script>
<script src="/product/js/testFile_infoCommon.js"></script>

<script>
// :: 페이지 상단 상품 이미지 웹 슬라이드 스크립트 
$('.goodsSpecSlider.webViewGroup').slick({
	dots:false,
	prevArrow:false,
	nextArrow:false,
	autoplay : true,
	autoplaySpeed : 55000,
	asNavFor : '.script_thumbnail'
});

// :: 페이지 상단 상품 이미지 모바일 슬라이드 스크립트 
$('.goodsSpecSlider.mobileViewGroup').slick({
	dots:true,
	prevArrow:false,
	nextArrow:false,
	autoplay : true,
	autoplaySpeed : 55000,
	dotsClass: 'custom_paging',
	customPaging: function (slider, i) {
        console.log(slider);
        return  (i + 1) + '/' + slider.slideCount;
    }
});

// :: 슬라이드 섬네일 기능 스크립트  
$('.script_thumbnail').slick({
 	slidesToShow: 4,
 	slidesToScroll: 1,
 	asNavFor: '.goodsSpecSlider',
 	dots: false,
	accessability : false,
 	focusOnSelect: true
 });

// 	:: 슬라이드 섬네일 스타일 초기화 스크립트
$('.script_thumbnail .slick-slide').removeClass('activated');

// :: 선택 섬네일/첫 섬네일 스타일 부여 스크립트
$('.script_thumbnail .slick-slide').eq(0).addClass('activated');

// :: 큰 슬라이드 이미지와 섬네일 이미지 순서 일치 시키는 스크립트
$('.goodsSpecSlider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
	let mySlideNumber = nextSlide;
	$('.script_thumbnail .slick-slide').removeClass('activated');
	$('.script_thumbnail .slick-slide').eq(mySlideNumber).addClass('activated');
});

// :: 모바일 구매하기 버튼 클릭 시 하단 내용 표시
$(document).on('click', '.rimlessBtn.buyPopBtn', function(){
	$('.goodsBuyInfoGroup').addClass('activated');
	$('.goodsBuyInfoGroup.activated').slideDown(400);
	$('.container').addClass('bottomOverlay');
});

// :: 모바일 하단 슬라이드 파트의 화살표 꼬다리 클릭 시 구매 내용 사라지게 하는 스크립트
$(document).on('click', '.slideBottomCloseBtn', function(){
	
	$('.goodsBuyInfoGroup').slideUp(400);
	$('.goodsBuyInfoGroup').removeClass('activated');
	$('.container').removeClass('bottomOverlay');
});

// :: 장바구니 졸졸이 따라다니는 기능 스크립트(테스팅 진행중)
$(document).ready(function() {

	$(window).scroll(function() {
	
		// :: 졸졸이의 기능이 활성화 되어 올라갈 수 있는 최대 한계치.
		var limitTop = $(".findPageTab.goodsInfoTypeTab").offset().top;
	
		// :: 현재 화면 스크롤 위치값.
		var scrollTop = $(window).scrollTop();
	
		// :: 졸졸이의 유동적인 top 값을 규정.
		var newPosition = scrollTop + "px";
	
		//  :: 현재 표시되는 화면의 바텀값.
		var scrollBottom = $("body").height() - $(window).height() - $(window).scrollTop();
	
		// :: 페이지 전체 내에서 footer 가 위치하고 있는 높이의 값. 
		var limitFooter = $('footer').position().top;
	
		// :: 애니메이션 들어간 졸졸이 따라다니는 스크립트. 
		if(scrollTop > limitTop - 150) {
			$(".separatedRight.rightFloat.innerFloat.goodsInfoGroup").stop().animate({
				"top" : newPosition
			}, 500);
		} 
		if (scrollBottom < 480) {
			$(".separatedRight.rightFloat.innerFloat.goodsInfoGroup").stop().animate({
				"top" : limitFooter - 750
			}, 500);
		}
	}).scroll();

});

</script>
</body>
</html>
