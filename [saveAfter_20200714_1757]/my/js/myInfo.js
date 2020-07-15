let element_wrap = document.getElementById('wrap');
$(document).ready(function(){
	foldDaumPostcode();
	get_user();

	if(isMobileCheck() == 'N'){
		$('#addrSearch_m').remove();
	} else {
		$('#addrSearch').remove();
	}
});

function foldDaumPostcode() {
	// iframe을 넣은 element를 안보이게 한다.
	element_wrap.style.display = 'none';
}

let tempMobile 				=	'';

function get_user(){
	let token				=	$('input[name="token"]').val();
	let url					=	'/my/event/myInfo_get_user';
	let dataType			=	'json';
	let param				= 	{
		token				:	token
	};
	postService(url, dataType, param, function(data){
		let user 			=	data.user;

		$('input[name="userName"]').val(user.userName);
		$('input[name="userID"]').val(user.userID);
		$('input[name="userZip"]').val(user.userZip);
		$('input[name="userAddr"]').val(user.userAddr)
		$('input[name="userMobile"]').val(user.userMobile);
		tempMobile 				=	user.userMobile;
		$('input[name="userAddrDetail"]').val(user.userAddrDetail);
		$('input[name="userEmail"]').val(user.userEmail);
		if(user.isSMS == 1){
			$("input[name='isSMS']").prop("checked", true);
		}
		if(user.isEmail == 1){
			$("input[name='isEmail']").prop("checked", true);
		}
	});
}

