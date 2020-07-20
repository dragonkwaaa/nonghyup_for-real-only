<!DOCTYPE html>
<html lang="ko">
<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';
$type							=	$SubFunction->allTags($_GET['type'])		?	$SubFunction->allTags($_GET['type'])	:	0;			//0:일반,1:정기,2:묶음
$code 							=	$SubFunction->allTags($_GET['code']);

if(!$code){
	$CommonManager->goBack('잘못된 접근입니다.');
}

?>

<body class="prdtBody">
<div class="container">
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/header.php';?>
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/topMenu.php';?>
	<div class="contents">
		<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/rightFloat.php';?>
		<div class="section goodsSect">

			<!-- :: 상품정보 파트 -->
			<form name="frm" id="frm" onkeypress="if(event.keyCode==13) {document.frm.submit(); return false;}">
			<div class="goodsTop">
				<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
				<input type="hidden" name="type" value="<?= $type?>">	<!-- 1:정기배송,2:묶음배송 -->
				<input type="hidden" name="code" value="<?= $code?>">
				<input type="hidden" name="price" value="0">			<!-- 상품가격 -->
				<input type="hidden" name="qty" value="1">				<!-- 상품개수 -->
				<input type="hidden" name="total" value="0">			<!-- 개수 * 가격 -->
				<input type="hidden" name="isOption" value="0">			<!-- 개수 * 가격 -->
				<input type="hidden" name="isRegular" value="0">
				<input type="hidden" name="isBundle" value="0">
				<input type="hidden" name="userRegular" value="0">
				<input type="hidden" name="regularLimit" value="0">

				<!-- :: 웹 슬라이드 이미지 파트 open -->
				<div class="imgGroup">
					<div class="goodsSpecSlider webViewGroup customSlider">
						<!--<div class="sliderImgSingle">
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
						</div>-->
					</div>
					<!-- :: 웹 슬라이드 이미지 파트 close -->

					<!-- :: 모바일 슬라이드 이미지 파트 open -->
					<div class="goodsSpecSlider mobileViewGroup customSlider">
						<!--<div class="sliderImgSingle">
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
						</div>-->
					</div>
					<!-- :: 모바일 슬라이드 이미지 파트 close -->

					<!-- ::  슬라이드 섬네일 이미지 파트 open   -->
					<div id="underSlide">
					<!--<ul class="imgTab script_thumbnail">-->
					<!--	<li>
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
						</li>-->
					<!--</ul>-->
					</div>
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
					<div class="goodsInfo selectGroup">
						<span>옵션선택</span>
						<span class="sbox">
							<a href="javascript:void(0);" class="f16" id="opTitle">옵션선택</a>
							<ul id="opList">
							</ul>
						</span>
					</div>
					<div id="opSel">
						<div class="goodsInfo opControlGroup" id="orderOpList1">
						</div>
					</div>
					<div class="goodsSumInfo">
						<span class="f14">총 합계금액</span>
						<span class="ml14 f24 f_red f_bold" id="total1">0 원</span>
					</div>
					<div class="btnGroup">
						<a href="javascript:set_cart()" class="rimlessBtn cartBtn orderBtn longMod">장바구니</a>
						<?php /*if($type != 1){ */?><!--
						<a href="javascript:directOrder()" class="plainBtn buyBtn orderBtn">바로구매</a>
						--><?php /*} */?>
						<a href="javascript:set_favorite()" class="script_favorite rimlessBtn favoriteBtn">
							<i class="heartIcon"></i>
						</a>
					</div>
				</div>
				<!-- :: 웹 화면 상품 제목 및 옵션 선택 파트 close -->


				<!-- :: 모바일 화면 상품 제목 파트 open  -->
				<div class="textGroup mobileGoodsTitle">
					<div class="f30 f_bold" id="name_m">
					</div>
					<div class="f30 f_bold f_red mt9" id="price_m">
					</div>
					<div class="goodsInfo">
						<span>원산지</span>
						<span id="originInfo_m"></span>
					</div>
					<div class="goodsInfo">
						<span>규격정보</span>
						<span id="standardInfo_m"></span>
					</div>
					<div class="goodsInfo">
						<span>배송정보</span>
						<span id="deliveryInfo_m"></span>
					</div>
				</div>
				<!-- :: 모바일 화면 상품 제목 파트 close  -->

				<!-- :: 모바일 하단 상품 구매 슬라이드 파트 open -->
				<div class="textGroup mobilePurchaseGroup">


                    <a href="javascript:void(0);" class="openSlideBottomBtn">
				    	<i></i>
				    </a>



					<div class="goodsBuyInfoGroup">
						<a href="javascript:void(0);" class="slideBottomCloseBtn bundleSlideMod">
							<i></i>
						</a>
						<div class="goodsInfo selectGroup">
							<span>옵션선택</span>
							<span class="sbox">
								<a href="javascript:void(0);" class="f16" id="opTitle_m">옵션선택</a>
								<ul id="opList_m">
								</ul>
							</span>
						</div>
						<div class="goodsInfo opControlGroup" id="orderOpList1_m">
							<!--<div class="singleOptionBox">
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
							</div>-->
						</div>
						<div class="goodsSumInfo">
							<span class="f14">총 합계금액</span>
							<span class="ml14 f24 f_red f_bold" id="total_m">0 원</span>
						</div>

                        <div class="insideBtnGroup">
						<!--	<?php /*if($type != 1){ */?>
								<a href="javascript:void(0);" class="plainBtn halfSort rightSort">바로구매</a>
							--><?php /*} */?>
                            <!-- <a href="javascript:set_cart();" class="rimlessBtn <?php if($type != 1){ ?>halfSort<?php } ?> leftSort">장바구니</a> -->
						    
                        </div>
					</div>
					<div class="btnGroup">
						<!-- <a href="javascript:void(0)" class="rimlessBtn buyPopBtn orderBtn">장바구니</a> -->
                        <a href="javascript:set_cart()" class="rimlessBtn buyPopBtn orderBtn" id="cartButton_m">장바구니</a>
						<a href="javascript:set_favorite()" class="script_favorite rimlessBtn favoriteBtn">
							<i class="heartIcon"></i>
						</a>
					</div>
				</div>
				<!-- :: 모바일 하단 상품 구매 슬라이드 파트 close -->

			</div>
			</form>

			<ul class="findPageTab goodsInfoTypeTab goodsSpecGroup mt50">
				<li class="activated">
					<a href="javascript:void(0);" class="goodsSpecSort">상품정보</a>
				</li>
				<li>
					<a href="javascript:void(0);" class="goodsReviewSort">구매후기</a>
				</li>
				<li>
					<a href="javascript:void(0);" class="goodsFaqSort">상품문의</a>
				</li>
				<li>
					<a href="javascript:void(0);" class="deliveryRuleSort">배송/교환/반품</a>
				</li>
			</ul>
			<!-- :: 상품정보 내용 파트 -->
			<div class="separatedLeft goodsInfoGroup">
				<div class="listGroup">
					<ul class="regInfoList">

						<li>
							<!-- ::묶음 내 상품 리스트 -->
							<ul class="bundleInsideList">
							</ul>
						</li>

						<li class="infoGroup imgGroup" id="info">
							<!-- 에디터 상품 정보 -->
						</li>
						<li>
							<ul class="findPageTab goodsInfoTypeTab goodsReviewSub">
								<li>
									<a href="javascript:void(0);" class="goodsSpecSort">상품정보</a>
								</li>
								<li class="activated">
									<a href="javascript:void(0);" class="goodsReviewSort">구매후기</a>
								</li>
								<li>
									<a href="javascript:void(0);" class="goodsFaqSort">상품문의</a>
								</li>
								<li>
									<a href="javascript:void(0);" class="deliveryRuleSort">배송/교환/반품</a>
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
							<ul class="infoList" id="reviewList">
							</ul>
							<ul class="pagingGroup" id="pagingGroup1">
							</ul>
						</li>



						<!-- :: 상품문의 파트  -->
						<li>
							<ul class="findPageTab goodsInfoTypeTab goodsReviewSub">
								<li>
									<a href="javascript:void(0);" class="goodsSpecSort">상품정보</a>
								</li>
								<li>
									<a href="javascript:void(0);" class="goodsReviewSort">구매후기</a>
								</li>
								<li class="activated">
									<a href="javascript:void(0);" class="goodsFaqSort">상품문의</a>
								</li>
								<li>
									<a href="javascript:void(0);" class="deliveryRuleSort">배송/교환/반품</a>
								</li>
							</ul>
						</li>
						<li class="infoGroup inquiryGroup">
							<a href="javascript:void(0);" class="rimlessBtn inquiryReg absoluteR bg_yellow script_goodsInquiry">상품 문의하기</a>
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
									<a href="javascript:void(0);" class="goodsSpecSort">상품정보</a>
								</li>
								<li>
									<a href="javascript:void(0);" class="goodsReviewSort">구매후기</a>
								</li>
								<li>
									<a href="javascript:void(0);" class="goodsFaqSort">상품문의</a>
								</li>
								<li class="activated">
									<a href="javascript:void(0);" class="deliveryRuleSort">배송/교환/반품</a>
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
			<div class="separatedRight rightFloat innerFloat goodsInfoGroup">
				<div id="selectGroup2">
					<span class="f14">수량</span>
					<span class="quantityBox ml30">
						<a href="javascript:updateQty('M');" class="decreaseIcon">-</a>
						<input value="1" class="quantity onlyNum" id="qty2" onchange="calculation(this.value)">
						<a href="javascript:updateQty('P');" class="increaseIcon">+</a>
					</span>
                </div>
                

                <!-- :: 웹 우측 하단의 장바구니 옵션 선택하는 파트 -->
                <!-- <div class="goodsInfo selectGroup">
					<span>옵션선택</span>
					<span class="sbox">
						<a href="javascript:void(0);" class="f16">상품선택</a>
						<ul>
                            <li>참외</li>
                            <li>양파</li>
                            <li>애호박</li>
					</span>
				</div> -->


                <!-- :: 웹 우측 하단의 장바구니 선택된 옵션 파트 -->
           		<!-- <div>
					<div class="singleOptionBox">
						<div class="optionName">옵션명</div>
						<span class="f14">수량</span>
						<span class="quantityBox ml30">
							<a href="javascript:void(0);" class="decreaseIcon">-</a>
							<input value="1" class="quantity">
							<a href="javascript:void(0);" class="increaseIcon">+</a>
						</span>
						<div class="relative optionPriceBox">
							<span>17,900원</span>
							<a href="javascript:void(0);" class="rimlessBtn absoluteMR">삭제</a>
						</div>
					</div>
					<div class="singleOptionBox">
						<div class="optionName">옵션명</div>
						<span class="f14">수량</span>
						<span class="quantityBox ml30">
							<a href="javascript:void(0);" class="decreaseIcon">-</a>
							<input value="1" class="quantity">
							<a href="javascript:void(0);" class="increaseIcon">+</a>
						</span>
						<div class="relative optionPriceBox">
							<span>17,900원</span>
							<a href="javascript:void(0);" class="rimlessBtn absoluteMR">삭제</a>
						</div>
					</div>
				</div> -->



				<div class="goodsSumPrice">
					<span class="f14 vAlignM">총 합계금액</span>
					<span class="f_red f24 f_bold ml14 vAlignM" id="total2"></span>
				</div>
				<a href="javascript:set_cart()" class="rimlessBtn cartBtn orderBtn">장바구니</a>
				<!--<a href="javascript:directOrder()" class="plainBtn buyBtn orderBtn">바로구매</a>-->
			</div>
		</div>
	</div>
	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?>
