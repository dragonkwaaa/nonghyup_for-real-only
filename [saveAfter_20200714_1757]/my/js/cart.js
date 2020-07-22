
$(document).ready(function(){
	get_cart(1);
});


function get_cart(type){
	$('input[name="isRegular"]').val(type);
	let token 				=	$('input[name="token"]').val();
	let isRegular 			=	$('input[name="isRegular"]').val();

	let url					=	'/my/event/cart_get_cart';
	let dataType			=	'json';
	let param				= 	{
		token				:	token,
		isRegular 			:	isRegular
	};

	postService(url, dataType, param, function(data){

		//let list			=	data.list;
		let regular 		=	data.regular;
		let notRegular 		=	data.notRegular;
		let regularTot		=	data.regularTot;
		let notRegularTot	=	data.notRegularTot;
		let str				=	'';
		let userRegular 	=	data.userRegular;
		let totalPrice 		=	0;

		let list 			=	'';
		let totalCount 		=	'';

		$('#buyButton').show();
		$('#checkSel').show();
		$('#buttonSel').show();
		if(type == 1){
			list			=	regular;
			totalCount 		=	regularTot;
			$('#regularCart').addClass('activated');
			$('#notRegularCart').removeClass('activated');
		//	$('#buyButton').prop('href', "javascript:set_cart_fix()");
		} else {
			list 			=	notRegular;
			totalCount 		=	notRegularTot;
			$('#regularCart').removeClass('activated');
			$('#notRegularCart').addClass('activated');
			$('#buyButton').hide();
			//$('#buyButton').prop('href', "javascript:set_order()");
		}

		if(userRegular != 1){
			$('#regularCart').hide();
		}

		if(list.length){
			$.each(list, function(index, cart) {
				let op 				=	cart.opData;
				let goods 			=	cart.goods;
				let opStr 			=	'기본';
				let opPrice 		=	0;
				let discount 		=	0;
				let perGoodsPrice 	=	goods.goodsPrice;
				if(cart.goodsOpIdx > 0 && goods.isOption == 1){
					opStr 				=	op.goodsOpInfo;
					opPrice 			=	op.goodsOpPrice;
					perGoodsPrice		=	opPrice;
					goods.goodsPrice 	=	0;
				}

				let isFixStr 		=	'';
				/*if(cart.isFix == 1){
					isFixStr 		=	' (구매확정)';
				}*/
			str			+=		'<li>';
            // str			+=		'	<div class="segmentHeadLine f12">'+goods.goodsName+' '+isFixStr+'</div>';

            str			+=		'	<div class="segmentHeadLine f12">';
            str			+=		'       <span>'+goods.goodsName+'</span>';
            str			+=		'       <span class="confirmedMark">'+isFixStr+'</span>';
            str			+=		'   </div>';

			str			+=		'	<div class="segmentTop">';
			str			+=		'		<label>';
			str			+=		'			<input type="checkbox" name="cartCode[]" value="'+cart.cartCode+'" checked onchange="calculation();">';
			str 		+=		'			<input type="hidden" name="goodsCode[]" value="'+cart.goodsCode+'">';
			str 		+=		'			<input type="hidden" id="tempOpData'+cart.cartCode+'" value="'+opStr+'">';
			str			+=		'			<span class="f_w14m30">'+opStr+'</span>';
			str			+=		'		</label>';
			str			+=		'		<a href="javascript:delete_cart('+cart.cartCode+');" class="deleteBtn absoluteR"></a>';
			str			+=		'	</div>';
			str			+=		'	<div class="mainCon imgGoods">';
			str			+=		'		<img src="http://nonghyup.heeyam.com'+goods.goodsImg1+'" class="goodsImg separatedLeft"></img>';
			str			+=		'		<div class="goodsInfo separatedRight">';
			str			+=		'			<div class="f20 f_semiBold mt8">';
			str			+=		'				<span>'+numberWithCommas(perGoodsPrice)+'원</span>';
			str			+=		'				<span class="f14">('+cart.cartQty+'개)</span>';
			str			+=		'			</div>';
			str			+=		'		</div>';
		/*	if(isRegular != 1){
			str			+=		'		<a href="javascript:show_cart('+cart.cartCode+');" class="changeOptionBtn mt12 plainBtn">옵션/수량</a>';
			}*/
			str			+=		'	</div>';



			str			+=		'	<div class="calculationCon cartCalc">';
			str			+=		'		<div>';
			str			+=		'			<div>';
			str			+=		'				<span class="f13">상품금액</span>';
			str			+=		'				<span class="floatR f_bold f13">'+numberWithCommas(perGoodsPrice)+'원</span>';
			str			+=		'			</div>';
			str			+=		'			<div class="mt20">';
			str			+=		'				<span class="f13">배송비</span>';
			str			+=		'				<span class="floatR f13">무료</spa>';
			str			+=		'			</div>';
			str			+=		'			<div class="mt20">';
			str			+=		'				<span class="lh20 f13">주문금액</span>';
			str			+=		'				<span class="floatR f_bold f20">'+numberWithCommas(parseInt((perGoodsPrice) * cart.cartQty))+'원</span>';
			str			+=		'			<input type="hidden" name="name[]" value="'+goods.goodsName+'" id="name'+cart.cartCode+'">';
			str			+=		'			<input type="hidden" name="qty[]" value="'+cart.cartQty+'" id="qty'+cart.cartCode+'">';
			str			+=		'			<input type="hidden" name="price[]" value="'+goods.goodsPrice+'" id="price'+cart.cartCode+'">';
				str			+=		'			<input type="hidden" name="discount[]" value="'+discount+'" id="discount'+cart.cartCode+'">';
				str			+=		'			<input type="hidden" name="opPrice[]" value="'+opPrice+'" id="opPrice'+cart.cartCode+'">';
			str			+=		'			</div>';
			str			+=		'		</div>';
			str			+=		'	</div>';
			str			+=		'</li>';

			totalPrice	+=		parseInt((perGoodsPrice) * cart.cartQty);
			});
		} else {
			str			+=		'<div class="emptyItemDisplay tAlignC">';
			str			+=		'	<i class="emptyCartIcon"></i>';
			str			+=		'	<div class="mt40 f24">장바구니에 담긴 상품이 없습니다.</div>';
			str			+=		'	<a href="/" class="rimlessBtn">쇼핑하러 가기</a>';
			str			+=		'</div>';

			$('#checkSel').hide();
			$('#buttonSel').hide();
			$('#buyButton').hide();
		}

		$('.goodsList').html(str);
		$('#totalPrice').html(numberWithCommas(totalPrice)+'원');
		$('#orderPrice').html(numberWithCommas(totalPrice)+'원');
		//$('#discountPrice').html(numberWithCommas(discountPrice)+'원');
		//setPaging(recordPerPage, pnoPerPage, pno, totalCount);
		calculation();
	});
}

