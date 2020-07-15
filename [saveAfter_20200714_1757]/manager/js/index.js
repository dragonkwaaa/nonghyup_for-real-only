$(document).ready(function(){
	get_bundleGoods();
});

function movePage(pno){
	pno						=	pno			?	pno		:	1;
	$('input[name="pno"]').val(pno);
	get_bundleGoods();
}

function get_bundleGoods(){

	$('#bundleGoods').html('');

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

	let url					=	'/manager/product/event/index_get_bundleGoods';
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
		let pno 			=	data.pno;
		
		$('input[name="pno"]').val(pno);

		if(list.length){
			$.each(list, function(index, bundleGoods) {
			str				+=	'<tr>';
			str				+=	'	<td>';
			str				+=	'		<label>';
			str				+=	'			<input type="checkbox" value="'+bundleGoods.bundleGoodsIdx+'" name="code" class="code">';
			str				+=	'		</label>';
			str				+=	'	</td>';
			str				+=	'	<td>';
			str				+=	'		<div>';
			str				+=	'			<img src="'+bundleGoods.bundleGoodsImg1+'" alt="상품이미지" class="goods_img">';
			str				+=	'		</div>';
			str				+=	'	</td>';
			str				+=	'	<td>';
			str				+=	'		<div class="bold">'+bundleGoods.bundleGoodsName+'</div>';
			str				+=	'		<div class="bold">'+bundleGoods.bundleGoodsSubName+'</div>';
			str				+=	'	</td>';
			str				+=	'	<td>'+numberWithCommas(bundleGoods.bundleGoodsPrice)+'원</td>';
			str				+=	'	<td>';
			str				+=	'		<div class="optStatChkBox">';
			str				+=	'			<label>';
			str				+=	'				<input type="radio" name="tmpGoodsState'+index+'" value="1" id="tmpGoodsState'+index+'" '+(bundleGoods.bundleGoodsState == 1 ? " checked" : "")+'>';
			str				+=	'				<span>사용</span>';
			str				+=	'			</label>';
			str				+=	'		</div>';
			str				+=	'		<div class="optStatChkBox">';
			str				+=	'			<label>';
			str				+=	'				<input type="radio" name="tmpGoodsState'+index+'" value="2" id="tmpGoodsState'+index+'" '+(bundleGoods.bundleGoodsState == 2 ? " checked" : "")+'>';
			str				+=	'				<span>미사용</span>';
			str				+=	'			</label>';
			str				+=	'		</div>';
			str				+=	'		</div>';
			str				+=	'	</td>';
			str				+=	'	<td>';
			str				+=	'		<span>';
			str				+=	'			<a href="/manager/product/bundleGoodsModify?no='+bundleGoods.bundleGoodsIdx+'" class="btn small col_main f_w">상세보기</a>';
			str				+=	'		</span>';
			str				+=	'		<span>';
			str				+=	'			<a href="javascript:delete_product('+bundleGoods.bundleGoodsIdx+', 3);" class="btn small col_darkGrey f_w">삭제</a>';
			str				+=	'		</span>';
			str				+=	'	</td>';
			str				+=	'</tr>';

			});
		} else {
			str				+=	'<tr>';
			str				+=	'	<td colspan="11">등록된 상품이 없습니다.</td>';
			str				+=	'</tr>';
		}
		$('#bundleGoods').html(str);
		setPaging(recordPerPage, pnoPerPage, pno, totalCount);
	});
}

function set_excel(){
	let frm 					=	document.frm;
	frm.action 					=	'/manager/product/event/bundleGoods_set_excel';
	$('#frm').submit();

	frm.action 					=	'';
}
