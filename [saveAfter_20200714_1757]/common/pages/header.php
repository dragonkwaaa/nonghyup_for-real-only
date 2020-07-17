
<div class="webTopLine">
	<div class="webTopCase">

		<?php if($User->userCode()){ ?>
		<a href="/intro/event/index_logOut" class="btn webtopSort">로그아웃</a>
		<?php } else { ?>
			<a href="/intro/login" class="btn webtopSort">로그인</a>
			<a href="/intro/join" class="btn webtopSort">회원가입</a>
		<?php } ?>


        <a href="/intro/event/index_logOut" class="btn webtopSort">마이페이지</a>
        <a href="/intro/event/index_logOut" class="btn webtopSort">장바구니</a>


	</div>
</div>
<header>
	<div class="logoCase">
		<a href="/">
		<img src="/common/img/logoMain.png">
		</a>
	</div>
	<form action="/product">
	<div class="searchBox absoluteR">
		<input placeholder="ex)유기농 식품" class="searchInput" name="search" value="<?= $_GET['search']?>">
		<a href="javascript:void(0);" class="absoluteR searchIcon" onclick="$(this).closest('form').submit()"></a>
	</div>
	</form>
</header>



<!-- :: 모바일 헤더 파트 open -->
<header class="mobileViewGroup">
	<a href="javascript:void(0);" class="script_hambergerM btn hamburgerBtn">
		<i class="iconHamburgerM verticalM"></i>
	</a>
	<div class="logoCase">
		<a href="/">
		<img src="/common/img/logoMain.png">
		</a>
	</div>
	<?php /*if($User->userCode()){ */?><!--
	<a href="/intro/event/index_logOut" class="iconLogout"></a>
	--><?php /*} */?>
	<a href="/my/cart" class="iconCart"></a>
	<div class="hamburgerListM">
		<div class="hamburerTitle">
            <div>전체 카테고리</div>
			<?php if($User->userCode()){ ?>
            <a href="/intro/event/index_logOut" class="btn hamOutSort">로그아웃</a>
			<?php } else { ?>
			<a href="/intro/login" class="btn hamOutSort">로그인</a>
			<?php } ?>
        </div>
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

		?>
		<ul class="categoryList layer1">
			<?php if($category1){
				for($i = 0 ; $i < sizeof($category1) ; $i ++){
					$cate1 					=	$category1[$i];
					$cateIdx1 				=	$cate1['categoryIdx'];
					$cateName1 				=	$cate1['cateName'];
					$category1Url 			=	'/product?category='.$cateIdx1;
				?>
				<li>
					<?php
					$search 		=	array(
						'pCateIdx'				=>	$cateIdx1,
						'cateLevel'			=>	2,
						'isUse'					=>	1,
						'isDel'					=>	1,
						'orderType'			=>	1
					);
					$msg 			=	$GoodsManager->get_category('', '', '', $search);
					if($msg->getData()){
						$category1Url			=	'javascript:void(0)';
						?>
						<a href="<?= $category1Url?>"><?= $cateName1?></a>
						<ul class="categoryList layer2">
							<?php
							$category2 			=	$msg->getData();
							for($j = 0 ; $j < sizeof($category2) ; $j ++){
								$cate2 				=	$category2[$j];
								$cateName2			=	$cate2['cateName'];
								$cateIdx2 			=	$cate2['categoryIdx'];
								?>
							<li>
								<a href="/product?category=<?= $cateIdx2?>"><?= $cateName2?></a>
							</li>
							<?php } ?>
						</ul>
					<?php } else { ?>
						<a href="<?= $category1Url?>"><?= $cateName1?></a>
					<?php } ?>
				</li>
			<?php }
			} ?>
		</ul>
        <?php ?>
        

        
        <div class="shareBtnGroup mobileSort">
            <div class="titleBox">공유하기</div>
            <a href="javascript:void(0)" class="btn">
                <i class="kakaoIcon"></i>
            </a>
            <a href="javascript:void(0)" class="btn">
                <i class="facebookIcon"></i>
            </a>
            <a href="javascript:void(0)" class="btn">
                <i class="naverIcon"></i>
            </a>
        </div>




	</div>
</header>
<!-- :: 모바일 헤더 파트 close -->


<script>
// :: 1차 카테고리 클릭 시 2차 카테고리 표시 스크립트
$(document).on('click', '.categoryList.layer1 > li > a', function(){
	$(this).toggleClass('activated');
	$(this).siblings('ul.categoryList.layer2').toggleClass('activated');
});
// :: 모바일 햄버거 메뉴의 내용물 표시 스크립트 open
$(document).on('click', '.script_hambergerM', function(){
	$('.hamburgerListM').show("slide", { direction: "left" }, 250);
	$('.container').addClass('hamOverlay');
});	
// :: 모바일 햄버거 메뉴의 내용물 표시 스크립트 close
</script>
