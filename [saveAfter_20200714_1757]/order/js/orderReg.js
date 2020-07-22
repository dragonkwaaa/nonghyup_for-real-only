let element_wrap = document.getElementById('wrap');
$(document).ready(function(){
	get_order();
	foldDaumPostcode();
});

function foldDaumPostcode() {
	// iframe을 넣은 element를 안보이게 한다.
	element_wrap.style.display = 'none';
}


function get_order(){
	let token 				=	$('input[name="token"]').val();
	$('.subList').html('');

	let isRegular 			=	$('input[name="isRegular"]').val();
	let url 				=	'/order/event/orderReg_get_orderInfo';
	let dataType 			=	'json';
	let param 				=	{
		token				:	token,
		procType 			:	1,
		isRegular 			:	isRegular
	};
	postService(url, dataType, param, function(data){
		let str 			=	'';
		let list 			=	data.list;
		let total 			=	data.total;
		let directOrder 	=	data.directOrder;
		let user 			=	data.user;
		let regular 		=	data.regular;

		$('#title1').html('주문 상품 ('+list.length+'개)');
		$('#title2').html('상품 ('+list.length+'개)');
		$('#total').html(numberWithCommas(total)+'원');
		$('#discountTotal').html('0원');
		$('#orderPrice').html(numberWithCommas(total)+'원');
		$('input[name="isRegular"]').val(isRegular);
		$('input[name="orgAmount"]').val(total);
		$('input[name="amount"]').val(total);
		$('input[name="directOrder"]').val(directOrder);

		if(list.length){
			for(var i = 0 ; i < list.length ; i ++){
				let li 				=	list[i];
				let op 				=	li.opData;
				let goods 			=	li.goods;
				let opStr 			=	'기본';
				if(goods.isOption == 1){
					opStr 			=	op.goodsOpInfo+ ' ('+li.cartQty+'개)';
				}

				str				+=	' <li>';
				str 			+=	'	<input type="hidden" name="goodsCode[]" value="'+li.goodsCode+'">';
				str 			+=	'	<input type="hidden" name="goodsOpIdx[]" value="'+li.goodsOpIdx+'">';
				str 			+=	'	<input type="hidden" name="orderQty[]" value="'+li.cartQty+'">';
				str 			+=	'	<input type="hidden" name="cartCode[]" value="'+li.cartCode+'">';
				str 			+=	'	<input type="hidden" name="perAmount[]" value="'+li.perTotal+'">';
				str				+=	'	<div class="mainCon">';
				str				+=	'		<div class="goodsInfo relative">';
				str				+=	'			<div class="f16">'+goods.goodsName+'</div>';
				str				+=	'			<div class="f12 mt13">';
					str				+=	'				<div>'+opStr+'</div>';
				str				+=	'			</div>';
				str				+=	'			<div class="absoluteMR f_bold f20">'+numberWithCommas(li.perTotal)+'원</div>';
				str				+=	'		</div>';
				str				+=	'	</div>';

				str				+=	'	<div class="calculationCon">';
				str				+=	'		<div class="priceInfo">';
				str				+=	'			<div class="f14">상품금액</div>';
				str				+=	'			<div class="f20 f_bold mt10">'+numberWithCommas(li.perTotal)+'원</div>';
				str				+=	'		</div>';
				str				+=	'		<i class="iconCalc_plus"></i>';
				str				+=	'		<div class="priceInfo">';
				str				+=	'			<div class="f14">배송비</div>';
				str				+=	'			<div class="f20 f_bold mt10">무료</div>';
				str				+=	'		</div>';
				str				+=	'		<i class="iconCalc_equal"></i>';
				str				+=	'		<div class="priceInfo">';
				str				+=	'			<div class="f14">주문금액</div>';
				str				+=	'			<div class="f20 f_bold mt10">'+numberWithCommas(li.perTotal)+'원</div>';
				str				+=	'		</div>';
				str				+=	'	</div>';
				str				+=	'</li>';
			}
			$('.subList').html(str);
		}

		if(user){
			$('input[name="ordererName"]').val(user.userName);
			$('input[name="ordererMobile"]').val(user.userMobile);
			$('input[name="ordererEmail"]').val(user.userEmail);
			$('input[name="receiveZip"]').val(user.userZip);
			$('input[name="receiveAddr"]').val(user.userAddr);
			$('input[name="receiveAddrDetail"]').val(user.userAddrDetail);
		}
		if(regular){
			$('input[name="ordererName"]').val(regular.ordererName);
			$('input[name="ordererMobile"]').val(regular.ordererMobile);
			$('input[name="ordererEmail"]').val(regular.ordererEmail);
			$('input[name="receiveZip"]').val(regular.receiveZip);
			$('input[name="receiveAddr"]').val(regular.receiveAddr);
			$('input[name="receiveAddrDetail"]').val(regular.receiveAddrDetail);
			$('input[name="deliveryMsg"]').val(regular.deliveryMsg);
			$('input[name="receiveName"]').val(regular.receiveName);
			$('input[name="receiveMobile"]').val(regular.receiveMobile);
			$('input[name="payMethod"]').val(regular.payMethod);
		}
		if(isRegular == 1){
			$('#payMethodSel0').remove();
			$('#checkPay1').html('주문하기');
			$('#checkPay2').html('주문하기');
		} else {
			$('#checkPay1').html('결제하기');
			$('#checkPay2').html('결제하기');
		}

	}, '', '', '', '', 1);
}

