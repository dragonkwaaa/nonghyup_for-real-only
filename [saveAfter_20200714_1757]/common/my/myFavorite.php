<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';
if(!$User->userCode()){
	$CommonManager->goPage('/intro/login', '로그인 후, 사용가능합니다.');
}
$pno					=	(int)$SubFunction->allTags($_GET['pno'])	?	(int)$SubFunction->allTags($_GET['pno'])	:	1;
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
			<div class="mainTitle">찜한 상품</div>
			<form name="frm" id="frm" onkeypress="if(event.keyCode==13) {document.frm.submit(); return false;}">
				<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
				<input type="hidden" name="pno" value="<?=$pno?>">
			</form>
			<div class="listGroup">
				<div class="listTop">
					<label>
						<input type="checkbox" name="checkAll" id="checkAll">
						<span class="f_semiBold">전체선택</span>
					</label>
				</div>
				<ul class="goodsList">
				</ul>
				<!-- :: 선택 관련 버튼 파트 -->
				<div class="btnGroup mt20">
					<a href="javascript:idxCheckAll();" class="plainBtn">전체선택</a>
					<a href="javascript:delete_favorite();" class="plainBtn ml7">선택삭제</a>
				</div>
				<!-- :: 페이징 파트 -->
				<ul class="pagingGroup">
				</ul>
			</div>
		</div>
	</div>
	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?> 

</div>
<script src="/my/js/myFavorite.js"></script>
</body>
</html>