
$(document).ready(function(){
	get_regularOrder();
});


function get_regularOrder(){
	let token 				=	$('input[name="token"]').val();
	let orderCode 			=	$('input[name="orderCode"]').val();
	$('.subList').html('');

	let url 				=	'/order/event/regularSpec_get_regularOrder';
	let dataType 			=	'json';
	let param 				=	{
		token				:	token,
		orderCode 			:	orderCode
	};
	postService(url, dataType, param, function(data){
		let order 			=	data.order;
		let orderList		=	data.orderList;
		let regularInfo 	=	data.regularInfo;
		let regularAmount 	=	data.regularAmount;


		$('#orderCode').html(order.re_orderCode);
		$('#regDate').html(order.re_date);
		$('#orderTitle').html(order.re_orderTitle);
		$('#ordererName').html(order.re_ordererName);
		$('#ordererMobile').html(order.re_ordererMobile);
		$('#ordererEmail').html(order.re_ordererEmail);
		$('#orgAmount').html(numberWithCommas(order.re_amount));
		$('#amount').html(numberWithCommas(regularAmount));

		let payMethodStr 				=	'';
		let payMethod 					=	regularInfo.payMethod;
		if(payMethod == 1){
			payMethodStr 				=	'신용카드';
		}
		if(payMethod == 2){
			payMethodStr 				=	'계좌이체 ['+regularInfo.AccountBank+': '+regularInfo.AccountNo+']';
		}

		$('#payMethodStr').html(payMethodStr);

		let str 						=	'';
		if(orderList.length){
			for(var i = 0 ; i < orderList.length ; i ++){
				let ol 					=	orderList[i];
				str 					+=	'';
				str 					+=	'<li class="singleGoodsCase">';


				str 					+=	'<div class="segmentTop">';
				str 					+=	'	<span class="f20 process_delivery">선택완료</span>';
			/*	str 					+=	'	<span class="f20 process_done">'++'</span>';*/
			/*	str 					+=	'	<a href="javascript:delete_regularOrderList('+ol.re_orderListIdx+');" class="rimlessBtn viewSpecBtn absoluteR process_done">선택취소</a>';*/
				str 					+=	'</div>';
				str 					+=	'	<div class="mainCon">';
				str 					+=	'		<img src="http://nonghyup.heeyam.com'+ol.re_goodsImg+'" class="goodsImg separatedLeft"></img>';
				str 					+=	'		<div class="goodsInfo separatedRight relative">';
				str 					+=	'			<div class="absoluteT infoText">';
				str 					+=	'				<div class="f16 f_semiBold">'+ol.re_goodsName+'</div>';
				if(ol.re_goodsOpIdx > 0){
					str 					+=	'				<div class="f12">';
					str 					+=	'					<div>'+ol.re_goodsOpName+' : '+ol.re_goodsOpInfo+'('+numberWithCommas(ol.re_goodsOpPrice)+'원) X '+ol.re_orderQty+'개</div>';
					str 					+=	'				</div>';
				} else {
					str 					+=	'				<div class="f12">';
					str 					+=	'					<div>기본 : '+ol.re_orderQty+'개</div>';
					str 					+=	'				</div>';
				}
				str 					+=	'			</div>';
				str 					+=	'			<div class="absoluteMR f_bold f20">'+numberWithCommas(ol.re_perAmount)+'원</div>';
				str 					+=	'		</div>';
				str 					+=	'	</div>';
				str 					+=	'</li>';
			}

			$('.goodsList').html(str);
		}

		$('#receiveName').html(order.re_receiveName);
		$('#receiveZip').html(order.re_receiveZip);
		$('#receiveAddr').html(order.re_receiveAddr+' '+order.re_receiveAddrDetail);
		$('#receiveMobile').html(order.re_receiveMobile);
		$('#deliveryMsg').html(order.re_deliveryMsg);
	});
}

function delete_regularOrderList(orderListCode, updateState){
	var orderCode 			=	$('input[name="orderCode"]').val();
	let token				=	$('input[name="token"]').val();
	let state				=	$('input[name="state"]').val();
	let url 				=	'/order/event/regular';
	let dataType			=	'json';
	let param				= 	{
		token					:	token,
		orderCode 				:	orderCode,
		orderListCode 			:	orderListCode,
		updateState 			:	updateState,
		type					:	state
	};

	if(confirm('주문상태를 바꾸시겠습니까?')){
		postService(url, dataType, param, '', '');
	}
}