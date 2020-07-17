let element_wrap = document.getElementById('wrap');
$(document).ready(function(){
	get_regular();
	foldDaumPostcode();
	let BillKey 				=	$('input[name="BillKey"]').val();
	if(BillKey.trim()){
		$('#processStr').html('결제하기');
	}

	/*if(isMobileCheck() == 'N'){
		$('#addrSearch_m').remove();
	} else {
		$('#addrSearch').remove();
	}*/
});

function foldDaumPostcode() {
	// iframe을 넣은 element를 안보이게 한다.
	element_wrap.style.display = 'none';
}

function get_regular(){
	$('#regularList').html('');

	let token				=	$('input[name="token"]').val();

	let url					=	'/my/event/myRegular_get_regular';
	let dataType			=	'json';
	let param				= 	{
		token				:	token
	};
	postService(url, dataType, param, function(data){
		let userData 		=	data.userData;
		let info 			=	data.regularInfo;
		let merchantID 		=	data.merchantID;
		let payDate 		=	data.payDate;
		let deliveryDate 	=	data.deliveryDate;
		let str				=	'';
		// 관리자가 제어중일 경우 해제 우선 금지
		$('#corpPayInfo').html('* 매달 결제일은 '+payDate+'일, 배송일은 '+deliveryDate+'일 입니다.');
		if(userData.isOrgRegular == 1 || userData.isOrgRegular == 2){
			$('#regularStr').remove();
		}

		if(userData.isRegular != 1){
			$('#regularStr').html('신청하기');
		}

		$('input[name="isRegular"]').val(userData.isRegular);
		$('input[name="isOrgRegular"]').val(userData.isOrgRegular);				//0 또는 3일 경우에만 제어 가능

		if(info){
			$('input[name="receiveZip"]').val(info.receiveZip);					//우편번호
			$('input[name="receiveAddr"]').val(info.receiveAddr);					//주소1
			$('input[name="receiveAddrDetail"]').val(info.receiveAddrDetail);		//주소2\
			$('input[name="ordererName"]').val(info.ordererName);
			$('input[name="startDate"]').val(info.startDate);
			$('input[name="ordererMobile"]').val(info.ordererMobile);					//연락처
			$('input[name="ordererEmail"]').val(info.ordererEmail);
			$('input[name="deliveryMsg"]').val(info.deliveryMsg);

			let noPayStr 						=	'';
			if(info.payMethod > 0 && userData.isOrgRegular != 2){
				if(info.payMethod == 1){
					$('#payName').html(info.CardName);
					$('#payNum').html(info.CardNo);
				} else if(info.payMethod == 2){
					$('#payName').html(info.AccountBank +' (예금주명 : '+info.AccountName+')');
					$('#payNum').html(info.AccountNo);
				}
				$('#noPayInfo').addClass('hide');
			}
			else {
				$('#payInfo').addClass('hide');
				if(userData.isOrgRegular == 2){
					$('#noPayInfoStr').html('등록된 결제수단이 미승인 상태입니다. 관리자에게 문의해주세요.');
					$('#payButton').remove();
				}
			}

			if(userData.isOrgRegular == 1 || userData.isOrgRegular == 2){
				$("input[name='checkOrg']").prop("checked", true);
			}
		} else {
			$('input[name="receiveZip"]').val(userData.userZip);					//우편번호
			$('input[name="receiveAddr"]').val(userData.userAddr);					//주소1
			$('input[name="receiveAddrDetail"]').val(userData.userAddrDetail);		//주소2
			$('input[name="ordererName"]').val(userData.userName);
			$('input[name="ordererMobile"]').val(userData.userMobile);					//연락처
			$('input[name="ordererEmail"]').val(userData.userEmail);
			$('#payInfo').hide();
		}

	});
}

// 결제정보 삭제
function delete_payMethod(){

	if($('input[name="isOrgRegular"]').val() == 1 || $('input[name="isOrgRegular"]').val() == 2){
		alert('관리자가 인증한 결제수단입니다. 관리자에게 관리해제를 요청해주세요.');
		return;
	}

	if(confirm('삭제하시겠습니까?')){
		let url 					=	'/my/event/myRegular_update_regularInfo';
		let dataType 				=	'json';
		let param 					=	{
			userCode 				:	$('input[name="userCode"]').val(),
			payInfoDel 				:	'Y'
		}
		postService(url, dataType, param, '', '');
	}
}

