<?php include $_SERVER['DOCUMENT_ROOT'] . '/manager/common/pages/head.php';
	$mCode					=	'02';
	$lCode					=	'0205';
?>
<body>
<div class="container">
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/manager/common/pages/header.php'; ?>
	<div class="wrapper">
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/manager/product/pages/product_left.php'; ?>
		<div class="contents">
			<!-- <div class="set_field">
				<div class="field_title">
					<span class="title_mark">■ 1차 카테고리 등록</span>
				</div>
				<table class="set_table">
					<colgroup>
						<col width="200">
						<col width="*">
					</colgroup>
					<tbody>
					<tr>
						<th>카테고리명</th>
						<td colspan="3">
							<input class="tbox normal" value="" name="tempCate" id="tempCate">
							<a href="javascript:void(0)" class="cateAdd_1 btn smaller higher col_main f_w ml10">추가</a>
						</td>
					</tr>
					</tbody>
				</table>
            </div> -->
			<div class="list_field firCate">
				<div class="field_title">
					<span class="title_mark">■ 1차 카테고리 리스트</span>
				</div>
				<form name="frm" id="frm" onkeypress="if(event.keyCode==13) {document.frm.submit(); return false;}">
					<input type="hidden" name="total" id="total" value="0">
					<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
				<div class="list_menu">
					<span class="left_menu">
					<!--	<a href="javascript:checkAll();" class="btn col_grey">전체선택</a>
						<a href="javascript:checkNone();" class="btn col_grey">전체해제</a>
						<a href="javascript:delete_categoryArr();" class="btn col_darkGrey f_w">선택삭제</a>-->
						<!--<span class="sbox ml15">
							<select id="isSale">
								<option value="">- 선택 -</option>
								<option value="">사용</option>
								<option value="">미사용</option>
							</select>
						</span>
						<a href="javascript:void(0)" class="btn col_darkGrey f_w">상태변경</a>-->
					</span>
					<span class="right_menu">
						<a href="javascript:void(0)" class="btn col_darkGrey f_w">엑셀저장</a>
						<!--<span class="sbox small">
							<select onchange="search_list()" name="orderType">
								<option value="1">번호순 ▲</option>
								<option value="2">번호순 ▼</option>
								<option value="3">적용상품순 ▲</option>
								<option value="4">적용상품순 ▼</option>
							</select>
						</span>-->
						<!--<span class="sbox small">
							<select onchange="" name="limitNum">
								<option value="20">20개씩</option>
								<option value="50">50개씩</option>
								<option value="100">100개씩</option>
							</select>
						</span>-->
					</span>
				</div>
				<table class="list_table">
					<colgroup>
					<!--	<col width="30">-->
						<col width="50">
						<col width="150">
						<col width="50">
                        <col width="80">
                        <col width="80">
						<col width="80">
					</colgroup>
					<thead>
					<tr>
						<!--<th>
							<label>
								<input type="checkbox" name="all_chk" onclick="toggleCheckAll(this)">
							</label>
						</th>-->
						<th>순서</th>
						<th>카테고리명</th>
						<th>적용상품수</th>
                        <th>상태</th>
                        <th>2차 카테고리</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody id="categoryList">
                    <tr>
                        <td>
                        	<input class="tbox indexInput" value="" name="">
                        </td>
                        <td>
                        	<div>
                        		<input class="tbox full" value="" name="">
                        	</div>
                        </td>
                        <td></td>
                        <td>
                        	<label>
                        		<input type="radio" name="" value="1" checked>
                        		<span>사용</span>
                        	</label>
                        	<label class="ml10">
                        		<input type="radio" name="" value="0">
                        		<span>미사용</span>
                        	</label>
                        </td>
                        <td>
                        </td>
                        <td>
							<a href="javascript:void(0)" class="btn small col_main f_w addSecCateBtn">추가</a>
                        </td>
                    </tr>
					</tbody>	
				</table>
				</form>
            </div>

            <!-- :: 2차 카테고리 리스트 -->
            <div class="list_field secCate">
				<div class="field_title">
					<span class="title_mark">■ 2차 카테고리 리스트</span>
				</div>
				<div class="list_menu">
					<span class="right_menu">
						<a href="javascript:void(0)" class="btn col_darkGrey f_w">엑셀저장</a>
						<!--<span class="sbox small">
							<select onchange="search_list()" name="orderType">
								<option value="1">번호순 ▲</option>
								<option value="2">번호순 ▼</option>
								<option value="3">적용상품순 ▲</option>
								<option value="4">적용상품순 ▼</option>
							</select>
						</span>-->
					</span>
				</div>
				<table class="list_table">
					<colgroup>
						<col width="50">
						<col width="200">
						<col width="50">
						<col width="100">
						<col width="80">
					</colgroup>
					<thead>
					<tr>
						<th>순서</th>
						<th>카테고리명</th>
						<th>적용상품수</th>
						<th>상태</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
                    <tr>
                        <td>
                        	<input class="tbox indexInput" value="" name="">
                        </td>
                        <td>
                        	<div>
                        		<input class="tbox full" value="" name="">
                        	</div>
                        </td>
                        <td></td>
                        <td>
                        	<label>
                        		<input type="radio" name="" value="1" checked>
                        		<span>사용</span>
                        	</label>
                        	<label class="ml10">
                        		<input type="radio" name="" value="0">
                        		<span>미사용</span>
                        	</label>
                        </td>
                        <td>
							<a href="javascript:void(0)" class="btn small col_main f_w addFirCateBtn">추가</a>
                        </td>
                    </tr>
					<div id="category2">
                    <tr>
                        <td>
                        	<input class="tbox indexInput" value="1" name="">
                        </td>
                        <td>
                        	<div>
                        		<input class="tbox full" value="양파" name="">
                        	</div>
                        </td>
                        <td>10</td>
                        <td>
                        	<label>
                        		<input type="radio" name="" value="1" checked>
                        		<span>사용</span>
                        	</label>
                        	<label class="ml10">
                        		<input type="radio" name="" value="0">
                        		<span>미사용</span>
                        	</label>
                        </td>
                        <td>
                        	<span>
                        		<a href="javascript:void(0)" class="btn small col_darkGrey f_w delTr">삭제</a>
                        	</span>
                        </td>
                    </tr>
					</div>
					</tbody>	
				</table>
            </div>

			<!--<div class="page_group subPaging">
				<ul class="page_box">
					<li class="first arrow">
						<a href="javascript:void(0);"></a>
					</li>
					<li class="prev arrow">
						<a href="javascript:void(0);"></a>
					</li>
					<li class="pageNum on">
						<a href="javascript:void(0);">1</a>
					</li>
					<li class="pageNum">
						<a href="javascript:void(0);">2</a>
					</li>
					<li class="next arrow">
						<a href="javascript:void(0); "></a>
					</li>
					<li class="end arrow">
						<a href="javascript:void(0);"></a>
					</li>
				</ul>
			</div>-->
			<div class="btn_group">
				<a href="javascript:setCategory()" class="btn col_main">등록</a>
			</div>
		</div>
	</div>
