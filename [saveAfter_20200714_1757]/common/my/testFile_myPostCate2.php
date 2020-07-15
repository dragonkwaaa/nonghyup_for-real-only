<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';?> 

<body>
<div class="container">
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/header.php';?> 

	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/topMenu.php';?> 
	<!-- :: 컨텐츠  파트 -->
	<div class="contents">

		<!-- :: 플로팅 내용 파트 -->
		<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/rightFloat.php';?> 

		<!-- :: 주요 내용 섹션 -->
		<div class="section listSect inquiryMod">
			<div class="mainTitle">나의 글 목록</div>
			<ul class="findPageTab deliveryTypeTab">
				<li>
					<a href="javascript:void(0);">상품후기</a>
				</li>
				<li class="activated">
					<a href="javascript:void(0);">1:1문의</a>
				</li>
			</ul>
			<div class="searchBox subSearchGroup">
				<span class="sbox">
					<a href="javascript:void(0);">제목</a>
					<ul>
						<li>내용</li>
					</ul>
				</span>
				<input class="searchInput ml9">
				<a class="rimlessBtn ml5">검색</a>
			</div>
			<div class="listGroup">
				<ul class="noticeList">
					<li class="infoGroup">
						<ul class="infoList">
							<!-- :: 문의사항 묶음 1 -->
							<li class="relative">
								<a href="javascript:void(0);" class="noticeSpecShow noticeListTitle">
									<!-- <span class="indexNumBox">1</span> -->
									<span class="ml30">문의사항 있습니다.</span>
									<span class="absoluteR">2020.01.01</span>
								</a>
								<div class="noticeSpecInfo questionGroup">
									<div class="goodsInfo separatedRight relative">
										<div class="infoText">
											<span class="f18 f_Bold f_red">Q</span>
											<span class="f12 ml25">딸기 크기가 어느정도 되나요?</span>
										</div>

										<div class="mt5">
											<img src="/common/img/goodsTag_1.png" class="goodsImg separatedLeft ml10">	
											<img src="/common/img/goodsTag_1.png" class="goodsImg separatedLeft ml10">
											<img src="/common/img/goodsTag_1.png" class="goodsImg separatedLeft ml10">
											<img src="/common/img/goodsTag_1.png" class="goodsImg separatedLeft ml10">
											<img src="/common/img/goodsTag_1.png" class="goodsImg separatedLeft ml10">
										</div>
										<div class="absoluteMR f_bold f20 f_red">답변완료</div>
									</div>
								</div>
								<div class="noticeSpecInfo aswerGroup">
									<span class="f18 f_bold f_red absoluteL">A</span>
<pre>안녕하세요. 농협몰입니다.

문의주신 딸기는 5살 남아 주먹크기로 크고 싱싱한 과일입니다.
대표 겨울과일로 선물하시기도 좋습니다.

감사합니다.</pre>
									<span class="f14 absoluteR">2020.01.01</span>
								</div>
							</li>
							<!-- :: 문의사항 묶음 2 -->
							<li class="relative">
								<a href="javascript:void(0);" class="noticeSpecShow noticeListTitle">
									<!-- <span class="indexNumBox">1</span> -->
									<span class="ml30">궁금한 점이 있습니다.</span>
									<span class="absoluteR">2020.01.01</span>
								</a>
								<div class="noticeSpecInfo questionGroup">
									<img src="/common/img/goodsTag_1.png" class="goodsImg separatedLeft">
									<div class="goodsInfo separatedRight relative">
										<div class="absoluteT infoText">
											<span class="f18 f_Bold f_red">Q</span>
											<span class="f12 ml25">딸기 크기가 어느정도 되나요?</span>
										</div>
										<div class="absoluteMR f_bold f20 f_red">답변완료</div>
									</div>
								</div>
								<div class="noticeSpecInfo aswerGroup">
									<span class="f18 f_Bold f_red absoluteL">A</span>
<pre>안녕하세요. 농협몰입니다.

문의주신 딸기는 5살 남아 주먹크기로 크고 싱싱한 과일입니다.
대표 겨울과일로 선물하시기도 좋습니다.

감사합니다.</pre>
									<span class="f14 absoluteR">2020.01.01</span>
								</div>
							</li>
						</ul>
					</li>
				</ul>
				<!-- :: 페이징 파트 -->
				<ul class="pagingGroup">
					<li>
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
					</li>
				</ul>
			</div>
		</div>
	</div>

	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?> 

</div>
<script>

// :: 문의사항 상세내용 표시 스크립트.
$(document).on('click', '.noticeSpecShow', function(){
	$(this).siblings('.noticeSpecInfo').slideToggle();
});

</script>
</body>
</html>