//정기배송 주문시, 회원정보 가져오기

//주문자 정보와 동일
function paste_order(){
	let ordererName 				=	$('input[name="ordererName"]').val();
	let ordererMobile 				=	$('input[name="ordererMobile"]').val();
	$('input[name="receiveName"]').val(ordererName);
	$('input[name="receiveMobile"]').val(ordererMobile);
}

//결제수단 선택
function setPayMethod(method){
	$('input[name="payMethod"]').val(method);
}

//주문하기
function insert_order(type){
	let ordererName				=	$('input[name="ordererName"]');
	let ordererMobile			=	$('input[name="ordererMobile"]');
	let ordererEmail			=	$('input[name="ordererEmail"]');
	let receiveName				=	$('input[name="receiveName"]');
	let receiveAddr				=	$('input[name="receiveAddr"]');
	let receiveAddrDetail		=	$('input[name="receiveAddrDetail"]');
	let receiveMobile			=	$('input[name="receiveMobile"]');
	let payMethod				=	$('input[name="payMethod"]');
	let isRegular 				=	$('input[name="isRegular"]').val();
	if(!ordererName.val().trim()){
		alert('주문자 이름을 입력해주세요.');
		ordererName.focus();
		return;
	}
	if(!ordererMobile.val().trim()){
		alert('주문자 연락처를 입력해주세요.');
		ordererMobile.focus();
		return;
	}
	if(!ordererEmail.val().trim()){
		alert('주문자 이메일을 입력해주세요.');
		ordererEmail.focus();
		return;
	}
	if(!receiveName.val().trim()){
		alert('수령인을 입력해주세요.');
		receiveName.focus();
		return;
	}
	if(!receiveAddr.val().trim()){
		alert('주소를 입력해주세요.');
		receiveAddr.focus();
		return;
	}
	if(!receiveAddrDetail.val().trim()){
		alert('상세주소를 입력해주세요.');
		receiveAddrDetail.focus();
		return;
	}
	if(!receiveMobile.val().trim()){
		alert('수령인 연락처를  입력해주세요.');
		receiveMobile.focus();
		return;
	}
	if(!payMethod.val().trim()){
		alert('결제수단을 선택해주세요.');
		payMethod.focus();
		return;
	}
	if(type == 1){
		if($('input:checkbox[id="agree1"]').is(":checked") ==  false){
			alert('이용사항 동의 후 결제 가능합니다.');
			$('#agree1').focus();
			return;
		}
		if($('input:checkbox[id="agree2"]').is(":checked") ==  false){
			alert('이용사항 동의 후 결제 가능합니다.');
			$('#agree2').focus();
			return;
		}
	} else if(type == 2){
		if($('input:checkbox[id="agree1_m"]').is(":checked") ==  false){
			alert('이용사항 동의 후 결제 가능합니다.');
			$('#agree1').focus();
			return;
		}
		if($('input:checkbox[id="agree2_m"]').is(":checked") ==  false){
			alert('이용사항 동의 후 결제 가능합니다.');
			$('#agree2').focus();
			return;
		}
	}


	let form				=   document.querySelector("#frm");
	let postData			=   new FormData(form);

	let url					=	'/order/event/orderReg_insert_regularOrder';
	let dataType			=	'json';
	let param				= 	postData;
	let formType			=	1;

	postService(url, dataType, param, '', formType);
}


