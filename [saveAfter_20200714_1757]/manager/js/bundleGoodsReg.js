



// 상품등록
function insert_bundleGoods(){
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

	if(confirm('상품을 등록하시겠습니까?')) {
		let form				=   document.querySelector("#frm");
		let postData			=   new FormData(form);

		let url					=	'/manager/product/event/bundleGoodsReg_insert_bundleGoods';
		let dataType			=	'json';
		let param				= 	postData;
		let formType			=	1;
		postService(url, dataType, param, '', formType);
	}

}