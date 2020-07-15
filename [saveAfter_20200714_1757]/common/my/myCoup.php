<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';
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
		<div class="section listSect noticeMod">
			<div class="mainTitle">내 쿠폰</div>
            
            
            <div class="tableGroup webSort">
                <table>
                    <colgroup>
                        <col width="200">
                        <col width="100">
                        <col width="100">
                        <col width="120">
                        <col width="100">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>쿠폰명</th>
                        <th>할인유형</th>
                        <th>할인금액</th>
                        <th>사용기간</th>
                        <th>상태</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>여름 맞이 코로나 극복 쿠폰 2차</td>
                        <td>특별할인</td>
                        <td>10,000원</td>
                        <td>2020.07.01 ~ 2020.07.30</td>
                        <td>사용가능</td>
                    </tr>
                    <tr>
                        <td>여름 맞이 코로나 극복 쿠폰 1차</td>
                        <td>특별할인</td>
                        <td>30,000원</td>
                        <td>2020.06.01 ~ 2020.06.30</td>
                        <td>기간만료</td>
                    </tr>
                    </tbody>
                </table>
                <!-- :: 페이징 파트 -->
				<ul class="pagingGroup">
				</ul>
            </div>
			<div class="listGroup mobSort">
				<ul class="mobCoupList">
					<li class="infoGroup usable">
                        <div class="coupInfo">
                            <div class="infoBox">여름 맞이 코로나 극복 쿠폰 2차</div>
                            <div class="titleBox">[특별할인] 10,000원 할인 쿠폰</div>
                            <div class="periodBox">사용기간 : 2020.07.01 ~ 2020.07.30</div>
                        </div>
                        <div class="remainDate">
                            <div>남은 기간</div>
                            <div>15일</div>
                        </div>
                    </li>
                    <li class="infoGroup">
                        <div class="coupInfo">
                            <div class="infoBox">여름 맞이 코로나 극복 쿠폰 1차</div>
                            <div class="titleBox">[특별할인] 30,000원 할인 쿠폰</div>
                            <div class="periodBox">사용기간 : 2020.06.01 ~ 2020.06.30</div>
                        </div>
                        <div class="remainDate">
                            <div>기간만료</div>
                        </div>
                    </li>
                    <li class="infoGroup">
                        <div>
                            <div>여름 맞이 코로나 극복 쿠폰</div>
                            <div>[특별할인] 1만원 할인 쿠폰</div>
                            <div>사용기간 : 2020.06.01 ~ 2020.06.30</div>
                        </div>
                        <div>
                            <!-- <div>남은 기간</div>
                            <div>15일</div> -->
                            <div>기간만료</div>
                        </div>
					</li>
                </ul>
				<!-- :: 페이징 파트 -->
				<ul class="pagingGroup">
				</ul>
            </div>
		</div>
	</div>
	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?> 

</div>
<script src="/board/js/notice.js"></script>
<script>

// $(document).on('click', '.noticeSpecShow', function(){
// 	$(this).siblings('.noticeSpecInfo').slideToggle();
// });

</script>
</body>
</html>