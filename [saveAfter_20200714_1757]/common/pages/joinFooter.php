<?php
use Common\classes\BoardManager;
use Common\classes\BasicManager;
$BoardManager				=	new BoardManager();
$BasicManager				=	new BasicManager();

$msg 						=	$BasicManager->get_config();
$config 					=	array();
if($msg->getData()){
	$config 				=	$msg->getData();
	$config 				=	$config[0];
}

// 공지사항
$search 					=	array(
	'bbsCate'				=>	1,
	'isUse'					=>	1,
	'isDel'					=>	1,
	'order'					=>	'bbs.regDate DESC'
);
$msg 						=	$BoardManager->get_bbs(0, 2, '', $search);
$notice 					=	array();
if($msg->getData()){
	$notice 				=	$msg->getData();
}

// 하단 탭 선택
$urlStr 					=	$_SERVER['REQUEST_URI'];
$urlArr 					=	explode('/', $urlStr);
$tabOn1_m 					=	'';
$tabOn2_m 					=	'';
$tabOn3_m 					=	'';
$tabOn4_m 					=	'';
$urlArr2 					=	explode('=', $urlArr[2]);
$urlArr2Str 				=	substr($urlArr2[0], 1, 7);

if($urlArr2Str == 'search' || $urlArr[2] == 'mSearch'){
	$tabOn2_m				=	'activated';
}
else if($urlArr[1] == 'my'){
	if($urlArr[2] == 'myFavorite'){
		$tabOn3_m			=	'activated';
	} else {
		$tabOn4_m			=	'activated';
	}
} else {
	$tabOn1_m 				=	'activated';
}


?>


<footer>
	<div class="section footerSection">
		<!-- :: 푸터 상단 좌측 파트 -->
		<div class="separatedLeft">
			<div class="CSInfo">
				<div class="f_semiBold f30">
					고객센터
				</div>
				<div class="corpCallNum">
					<div class="corpName">농협전남지역본부</div>
					<div><?= $config['corpTel1']?></div>
				</div>
				<div class="corpCallNum">
					<div class="corpName">농협호남권친환경농산물물류센터</div>
					<div><?= $config['corpTel2']?></div>
				</div>
				<!--<div class="f16 mt16">
					09:00~18:00 주말/공휴일 휴무
				</div>-->
			</div>
			<!-- :: 문의하기/바로가기 버튼 파트 -->
			<div class="btnGroup faqBtnGroup">
				<a href="/board/inquiryWrite" class="plainBtn long relative">
					<span>1:1문의하기</span>
					<i class="linkIcon absoluteR"></i>
				</a>
				<a href="/board/faqList" class="plainBtn long relative mt9">
					<span>FAQ 바로가기</span>
					<i class="linkIcon absoluteR"></i>
				</a>
			</div>
		</div>
		<!-- :: 푸터 상단 우측 파트  -->
		<div class="separatedRight">
			<a href="/board/notice" class="noticeMore">
				<span class="f30 f_semiBold">공지사항</span>
				<i class="linkIcon ml30"></i>
			</a>
			<ul class="noticeList mt30">
				<?php if($notice){
					for($i = 0 ; $i < sizeof($notice) ; $i ++){
						$nt 			=	$notice[$i];
					?>
				<li>
					<a href="/board/notice">[공지사항] <?= $nt['subject']?></a>
					<span class="absoluteR f14"><?= substr($nt['regDate'], 0, 10)?></span>
				</li>
				<?php }
				}?>
			</ul>
		</div>
	</div>
	<!-- :: 푸터 최하단 파트 -->
	<div class="section bg_black f_white mt80">
		<div class="copywritePannel relative">
			<div class="btnGroup">
				<a href="/intro/terms">이용약관</a>
				<a href="/intro/privacyTerm" class="f_semiBold ml30">개인정보처리방침</a>
			</div>
			<div class="businessInfo mt40">
				<div>
					<span>상호명 : <?= $config['corpName']?></span>
					<span>대표 : <?= $config['corpOwner']?></span>
					<span class="mobileBlock"><?= $config['corpAddr']?></span>
				</div>
				<div>
					<span>농협전남지역본부 : <?= $config['corpTel1']?></span>
				</div>
				<div>
				<span>농협호남권친환경농산물물류센터 : <?= $config['corpTel2']?></span>
				</div>
				<div>메일 : <?= $config['corpMail']?></div>
				<div>
					<span>사업자등록번호 : <?= $config['corpNum']?></span>
				<!--	<span class="mobileBlock">통신판매업신고번호 : 제2020-00107호</span>-->
				</div>
				<div><?= $config['corpCopyRight']?></div>
            </div>
            <div class="shareBtnGroup mt40">
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
			<img src="/common/img/logoFooter.png" class="absoluteR footerLogo">
		</div>
	</div>

	<!-- :: 모바일 푸터 및 최하단 버튼 파트 open -->
	<div class="rightFloat mobileViewGroup mMoveTop" >
		<div id="RECENT_PRODUCT_M">
		<!--<a href="/product/bundleInfo?code=2&type=2&re=1" class="recentViewMobile">
			<img src="/common/img/recentView_1.png">
		</a>-->
		</div>
		<a href="/board/inquiryWrite" class="bg_yellow rimlessBtn mt9 f14 f_semiBold tAlignC"></a>
		<!-- <a href="javascript:moveTopFunction();" class="arrowUp"></a> -->
    </div>
    
    <!-- <div class="rightFloat mMoveTop">
        <a href="javascript:moveTopFunction();" class="arrowUp"></a>
    </div> -->


	<div class="mobileBottomMenu">	
		<!-- :: "activated" 클래스를 추가하면 선택된 페이지 표시(노란색 동그라미)가 나타남. -->
		<a href="/" class="bottomLinkMenu home <?= $tabOn1_m?>">
			<img src="/common/img/bottomIcon_home.png">
			<div>홈</div>
		</a>
		<a href="/intro/mSearch" class="bottomLinkMenu search <?= $tabOn2_m?>">
			<img src="/common/img/bottomIcon_search.png">
			<div>검색</div>
		</a>
		<a href="/my/myFavorite" class="bottomLinkMenu favorite <?= $tabOn3_m?>">
			<img src="/common/img/bottomIcon_favorite.png">
			<div>찜</div>
		</a>
		<a href="/my/" class="bottomLinkMenu mypage <?= $tabOn4_m?>">
			<img src="/common/img/bottomIcon_mypage.png">
			<div>마이페이지</div>
		</a>	
	</div>
	<!-- :: 모바일 푸터 및 최하단 버튼 파트 close -->

</footer>
