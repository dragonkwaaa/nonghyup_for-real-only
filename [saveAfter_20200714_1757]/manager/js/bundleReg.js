$(document).ready(function(){
	get_category1();
});


function get_bundleList(type){
	let token 				=	$('input[name="token"]').val();
	let searchType			=	$('input[name="searchType"]').val();
	let searchWord 			=	$('input[name="searchWord"]').val();
	let isBundle 			=	$('input[name="isBundle"]').val();

	if(type == 2){
		searchType 			=	'';
		searchWord 			=	'';
	}

	let url 				=	'/manager/product/event/bundleReg_get_goodsList';
	let dataType 			=	'json';
	let param 				=	{
		token 				:	token,
		searchType 			:	searchType,
		searchWord			:	searchWord,
		isBundle 			:	isBundle
	};

	postService(url, dataType, param, function(data){
		$('#bundleList').html('');
		let list 			=	data.list;
		let str 			=	'';

		if(list.length){
			$.each(list, function(index, bundle) {
				str				+=	'<tr>';
				str				+=	'	<td>'+bundle.goodsName+'</td>';
				str				+=	'	<td>'+numberWithCommas(bundle.goodsOriginPrice)+'원</td>';
				str				+=	'	<td>'+numberWithCommas(bundle.goodsPrice)+'원</td>';
				str				+=	'	<td>'+bundle.goodsSaleRatio+'%</td>';
				str				+=	'	<td><a href="javascript:paste_bundle('+bundle.goodsCode+')" class="cateAdd_1 btn smaller higher col_blue f_w">선택</a></td>';
				str				+=	'</tr>';
			});
		} else {
			str				+=	'<tr>';
			str				+=	'	<td colspan="5">등록된 묶음상품이 없습니다.</td>';
			str				+=	'</tr>';
		}

		$('#bundleList').html(str);
		$('.popup.groupItemPop').show();
        $('.contents').addClass('overlay');
    
	});
}

// 묶음상품리스트에서 복사
function paste_bundle(goodsCode){

	let url 				=	'/manager/product/event/goodsModify_get_goodsInfo';
	let dataType 			=	'json';
	let param 				=	{
		goodsCode			:	goodsCode
	};
	postService(url, dataType, param, function(data){

		$('input[name="goodsName"]').val('');
		$('.selectedCateGroup').html('');
		$('input[name="goodsSubName"]').val('');
		//$('#bundleInfo').html('');
		$('input[name="goodsStock"]').val('');
		$('#selBundleGoods').html('');
		$('input[name="goodsPrice"]').val(0);


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

		let imgSel				=	'';
		if(goods.goodsImg1){
			for(var i = 1 ; i <= 5 ; i ++){
				if(eval('goods.goodsImg' + i)){
					goodsImg 			=	eval('goods.goodsImg' + i);
					imgSel				+=	'<canvas></canvas>';
					imgSel				+=	'<img src="http://nonghyup.heeyam.com'+goodsImg+'" alt="이미지">';
					imgSel				+=	'<a href="#none" class="del_btn" onclick="delImg(this)">삭제</a>';
					$('input[name="img_'+i+'"]').closest('div').append(imgSel);
					$('input[name="pasteImg'+i+'"]').val(goodsImg);
				}
			}
		}

		$('input:radio[name="goodsState"]:radio[value="'+goods.goodsState+'"]').prop('checked', true);

		let str2 				=	'';
		$('#defaultSel').remove();
		for(var i = 0 ; i < goodsOp1.length ; i ++){
			var op 			=	goodsOp1[i];
			str2 			+=	'<tr>';
			str2			+=	'<input type="hidden" value="0" name="opIdx1[]">';
			str2			+=	'<input type="hidden" value="상품선택" name="opName1[]">';
			str2			+=	'<input type="hidden" value="'+op.goodsOpInfo+'" name="opInfo1[]">';
			str2			+=	'<input type="hidden" value="'+op.goodsOpPrice+'" name="opPrice1[]">';
			str2			+=	'<input type="hidden" value="'+op.goodsOpSubName+'" name="opSubName1[]">';
			str2			+=	'<input type="hidden" value="'+op.goodsOpImg+'" name="opImg1[]">';
			str2 			+=	'';
			str2 			+=	'<td>'+op.goodsOpInfo+'</td>';
			str2 			+=	'<td>'+op.goodsOpPrice+'</td>';
			str2 			+=	'<td><input name="opStock1[]" value="0" class="onlyNum"></td>';
			str2 			+=	'<td><a href="javascript:void(0)" class="cateAdd_1 btn smaller higher col_grey delTr">삭제</a></td>';
			str2				+=	'</tr>';
		}
		$('#selBundleGoods').append(str2);
		$('input[name="goodsPrice"]').val(numberWithCommas(goods.goodsPrice));
		//calculation();

		$('input:radio[name="isRegular"]:radio[value="'+goods.isRegular+'"]').prop('checked', true);
		$('input:radio[name="isOption"]:radio[value="'+goods.isOption+'"]').prop('checked', true);

		closePop();
	});
}