</div>

<div class="popup inquiry ">
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

<script src="/product/js/info.js"></script>
<script src="/product/js/infoCommon.js"></script>

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

// :: 모바일 화살표 꼬다리 버튼 클릭 시 하단 내용 표시
$(document).on('click', '.openSlideBottomBtn', function(){
	$('.goodsBuyInfoGroup').addClass('activated');
    $('.openSlideBottomBtn').addClass('hide');
    $('.rimlessBtn.buyPopBtn.orderBtn').addClass('linkable');
	$('.goodsBuyInfoGroup.activated').slideDown(400);
	$('.container').addClass('bottomOverlay');
});

// :: 모바일 하단 슬라이드 파트의 화살표 꼬다리 클릭 시 구매 내용 사라지게 하는 스크립트
$(document).on('click', '.slideBottomCloseBtn', function(){
	
	$('.goodsBuyInfoGroup').slideUp(400);
	$('.goodsBuyInfoGroup').removeClass('activated');
    $('.rimlessBtn.buyPopBtn.orderBtn').removeClass('linkable');
    $('.openSlideBottomBtn').removeClass('hide');
	$('.container').removeClass('bottomOverlay');
});


// :: 장바구니 졸졸이 따라다니는 기능 스크립트
setTimeout( function(){ 

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
    		if(scrollTop > limitTop - 0) {
                $(".separatedRight.rightFloat.innerFloat.goodsInfoGroup").css('top', 'auto')
    			$(".separatedRight.rightFloat.innerFloat.goodsInfoGroup").stop().animate({
    				"bottom" : scrollBottom - 600
    			}, 500);
    		} 
    		if (scrollBottom < 480) {
                $(".separatedRight.rightFloat.innerFloat.goodsInfoGroup").css('top', 'auto')
    			$(".separatedRight.rightFloat.innerFloat.goodsInfoGroup").stop().animate({
                    "bottom" : "0"
                    // "top" : "auto"
                    
    			}, 500);
    		}
    	}).scroll();

    });
}  , 1000 );







