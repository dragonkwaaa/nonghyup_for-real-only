function get_category1(){
	let token				=	$('input[name="token"]').val();

	let url 				=	'/manager/product/event/_get_category';
	let dataType 			=	'json';
	let param				= 	{
		token				:	token,
		cateLevel 			:	1
	};
	postService(url, dataType, param, function(data){
		let category1 		=	data.category;
		let str 			=	'';

		if(category1.length){
			var select 		=	'';
			for(var i = 0 ; i < category1.length ; i ++){
				var cate1 	=	category1[i];
				str 		+=	'<option value="'+cate1.categoryIdx+'-'+cate1.cateName+'" '+select+'>'+cate1.cateName+'</option>';
			}
		}
		$('#category1').html(str);
		$("#category1 option:eq(0)").prop("selected", true);
		get_category2()
	});
}

function get_category2(){
	let token				=	$('input[name="token"]').val();
	let pCateIdx			=	$('select[name="category1"]').val();

	let url 				= 	'/manager/product/event/_get_category';
	let dataType 			= 	'json';
	let param				= {
		token				:	token,
		cateLevel			: 	2,
		pCateIdx 			:	pCateIdx
	};
	postService(url, dataType, param, function (data) {
		let	category2 		=	data.category;
		let	str 			=	'';

		$('#category2').html('');

		if (category2.length) {
			for (var i = 0 ; i < category2.length ; i++) {
				var cate2 			=	category2[i];
				str					+=	'<option value="'+cate2.categoryIdx+'-'+cate2.cateName+'">'+cate2.cateName+'</option>';
			}
		} else {
			str					+=	'<option value="">-</option>';
		}
		$('#category2').html(str);
	});
}


$(document).on('click', '.selectCateBtn', function(){
	var cateArr				=	[];

	if($('.selectedCate').length > 0){
		$("input[name='categoryIdx[]']").each(function(i){
			cateArr.push($(this).val());
		});
	}

	var str 				=	'';

	var category1			=	$('select[name="category1"]').val();
	var cate1Arr			=	category1.split('-');
	var cateIdx1 			=	cate1Arr[0];
	var cateName1			=	cate1Arr[1];

	var categoryIdx 		=	cateIdx1;

	var category2			=	$('select[name="category2"]').val();
	var cate2Arr			=	category2.split('-');
	var cateIdx2 			=	cate2Arr[0];
	var cateName2 			=	'';
	if(cateIdx2 > 0){
		cateName2 			=	'/ '+cate2Arr[1];
		categoryIdx 		=	cateIdx2;
	}

	if(cateArr.indexOf(categoryIdx) != -1){
		alert('이미 선택한 카테고리입니다.');
		return;
	}

	str						+=	'<li class="selectedCate">';
	str						+=	'	<span class="f_main">'+cateName1+' '+cateName2+'</span>';
	str						+=	'	<input type="hidden" name="categoryIdx[]" value="'+categoryIdx+'">';
	str						+=	'	<a href="javascript:void(0)" class="closeBtn">×</a>';
	str						+=	'</li>';

	$('.selectedCateGroup').append(str);
	$('li.emptyListText').hide();
});



$(document).on('click', '.closeBtn', function(){
	$(this).parents('li').remove();
	if($('.selectedCate').length < 1){
		$('li.emptyListText').show();
	}
});