function show_cart(cartCode){
	$('#tempOpSel').show();
	$('#tempName').html('');
	$('#tempQty').val(0);

	var tempQty 				=	parseInt($('#qty'+cartCode).val());
	var tempName 				=	$('#name'+cartCode).val();
	var price 					=	parseInt($('#price'+cartCode).val());
	var opPrice 				=	parseInt($('#opPrice'+cartCode).val());
	var tempOpData 				=	$('#tempOpData'+cartCode).val();

	$('#tempName').html(tempName);
	$('#tempQty').val(tempQty);
	$('#popupOpData').html(tempOpData);
	$('#tempCartCode').val(cartCode);

	var tempPerTotal			=	parseInt(tempQty * (price + opPrice));
	$('#tempPerTotal').html(numberWithCommas(tempPerTotal));
	
	$('.popup.changeOptionPop').show();
	$('.container').addClass('overlay');
}


function updateQty(type){
	var tempQty 			=	$('#tempQty').val();
	if(type == 'M'){
		if(tempQty == 1){
			return;
		} else {
			tempVal 		=	parseInt(tempQty) - 1;
		}
	} else if(type == 'P'){
		tempVal 			=	parseInt(tempQty) + 1;
	}

	$('#tempQty').val(tempVal);
	popup_calculation();
}

function popup_calculation(){
	var tempCartCode 			=	$('#tempCartCode').val();
	var tempQty 				=	$('#tempQty').val();
	var price 					=	parseInt($('#price'+tempCartCode).val());
	var opPrice 				=	parseInt($('#opPrice'+tempCartCode).val());
	var tempPerTotal			=	parseInt(tempQty * (price + opPrice));
	$('#tempPerTotal').html(numberWithCommas(tempPerTotal));
}

$(document).on('click', '.closePopBtn', function(){
	$('.popup').hide();
	$('.container').removeClass('overlay');
});

function update_cartQty(){
	let url 					=	'/my/event/cart_update_cart';
	let dataType 				=	'json';
	let param 					=	{
		cartCode				:	$('#tempCartCode').val(),
		procType 				:	3,
		isRegular				:	$('input[name="isRegular"]').val(),
		qty 					:	$('#tempQty').val()
	}
	postService(url, dataType, param, '', '');

}