// :: 탭 누르면 그에 대응하는 내용 파트로 화면 이동되는 스크립트.
$(document).ready(function() {
  $(".findPageTab.goodsInfoTypeTab a").click(function() {
	if ($(this).hasClass('goodsSpecSort')) {
		$("body,html").animate(
    	  { 
    	    scrollTop: $(".separatedLeft.goodsInfoGroup").offset().top - 95
    	  },
    	  800
    	);
	} else if ($(this).hasClass('goodsReviewSort')) {
		$("body,html").animate(
    	  { 
    	    scrollTop: $(".infoGroup.reviewGroup").offset().top - 95
    	  },
    	  800
    	);
	} else if ($(this).hasClass('goodsFaqSort')) {
		$("body,html").animate(
    	  { 
    	    scrollTop: $(".infoGroup.inquiryGroup").offset().top - 95
    	  },
    	  800
    	);
	} else if ($(this).hasClass('deliveryRuleSort')) {
		$("body,html").animate(
    	  { 
    	    scrollTop: $(".infoGroup.deliveryInfoGroup").offset().top - 95
    	  },
    	  800
    	);
	};
  });
});


</script>


</body>
</html>



<style>
.section.goodsSect .goodsTop .textGroup .goodsBuyInfoGroup {
    margin-bottom : 0; 
}
</style>