function get_bundleGoods(type){
	let token 				=	$('input[name="token"]').val();
	let searchType			=	$('input[name="searchType"]').val();
	let searchWord 			=	$('input[name="searchWord"]').val();

	if(type == 2){
		searchType 			=	'';
		searchWord 			=	'';
	}


	let url 				=	'/manager/product/event/bundleReg_get_bundleGoodsList';
	let dataType 			=	'json';
	let param 				=	{
		token 				:	token,
		searchType 			:	searchType,
		searchWord			:	searchWord
	};

	postService(url, dataType, param, function(data){
		$('#bundleGoodsList').html('');
		let list 			=	data.list;
		let str 			=	'';

		if(list.length){
			$.each(list, function(index, bundleGoods) {
				str				+=	'	<tr>';
				str				+=	'	<td>'+bundleGoods.bundleGoodsName+'</td>';
				str				+=	'	<td>'+numberWithCommas(bundleGoods.bundleGoodsPrice)+'</td>';
				str				+=	'	<td><label><input type="checkbox" name="bundleGoods[]" value="'+bundleGoods.bundleGoodsIdx+'"></label></td>';
				str				+=	'	</tr>';
			});
		} else {
			str				+=	'	<tr>';
			str				+=	'	<td colspan="4">등록된 묶음선택상품이 없습니다.</td>';
			str				+=	'	</tr>';
		}

		$('#bundleGoodsList').html(str);
		$('.popup.partialItemPop').show();
        $('.contents').addClass('overlay');
        
        $('.popup.partialItemPop').css({
            "top": (($(window).height()-$('.popup.partialItemPop').outerHeight())/2+$(window).scrollTop())+"px",
            "left": (($(window).width()-$('.popup.partialItemPop').outerWidth())/2+$(window).scrollLeft())+"px"
        });

	});
}

// 묶음선택상품 팝업 전체선택
function bundleGoodsAll(){
	if ($('input:checkbox[name="bundleCheckAll"]').is(":checked") == true) {
		$("input[name='bundleGoods[]']").prop("checked", true);
	} else {
		$("input[name='bundleGoods[]']").prop("checked", false);
	}
}

// 묶음선택상품 체크박스
var bundleGoodsIdx			=	[];
function setBundleGoods(){
	var bundleGoodsIdx		=	[];
	var bundleGoodsArr		=	[];
	$("input[name='bundleGoodsIdx[]']").each(function(i){
		bundleGoodsIdx.push($(this).val());
	});

	$("input[name='bundleGoods[]']:checked").each(function(i){
		bundleGoodsArr.push($(this).val());
	});
	$('#defaultSel').remove();

	let url 			=	'/manager/product/event/bundleReg_get_bundleGoods';
	let dataType		=	'json';
	let param 			=	{
		bundleGoodsIdx	:	bundleGoodsArr
	};

	postService(url, dataType, param, function(data){
		let bundleGoods 	=	data.bundleGoods;
		let str 			=	'';

		if(bundleGoods){
			for(var i = 0 ; i < bundleGoods.length ; i ++){
				let goods 			=	bundleGoods[i];
				str 				+=	'<tr>';
				str					+=	'<input type="hidden" value="0" name="opIdx1[]">';
				str					+=	'<input type="hidden" value="상품선택" name="opName1[]">';
				str					+=	'<input type="hidden" value="'+goods.bundleGoodsName+'" name="opInfo1[]">';
				str					+=	'<input type="hidden" value="'+goods.bundleGoodsSubName+'" name="opSubName1[]">';
				str					+=	'<input type="hidden" value="'+goods.bundleGoodsImg1+'" name="opImg1[]">';
				str 				+=	'';
				str 				+=	'<td>'+goods.bundleGoodsName+'</td>';
				str 				+=	'<td><input name="opPrice1[]" value="'+goods.bundleGoodsPrice+'" class="onlyNum"></td>';
				str 				+=	'<td><input name="opStock1[]" value="0" class="onlyNum"></td>';
				str 				+=	'<td><a href="javascript:void(0)" class="cateAdd_1 btn smaller higher col_grey delTr">삭제</a></td>';
				str					+=	'</tr>';
			}
		}

		$('#selBundleGoods').append(str);
		//calculation();
		closePop();
	});
}