</div>
</body>
<script src="/manager/common/js/common.js"></script>
<script src="/manager/product/js/category.js"></script>
<script>
	// :: 테이블 내 <tr> 태그 위로 이동 스크립트
$(document).on('click', '.moveUp', function(){

let	$targetTr	=	$(this).closest('tr');

$targetTr.prev().before($targetTr);
});

// :: 테이블 내 <tr> 태그 아래로 이동 스크립트
$(document).on('click', '.moveDown', function(){

let	$targetTr	=	$(this).closest('tr');

$targetTr.next().after($targetTr);
});


//  :: 페이징 스크립트
$(document).on('click', '.page_group a',function(){
	let pageGroup	=	$(this).parent('li.pageNum').siblings('li');
	$(pageGroup).removeClass('on');
	$(this).parent('li.pageNum').addClass('on');
});






// :: 첫번째 카테고리 추가 스크립트.
$(document).on('click', '.addFirCateBtn', function(){

let str 			=	'';
str		+=	'<tr>';
str		+=	'    <td>';
str		+=	'    	<input class="tbox indexInput" value="1" name="">';
str		+=	'    </td>';
str		+=	'    <td>';
str		+=	'    	<div>';
str		+=	'    		<input class="tbox full" value="양파" name="">';
str		+=	'    	</div>';
str		+=	'    </td>';
str		+=	'    <td>10</td>';
str		+=	'    <td>';
str		+=	'    	<label>';
str		+=	'    		<input type="radio" name="" value="1" checked>';
str		+=	'    		<span>사용</span>';
str		+=	'    	</label>';
str		+=	'    	<label class="ml10">';
str		+=	'    		<input type="radio" name="" value="0">';
str		+=	'    		<span>미사용</span>';
str		+=	'    	</label>';
str		+=	'    </td>';
str		+=	'    <td>';
str		+=	'    	<span>';
str		+=	'    		<a href="javascript:void(0)" class="btn small col_darkGrey f_w delTr">삭제</a>';
str		+=	'    	</span>';
str		+=	'    </td>';
str		+=	'</tr>';
$(this).parents('tbody').after().append(str);

});









// :: 두번째 카테고리 추가 스크립트.

$(document).on('click', '.addSecCateBtn', function(){

    let str 			=	'';
    str		+=	'<tr>';
	str		+=	'    <td>';
	str		+=	'    	<input class="tbox indexInput" value="1" name="">';
	str		+=	'    </td>';
	str		+=	'    <td>';
	str		+=	'    	<div>';
	str		+=	'    		<input class="tbox full" value="과채류" name="">';
	str		+=	'    	</div>';
	str		+=	'    </td>';
	str		+=	'    <td>10</td>';
	str		+=	'    <td>';
	str		+=	'    	<label>';
	str		+=	'    		<input type="radio" name="" value="1" checked>';
	str		+=	'    		<span>사용</span>';
	str		+=	'    	</label>';
	str		+=	'    	<label class="ml10">';
	str		+=	'    		<input type="radio" name="" value="0">';
	str		+=	'    		<span>미사용</span>';
	str		+=	'    	</label>';
    str		+=	'    </td>';
    str		+=	'    <td>';
	str		+=	'    	<span>';
	str		+=	'    		<a href="javascript:void(0)" class="btn small col_main f_w delTr">조회</a>';
	str		+=	'    	</span>';
	str		+=	'    </td>';
	str		+=	'    <td>';
	str		+=	'    	<span>';
	str		+=	'    		<a href="javascript:void(0)" class="btn small col_darkGrey f_w delTr">삭제</a>';
	str		+=	'    	</span>';
	str		+=	'    </td>';
	str		+=	'</tr>';
    $(this).parents('tbody').after().append(str);

});



</script>
</html>