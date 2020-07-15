
$(document).ready(function(){
	get_category1();
	checkDefault1();				//js/option.js

	$('.optionSet_1').addClass('hide');
	$('.optionList_1').addClass('hide');
	$('.optionCheck_1').removeClass('active');
});


function get_goodsInfo(){
	let token				=	$('input[name="token"]').val();
	let goodsCode			=	$('input[name="goodsCode"]').val();

	let url 				=	'/manager/goods/event/goodsModify_get_goodsInfo';
	let dataType			=	'json';
	let param				= 	{
		token					:	token,
		goodsCode 				:	goodsCode
	};
	postService(url, dataType, param, function(data){
		let goods 			=	data.goods;
		$('select[name="categoryIdx"]').val(goods.categoryIdx);
		$('input[name="goodsName"]').val(goods.goodsName);
	});
}


// 상품등록
function insert_goods(){
	let goodsName				=	$('input[name="goodsName"]');
	//let goodsInfolength 		=	document.getElementById("goodsInfo").value.length;
	let goodsPrice 				=	$('input[name="goodsPrice"]');
	let goodsStock 				=	$('input[name="goodsStock"]');
	let isOpType2 				=	$('radio[name="isOpType2"]').val();

	oEditors.getById["goodsInfo"].exec("UPDATE_CONTENTS_FIELD", []);

	if(!goodsName.val().trim()){
		alert('싱품명을 입력해주세요.');
		goodsName.focus();
		return;
	}

	if(!goodsPrice.val().trim()){
		alert('기본가격을 입력해주세요.');
		goodsPrice.focus();
		return;
	}

	if(!goodsStock.val().trim()){
		alert('재고를 입력해주세요.');
		goodsStock.focus();
		return;
	}

	if($('#opList1 tr').length == 0){
		alert('기본옵션을 입력해주세요.');
		$('#opList1').focus();
		return;
	}

	if(isOpType2 == 1){
		if($('#opList2 tr').length == 0){
			alert('선택옵션을 입력해주세요.');
			$('#opList2').focus();
			return;
		}
	}

	if(confirm('상품을 등록하시겠습니까?')) {
		let form				=   document.querySelector("#frm");
		let postData			=   new FormData(form);

		let url					=	'/manager/product/event/goodsReg_insert_goods';
		let dataType			=	'json';
		let param				= 	postData;
		let formType			=	1;
		postService(url, dataType, param, '', formType);
	}

}