// 정기배송정보 수정
function update_regularInfo(){
	let isRegular 			=	$('input[name="isRegular"]');
	let monthPeriod	 		=	$('input[name="monthPeriod"]');
	let receiveZip 			=	$('input[name="receiveZip"]');
	let receiveAddrDetail	=	$('input[name="receiveAddrDetail"]');
	let bankName	 		=	$('input[name="bankName"]');
	let bankAccountNum 		=	$('input[name="bankAccountNum"]');

	if(isRegular == 1){
		if(!monthPeriod.val().trim()){
			alert('정기배송 이용기간을 선택해주세요.');
			$('#monthPeriod3').focus();
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
		if(!bankName.val().trim()){
			alert('은행을 선택헤주세요.');
			$('#bankSel').focus();
			return;
		}
		if(!bankAccountNum.val().trim()){
			alert('계좌번호를 입력해주세요.');
			bankAccountNum.focus();
			return;
		}
	}

	if(confirm('수정하시겠습니까?')){
		let form				=   document.querySelector("#frm");
		let postData			=   new FormData(form);

		let url					=	'/my/event/myRegular_update_regularInfo';
		let dataType			=	'json';
		let param				= 	postData;
		let formType			=	1;
		postService(url, dataType, param, '', formType);
	}
}

// 정기배송상품 삭제
function delete_regular(){
	let regularCode 				=	[]
	$('input:checkbox[name="code[]"]').each(function() {
		if(this.checked){								//checked 처리된 항목의 값
			regularCode.push(this.value);
		}
	});

	if(!regularCode.length){
		alert('삭제할 상품을 선택해주세요.');
		return;
	}

	if(confirm('선택한 상품을 삭제하시겠습니까?')){
		let url 					=	'/my/event/myRegular_delete_regularProduct';
		let dataType 				=	'json';
		let param 					=	{
			regularProductCode 		:	regularCode
		}
		postService(url, dataType, param, '', '');
	}
}

let mobileCheck					=	0;		//모바일 인증하기
let re_mobileCheck				=	0;		//모바일 인증 메시지 재 발송
let mobileCheckNum_confirm		=	0;		//모바일 인증번호 완료
function complete_mobileCode(){
	let userMobile		=	$('input[name="userMobile"]');
	let mobileCheckNum	=	$('input[name="mobileCheckNum"]');


	if(mobileCheckNum_confirm){
		return;
	}

	if(!mobileCheck){
		alert('핸드폰 번호 입력 후 인증하기를 진행해주세요.');
		userMobile.focus();
		return;
	}

	if(!userMobile.val().trim()){
		mobileCheck		=	0;
		alert('핸드폰 번호를 재 입력하신 후 인증하기를 다시 시도해주세요.');
		userMobile.focus();
		return;
	}

	if(!mobileCheckNum.val().trim()){
		alert('제한 시간 내에 인증번호를 입력해주세요.');
		mobileCheckNum.focus();
		return;
	}

	let url					=	'/intro/event/join_check_mobileCode';
	let dataType			=	'json';
	let param				= 	{
		userMobile				:	userMobile.val(),
		mobileCheckNum			:	mobileCheckNum.val()
	};

	postService(url, dataType, param, function(data){
		let errMsg			=	data.errMsg;

		userMobile.prop('readonly', true);
		mobileCheckNum.prop('readonly', true);

		mobileCheck			=	1;
		re_mobileCheck		=	1;
		mobileCheckNum_confirm		=	1;
		//stop_timer();
		alert(errMsg);

	});
}

function codeCheckAll(){
	$("input[name='code[]']").prop("checked", true);
}
//인증하기
function send_mobileCode(){
	let userMobile		=	$('input[name="userMobile"]');

	if(mobileCheckNum_confirm){
		return;
	}

	if(re_mobileCheck){
		if(!confirm('이미 인증번호가 발송되었습니다. 재발송하시겠습니까?')) {
			return;
		}
	}

	if(!userMobile.val().trim()){
		alert('핸드폰 번호를 입력해주세요.');
		userMobile.focus();
		return;
	}

	//핸드폰 번호 정규화
	if(!isPhone(userMobile.val())){
		alert('핸드폰 번호가 올바르지 않습니다.');
		userMobile.focus();
		return;
	}

	let url					=	'/intro/event/join_set_mobileCode';
	let dataType			=	'json';
	let param				= 	{
		userMobile				:	userMobile.val()
	};

	postService(url, dataType, param, function(data){
		let isUse			=	data.isUse;
		let msg				=	data.errMsg;
		let checkNum		=	data.checkNum;

		alert(msg);
		if(isUse){
			$('input[name="mobileCheckNum"]').val(checkNum);
			re_mobileCheck		=	1;
			//start_timer();
			mobileCheck			=	1;
		} else {
			mobileCheck			=	0;
		}
	});

}

// 정기배송정보 수정
function update_user(){
	let userName 			=	$('input[name="userName"]');
	let userZip	 			=	$('input[name="userZip"]');
	let userAddrDetail 		=	$('input[name="userAddrDetail"]');
	let userEmail			=	$('input[name="userEmail"]');
	let userPWD				=	$('input[name="userPWD"]');
	let userMobile 			=	$('input[name="userMobile"]');
	let re_userPWD			=	$('input[name="re_userPWD"]');
	if(!userName.val().trim()){
		alert('정기배송 이용기간을 선택해주세요.');
		$('#userName').focus();
		return;
	}
	if(!userZip.val().trim()){
		alert('주소를 입력해주세요.');
		userZip.focus();
		return;
	}
	if(!userAddrDetail.val().trim()){
		alert('상세주소를 입력해주세요.');
		userAddrDetail.focus();
		return;
	}
	if(!userEmail.val().trim()){
		alert('은행을 선택헤주세요.');
		userEmail.focus();
		return;
	}

	if(userPWD.val().trim()){
		if(!userPWD.val().trim()){
			alert('비밀번호를 입력해주세요.');
			userPWD.focus();
			return;
		}

		if(userPWD.val().length < 4){
			alert('비밀번호는 4글자 이상 입력해주세요.');
			userPWD.focus();
			return;
		}

		if(!re_userPWD.val().trim()){
			alert('비밀번호 확인을 입력해주세요.');
			re_userPWD.focus();
			return;
		}

		if(userPWD.val() != re_userPWD.val()){
			alert('비밀번호가 일치하지 않습니다.');
			re_userPWD.focus();
			return;
		}

	}

	if(tempMobile != userMobile.val()){
		if(!mobileCheck){
			alert('핸드폰 번호 인증하기를 진행해주세요.');
			return;
		}

		if(!mobileCheckNum_confirm){
			alert('핸드폰 번호 인증을 완료해주세요.');
			return;
		}
	}

	if(confirm('수정하시겠습니까?')){
		let form				=   document.querySelector("#frm");
		let postData			=   new FormData(form);

		let url					=	'/my/event/myInfo_update_user';
		let dataType			=	'json';
		let param				= 	postData;
		let formType			=	1;
		postService(url, dataType, param, '', formType);
	}
}