// 해지 또는 등록하기
function update_isRegular(){
	let isRegular 			=	$('input[name="isRegular"]').val();
	let ordererName 		=	$('input[name="ordererName"]');
	let ordererMobile 		=	$('input[name="ordererMobile"]');
	let receiveZip 			=	$('input[name="receiveZip"]');
	let receiveAddrDetail	=	$('input[name="receiveAddrDetail"]');
	let receiveAddr 		=	$('input[name="receiveAddr"]');
	let ordererEmail 		=	$('input[name="ordererEmail"]');
	let deliveryMsg 		=	$('input[name="deliveryMsg"]');

	if(isRegular != 1){
		if(!ordererName.val().trim()){
			alert('구매자 이름을 입력해주세요.');
			ordererName.focus();
			return;
		}
		if(!ordererMobile.val().trim()){
			alert('구매자 연락처를 입력해주세요.');
			ordererMobile.focus();
			return;
		}

		if(!receiveZip.val().trim()){
			alert('주소를 입력해주세요.');
			receiveZip.focus();
			return;
		}
		if(!receiveAddrDetail.val().trim()){
			alert('상세주소를 입력해주세요.');
			receiveAddrDetail.focus();
			return;
		}
	}
	let str 						=	'정기회원을 신청하시겠습니까?';
	if(isRegular == 1){
		if($('input[name="isOrgRegular"]').val() == 1 || $('input[name="isOrgRegular"]').val() == 2){
			alert('관리자가 인증한 결제수단입니다. 관리자에게 관리해제를 요청해주세요.');
			return;
		}
		str 						=	'정기회원을 해지하시겠습니까?';
	}

	if(confirm(str)){
		let url 					=	'/my/event/myRegular_update_isRegular';
		let dataType 				=	'json';
		let param 					=	{
			userCode 				:	$('input[name="userCode"]').val()
		}
		postService(url, dataType, param, '', '');
	}
}

// 정기배송정보 수정
function set_regularInfo(){
	let ordererName 		=	$('input[name="ordererName"]');
	let ordererMobile 		=	$('input[name="ordererMobile"]');
	let receiveZip 			=	$('input[name="receiveZip"]');
	let receiveAddrDetail	=	$('input[name="receiveAddrDetail"]');
	let receiveAddr 		=	$('input[name="receiveAddr"]');
	let ordererEmail 		=	$('input[name="ordererEmail"]');
	let deliveryMsg 		=	$('input[name="deliveryMsg"]');

	if(!ordererName.val().trim()){
		alert('구매자 이름을 입력해주세요.');
		ordererName.focus();
		return;
	}
	if(!ordererMobile.val().trim()){
		alert('구매자 연락처를 입력해주세요.');
		ordererMobile.focus();
		return;
	}

	if(!receiveZip.val().trim()){
		alert('주소를 입력해주세요.');
		receiveZip.focus();
		return;
	}
	if(!receiveAddrDetail.val().trim()){
		alert('상세주소를 입력해주세요.');
		receiveAddrDetail.focus();
		return;
	}

	if(confirm('수정하시겠습니까?')){
		let url 					=	'/my/event/myRegular_update_regularInfo';
		let dataType 				=	'json';
		let param 					=	{
			userCode 				:	$('input[name="userCode"]').val(),
			ordererName 			:	ordererName.val(),
			ordererMobile			:	ordererMobile.val(),
			receiveZip 				:	receiveZip.val(),
			receiveAddr 			:	receiveAddr.val(),
			receiveAddrDetail 		:	receiveAddrDetail.val(),
			ordererEmail 			:	ordererEmail.val(),
			deliveryMsg 			:	deliveryMsg.val()
		}
		postService(url, dataType, param, '', '');
	}
}

// 사용자 빌키 받기
function keyRequest(){

	let CardNo 				=	$('input[name="CardNo"]');
	let ExpMonth 			=	$('input[name="ExpMonth"]');
	let ExpYear 			=	$('input[name="ExpYear"]');
	let IDNo 				=	$('input[name="IDNo"]');
	let CardPw 				=	$('input[name="CardPw"]');

	if(!CardNo.val().trim()){
		alert('카드번호를 입력해주세요.');
		CardNo.focus();
		return;
	}
	if(!ExpMonth.val().trim()){
		alert('유효기간(월)을 입력해주세요.');
		ExpMonth.focus();
		return;
	}
	if(!ExpYear.val().trim()){
		alert('유효기간(년)을 입력해주세요.');
		ExpYear.focus();
		return;
	}
	if(!IDNo.val().trim()){
		alert('생년월일 또는 사업자번호를 입력해주세요.');
		IDNo.focus();
		return;
	}
	if(!CardPw.val().trim()){
		alert('비밀번호를 입력해주세요.');
		CardPw.focus();
		return;
	}

	let url 				=	'/my/event/myRegular_get_BillKey';
	let dataType 			=	'json';
	let param 				=	{
		payMethod 			:	$('input[name="payMethod"]').val(),
		CardNo 				:	$('input[name="CardNo"]').val(),
		ExpMonth 			:	$('input[name="ExpMonth"]').val(),
		ExpYear 			:	$('input[name="ExpYear"]').val(),
		IDNo 				:	$('input[name="IDNo"]').val(),
		CardPw 				:	$('input[name="CardPw"]').val()
	};

	postService(url, dataType, param, function(data){
		let isSuccess 		=	data.isSuccess;
		let result			=	data.result;
		if(isSuccess == 1){
			$('#payName').html(result.CardName);
			$('#payNum').html(result.CardNo);
			$('#noPayInfo').addClass('hide');
			$('#payInfo').removeClass('hide');
			alert('인증이 완료되었습니다.');
			$('.popup').hide();
			$('.container').removeClass('overlay');
		}
	});
}