function calculation(){
	var perCode 						=	0;
	var perPrice 						=	0;
	var opPrice 						=	0;
	var totalPrice 						=	0;
	var perDiscount 					=	0;
	var totalDiscount 					=	0;
	var i 								=	0;

	$('input:checkbox[name="cartCode[]"]').each(function() {
		if(this.checked){
			perCode 					=	this.value;
			perPrice	 				=	parseInt($('#price'+perCode).val());
			opPrice	 					=	parseInt($('#opPrice'+perCode).val());
			perQty	 					=	parseInt($('#qty'+perCode).val());
			totalPrice 					+=	(perPrice + opPrice) * perQty;

			perDiscount	 				=	parseInt($('#discount'+perCode).val());
			totalDiscount 				+=	perDiscount * perQty;
			i++;
		}
	});

	$('#cartNum').html('(상품'+i+'개)');
	$('#totalPrice').html(numberWithCommas(totalPrice));
	$('#orderPrice').html(numberWithCommas(totalPrice));

	$('input[name="amount"]').val(totalPrice);
	$('input[name="orgAmount"]').val(totalPrice);
	//$('#discountPrice').html(numberWithCommas(totalDiscount));
}

function codeCheckAll(){
	if ($('input:checkbox[name="checkAll"]').is(":checked") == true) {
		$("input[name='cartCode[]']").prop("checked", true);
	} else {
		$("input[name='cartCode[]']").prop("checked", false);
	}
	calculation();
}

function delete_cart(cartCode){
	let url 					=	'/my/event/cart_delete_cart';
	let dataType 				=	'json';
	let param 					=	{
		cartCode				:	cartCode,
		isRegular				:	$('input[name="isRegular"]').val()
	}
	postService(url, dataType, param, function(data) {
		var isRegular 			=	$('input[name="isRegular"]').val();
		get_cart(isRegular);
	});
}

function delete_cartArr(){
	let cartCode	 			=	[];
	let token 				=	$('input[name="token"]').val();
	if ($('input:checkbox[name="cartCode[]"]').is(":checked") == false) {
		alert('변경할 상품을 선택해주세요.');
		return false;
	}

	$("input[name='cartCode[]']:checked").each(function(i){
		cartCode.push($(this).val());
	});

	let url 				=	'/my/event/cart_delete_cart';
	let dataType			=	'json';
	let param				= 	{
		token					:	token,
		cartCode				:	cartCode
	};

	if(confirm('삭제하시겠습니까?')){
		postService(url, dataType, param, '', '');
	}
}

function checkMobile(chkType){
	var chkType					=	'';
	var filter 					=	"win16|win32|win64|mac";
	if(navigator.platform){

		if(0 > filter.indexOf(navigator.platform.toLowerCase())){
			//alert("Mobile");
			chkType 			=	'1';
		}else{
			//alert("PC");
			chkType 			=	'2';
		}
	}
	return chkType;
}

function set_regularOrder(){
	let cartCode 				=	[]
	$('input:checkbox[name="cartCode[]"]').each(function() {
		if(this.checked){								//checked 처리된 항목의 값
			cartCode.push(this.value);
		}
	});

	let form				=   document.querySelector("#frm");
	let postData			=   new FormData(form);

	let url					=	'/order/event/orderReg_insert_order';
	let dataType			=	'json';
	let param				= 	postData;
	let formType			=	1;
	postService(url, dataType, param, '', formType);

}

function set_order(){
	let cartCode 				=	[]
	$('input:checkbox[name="cartCode[]"]').each(function() {
		if(this.checked){								//checked 처리된 항목의 값
			cartCode.push(this.value);
		}
	});

	let url 				=	'/order/event/orderReg_before_order';

	let form				=   document.querySelector("#frm");
	let postData			=   new FormData(form);

	let dataType			=	'json';
	let param				= 	postData;
	let formType			=	1;
	postService(url, dataType, param, '', formType);

}

function set_cart_fix(){
	let cartCode 			=	[]

	$("input[name='cartCode[]']:checked").each(function(i){
		cartCode.push($(this).val());
	});

	let url 				=	'/my/event/cart_set_fix';
	let dataType			=	'json';
	let param				= 	{
		cartCode				:	cartCode
	};

	postService(url, dataType, param, function(data) {
		alert('정기배송상품이 담겼습니다.');
		var isRegular 			=	$('input[name="isRegular"]').val();
		get_cart(isRegular);
	});
}
/*

function set_regularOrder(){
	let cartCode 				=	[]
	$('input:checkbox[name="cartCode[]"]').each(function() {
		if(this.checked){								//checked 처리된 항목의 값
			cartCode.push(this.value);
		}
	});

	let form				=   document.querySelector("#frm");
	let postData			=   new FormData(form);

	let url					=	'/common/event/insert_pay_card';
	let dataType			=	'json';
	let param				= 	postData;
	let formType			=	1;
	postService(url, dataType, param, '', formType);

}*/
