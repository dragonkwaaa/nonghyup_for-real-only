<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';
$type							=	$SubFunction->allTags($_GET['type']);		//1:정기배송,2:묶음배송
$category 						=	$SubFunction->allTags($_GET['category']);
$schWord 						=	$SubFunction->allTags($_GET['search']);
$pno							=	(int)$SubFunction->allTags($_GET['pno'])	?	(int)$SubFunction->allTags($_GET['pno'])	:	1;
if(!$type && !$category && !$schWord){
	$type 						=	1;
}

?>

<body>
<div class="container">
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/common/pages/header.php';?>
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/topMenu.php';?>
	<div class="contents">
		<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/rightFloat.php';?>
		<div class="section mainSect">
			<form name="frm" id="frm" onkeypress="if(event.keyCode==13) {document.frm.submit(); return false;}">
			<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
			<input type="hidden" name="pno" value="<?=$pno?>">
			<input type="hidden" name="type" value="<?= $type?>">
			<input type="hidden" name="category" value="<?= $category?>">
			<input type="hidden" name="search" value="<?= $schWord?>">
			<div class="mainTitle">정기배송</div>

			<div id="productSel">
				<div id="bannerSel">
				<!--<img src="/common/img/mainLongBanner.png" class="mainSingleBanner">-->

				<!-- :: 모바일 전용 대형 배너 이미지 single -->
				<img src="/common/img/mainMobileSingle.png" class="mainSingleBanner mobileViewGroup">
				</div>
				<div class="carboxList simpleListGroup">
					<a href="javascript:void(0);" class="listLink">
						<span class="listTitle">총 0개</span>
					</a>
					<ul id="list">
					</ul>
				</div>
			</div>
			</form>
		</div>
	</div>
	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?>
</div>

<script src="/product/js/index.js"></script>
<script>

	// ::전체 카테고리 호버 시 리스트 표시되는 스크립트
	$('.pageTop .hamburgerBtn').hover(function(){
		$(this).siblings('ul.hamburgerList').show();
	}, function(){
		$(this).siblings('ul.hamburgerList').hide();
	});
	// :: 리스트에 마우스 올리고 있는 동안 계속 표시되게 하는 스크립트
	$('ul.hamburgerList').hover(function(){
		$(this).show();
	}, function(){
		$(this).hide();
	});

	// :: 리스트 특정 항목에 마우스 호버 시 하위 리스트 표시되게 하는 스크립트
	$('ul.hamburgerList > li').hover(function(){
		$(this).children('ul.hamburgerSubList').show();
	}, function(){
		$(this).children('ul.hamburgerSubList').hide();
	});






</script>

</body>
</html>