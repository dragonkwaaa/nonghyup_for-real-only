$(document).ready(function(){
	//get_category1();
	get_goodsInfo();
	checkDefault1();				//js/option.js
});



function get_goodsInfo(){
	let token				=	$('input[name="token"]').val();
	let goodsCode			=	$('input[name="goodsCode"]').val();

	let url 				=	'/manager/product/event/goodsModify_get_goodsInfo';
	let dataType			=	'json';
	let param				= 	{
		token					:	token,
		goodsCode 				:	goodsCode
	};
	postService(url, dataType, param, function(data){
		let goods 			=	data.goods;
		let categoryList 	=	data.categoryList;
		let goodsOp1 		=	data.goodsOp1;

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

		$('input[name="goodsName"]').val(goods.goodsName);
		$('input[name="goodsSubName"]').val(goods.goodsSubName);
		$('textarea[id="goodsInfo"]').html(goods.goodsInfo);
		$('input[name="goodsPrice"]').val(numberWithCommas(goods.goodsPrice));
		$('input[name="goodsStock"]').val(goods.goodsStock);
		$('input[name="oldImg1"]').val(goods.goodsImg1);
		$('input[name="oldImg2"]').val(goods.goodsImg2);
		$('input[name="oldImg3"]').val(goods.goodsImg3);
		$('input[name="oldImg4"]').val(goods.goodsImg4);
		$('input[name="oldImg5"]').val(goods.goodsImg5);
		$('input:radio[name="goodsState"]:radio[value="'+goods.goodsState+'"]').prop('checked', true);
		$('input:radio[name="isOption"]:radio[value="'+goods.isOption+'"]').prop('checked', true);
		$('input:radio[name="isRegular"]:radio[value="'+goods.isRegular+'"]').prop('checked', true);

		if(goods.isOption == 0){
			$('.optionSet_1').addClass('hide');
			$('.optionList_1').addClass('hide');
			$('.optionCheck_1').removeClass('active');
		}
		opStr1				=	'';
		if(goodsOp1.length > 0){
			for(var i = 0 ; i < goodsOp1.length ; i ++){
				$('#opList1').html('');
				var op1			=	goodsOp1[i];

				opStr1			+=	'<tr>';
				opStr1			+=	'<input type="hidden" name="opIdx1[]" value="'+op1.goodsOpIdx+'">';
				opStr1			+=	'	<td>';
				opStr1			+=	'		<input class="tbox full center" value="'+op1.goodsOpName+'" name="opName1[]">';
				opStr1			+=	'	</td>';
				opStr1			+=	'	<td>';
				opStr1			+=	'		<input class="tbox full center" value="'+op1.goodsOpInfo+'" name="opInfo1[]">';
				opStr1			+=	'	</td>';
				opStr1			+=	'	<td>';
				opStr1			+=	'		<input class="tbox full center" value="'+op1.goodsOpPrice+'" name="opPrice1[]">';
				opStr1			+=	'	</td>';
				opStr1			+=	'	<td>';
				opStr1			+=	'		<input class="tbox full center onlyNum" value="'+op1.goodsOpStock+'" name="opStock1[]">';
				opStr1			+=	'	</td>';
				opStr1			+=	'	<td>';
				opStr1			+=	'		<div class="optStatChkBox">';
				opStr1			+=	'			<label>';
				opStr1			+=	'				<input type="radio" name="opState1_'+i+'" value="1" '+(op1.goodsOpState == 1 ? " checked" : "")+'>';
				opStr1			+=	'				<span>사용</span>';
				opStr1			+=	'			</label>';
				opStr1			+=	'		</div>';
				opStr1			+=	'		<div class="optStatChkBox">';
				opStr1			+=	'			<label>';
				opStr1			+=	'				<input type="radio" name="opState1_'+i+'" value="0" '+(op1.goodsOpState == 0 ? " checked" : "")+'>';
				opStr1			+=	'				<span>미사용</span>';
				opStr1			+=	'			</label>';
				opStr1			+=	'		</div>';
				opStr1			+=	'		<div class="optStatChkBox">';
				opStr1			+=	'			<label>';
				opStr1			+=	'				<input type="radio" name="opState1_'+i+'" value="2" '+(op1.goodsOpState == 2 ? " checked" : "")+'>';
				opStr1			+=	'				<span>품절</span>';
				opStr1			+=	'			</label>';
				opStr1			+=	'		</div>';
				opStr1			+=	'	</td>';
				opStr1			+=	'	<td>';
				opStr1			+=	'		<span>';
				opStr1			+=	'			<a href="javascript:void(0);" class="btn small col_darkGrey f_w delTr1">삭제</a>';
				opStr1			+=	'		</span>';
				opStr1			+=	'	</td>';
				opStr1			+=	'</tr>';
			}
		}
		$('#opList1').append(opStr1);

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

		// for 문으로 돌리는거 물어보기
		/*let str1						=	'';
		if(goods.goodsImg1){
			str1					+=	'<canvas></canvas>';
			str1					+=	'<img src="http://nonghyup.heeyam.com'+goods.goodsImg1+'" alt="이미지">';
			str1					+=	'<a href="#none" class="del_btn" onclick="delImg(this)">삭제</a>';
			$('input[name="img_1"]').closest('div').append(str1);
		}
*/
		get_category1();
	});
}

function update_goods(){
	console.log($('#isExist1').val());
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
/*
	if($('#isExist1').val() == 1){
		alert('기본옵션을 입력해주세요.');
		$('#opList1').focus();
		return;
	}*/

	if(isOpType2 == 1){
		if($('#isExist1').val() == 1){
			alert('선택옵션을 입력해주세요.');
			$('#opList2').focus();
			return;
		}

	}

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
