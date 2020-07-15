$(document).ready(function(){
	get_bundle();
});

// 묶음상품리스트에서 복사
function get_bundle(){
	let goodsCode 			=	$('input[name="goodsCode"]').val();
	let url 				=	'/manager/product/event/goodsModify_get_goodsInfo';
	let dataType 			=	'json';
	let param 				=	{
		goodsCode			:	goodsCode
	};
	postService(url, dataType, param, function(data){

		let goods 			=	data.goods;
		let categoryList 	=	data.categoryList;
		let goodsOp1 		=	data.goodsOp1;

		$('input[name="goodsName"]').val(goods.goodsName);

		// 카테고리
		let str0 					=	'';
		for(var i = 0 ; i < categoryList.length ; i ++){
			var cate				=	categoryList[i];
			str0					+=	'<li class="selectedCate">';
			str0					+=	'	<span class="f_main">'+cate.cateName1+' '+cate.cateName2+'</span>';
			str0					+=	'	<input type="hidden" name="categoryIdx[]" value="'+cate.categoryIdx+'">';
			str0					+=	'	<a href="javascript:void(0)" class="closeBtn">×</a>';
			str0					+=	'</li>';
		}

		$('.selectedCateGroup').append(str0);
		$('li.emptyListText').hide();

		$('input[name="goodsSubName"]').val(goods.goodsSubName);
		$('#goodsInfo').html(goods.goodsInfo);

		$('input[name="oldImg1"]').val(goods.goodsImg1);
		$('input[name="oldImg2"]').val(goods.goodsImg2);
		$('input[name="oldImg3"]').val(goods.goodsImg3);
		$('input[name="oldImg4"]').val(goods.goodsImg4);
		$('input[name="oldImg5"]').val(goods.goodsImg5);

		let imgSel				=	'';
		if(goods.goodsImg1){
			for(var i = 1 ; i <= 5 ; i ++){
				if(eval('goods.goodsImg' + i)){
					goodsImg 			=	eval('goods.goodsImg' + i);
					imgSel				+=	'<canvas></canvas>';
					imgSel				+=	'<img src="http://nonghyup.heeyam.com'+goodsImg+'" alt="이미지">';
					imgSel				+=	'<a href="#none" class="del_btn" onclick="delImg(this)">삭제</a>';
					$('input[name="img_'+i+'"]').closest('div').append(imgSel);
				}
			}
		}

		$('input:radio[name="goodsState"]:radio[value="'+goods.goodsState+'"]').prop('checked', true);
		$('input[name="goodsStock"]').val(goods.goodsStock);

		let str2 				=	'';
		$('#defaultSel').remove();
		for(var i = 0 ; i < goodsOp1.length ; i ++){
			var op 				=	goodsOp1[i];
			str2 				+=	'<tr>';
			str2				+=	'<input type="hidden" value="0" name="opIdx1[]">';
			str2				+=	'<input type="hidden" value="'+op.goodsOpName+'" name="opName1[]">';
			str2				+=	'<input type="hidden" value="상품선택" name="opName1[]">';
			str2				+=	'<input type="hidden" value="'+op.goodsOpInfo+'" name="opInfo1[]">';
			str2				+=	'<input type="hidden" value="'+op.goodsOpImg+'" name="opImg1[]">';
			str2 				+=	'<td>'+op.goodsOpInfo+'</td>';
			str2 				+=	'<td><input value="'+op.goodsOpPrice+'" name="opPrice1[]" onkeyup="calculation()" class="onlyNum"></td>';
			str2 				+=	'<td><input name="opStock1[]" value="'+op.goodsOpStock+'" class="onlyNum"></td>';
			str2 				+=	'<td><a href="javascript:void(0)" class="cateAdd_1 btn smaller higher col_grey delTr">삭제</a></td>';
			str2				+=	'</tr>';
		}
		$('#selBundleGoods').append(str2);
		$('input[name="goodsOriginPrice"]').val(numberWithCommas(goods.goodsOriginPrice));
		$('input[name="goodsPrice"]').val(numberWithCommas(goods.goodsPrice));
		$('input[name="goodsSaleRatio"]').val(goods.goodsSaleRatio);
		$('input:radio[name="isRegular"]:radio[value="'+goods.isRegular+'"]').prop('checked', true);
		$('input:radio[name="isOption"]:radio[value="'+goods.isOption+'"]').prop('checked', true);
		get_category1();
		calculation();
	});
}

// 상품등록
function update_bundle(){
	/*let bundleName				=	$('input[name="bundleName"]');
	let bundleSubName			=	$('input[name="bundleSubName"]');
	let bundleInfolength 		=	document.getElementById("bundleInfo").value.length;
	let bundleStock 			=	$('input[name="bundleStock"]');
	let bundleGoodsTot 			=	$('input[name="bundleGoodsTot"]');
	let bundlePrice 			=	$('input[name="bundlePrice"]');

	oEditors.getById["bundleInfo"].exec("UPDATE_CONTENTS_FIELD", []);
	
	if(!bundleName.val().trim()){
		alert('싱품명을 입력해주세요.');
		bundleName.focus();
		return;
	}

	if($('.selectedCate').length < 1){
		alert('카테고리를 선택해주세요.');
		$('#category1').focus();
		return;
	}

	if(!bundleSubName.val().trim()){
		alert('요약설명을 입력해주세요.');
		bundleSubName.focus();
		return;
	}

	if(bundleInfolength < 1){
		alert('상품 상세 설명을 입력해주세요.');
		bundleInfo.focus();
		return;
	}

	if(!bundleStock.val().trim()){
		alert('상품 재고를 입력해주세요.');
		bundleStock.focus();
		return;
	}

	if(bundleGoodsTot.val() == 0){
		alert('묶음선택상품을 추가해주세요.');
		$('#selBundleGoods').focus();
		return;
	}

	if(!bundlePrice.val().trim() || bundlePrice.val() < 1){
		alert('판매가를 입력해주세요.');
		bundlePrice.focus();
		return;
	}

	if($('input[name="isDel_1"]').val() == 1){
		if(!$('input[name="img_1"]').val().trim()){
			alert('이미지를 입력해주세요.');
			return;
		}
	}
*/
	if(confirm('상품을 수정하시겠습니까?')) {
		let form				=   document.querySelector("#frm");
		let postData			=   new FormData(form);

		let url					=	'/manager/product/event/goodsModify_update_goods';
		let dataType			=	'json';
		let param				= 	postData;
		let formType			=	1;
		postService(url, dataType, param, '', formType);
	}

}
