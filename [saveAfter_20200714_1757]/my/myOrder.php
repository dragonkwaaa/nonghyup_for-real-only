<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';

if(!$User->userCode()){
	$CommonManager->goPage('/intro/login', '로그인 후, 사용가능합니다.');
}
$state					=	(int)$SubFunction->allTags($_GET['state'])	?	(int)$SubFunction->allTags($_GET['state'])	:	1;
$type 					=	(int)$SubFunction->allTags($_GET['type'])	?	(int)$SubFunction->allTags($_GET['type'])	:	3;

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
		<div class="section listSect">

			<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
			<input type="hidden" name="pno" value="1">
			<input type="hidden" name="startDate" value="" id="startDate">
			<input type="hidden" name="endDate" value="" id="endDate">
			<!--<input type="hidden" name="orderState" value="0" id="orderState">-->
			<input type="hidden" name="year" value="" id="year">
			<input type="hidden" name="month" value="" id="month">
			<input type="hidden" name="searchType" value="1" id="searchType">
			<input type="hidden" name="state" value="<?= $state?>" id="state"">
			<input type="hidden" name="type" value="" id="type">

			<div class="mainTitle"></div>
			<ul class="findPageTab deliveryTypeTab orderedSort">
				<li id="selectRegularOrder">
					<a href="javascript:get_order(3);">이번달 정기배송</a>
				</li>
				<li id="regularOrder">
					<a href="javascript:get_order(1);">정기배송</a>
				</li>
				<li id="notRegularOrder">
					<a href="javascript:get_order(2);">일반배송</a>
				</li>
			</ul>
			<!-- :: 상품 리스트 파트 -->
			<div class="listGroup">
				<!-- :: 기간 설정 파트 -->
				<div class="listTop">
					<span class="todayDate f_bold vAlignM"></span>
					<div class="tAlignR">
						<ul class="dateTerm">
							<li>
								<a href="javascript:setSearchDate_my('0d');" class="plainBtn">오늘</a>
							</li>
							<li>
								<a href="javascript:setSearchDate_my('1m');" class="plainBtn">1개월</a>
							</li>
							<li>
								<a href="javascript:setSearchDate_my('3m');" class="plainBtn">3개월</a>
							</li>
							<li>
								<a href="javascript:setSearchDate_my('6m');" class="plainBtn">6개월</a>
							</li>
							<li class="activated relative">
								<a href="javascript:void(0);" class="plainBtn setPeriodBtn">기간설정</a>
								<div class="miniPop customDate hide">
									<span class="sbox year">
										<a href="javascript:void(0);" class="f16" id="yearSel">년도</a>
										<ul style="display: none;">
											<li onclick="setYear(<?php echo date('Y');?>);">2020년</li>
										</ul>
									</span>
									<span class="sbox month ml5">
										<a href="javascript:void(0);" class="f16" id="monthSel">월</a>
										<ul style="display: none;">
											<?php for($i = 1 ; $i <= 12 ; $i ++){?>
											<li onclick="setMonth(<?= $i?>);"><?= $i?>월</li>
											<?php } ?>
										</ul>
									</span>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<ul class="goodsList delivery" id="orderList">
					<!--<li>
						<div class="segmentTop">
							<label>
								<input type="checkbox" name="">
							</label>
							<a href="/order/orderSpec" class="rimlessBtn viewSpecBtn absoluteR">상세보기</a>
						</div>
						<div class="mainCon">
							<img src="/common/img/goodsTag_1.png" class="goodsImg separatedLeft"></img>
							<div class="goodsInfo separatedRight relative">
								<div class="absoluteT infoText">
									<div class="f16 f_semiBold">새벽에 수확한 딸기 500g</div>
									<div class="f12">
										<div>딸기 500g : 2~5팩 X 1개</div>
										<div>-추가 50g X 1개</div>
									</div>
								</div>
								<div class="absoluteMR f_bold f20">17,900원</div>
							</div>
						</div>
					</li>
					<li>
						<div class="segmentTop">
							<label>
								<input type="checkbox" name="">
							</label>
							<a href="/order/orderSpec" class="rimlessBtn viewSpecBtn absoluteR">상세보기</a>
						</div>
						<div class="mainCon">
							<img src="/common/img/goodsTag_1.png" class="goodsImg separatedLeft"></img>
							<div class="goodsInfo separatedRight relative">
								<div class="absoluteT infoText">
									<div class="f16 f_semiBold">새벽에 수확한 딸기 500g</div>
									<div class="f12">
										<div>딸기 500g : 2~5팩 X 1개</div>
										<div>-추가 50g X 1개</div>
									</div>
								</div>
								<div class="absoluteMR f_bold f20">17,900원</div>
							</div>
						</div>
					</li>-->
					<!-- :: 리스트에 아무 내용도 없을 때 나올 li 태그. -->
					<!--<li class="emptyList">
						등록된 찜 목록이 없습니다.
					</li>-->
				</ul>
				<!-- :: 선택 관련 버튼 파트 -->
				<div class="btnGroup mt20">
					<a href="javascript:codeCheckAll();" class="plainBtn selDelete">전체선택</a>
					<a href="javascript:delete_orderList();" class="plainBtn ml7 selDelete">선택삭제</a>
				</div>
				<!-- :: 페이징 파트 -->
				<ul class="pagingGroup">
					<!--<li>
						<a href="javascript:void(0);" class="pagingPrev"></a>
					</li>
					<li class="on">
						<a href="javascript:void(0);" class="">1</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="on">2</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="">3</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="">4</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="">5</a>
					</li>
					<li>
						<a href="javascript:void(0);" class="pagingNext"></a>
					</li>-->
				</ul>
			</div>
		</div>
	</div>

	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?>

</div>
<script src="/my/js/myOrder.js"></script>
<script>
	// ::기간설정 선택창 팝업 스크립트
	$(document).on('click', 'a.setPeriodBtn', function(){
		$(this).siblings('.miniPop.hide').toggle();
	})

	// :: 개월 선택시 노란 불 들어오는 스크립트.
	$(document).on('click', 'ul.dateTerm a', function(){
		$(this).parent('li').siblings('li').removeClass('activated');
		$(this).parent('li').addClass('activated');
	})

</script>
</body>
</html>