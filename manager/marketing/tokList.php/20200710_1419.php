<?php include $_SERVER['DOCUMENT_ROOT'] . '/manager/common/pages/head.php';
	$mCode					=	'06';
	$lCode					=	'0603';
?>
<body>
<div class="container">
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/manager/common/pages/header.php'; ?>
	<div class="wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/manager/marketing/pages/marketing_left.php'; ?>
		<div class="contents">
			<div class="set_field">
				<div class="field_title">
					<span class="title_mark">■ 알림톡 목록</span>
				</div>
				<table class="set_table">
					<colgroup>
						<col width="200">
						<col width="*">
					</colgroup>
					<tbody>
					<tr>
						<th>전화번호</th>
						<td>
							<input class="tbox" value="">
						</td>
					</tr>
					<tr>
						<th>상황</th>
						<td colspan="">
							<label>
								<input type="checkBox">
								<span>전체</span>
							</label>
							<label class="ml10">
								<input type="checkBox">
								<span>주문완료</span>
							</label>
							<label class="ml10">
								<input type="checkBox">
								<span>결제완료</span>
							</label>
							<label class="ml10">
								<input type="checkBox">
								<span>베달중</span>
							</label>
							<label class="ml10">
								<input type="checkBox">
								<span>배달완료</span>
							</label>
							<label class="ml10">
								<input type="checkBox">
								<span>주문취소</span>
							</label>
							<label class="ml10">
								<input type="checkBox">
								<span>주문변경</span>
							</label>
						</td>
					</tr>
					<tr>
						<th>등록일</th>
						<td>
							<input id="startDate" class="tbox" name="" value="" readonly> ~ <input id="endDate" class="tbox" name="" value="" readonly>
							<a href="javascript:setSearchDate('0d')" class="btn smaller higher col_grey ml10">당일</a>
							<a href="javascript:setSearchDate('1d')" class="btn smaller higher col_grey ml5">어제</a>
							<a href="javascript:setSearchDate('1w')" class="btn smaller higher col_grey ml5">일주일</a>
							<a href="javascript:setSearchDate('1m')" class="btn smaller higher col_grey ml5">1달</a>
							<a href="javascript:setSearchDate('3m')" class="btn smaller higher col_grey ml5">3달</a>
							<a href="javascript:setSearchDate('6m')" class="btn smaller higher col_grey ml5">6달</a>
						</td>
					</tr>
					</tbody>
				</table>
				<div class="set_menu">
					<a href="javascript:void(0)" class="btn normal col_main f_w">검색</a>
					<a href="javascript:void(0)" class="btn normal col_darkGrey f_w ml5">전체목록</a>
				</div>
			</div>
			<div class="list_field">
				<div class="field_title">
					<span class="title_mark">■ 알림톡 목록</span>
				</div>
				<div class="list_menu">
					<span class="right_menu">
						<a href="javascript:void(0)" class="btn col_darkGrey f_w">엑셀저장</a>
						<span class="sbox small">
							<select id="order" onchange="listOption()">
								<option value="1">번호순 ▲</option>
								<option value="2">번호순 ▼</option>
								<option value="3">금액순 ▲</option>
								<option value="4">금액순 ▼</option>
							</select>
						</span>
						<span class="sbox small">
							<select id="limit" onchange="listOption()">
								<option value="20">10개씩</option>
								<option value="50">20개씩</option>
								<option value="100">30개씩</option>
							</select>
						</span>
					</span>
				</div>
				<table class="list_table">
					<colgroup>
						<col width="60">
						<col width="125">
						<col width="200">
						<col width="125">
					</colgroup>
					<thead>
					<tr>
						<th>순서</th>
						<th>전화번호</th>
						<th>상황</th>
						<th>발송일</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>1</td>
					
						<td>010-0000-0072</td>
						<td>
							주문완료
						</td>
						<td>
							2020-05-06 11:00
						</td>
					</tr>
					<tr>
						<td>2</td>
					
						<td>010-0000-1172</td>
						<td>
							주문취소
						</td>
						<td>
							2020-05-15 11:00
						</td>
					</tr>
					<tr>
						<td colspan="5">발송 내역이 없습니다.</td>
					</tr>
					
					</tbody>	
				</table>
			</div>
			<div class="page_group">
				<ul class="page_box">
					<li class="arrow prev"><a href="javascript:void(0);"></a></li>
					<li class="pageNum on"><a href="javascript:void(0);">1</a></li>
					<li class="pageNum"><a href="javascript:void(0);">2</a></li>
					<li class="arrow next"><a href="javascript:void(0);"></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
</body>
<script src="/manager/common/js/datePick.js"></script>
<script>
</script>
</html>