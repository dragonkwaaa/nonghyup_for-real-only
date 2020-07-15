$(document).ready(function(){
	search_list();
});

let num 					=	0;
function search_list(){
	$('#categoryList').html('');

	let token				=	$('input[name="token"]').val();
	let orderType 			=	$('select[name="orderType"]').val();

	let url 				=	'/manager/product/event/category_get_category';
	let dataType 			=	'json';
	let param 				=	{
		orderType 			:	orderType,
		token 				:	token
	};

	postService(url, dataType, param, function(data){
		let list 			=	data.list;
		let str 			=	'';
		let totalCount 		=	parseInt(list.length);

		str					+=	'<tr>';
		str					+=	'	<td>';
		str					+=	'	</td>';
		str					+=	'	<td>';
		str					+=	'		<div>';
		str					+=	'			<input class="tbox full" value="" name="addCate1" id="addCate1">';
		str					+=	'		</div>';
		str					+=	'	</td>';
		str					+=	'	<td></td>';
		str					+=	'	<td>';
		// str					+=	'		<label>';
		// str					+=	'			<input type="radio" name="" value="1" checked>';
		// str					+=	'			<span>사용</span>';
		// str					+=	'		</label>';
		// str					+=	'		<label class="ml10">';
		// str					+=	'			<input type="radio" name="" value="0">';
		// str					+=	'			<span>미사용</span>';
		// str					+=	'		</label>';
		console.log(totalCount);
		str					+=	'	</td>';
		str					+=	'	<td>';
		str					+=	'	</td>';
		str					+=	'	<td>';
		str					+=	'		<a href="javascript:addCategory1('+totalCount+')" class="btn small col_main f_w addSecCateBtn">추가</a>';
		str					+=	'	</td>';
		str					+=	'</tr>';
		if(list.length > 0){
			$.each(list, function(index, cate) {
				var isUse0 		=	'';
				var isUse1 		=	'';
				if(cate.isUse == 1){
					isUse1 		=	'checked';
				} else if(cate.isUse == 0){
					isUse0 		=	'checked';
				}


				str 			+=	'<tr>';
				str 			+=	'<input type="hidden" value="'+cate.categoryIdx+'" name="idx[]">';
				str 			+=	'<td>';
				str 			+=	'<input class="tbox indexInput" value="'+cate.cateOrder+'" name="cateOrder[]">';
				str 			+=	'</td>';
				str 			+=	'<td>';
				str 			+=	'<div>';
				str 			+=	'<input class="tbox full" value="'+cate.cateName+'" name="cateName[]">';
				str 			+=	'</div>';
				str 			+=	'</td>';
				str 			+=	'<td>'+cate.goodsNum+'</td>';
				str 			+=	'<td>';
				str 			+=	'<label>';
				str 			+=	'<input type="radio" name="isUse'+index+'" value="1" '+isUse1+'>';
				str 			+=	'<span>사용</span>';
				str 			+=	'</label>';
				str 			+=	'<label class="ml10">';
				str 			+=	'<input type="radio" name="isUse'+index+'" value="0" '+isUse0+'>';
				str 			+=	'<span>미사용</span>';
				str 			+=	'</label>';
                str 			+=	'</td>';
                
                // :: 2차 카테고리 조회 버튼
                str			+=	'	<td>';
                str			+=	'		<span>';
                str			+=	'			<input type="hidden" name="" value="1">';
                str			+=	'			<a href="javascript:get_category2('+cate.categoryIdx+')" class="btn small col_main f_w viewSubList">조회</a>';
                str			+=	'		</span>';
                str			+=	'	</td>';

				str 			+=	'<td>';
				str 			+=	'<span>';
				str				+=	'	<input type="hidden" name="isDel[]" value="1">';
				str 			+=	'	<a href="javascript:void(0);" class="btn small col_darkGrey f_w delTr">삭제</a>';
				str 			+=	'</span>';
				str 			+=	'</td>';
				str 			+=	'</tr>';
			});
		} else {
			str 			+=	'<input type="hidden" id="isExist" value="1">';
			str 			+=	'<tr>';
			str 			+=	'<td colspan="11">등록된 카테고리가 없습니다.</td>';
			str 			+=	'</tr>';
		}

		$('#categoryList').html(str);
	});
}

