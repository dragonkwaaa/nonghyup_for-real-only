<?php
use Common\classes\GoodsManager;
$GoodsManager				=	new GoodsManager();

//카테고리 가져오기
$search 					=	array(
	'isUse'					=>	1,
	'orderType'			=>	1,
	'isDel'					=>	1,
	'cateLevel'			=>	1
);
$category1 					=	array();
$msg 						=	$GoodsManager->get_category('', '', '', $search);
if($msg->getData()){
	$category1				=	$msg->getData();
}

$urlStr 					=	$_SERVER['REQUEST_URI'];
$urlArr 					=	explode('/', $urlStr);
$tabOn1 					=	'';
$tabOn2 					=	'';
$tabOn3 					=	'';
if($urlArr[1] == 'product'){
	$urlArr2				=	explode('?', $urlArr[2]);
	if($_GET['type']){
		$type 				=	$_GET['type'];
		if($type == 1){
			$tabOn1			=	'class="activated"';
		}
		if($type == 2){
			$tabOn2			=	'class="activated"';
		}
		if($type == 3){
			$tabOn3			=	'class="activated"';
		}
	} else if((!$urlArr2[1] && !$urlArr2[0])){
		$tabOn1				=	'class="activated"';
	}

}
?>

<div class="pageTop">
	<div class="separatedLeft relative">
		<a href="javascript:void(0);" class="btn hamburgerBtn">
			<i class="iconHamburger verticalM"></i>
			<span class="ml15 verticalM">전체 카테고리</span>
		</a>
		<ul class="hamburgerList absoluteL">

			<?php
			if($category1){
				for($i = 0 ; $i < sizeof($category1) ; $i ++){
					$cate1 					=	$category1[$i];
					$cateIdx1 				=	$cate1['categoryIdx'];
					$cateName1 				=	$cate1['cateName']
			?>
			<li>
				<a href="/product?category=<?= $cateIdx1?>"><?= $cateName1?></a>
			<?php
				$search 					=	array(
					'pCateIdx'				=>	$cateIdx1,
					'cateLevel'			=>	2,
					'isUse'					=>	1,
					'isDel'					=>	1,
					'orderType'			=>	1
				);
				$msg 						=	$GoodsManager->get_category('', '', '', $search);
				if($msg->getData()){
				?>
					<ul class="hamburgerSubList">
					<?php
						$category2 				=	$msg->getData();
						for($k = 0 ; $k < sizeof($category2) ; $k ++){
							$cate2 				=	$category2[$k];
							$cateName2			=	$cate2['cateName'];
							$cateIdx2 			=	$cate2['categoryIdx'];
					?>
							<li>
								<a href="/product?category=<?= $cateIdx2?>"><?= $cateName2?></a>
							</li>
					<?php
							}
							?>
					</ul>
				<?php
					}?>
			</li>
				<?php
					}
				}
			?>
		</ul>
		<ul class="menuTab verticalM topMenuSort">
			<li>
				<a href="/product?type=1" <?= $tabOn1?>>정기배송</a>
			</li>
			<li>
				<a href="/product?type=2" <?= $tabOn2?>>묶음배송</a>
			</li>
			<li>
				<a href="/event/" <?= $tabOn3?>>이벤트</a>
			</li>
		</ul>
	</div>
	<div class="separatedRight">
		<?php if($User->userCode()){ ?>
		<a href="/intro/event/index_logOut" class="iconLogout"></a>
		<?php } ?>
		<a href="/my" class="iconMy ml30"></a>
		<a href="/my/cart" class="iconCart ml30"></a>
	</div>
</div>



<!-- :: 모바일 전용 탑 메뉴 파트 open -->
<div class="pageTop mobileViewGroup">
	<ul class="menuTab verticalM topMenuSort">
		<li>
			<a href="/product" <?= $tabOn1?>>정기배송</a>
		</li>
		<li>
			<a href="/product?type=2" <?= $tabOn2?>>묶음배송</a>
		</li>
		<li>
			<a href="/event/" <?= $tabOn3?>>이벤트</a>
		</li>
	</ul>
</div>
<!-- :: 모바일 전용 탑 메뉴 파트 close -->


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


	$(document).on('ready', function(){
		if (top.location.pathname	===	'/nonghyup/goods/bundleList') {
			$('ul.hamburgerList').addClass('mainPageGroup');
		}
	})




</script>
