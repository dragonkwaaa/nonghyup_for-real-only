$(document).ready(function(){
	get_bundleGoods();
});


function get_bundleGoods(){
	let token				=	$('input[name="token"]').val();
	let bundleGoodsIdx		=	$('input[name="bundleGoodsIdx"]').val();

	let url 				=	'/manager/product/event/bundleGoodsModify_get_bundleGoods';
	let dataType			=	'json';
	let param				= 	{
		token					:	token,
		bundleGoodsIdx 			:	bundleGoodsIdx
	};

	postService(url, dataType, param, function(data){
		let bundleG 		=	data.bundleGoods;

		$('input[name="oldImg1"]').val(bundleG.bundleGoodsImg1);
		$('input[name="oldImg2"]').val(bundleG.bundleGoodsImg2);
		$('input[name="oldImg3"]').val(bundleG.bundleGoodsImg3);
		$('input[name="oldImg4"]').val(bundleG.bundleGoodsImg4);
		$('input[name="oldImg5"]').val(bundleG.bundleGoodsImg5);

		let str1				=	'';
		if(bundleG.bundleGoodsImg1){
			for(var i = 1 ; i <= 5 ; i ++){
				if(eval('bundleG.bundleGoodsImg' + i)){
						var bundleGoodsImg 	=	eval('bundleG.bundleGoodsImg' + i);
						str1				+=	'<canvas></canvas>';
						str1				+=	'<img src="http://nonghyup.heeyam.com'+bundleGoodsImg+'" alt="이미지">';
						str1				+=	'<a href="#none" class="del_btn" onclick="delImg(this)">삭제</a>';
						$('input[name="img_'+i+'"]').closest('div').append(str1);
				}
			}
		}

		$('input[name="bundleGoodsName"]').val(bundleG.bundleGoodsName);
		$('input[name="bundleGoodsPrice"]').val(numberWithCommas(bundleG.bundleGoodsPrice));
		$('input[name="bundleGoodsSubName"]').val(bundleG.bundleGoodsSubName);
		$('#bundleGoodsInfo').html(bundleG.bundleGoodsInfo);
	});
}

function update_bundleGoods(){
	let bundleGoodsName			=	$('input[name="bundleGoodsName"]');
	let bundleGoodsSubName		=	$('input[name="bundleGoodsSubName"]');
	let bundleGoodsInfolength 	=	document.getElementById("bundleGoodsInfo").value.length;
	let bundleGoodsPrice 		=	$('input[name="bundleGoodsPrice"]');

	if(!bundleGoodsName.val().trim()){
		alert('싱품명을 입력해주세요.');
		goodsName.focus();
		return;
	}

	if(!bundleGoodsPrice.val().trim()){
		alert('판매가를 입력해주세요.');
		goodsPrice.focus();
		return;
	}

	if(!bundleGoodsSubName.val().trim()){
		alert('상품 요약 설명을 입력해주세요.');
		goodsName.focus();
		return;
	}

	if(bundleGoodsInfolength < 1){
		alert('상품 상세 설명을 입력해주세요.');
		$('#goodsInfo').focus();
		return;
	}

	if($('input[name="isDel_1"]').val() == 1){
		if(!$('input[name="img_1"]').val().trim()){
			alert('이미지를 입력해주세요.');
			return;
		}
	}


	if(confirm('상품을 수정하시겠습니까?')) {
		let form				=   document.querySelector("#frm");
		let postData			=   new FormData(form);

		let url					=	'/manager/product/event/bundleGoodsModify_update_bundleGoods';
		let dataType			=	'json';
		let param				= 	postData;
		let formType			=	1;
		postService(url, dataType, param, '', formType);
	}

}
