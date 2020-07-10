<?php include $_SERVER['DOCUMENT_ROOT'] . '/manager/common/pages/head.php';
	$mCode					=	'06';
	$lCode					=	'0602';
?>
<body>
<div class="container">
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/manager/common/pages/header.php'; ?>
	<div class="wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/manager/marketing/pages/marketing_left.php'; ?>
		<div class="contents">
			<div class="set_field">
				<div class="field_title">
					<span class="title_mark">■ 상황별 설정</span>
				</div>
				<table class="set_table">
					<colgroup>
						<col width="200">
						<col width="*">
					</colgroup>
					<tbody>
					<tr>
						<th rowspan="3">발송상황</th>
						<td>
							<div class="tokRegHeadLine">
								<div class="titleBox">주문완료</div>
								<div class="radioGroup">
									<label>
										<input type="radio" name="tokUseCheck1" value="0">
										<span>사용</span>
									</label>
									<label class="ml10">
										<input type="radio" name="tokUseCheck1" value="1">
										<span>미사용</span>
									</label>
								</div>
								<div class="wordCounterGroup">
									<span class="count">0</span>
									<span>/ 200</span>
								</div>
							</div>
							<textarea class="textbox tokRegSort" placeholder="알림톡 내용을 입력해주세요."></textarea>
						</td>
						<td>
							<div class="tokRegHeadLine">
								<div class="titleBox">결제완료</div>
								<div class="radioGroup">
									<label>
										<input type="radio" name="tokUseCheck1" value="">
										<span>사용</span>
									</label>
									<label class="ml10">
										<input type="radio" name="tokUseCheck1" value="">
										<span>미사용</span>
									</label>
								</div>
								<div class="wordCounterGroup">
									<span class="count">0</span>
									<span>/ 200</span>
								</div>
							</div>
							<textarea class="textbox tokRegSort" placeholder="알림톡 내용을 입력해주세요."></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<div class="tokRegHeadLine">
								<div class="titleBox">주문접수</div>
								<div class="radioGroup">
									<label>
										<input type="radio" name="tokUseCheck1" value="">
										<span>사용</span>
									</label>
									<label class="ml10">
										<input type="radio" name="tokUseCheck1" value="">
										<span>미사용</span>
									</label>
								</div>
								<div class="wordCounterGroup">
									<span class="count">0</span>
									<span>/ 200</span>
								</div>
							</div>
							<textarea class="textbox tokRegSort" placeholder="알림톡 내용을 입력해주세요."></textarea>
						</td>
						<td>
							<div class="tokRegHeadLine">
								<div class="titleBox">배달완료</div>
								<div class="radioGroup">
									<label>
										<input type="radio" name="tokUseCheck1" value="">
										<span>사용</span>
									</label>
									<label class="ml10">
										<input type="radio" name="tokUseCheck1" value="">
										<span>미사용</span>
									</label>
								</div>
								<div class="wordCounterGroup">
									<span class="count">0</span>
									<span>/ 200</span>
								</div>
							</div>
							<textarea class="textbox tokRegSort" placeholder="알림톡 내용을 입력해주세요."></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<div class="tokRegHeadLine">
								<div class="titleBox">주문취소</div>
								<div class="radioGroup">
									<label>
										<input type="radio" name="tokUseCheck1" value="">
										<span>사용</span>
									</label>
									<label class="ml10">
										<input type="radio" name="tokUseCheck1" value="">
										<span>미사용</span>
									</label>
								</div>
								<div class="wordCounterGroup">
									<span class="count">0</span>
									<span>/ 200</span>
								</div>
							</div>
							<textarea class="textbox tokRegSort" placeholder="알림톡 내용을 입력해주세요."></textarea>
						</td>
						<td>
							<div class="tokRegHeadLine">
								<div class="titleBox">환불완료</div>
								<div class="radioGroup">
									<label>
										<input type="radio" name="tokUseCheck1" value="">
										<span>사용</span>
									</label>
									<label class="ml10">
										<input type="radio" name="tokUseCheck1" value="">
										<span>미사용</span>
									</label>
								</div>
								<div class="wordCounterGroup">
									<span class="count">0</span>
									<span>/ 200</span>
								</div>
							</div>
							<textarea class="textbox tokRegSort" placeholder="알림톡 내용을 입력해주세요."></textarea>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="set_field">
				<div class="field_title">
					<span class="title_mark">■ 단축어 설정</span>
				</div>
				<table class="set_table">
					<colgroup>
						<col width="200">
						<col width="*">
					</colgroup>
					<tbody>
					<tr>
						<th rowspan="2">단축어</th>
						<td>
							<div class="hashGroup">
								<span>업체명 :</span>
								<a href="javascript:void(0);">[shopName]</a>
							</div>
						</td>
						<td>
							<div class="hashGroup">
								<span>업체번호 :</span>
								<a href="javascript:void(0);">[shopNum]</a>
							</div>
						</td>
						<td>
							<div class="hashGroup">
								<span>상품명 :</span>
								<a href="javascript:void(0);">[goodSName]</a>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="hashGroup">
								<span>업체명 :</span>
								<a href="javascript:void(0);">[shopName]</a>
							</div>
						</td>
						<td>
							<div class="hashGroup">
								<span>업체번호 :</span>
								<a href="javascript:void(0);">[shopNum]</a>
							</div>
						</td>
						<td>
							<div class="hashGroup">
								<span>상품명 :</span>
								<a href="javascript:void(0);">[goodSName]</a>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
				<div class="btn_group">
					<a href="javascript:void(0)" class="btn col_main">등록</a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<script>
</script>
</html>