function setBankName(val, no){
	$('#bankName').html(val);
	$('input[name="AccountBank"]').val(val);
	$('input[name="AccountBankNo"]').val(no);
}


function bankRequest(){
	let checkOrg 			=	0;
	let payMethod 			=	$('input[name="payMethod"]');
	let AccountBank 		=	$('input[name="AccountBank"]');
	let AccountBankNo 		=	$('input[name="AccountBankNo"]');
	let AccountNo 			=	$('input[name="AccountNo"]');
	let AccountName 		=	$('input[name="AccountName"]');
	let idNo 				=	$('input[name="bank_IDNo"]');
	let HPNo 				=	$('input[name="HPNo"]');

	if(!AccountBank.val().trim()){
		alert('은행을 선택해주세요.');
		$('#bankName').focus();
		return;
	}
	if(!AccountNo.val().trim()){
		alert('계좌번호를 입력해주세요.');
		AccountNo.focus();
		return;
	}
	if(!AccountName.val().trim()){
		alert('예금주명을 입력해주세요.');
		AccountName.focus();
		return;
	}
	if(!idNo.val().trim()){
		alert('예금주 생년월일 앞 6자리 또는 사업자 번호 10자리를 입력해주세요.');
		idNo.focus();
		return;
	}
	if(!HPNo.val().trim()){
		alert('예금주 전화번호를 입력해주세요.');
		HPNo.focus();
		return;
	}
	if($("input:checkbox[name='checkOrg']").is(":checked") == true){
		checkOrg 			=	1;
	}

	 url 					=	'/my/event/myRegular_set_bank';

	let dataType 			=	'json';
	let param 				=	{
		userCode 			:	$('input[name="userCode"]').val(),
		payMethod 			:	2,
		AccountBank 		:	$('input[name="AccountBank"]').val(),
		AccountBankNo 	 	:	$('input[name="AccountBankNo"]').val(),
		AccountNo 			:	$('input[name="AccountNo"]').val(),
		AccountName 		:	$('input[name="AccountName"]').val(),
		IDNo 				:	$('input[name="bank_IDNo"]').val(),
		HPNo 				:	$('input[name="HPNo"]').val(),
		checkOrg 			:	checkOrg
	};

	postService(url, dataType, param, function(data){
		let isSuccess 		=	data.isSuccess;
		let result			=	data.result;
		let alertMsg 		=	data.alertMsg;
		if(isSuccess == 1){
			alert(alertMsg);
			location.reload();
		}
	});
}



/*
$(document).on('click', '.certInfoBox .btn.regSort', function(){
	if($('input[name="isOrgRegular"]').val() == 1 || $('input[name="isOrgRegular"]').val() == 2){
		alert('관리자가 인증한 결제수단입니다. 관리자에게 관리해제를 요청해주세요.');
		return;
	} else {
		$('.popup.regCard').show();
		$('.container').addClass('overlay');
	}
});*/

$(document).on('click', '.certInfoBox .btn.regSort', function(){
	if($('input[name="isOrgRegular"]').val() == 1 || $('input[name="isOrgRegular"]').val() == 2){
		alert('관리자가 인증한 결제수단입니다. 관리자에게 관리해제를 요청해주세요.');
		return;
	}
	else {
		$('.popup.regCard').show();
		$('.container').addClass('overlay');

        // :: 팝업창 오픈 시, 현재 보고 있는 화면 위치에 표시하는 스크립트.
        
        if (window.matchMedia("(max-width: 800px)").matches){
		    $('.popup.regCard').css({
		    	"top": (($(window).height()-$('.popup.regCard').outerHeight())/2+$(window).scrollTop())+"px",
		    	"left": (($(window).width()-$('.popup.regCard').outerWidth())/2+$(window).scrollLeft())+"px"
            });
        };


	}
});

// :: 팝업창에서 카드결제/계좌이체 선택.
function setPay_1() {
	$('input[name="payMethod"]').val(1);
	$('.useSelector.popupSort .plainBtn.cardMod').parent('li').addClass('activated');
	$('.useSelector.popupSort .plainBtn.bankMod').parent('li').removeClass('activated');
	$('.regInfoList.payTypeSort.cardMod').removeClass('hide');
	$('.regInfoList.payTypeSort.bankMod').addClass('hide');
}
function setPay_2() {
	$('input[name="payMethod"]').val(2);
	$('.useSelector.popupSort .plainBtn.bankMod').parent('li').addClass('activated');
	$('.useSelector.popupSort .plainBtn.cardMod').parent('li').removeClass('activated');
	$('.regInfoList.payTypeSort.bankMod').removeClass('hide');
	$('.regInfoList.payTypeSort.cardMod').addClass('hide');

}