//주문하기
function insert_order_pg(type){
	let ordererName				=	$('input[name="ordererName"]');
	let ordererMobile			=	$('input[name="ordererMobile"]');
	let ordererEmail			=	$('input[name="ordererEmail"]');
	let receiveName				=	$('input[name="receiveName"]');
	let receiveAddr				=	$('input[name="receiveAddr"]');
	let receiveAddrDetail		=	$('input[name="receiveAddrDetail"]');
	let receiveMobile			=	$('input[name="receiveMobile"]');
	let payMethod				=	$('input[name="payMethod"]');
	let isRegular 				=	$('input[name="isRegular"]').val();
	if(!ordererName.val().trim()){
		alert('주문자 이름을 입력해주세요.ss');
		ordererName.focus();
		return;
	}
	if(!ordererMobile.val().trim()){
		alert('주문자 연락처를 입력해주세요.');
		ordererMobile.focus();
		return;
	}
	if(!ordererEmail.val().trim()){
		alert('주문자 이메일을 입력해주세요.');
		ordererEmail.focus();
		return;
	}
	if(!receiveName.val().trim()){
		alert('수령인을 입력해주세요.');
		receiveName.focus();
		return;
	}
	if(!receiveAddr.val().trim()){
		alert('주소를 입력해주세요.');
		receiveAddr.focus();
		return;
	}
	if(!receiveAddrDetail.val().trim()){
		alert('상세주소를 입력해주세요.');
		receiveAddrDetail.focus();
		return;
	}
	if(!receiveMobile.val().trim()){
		alert('수령인 연락처를  입력해주세요.');
		receiveMobile.focus();
		return;
	}
	if(!payMethod.val().trim()){
		alert('결제수단을 선택해주세요.');
		payMethod.focus();
		return;
	}
	if(type == 1){
		if($('input:checkbox[id="agree1"]').is(":checked") ==  false){
			alert('이용사항 동의 후 결제 가능합니다.');
			$('#agree1').focus();
			return;
		}
		if($('input:checkbox[id="agree2"]').is(":checked") ==  false){
			alert('이용사항 동의 후 결제 가능합니다.');
			$('#agree2').focus();
			return;
		}
	} else if(type == 2){
		if($('input:checkbox[id="agree1_m"]').is(":checked") ==  false){
			alert('이용사항 동의 후 결제 가능합니다.');
			$('#agree1').focus();
			return;
		}
		if($('input:checkbox[id="agree2_m"]').is(":checked") ==  false){
			alert('이용사항 동의 후 결제 가능합니다.');
			$('#agree2').focus();
			return;
		}
	}

	let form				=   document.querySelector("#frm");
	let postData			=   new FormData(form);

	let url					=	'/order/event/orderReg_check_order';
	let dataType			=	'json';
	let param				= 	postData;
	let formType			=	1;


	if(confirm('주문을 하시겠습니까?')) {
		postService(url, dataType, param, function (data){
			var paySet				=	data.paySet;
			var paySet_str 			=	'';

			if(!paySet) return;

			var Amt 				=	$('input[name="amount"]').val();
			paySet_str				+=	'<input type="hidden" name="isPG" value="1">';
			paySet_str				+=	'<input type="hidden" name="PayMethod" value="'+paySet.PayMethod+'">';
			paySet_str				+=	'<input type="hidden" name="GoodsName" value="'+paySet.goodsName+'">';
			paySet_str				+=	'<input type="hidden" name="GoodsCnt" value="'+paySet.goodsCnt+'">';
			paySet_str				+=	'<input type="hidden" name="Amt" value="'+Amt+'">';
			paySet_str				+=	'<input type="hidden" name="BuyerName" value="'+paySet.receiveMobile+'">';
			paySet_str				+=	'<input type="hidden" name="BuyerTel" value="'+paySet.receiveMobile+'">';
			paySet_str				+=	'<input type="hidden" name="Moid" value="'+paySet.moid+'">';
			paySet_str				+=	'<input type="hidden" name="MID" value="'+paySet.merchantID+'">';

			paySet_str				+=	'<input type="hidden" name="ReturnURL" value="'+paySet.ReturnURL+'">';
			paySet_str				+=	'<input type="hidden" name="CharSet" value="'+paySet.CharSet+'">';
			paySet_str				+=	'<input type="hidden" name="GoodsCl" value="'+paySet.GoodsCl+'">';
			paySet_str				+=	'<input type="hidden" name="EncryptData" value="'+paySet.hashString+'">';
			paySet_str				+=	'<input type="hidden" name="ediDate" value="'+paySet.ediDate+'">';

			paySet_str				+=	'<input type="hidden" name="TrKey"  value=""/> ';
			$('#frm').html(paySet_str);

			if(navigator.platform){
				var filter 			=	'win16|win32|win64|mac';
				if(0 > filter.indexOf(navigator.platform.toLowerCase())){
					$('#chkType').val('Mobile');
				}
			}
			let pgFrm 					=	document.frm;
			//pgFrm.charset 				=	'euc-kr';
			pgFrm.method 				=	'post';
			pgFrm.target 				=	'_self';
			//pgFrm.action 				=	"https://web.nicepay.co.kr/v3/smart/smartPayment.jsp";
			pgFrm.action 				=	'/order/event/orderReg_insert_withoutPG';
			nicepayStart();
		}, formType);
	}
}