function get_category2(idx){

}

function addCategory1(num){
	var cateStr 	=	$('input[name="addCate1"]').val();
	console.log(cateStr);
	let str1 		=	'';

	str1 			+=	'<tr id="cateTr'+num+'">';
	str1 			+=	'<input type="hidden" value="0" name="idx[]">';
	str1 			+=	'<td>';
	str1 			+=	'<input class="tbox indexInput" value="0" name="cateOrder[]">';
	str1 			+=	'</td>';
	str1 			+=	'<td>';
	str1 			+=	'<div>';
	str1 			+=	'<input class="tbox full" value="'+cateStr+'" name="cateName[]">';
	str1 			+=	'</div>';
	str1 			+=	'</td>';
	str1 			+=	'<td>0</td>';
	str1 			+=	'<td>';
	str1 			+=	'<label>';
	str1 			+=	'<input type="radio" name="isUse'+num+'" value="1" checked>';
	str1 			+=	'<span>사용</span>';
	str1 			+=	'</label>';
	str1 			+=	'<label class="ml10">';
	str1 			+=	'<input type="radio" name="isUse'+num+'" value="0">';
	str1 			+=	'<span>미사용</span>';
	str1 			+=	'</label>';
	str1 			+=	'</td>';
	str1			+=	'	<td>';
	str1			+=	'		<span>';
	str1			+=	'			<input type="hidden" name="" value="1">';
	str1			+=	'			<a href="javascript:get_category2('+num+')" class="btn small col_main f_w viewSubList">조회</a>';
	str1			+=	'		</span>';
	str1			+=	'	</td>';

	str1 			+=	'<td>';
	str1 			+=	'<span>';
	str1				+=	'	<input type="hidden" name="isDel[]" value="1">';
	str1 			+=	'	<a href="javascript:deleteCate('+num+');" class="btn small col_darkGrey f_w delTr">삭제</a>';
	str1 			+=	'</span>';
	str1 			+=	'</td>';
	str1 			+=	'</tr>';


	$('#categoryList').append(str1);
	var trNum 		=	$('#categoryList tr').length;
	console.log(trNum);
}
function addCategory2(){

}

//등록
function setCategory(){

	var trNum 		=	$('#categoryList tr').length;		//순서를 위한 값
	$('#total').val(trNum);

	if(confirm('카테고리를 등록하시겠습니까?')) {
		let form				=   document.querySelector("#frm");
		let postData			=   new FormData(form);

		let url					=	'/manager/product/event/category_set_category';
		let dataType			=	'json';
		let param				= 	postData;
		let formType			=	1;
		postService(url, dataType, param, '', formType);
	}
}


//삭제버튼
$(document).on('click', '.delTr', function(){
	let	$targetTr	=	$(this).closest('tr');
	let	$isDel		=	$(this).siblings('input');
	$targetTr.hide();
	$isDel.val(0);
	console.log($isDel.val());
	let trNum 		=	$('#categoryList tr').length;		//순서를 위한 값
});

function delete_categoryArr(){
	if ($('input:checkbox[name="code"]').is(":checked") == false) {
		alert('삭제할 카테고리를 선택해주세요.');
		return false;
	}
	var category = [];
	let token				=	$('input[name="token"]').val();

	$("input[name='code']:checked").each(function(i){
		category.push($(this).val());
	});

	let url 				=	'/manager/product/event/category_update_category';
	let dataType			=	'json';
	let param				= 	{
		token					:	token,
		category 				:	category,
		procType 				:	'isDel',
		updateState				:	0
	};

	if(confirm('삭제하시겠습니까?')){
		postService(url, dataType, param, '', '');
	}
}



// :: 2차 카테고리 조회 시, 부모 1차 카테고리에 색상 추가.
$(document).on('click', '.viewSubList', function() {
    $('.firCate .list_table tr').removeClass('activated');
    $(this).parents('tr').addClass('activated');
});
