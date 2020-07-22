
$(document).ready(function(){
	get_order();
});


function get_order(){
	let token 				=	$('input[name="token"]').val();
	let orderCode 			=	$('input[name="orderCode"]').val();
	let state 				=	$('input[name="state"]').val();
	$('.subList').html('');

	let url 				=	'/order/event/orderSpec_get_order';
	let dataType 			=	'json';
	let param 				=	{
		token				:	token,
 		orderCode 			:	orderCode
	};
	postService(url, dataType, param, function(data){
		let order 			=	data.order;
		let orderList		=	data.orderList;

		if(state == 2){
			$('.mainTitle').html('취소/교환/반품 상세조회');
		}
		/*if(order.isRegular == 1){
			$('.mainTitle').html('정기배송주문 상세조회');
		}*/
		$('#orderCode').html(order.orderCode);
		$('#regDate').html(order.regDate);
		$('#orderTitle').html(order.orderTitle);
		$('#ordererName').html(order.ordererName);
		$('#ordererMobile').html(order.ordererMobile);
		$('#ordererEmail').html(order.ordererEmail);
		$('#orgAmount').html(numberWithCommas(order.orgAmount));
		$('#amount').html(numberWithCommas(order.amount));
		let payMethodStr 				=	'';
		let payMethod 					=	order.payMethod;
		if(payMethod == 1){
			payMethodStr 				=	'신용카드';
		}
		if(payMethod == 2){
			payMethodStr 				=	'계좌이체(정기배송)';
		}
		if(payMethod == 3){
			payMethodStr 				=	'무통장입금';
		}
		if(payMethod == 4){
			payMethodStr 				=	'핸드폰결제';
		}
		$('#payMethodStr').html(payMethodStr);

		if(order.isRegular == 1){
			$('#isRegularSel').append(' (정기배송)');
		}
		let str 						=	'';
		if(orderList.length){
			for(var i = 0 ; i < orderList.length ; i ++){
				let ol 					=	orderList[i];
				str 					+=	'';
				str 					+=	'<li class="singleGoodsCase">';


				str 					+=	'<div class="segmentTop">';
				// str 					+=	'	<span class="f20 process_delivery">배송중</span>';
				str 					+=	'	<span class="f20 process_done">'+ol.orderStateStr+'</span>';
				if(order.isRegular == 0){
					if(ol.orderState == 1){
						str 					+=	'	<a href="javascript:update_state('+ol.orderListCode+', 404);" class="rimlessBtn viewSpecBtn absoluteR process_done">주문취소</a>';
					}
				}
					if(ol.orderState == 4){
						str 					+=	'	<a href="javascript:update_state('+ol.orderListCode+', 5);" class="rimlessBtn viewSpecBtn absoluteR process_done">구매확정</a>';
					}
					if(ol.orderState == 5){
						str 					+=	'	<a href="javascript:openReviewPop();" class="rimlessBtn viewSpecBtn absoluteR process_done">상품후기작성</a>';
					}


				// str 					+=	'	<a href="/nonghyup/order/orderSpec" class="rimlessBtn viewSpecBtn absoluteR process_delivery">주문취소</a>';
				str 					+=	'</div>';



				str 					+=	'	<div class="mainCon">';
				str 					+=	'		<img src="http://nonghyup.heeyam.com'+ol.goodsImg+'" class="goodsImg separatedLeft"></img>';
				str 					+=	'		<div class="goodsInfo separatedRight relative">';
				str 					+=	'			<div class="absoluteT infoText">';
				str 					+=	'				<div class="f16 f_semiBold">'+ol.goodsName+'</div>';
				if(ol.goodsOpIdx > 0){
				str 					+=	'				<div class="f12">';
				str 					+=	'					<div>'+ol.goodsOpName+' : '+ol.goodsOpInfo+'('+numberWithCommas(ol.goodsOpPrice)+'원) X '+ol.orderQty+'개</div>';
				str 					+=	'				</div>';
				} else {
					str 					+=	'				<div class="f12">';
					str 					+=	'					<div>기본 : '+ol.orderQty+'개</div>';
					str 					+=	'				</div>';
				}
				str 					+=	'			</div>';
				str 					+=	'			<div class="absoluteMR f_bold f20 f_robotoBold">'+numberWithCommas(ol.perAmount)+'원</div>';
				str 					+=	'		</div>';
				str 					+=	'	</div>';
				str 					+=	'</li>';
			}

			$('.goodsList').html(str);
		}

		$('#receiveName').html(order.receiveName);
		$('#receiveZip').html(order.receiveZip);
		$('#receiveAddr').html(order.receiveAddr+' '+order.receiveAddrDetail);
		$('#receiveMobile').html(order.receiveMobile);
		$('#deliveryMsg').html(order.deliveryMsg);
	});
}

function update_state(orderListCode, updateState){
	var orderCode 			=	$('input[name="orderCode"]').val();
	let token				=	$('input[name="token"]').val();
	let state				=	$('input[name="state"]').val();
	let url 				=	'/order/event/orderSpec_update_orderState';
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