function nicepayStart(){
	document.charset	=	"euc-kr";
	document.action		=	"https://web.nicepay.co.kr/v3/smart/smartPayment.jsp";
	$('#frm').submit();
}
/*

function goPay(){
	var frmPG 							=	document.getElementById("frmPG");
	document.charset = "euc-kr";
	$('#frmPG').submit();
}
*/


function openPostcode() {
	new daum.Postcode({
		oncomplete: function(data) {
			// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
			var userSelectedType		=	data.userSelectedType;
			if (userSelectedType == 'R') {																			//	사용자가 도로명 주소를 선택한 경우
				var address				=	data.roadAddress;
			} else {																								//	사용자가 지번 주소를 선택한 경우
				var address				=	data.jibunAddress;
			}

			/*document.getElementById('userSido').value				=	data.sido;
			document.getElementById('userSigungu').value			=	data.sigungu;
*/
			document.getElementById('zip').value					=	data.zonecode;
			document.getElementById('addr1').value				=	address;
			document.getElementById('addr2').focus();
			//getXY(address);
		}
	}).open();
}




// :: 결제하기 졸졸이 따라다니는 기능 스크립트
setTimeout( function(){ 

    $(document).ready(function() {

    	$(window).scroll(function() {
        
    		// :: 졸졸이의 기능이 활성화 되어 올라갈 수 있는 최대 한계치.
    		var limitTop = $(".section .mainTitle").offset().top;
        
    		// :: 현재 화면 스크롤 위치값.
    		var scrollTop = $(window).scrollTop();
        
    		// :: 졸졸이의 유동적인 top 값을 규정.
    		var newPosition = scrollTop + "px";
        
    		//  :: 현재 표시되는 화면의 바텀값.
    		var scrollBottom = $("body").height() - $(window).height() - $(window).scrollTop();
        
    		// :: 페이지 전체 내에서 footer 가 위치하고 있는 높이의 값. 
    		var limitFooter = $('footer').position().top;
        
            // :: 애니메이션 들어간 졸졸이 따라다니는 스크립트. 
    		if(scrollTop > limitTop - 350) {
                $(".separatedRight.rightFloat.innerFloat").css('top', 'auto')
    			$(".separatedRight.rightFloat.innerFloat").stop().animate({
    				"bottom" : scrollBottom - 393
    			}, 500);
    		} 
    		if (scrollBottom < 480) {
                $(".separatedRight.rightFloat.innerFloat").css('top', 'auto')
    			$(".separatedRight.rightFloat.innerFloat").stop().animate({
                    "bottom" : "0"
                    // "top" : "auto"
                    
    			}, 500);
    		}
    	}).scroll();

    });
}  , 1000 );