//묶음상품리스트 삭제
$(document).on('click', '.delTr', function(){
	let	$targetTr	=	$(this).closest('tr');
	$targetTr.remove();
	let trNum 		=	$('#selBundleGoods tr').length;
	let str 		=	'';
	if(trNum < 1){
		str			+=	'<tr id="defaultSel">';
		str			+=	'<td colspan="4">묶음선택상품을 추가해주세요.</td>';
		str			+=	'<tr>';
		$('#selBundleGoods').append(str);
	}
	calculation();
});

// 개별상품 계산기
/*
function calculation(){
	var goodsOriginPrice 						=	0;
	var bundleGoodsPrice 					=	0;
	var saleRatio 							=	0;
	var tmpBundlePrice 						=	$('input[name="goodsPrice"]').val();			//관리자가 입력한값
	var goodsPrice 						=	tmpBundlePrice.replace(/[^\d]+/g, '');
	$("input[name='opPrice1[]']").each(function(i){
		price 								=	$(this).val();
		bundleGoodsPrice					=	price.replace(/[^\d]+/g, '');
		goodsOriginPrice						+=	Number(bundleGoodsPrice);
	});

	if(Number(goodsPrice) < Number(goodsOriginPrice)){
		saleRatio	 						=	Number(goodsPrice) / Number(goodsOriginPrice) * 100;
		saleRatio 							=	Math.round(saleRatio);
		saleRatio 							=	100 - saleRatio;
	} else {
		saleRatio							=	0;
	}
	$('input[name="goodsSaleRatio"]').val(saleRatio);
	$('input[name="goodsOriginPrice"]').val(numberWithCommas(goodsOriginPrice));
}
*/



// 상품등록
function insert_bundle(){
	let goodsName				=	$('input[name="goodsName"]');
	let goodsSubName			=	$('input[name="goodsSubName"]');
	let goodsStock	 			=	$('input[name="goodsStock"]');
	let goodsOriginPrice 		=	$('input[name="goodsOriginPrice"]');
	let goodsPrice 				=	$('input[name="goodsPrice"]');

	oEditors.getById["goodsInfo"].exec("UPDATE_CONTENTS_FIELD", []);

	if(!goodsName.val().trim()){
		alert('싱품명을 입력해주세요.');
		goodsName.focus();
		return;
	}

	if($('.selectedCate').length < 1){
		alert('카테고리를 선택해주세요.');
		$('#category1').focus();
		return;
	}

	if(!goodsSubName.val().trim()){
		alert('요약설명을 입력해주세요.');
		goodsSubName.focus();
		return;
	}

	if(!goodsStock.val().trim()){
		alert('상품 재고를 입력해주세요.');
		goodsStock.focus();
		return;
	}

/*	if(goodsOriginPrice.val() == 0){
		alert('묶음선택상품을 추가해주세요.');
		$('#selBundleGoods').focus();
		return;
	}*/

	if(!goodsPrice.val().trim() || goodsPrice.val() < 1){
		alert('판매가를 입력해주세요.');
		goodsPrice.focus();
		return;
	}

	if(!$('input[name="img_1"]').val().trim() && !$('input[name="pasteImg1"]').val().trim()){
		alert('이미지를 입력해주세요.');
		return;
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





