$(document).ready(function(){
	get_bundleList();
});

function movePage(pno){
	pno						=	pno			?	pno		:	1;
	$('input[name="pno"]').val(pno);
	get_bundleList();
}

function get_bundleList(){

	$('#bundleList').html('');

	let token				=	$('input[name="token"]').val();
	let pno					=	$('input[name="pno"]').val();
	let searchType			=	$('select[name="searchType"]').val();
	let searchWord			=	$('input[name="searchWord"]').val();
	let startDate			=	$('input[name="startDate"]').val();
	let endDate				=	$('input[name="endDate"]').val();
	let minPrice			=	$('input[name="minPrice"]').val();
	let maxPrice			=	$('input[name="maxPrice"]').val();
	let searchState 		=	$('input[name="searchState"]:checked').val();
	let orderType			=	$('select[name="orderType"]').val();
	let perNum				=	$('select[name="perNum"]').val();

	let url					=	'/manager/product/event/bundle_get_bundleList';
	let dataType			=	'json';
	let param				= 	{
		pno					:	pno,
		searchType			:	searchType,
		searchWord			:	searchWord,
		startDate			:	startDate,
		endDate				:	endDate,
		minPrice 			:	minPrice,
		maxPrice 			:	maxPrice,
		token				:	token,
		searchState 		:	searchState,
		orderType 			:	orderType,
		perNum				:	perNum
	};
	postService(url, dataType, param, function(data){

		let list			=	data.list;
		let totalCount		=	data.totalCount;
		let recordPerPage	=	data.recordPerPage;
		let pnoPerPage		=	data.pnoPerPage;
		let temp 			=	data.temp;
		let str				=	'';

		$('input[name="pno"]').val(pno);
		if(list.length){
			$.each(list, function(index, goods) {

				let regularStr 	=	'';
				if(goods.isRegular == 1){
					regularStr	=	'정기상품';
					if(goods.isOption == 1){
						regularStr	+=	' (선택)';
					}
				}

				str				+=	'<tr>';
				str				+=	'	<td>';
				str				+=	'		<label>';
				str				+=	'			<input type="checkbox" value="'+goods.goodsCode+'" name="code" class="code">';
				str				+=	'		</label>';
				str				+=	'	</td>';
				str				+=	'	<td>';
				str				+=	'		<div>';
				str				+=	'			<img src="'+goods.goodsImg1+'" alt="상품이미지" class="goods_img">';
				str				+=	'		</div>';
				str				+=	'	</td>';
				str				+=	'	<td>';
				str				+=	'		<div class="bold">'+goods.goodsName+'</div>';
				str				+=	'		<div class="">'+goods.goodsSubName+'</div>';
				str				+=	'	</td>';
				str				+=	'	<td>';
				str				+=	'		<div class="bold">'+regularStr+'</div>';
				str				+=	'	</td>';
				str				+=	'	<td>';
				str				+=	'		<div class="bold">판매가 : '+goods.goodsPrice+'원</div>';
				str				+=	'		<div>할인 : '+goods.goodsSaleRatio+'%</div>';
				str 			+=	'	</td>';
				str				+=	'	<td>'+numberWithCommas(goods.goodsStock)+'개</td>';
				str				+=	'	<td>';
				str				+=	'		<div class="optStatChkBox">';
				str				+=	'			<label>';
				str				+=	'				<input type="radio" name="tmpGoodsState'+index+'" value="1" id="tmpGoodsState'+index+'" '+(goods.goodsState == 1 ? " checked" : "")+'>';
				str				+=	'				<span>사용</span>';
				str				+=	'			</label>';
				str				+=	'		</div>';
				str				+=	'		<div class="optStatChkBox">';
				str				+=	'			<label>';
				str				+=	'				<input type="radio" name="tmpGoodsState'+index+'" value="2" id="tmpGoodsState'+index+'" '+(goods.goodsState == 2 ? " checked" : "")+'>';
				str				+=	'				<span>미사용</span>';
				str				+=	'			</label>';
				str				+=	'		</div>';
				str				+=	'		</div>';
				str				+=	'	</td>';
				str				+=	'	<td>';
				str				+=	'		<span>';
				str				+=	'			<a href="/manager/product/bundleModify?no='+goods.goodsCode+'" class="btn small col_main f_w">상세보기</a>';
				str				+=	'		</span>';
				str				+=	'		<span>';
				str				+=	'			<a href="javascript:delete_product('+goods.goodsCode+');" class="btn small col_darkGrey f_w">삭제</a>';
				str				+=	'		</span>';
				str				+=	'	</td>';
				str				+=	'</tr>';

			});
		} else {
			str				+=	'<tr>';
			str				+=	'	<td colspan="11">등록된 상품이 없습니다.</td>';
			str				+=	'</tr>';
		}
		$('#bundleList').html(str);
		setPaging(recordPerPage, pnoPerPage, pno, totalCount);
	});
}


function set_excel(){
	let frm 					=	document.frm;
	frm.action 					=	'/manager/product/event/bundle_set_excel';
	$('#frm').submit();

	frm.action 					=	'';
}
