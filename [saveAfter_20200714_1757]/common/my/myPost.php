<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';
if(!$User->userCode()){
	$CommonManager->goPage('/intro/login', '로그인 후, 사용가능합니다.');
}


$pno					=	(int)$SubFunction->allTags($_GET['pno'])	?	(int)$SubFunction->allTags($_GET['pno'])	:	1;
$cate 					=	(int)$SubFunction->allTags($_GET['cate'])	?	(int)$SubFunction->allTags($_GET['cate'])	:	4;
$searchWord 			=	$SubFunction->allTags($_GET['searchWord']);
$searchType 			=	$SubFunction->allTags($_GET['searchType']);
?>

<body>
<div class="container">

	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/header.php';?>
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/topMenu.php';?>
	<div class="contents">
		<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/rightFloat.php';?> 
		<!-- :: 주요 내용 섹션 -->
		<div class="section listSect myPostMod">
			<div class="mainTitle">나의 글 목록</div>
			<form name="frm" id="frm" onkeypress="if(event.keyCode==13) {document.frm.submit(); return false;}">
				<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
				<input type="hidden" name="pno" value="<?=$pno?>">
				<input type="hidden" name="cate" value="<?=$cate?>">
				<input type="hidden" name="searchType" value="1">
			<ul class="findPageTab deliveryTypeTab">
				<li  id="selTab1">
					<a href="/my/myPost?cate=4">상품후기</a>
				</li>
				<li id="selTab2">
					<a href="/my/myPost?cate=2">1:1문의</a>
				</li>
			</ul>
			<!-- :: 검색 파트 -->
			<div class="searchBox subSearchGroup">
				<span class="sbox">
					<a href="javascript:void(0)" id="searchType">제목</a>
					<ul>
						<li onclick="setSearchType(1)">제목</li>
						<li onclick="setSearchType(2)">내용</li>
						<li onclick="setSearchType(3)">제목 + 내용</li>
					</ul>
				</span>
				<input class="searchInput ml9" name="searchWord" value="<?= $searchWord?>">
				<a class="rimlessBtn ml5" onclick="document.frm.submit()" >검색</a>
			</div>
			</form>



			<!-- :: 상품 리스트 파트 -->
			<div class="listGroup">
				<!--<ul class="goodsList" id="postList">

				</ul>-->
				<!-- :: 페이징 파트 -->
				<ul class="pagingGroup">

				</ul>
			</div>
		</div>
	</div>
	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?> 

</div>
<script src="/my/js/myPost.js"></script>
</body>
</html>