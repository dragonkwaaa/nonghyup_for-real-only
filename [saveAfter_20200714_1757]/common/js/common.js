/**
 * 전체 선택
 * 해당 체크박스가 속한 테이블의 하위 바디에 존재하는 모든 체크박스 선택 및 해제
 */
/*$(document).on('change', '#allCheck', function(){
	let table			=	$(this).closest('table');
	let tbody			=	table.find('tbody');

	if($(this).prop('checked')){
		tbody.find('input[type="checkbox"]').prop("checked",true);
	} else {
		tbody.find('input[type="checkbox"]').prop("checked",false);
	}
});*/

function toggleCheckAll(button)
{
	var sa						=	true;
	var frm						=	document.frm;
	if ( button.checked ) sa	=	false;
	for (var i = 0; i < frm.elements.length; i++ )
	{
		var e					=	frm.elements[i];
		if ( sa ) e.checked		=	false;
		else e.checked			=	true;
	}
	if ( sa ) button.checked	=	false;
	else button.checked			=	true;
}


// 전체선택 (button)
function checkAll(){
	$("input[name='code[]']").prop("checked", true);
}

// 전체선택해제 (button)
function checkNone(){
	$("input[name='code[]']").prop("checked", false);
}


// Arguments :
//  verb : 'GET'|'POST'
//  target : an optional opening target (a name, or "_blank"), defaults to "_self"
var windowOpen = function(verb, url, data, target) {
	var form = document.createElement("form");
	form.action = url;
	form.method = verb;
	form.target = target || "_self";
	if (data) {
	  for (var key in data) {
		var input = document.createElement("textarea");
		input.name = key;
		input.value = typeof data[key] === "object" ? JSON.stringify(data[key]) : data[key];
		form.appendChild(input);
	  }
	}
	form.style.display = 'none';
	document.body.appendChild(form);
	form.submit();
  };

/**
 * 브라우저별 즐겨찾기 추가
 * @param {Array} e 버튼
 */
function addBoookMark(e){
	var bookmarkURL = window.location.href;
    var bookmarkTitle = document.title;
    var triggerDefault = false;

    if (window.sidebar && window.sidebar.addPanel) {
        // Firefox version < 23
        window.sidebar.addPanel(bookmarkTitle, bookmarkURL, '');
    } else if ((window.sidebar && (navigator.userAgent.toLowerCase().indexOf('firefox') > -1)) || (window.opera && window.print)) {
        // Firefox version >= 23 and Opera Hotlist
        var $this = $(this);
        $this.attr('href', bookmarkURL);
        $this.attr('title', bookmarkTitle);
        $this.attr('rel', 'sidebar');
        $this.off(e);
        triggerDefault = true;
    } else if (window.external && ('AddFavorite' in window.external)) {
        // IE Favorite
        window.external.AddFavorite(bookmarkURL, bookmarkTitle);
    } else {
        // WebKit - Safari/Chrome
        alert((navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') + '+D 키를 눌러 즐겨찾기에 등록하실 수 있습니다.');
    }

    return triggerDefault;
}
/**
 * 페이징
 * @param {int} recordPerPage 		//한 페이지당 최대 게시글 개수
 * @param {int} pnoPerPage 			//한 페이지당 최대 페이지번호
 * @param {int} pno 				//현재 페이지
 * @param {int} totalCount 			//전체 게시물
 * @param {string} target
 */
function setPaging(recordPerPage, pnoPerPage, pno, totalCount, type){

	pno						=	Number(pno)	?	Number(pno)	:	1;
	let total_page			=	Math.ceil(totalCount / recordPerPage);
	let total_block			=	Math.ceil(total_page / pnoPerPage);
	let now_block			=	Math.ceil(pno / pnoPerPage);
	let first_page			=	((now_block - 1) * pnoPerPage) + 1;
	let last_page			=	Math.min(total_page, now_block * pnoPerPage);
	let prev_page			=	pno - 1;
	let next_page			=	pno + 1;
	let prev_block			=	now_block - 1;
	let next_block			=	now_block + 1;
	let prev_block_page		=	prev_block * pnoPerPage;
	let next_block_page		=	next_block * pnoPerPage - (pnoPerPage - 1);
	let str					=	'';
	type					=	type	?	type	:	'';
	/*if(prev_block > 0){
		str					+=	'<li>';
		str					+=	'<a href="javascript:movePage(1)" class="pagingPrev"></a>';
		str					+=	'</li>';
	}*/
	if(prev_page > 0){
		str					+=	'<li>';
		str					+=	'	<a href="javascript:movePage'+type+'('+prev_page+')" class="pagingPrev"></a>';
		str					+=	'</li>';
	}
	for(i = first_page; i <= last_page; i++){
		if(i == pno){
			str				+=	'<li class="on">';
			str				+=	'<a href="javascript:void(0);" class="on">'+i+'</a>';
			str				+=	'</li>';
		} else {
			str				+=	'<li class="pageNum">';
			str				+=	'<a href="javascript:movePage'+type+'('+i+')">'+i+'</a>';
			str				+=	'</li>';
		}
	}
	if(next_page <= total_page){
		str					+=	'<li>';
		str					+=	'	<a href="javascript:movePage'+type+'('+next_page+')" class="pagingNext"></a>';
		str					+=	'</li>';
	}
	/*if(next_block <= total_block){
		str					+=	'<li class="end arrow">';
		str					+=	'	<a href="javascript:movePage('+total_page+')"></a>';
		str					+=	'</li>';
	}*/


	if(type){
		$('#pagingGroup'+type).html(str);
	} else {
		$('.pagingGroup').html(str);
	}
}
/*function setPaging(recordPerPage, pnoPerPage, pno, totalCount, type = ''){

	pno						=	Number(pno)	?	Number(pno)	:	1;
	let total_page			=	Math.ceil(totalCount / recordPerPage);		//총 게시물 수
	let total_block			=	Math.ceil(total_page / pnoPerPage);
	let now_block			=	Math.ceil(pno / pnoPerPage);
	let first_page			=	((now_block - 1) * pnoPerPage) + 1;
	let last_page			=	Math.min(total_page, now_block * pnoPerPage);
	let prev_page			=	pno - 1;
	let next_page			=	pno + 1;
	let prev_block			=	now_block - 1;
	let next_block			=	now_block + 1;
	let prev_block_page		=	prev_block * pnoPerPage;
	let next_block_page		=	next_block * pnoPerPage - (pnoPerPage - 1);
	let str					=	'';

	/!*if(prev_block > 0){
		str					+=	'<li>';
		str					+=	'<a href="javascript:movePage(1)" class="pagingPrev"></a>';
		str					+=	'</li>';
	}*!/
	if(prev_page > 0){
		str					+=	'<li>';
		str					+=	'	<a href="javascript:movePage'+type+'('+prev_page+')" class="pagingPrev"></a>';
		str					+=	'</li>';
	}
	for(i = first_page; i <= last_page; i++){
		if(i == pno){
			str				+=	'<li class="on">';
			str				+=	'<a href="javascript:void(0);" class="on">'+i+'</a>';
			str				+=	'</li>';
		} else {
			str				+=	'<li class="pageNum">';
			str				+=	'<a href="javascript:movePage'+type+'('+i+')">'+i+'</a>';
			str				+=	'</li>';
		}
	}
	if(next_page <= total_page){
		str					+=	'<li>';
		str					+=	'	<a href="javascript:movePage'+type+'('+next_page+')" class="pagingNext"></a>';
		str					+=	'</li>';
	}
	/!*if(next_block <= total_block){
		str					+=	'<li class="end arrow">';
		str					+=	'	<a href="javascript:movePage('+total_page+')"></a>';
		str					+=	'</li>';
	}*!/


	if(type){
		$('#pagingGroup'+type).html(str);
	} else {
		$('.pagingGroup').html(str);
	}
}*/
/**
 *
 * @param name
 * @param value
 * @param days
 * @returns
 */
function setCookie(name,value,days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

/**
 *
 * @param name
 * @returns
 */
function getCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

/**
 *	셀렉트박스 선택 값 전달
 * @param e
 */
function sboxSelect(e){
	var value			=	$(e).data('value');
	var target			=	$(e).data('target');

	$('#'+target).val(value);
}

/**
 * trim 함수
 *
 * @param val
 * @returns
 */
function trim(val){
	return val.replace(/(^\s*)|(\s*$)/gi, "");
}

/**
 * textarea 데이터: \n -> <br />
 * @param textAreaData
 * @returns
 */
function nlToBr(textAreaData) {
	if(textAreaData != undefined && textAreaData.length > 0) {
		return textAreaData.replace(/\n/gi, "<br />");
	}
}


/**
 * 날짜 포멧으로 변환(yyyy-MM-dd)
 *
 * @param str
 * @returns
 */
function setDateFormat(str) {
	if(str != null && str.length == 8) {
		return str.substring(0, 4) + "-" + str.substring(4, 6) + "-" + str.substring(6);
	}
	return isNullChangeStr(str,'');
}


/**
 * 금액 포멧에서 ','제거
 *
 * @param str
 * @returns
 */
function removeCommas(str) {
	return str.replace(/,/gi, "");
}

/**
 * 금액 포멧에서 '-'제거
 *
 * @param str
 * @returns
 */
function removeHyphen(str) {
	return str.replace(/-/gi, "");
}

/**
 * 숫자 세자리 단위 마다 콤마
 *
 * @param x
 * @returns
 */
function numberWithCommas(x) {

	if( undefined == x || null == x || '' == x) return x;

	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


// input 숫자만 입력

$(document).on('keyup change', '.onlyNum', function () {
	this.value = this.value.replace(/[^0-9]/g, '');
});

// input 콤마

$(document).on('keyup change', '.onlyComma', function () {
	var str = this.value = this.value.replace(/[^0-9]/g, '');
	this.value = str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
});


/**
 * 숫자 세자리 단위 마타 콤마 (KeyPress)
 * onkeyup="setNumberWithCommasKeyUp(this)"/
 */
function setNumberWithCommasKeyUp(obj) {
	obj.value = numberWithCommas(removeCommas(obj.value)); //콤마 찍기
}

function checkIP(strIP) {
	var expUrl = /^(1|2)?\d?\d([.](1|2)?\d?\d){3}$/;
	return expUrl.test(strIP);
}

function emailCheck(email) {
	var patten = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

	if (!patten.test(email)) {
		return false;
	}
	return true;
}


/**
 * when ajax call error
 */
function doAjaxError(err){
	doubleSubmitFlag    =   false;
	alert("error = " + err.status);
}

/**
 * 중복서브밋 방지
 *
 * @returns {Boolean}
 */
var doubleSubmitFlag = false;
function doubleSubmitCheck(){
	if(doubleSubmitFlag){
		return doubleSubmitFlag;
	}else{
		doubleSubmitFlag = true;
		return false;
	}
}

/**
 * 전화번호 포맷 변경
 * @param num
 * @returns
 */
function phone_format(num) {
	if(null == num){
		return "";
	}
	var formatNum = '';

	if(num.length==11){
		formatNum = num.replace(/(\d{3})(\d{4})(\d{4})/, '$1-$2-$3');
	}else if(num.length==8){
		formatNum = num.replace(/(\d{4})(\d{4})/, '$1-$2');
	}else{
		if(num.indexOf('02')==0){
			if(num.length==9){
				formatNum = num.replace(/(\d{2})(\d{3})(\d{4})/, '$1-$2-$3');
			}
			else{
				formatNum = num.replace(/(\d{2})(\d{4})(\d{4})/, '$1-$2-$3');
			}
		}else{
			formatNum = num.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
		}
	}
	return formatNum;
	//return num.replace(/(^02.{0}|^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/,"$1-$2-$3");
}

/**
 * 숫자만 입력
 * onkeydown="return setNumberOnKeyDown(event)"/
 * class="ime-mode" 필수
 */
function setNumberOnKeyDown(evt) {
	var code = evt.which ? evt.which : event.keyCode;

	//Backspace || Delete || Tab || ESC || Enter || F5
	if (code == 46 || code == 8 || code == 9 || code == 27 || code == 13 || code == 116
			// Ctrl + A , C , X , V
			|| (evt.ctrlKey === true && (code == 65 || code == 67 || code == 86 || code == 88))
			// PageUp ~ ArrowKey
			|| (code >= 33 && code <= 39)
			// 0 ~ 9 || KeyPad 0 ~ 9
			|| (code >= 48 && code <= 57) || (code >= 96 && code <= 105)) {
		return;
	}

	return false;
}


/**
 * 숫자 및 [-]
 * onkeydown="return setMinusNumberOnKeyDown(event)"/
 * @param evt
 * @returns {Boolean}
 */
function setMinusNumberOnKeyDown(evt){

	var code = evt.which ? evt.which : event.keyCode;

	//Backspace || Delete || Tab || ESC || Enter || F5
	if (code == 46 || code == 8 || code == 9 || code == 27 || code == 13 || code == 116
			// Ctrl + A , C , X , V
			|| (evt.ctrlKey === true && (code == 65 || code == 67 || code == 86 || code == 88))
			// PageUp ~ ArrowKey
			|| (code >= 33 && code <= 39) || code == 109 || code == 189
			// 0 ~ 9 || KeyPad 0 ~ 9
			|| (code >= 48 && code <= 57) || (code >= 96 && code <= 105)) {

		return;
	}

	return false;
}


/**
 * 숫자 및 [.]
 * onkeydown="return setPeriodNumberOnKeyDown(event)"/
 * class="ime-mode" 필수
 * @param evt
 * @returns {Boolean}
 */
function setPeriodNumberOnKeyDown(evt){
	var code = evt.which ? evt.which : event.keyCode;

	//Backspace || Delete || Tab || ESC || Enter || F5
	if (code == 46 || code == 8 || code == 9 || code == 27 || code == 13 || code == 116
			// Ctrl + A , C , X , V
			|| (evt.ctrlKey === true && (code == 65 || code == 67 || code == 86 || code == 88))
			// PageUp ~ ArrowKey
			|| (code >= 33 && code <= 39) || code == 110 || code == 190
			// 0 ~ 9 || KeyPad 0 ~ 9
			|| (code >= 48 && code <= 57) || (code >= 96 && code <= 105)) {
		return;
	}

	return false;
}


/**
 * 영어와 숫자만 입력
 * onkeydown="return setEngNumOnKeyDown(event)"/
 * @param evt
 * @returns {Boolean}
 */
function setEngNumOnKeyDown(evt)
{
	var code = evt.which ? evt.which : event.keyCode;

	//Backspace || Delete || Tab || ESC || Enter || F5
	if (code == 46 || code == 8 || code == 9 || code == 27 || code == 13 || code == 116
			// Ctrl + A , C , X , V
			|| (evt.ctrlKey === true && (code == 65 || code == 67 || code == 86 || code == 88))
			// PageUp ~ ArrowKey
			|| (code >= 33 && code <= 39) || code == 109 || code == 189
			// 0 ~ 9 || KeyPad 0 ~ 9
			|| (code >= 48 && code <= 57) || (code >= 96 && code <= 105)
			|| (code >= 65 && code <= 90) || (code >= 97 && code <= 122)) {
		return;
	}

	return false;
}


/**
 * 텍스트 바이트 가져오기
 * @param s
 * @returns {Number}
 */
function getByteLength(s) {

	if (s == null || s.length == 0) {
		return 0;
	}
	var size = 0;

	for ( var i = 0; i < s.length; i++) {

		if (escape(s.charAt(i)).length > 4) {
			size += 2;
		} else {
			size++;
		}
	}

	return size;
}


/**
 * 텍스트 최대바이트 초과시 substring
 * @param s
 * @param len
 * @returns
 */
function cutByteLength(s, len) {

	if (s == null || s.length == 0) {
		return 0;
	}
	var size = 0;
	var index = s.length;

	for ( var i = 0; i < s.length; i++) {
		if (escape(s.charAt(i)).length > 4) {
			size += 2;
		} else {
			size++;
		}
		if( size == len ) {
			index = i + 1;
			break;
		} else if( size > len ) {
			index = i;
			break;
		}
	}

	return s.substring(0, index);
}

/**
 * 텍스트 최대바이트 초과 키업 이벤트
 * @param obj
 * @param size
 */
function setByteCheckKeyUp(obj, size) {
	var str = new String(obj.val());
	var byte = getByteLength(str);

	if (size < byte) {
		obj.blur();
		obj.val(cutByteLength(str, size));
		obj.focus();
		//setByteCheckKeyUp(obj, size);
	}
}

/**
 * 지정자리 버림 (값, 자릿수)
 */
function Floor(n, pos) {
	var digits = Math.pow(10, pos);

	var num = Math.floor(n * digits) / digits;

//	return num.toFixed(pos);
	return num;
}
/**
 *지정자리 올림 (값, 자릿수)
 */
function Ceiling(n, pos) {
	var digits = Math.pow(10, pos);

	var num = Math.ceil(n * digits) / digits;

	return num;
}

function chkPercent(i) {
	var percent = parseFloat(i);

	if (NaN == percent || 99999 < percent) {
		return false;
	}
	return true;
}



/**
 * Call ajax
 */
function ajax(url, dataType, param, method, formType, gbn, callback, async, ingnoreDuble){
	//showLoading();

	if (undefined === async) {
		async = true;
	}

	if(!ingnoreDuble){
		if(doubleSubmitCheck()) return;
	}

	var ajaxData		= {
		type				:	method,
		url					:	url,
		dataType			:	dataType,
		data				:	param,
		async				:	async,
		success				:	function(data){
			doubleSubmitFlag    =   false;
			//토큰 갱신
			if(data.token){
				$('input[name="token"]').val(data.token);
			}
			if(dataType == 'json'){
				if(method == "GET"){
					data		=	JSON.parse(data);
				}
				var errCd		=	data.errCd;
				var errMsg		=	data.errMsg;

				if(errCd == "-9999"){
					alert("세션이 종료되었습니다. 다시 로그인 하여 주시기 바랍니다.");
					location.href = '/';
					return;
				}

				if(errCd == "-9"){
					alert("에러가 발생하였습니다.\n관리자에게 문의하세요.");
					return;
				}

				if(errCd != 0) {
					var url		=	data.url;
					if(errMsg){
						alert(errMsg);
					}

					if(url){
						if(url == 1){
							location.reload();
						} else {
							location.href	=	url;
						}
					}
					return;
				}

				callback(data , errCd , errMsg);
			} else {
				callback(data);
			}
		},
		error   : doAjaxError
	};

	if(dataType == "json"){
		if(formType == 1){
			ajaxData.contentType			=	false;
			ajaxData.processData			=	false;
		} else {

		}
	} else if(dataType == 'html'){
		if(formType == 1){
			ajaxData.contentType			=	false;
			ajaxData.processData			=	false;
		} else {
			ajaxData.contentType			=	"application/x-www-form-urlencoded; charset=UTF-8";
		}
	}

	ajaxData.responseText;
	$.ajax(ajaxData);
}

/**
 * Call ajax service with POST
 * @param url
 * @param data
 * @param callback
 */
function postService(url, dataType, data, callback, formType, async, ingnoreDuble){
	ajax(url, dataType, data, "POST", formType, "", callback, async, ingnoreDuble);
}

/**
 * Call ajax service With GET
 *
 * @param url
 * @param callback
 */
function getService(url , callback){
	var data = new Object();

	url = encodeURI(url);
	ajax(url , data , "GET" , "" , callback);
}


/**
 * 사업자 번호 포멧으로 변환(xxx-xx-xxxxx)
 * @param str
 * @returns
 */
function setBusiFormat(str) {
	if(str.length == 10) {
		return str.substring(0, 3) + "-" + str.substring(3, 5) + "-" + str.substring(5);
	}
	return str;
}

/**
 *
 * @param name
 * @param value
 * @param days
 * @returns
 */
function setCookie(name,value,days) {
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
/**
 *
 * @param name
 * @returns
 */
function getCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

/**
 * Get Paramter key 로 조회하여 value 를 반환
 * @param paramName
 * @returns
 */
function getParameters(paramName) {
	// 리턴값을 위한 변수 선언
	var returnValue;

	// 현재 URL 가져오기
	var url = location.href;

	// get 파라미터 값을 가져올 수 있는 ? 를 기점으로 slice 한 후 split 으로 나눔
	var parameters = (url.slice(url.indexOf('?') + 1, url.length)).split('&');

	// 나누어진 값의 비교를 통해 paramName 으로 요청된 데이터의 값만 return
	for (var i = 0; i < parameters.length; i++) {
		var varName = parameters[i].split('=')[0];
		if (varName.toUpperCase() == paramName.toUpperCase()) {
			returnValue = parameters[i].split('=')[1];
			return decodeURIComponent(returnValue);
		}
	}
};


// :: 팝업창 오픈 스크립트
function memoPopup(idx, procType) {

	let url 					=	'/setting/event/common_get_managerMemo';
	let dataType 				=	'json';
	let token 					=	$('input[name="token"]').val();
	let param 					=	{
		idx 					:	idx,
		procType 				:	procType,
		token					:	token
	};
	postService(url, dataType, param, function(data){
		let managerMemo 		=	data.managerMemo;
		let str 				=	'';
		str 					+=	'<input type="hidden" name="memoProcType" value="'+procType+'"></input>';
		str 					+=	'<input type="hidden" name="tempIdx" value="'+idx+'"></input>';
		if(managerMemo){
			str 				+=	'<textarea class="memo" name="managerMemo" id="managerMemo">'+managerMemo+'</textarea>';
		} else {
			str 				+=	'<textarea class="memo" name="managerMemo" id="managerMemo"></textarea>';
		}

		$('#memoSel').html(str);
		$('.popup.memoPopup').fadeIn(400);
		$('.contents').addClass('overlay');
	});

}

// :: 팝업창 닫기 스크립트
function closePop(){
	$('.popup').fadeOut(400);
	$('.contents').removeClass('overlay');
	/* scroll_in_able();
	scroll_able(); */
}

/**
 * @date		2019-09-30
 * @author		Heejae Park
 * @detail 		관리자페이지에서 모든 메모 update
 */
function updateMemo(){
	let idx 					=	$('input[name="tempIdx"]').val();
	let managerMemo 			=	$('#managerMemo').val();
	let procType 				=	$('input[name="memoProcType"]').val();

	let token 					=	$('input[name="token"]').val();
	let dataType 				=	'json';
	let url 					=	'/setting/event/common_update_managerMemo';
	let param 					=	{
		managerMemo 			:	managerMemo,
		idx 					:	idx,
		procType 				:	procType,
		token 					:	token
	};
	postService(url, dataType, param, '');
}

function onlyNumber(){

	if((event.keyCode<48)||(event.keyCode>57))

		event.returnValue=false;
}


//날짜 검색시
function setSearchDate(start){

	var num = start.substring(0,1);
	var str = start.substring(1,2);

	var today = new Date();
	var year = today.getYear()+1900;

	//var year = today.getFullYear();
	//var month = today.getMonth() + 1;
	//var day = today.getDate();

	var endDate = $.datepicker.formatDate('yy-mm-dd', today);
	$('#endDate').val(endDate);

	if(str == 'd'){
		today.setDate(today.getDate() - num);
	}else if (str == 'w'){
		today.setDate(today.getDate() - (num*7));
	}else if (str == 'm'){
		today.setMonth(today.getMonth() - num);
		today.setDate(today.getDate() + 1);
	}else if (str == 'y'){
		today.setMonth(today.getYear() - num);
		today.setDate(today.getDate() + 1);
	}

	var startDate = $.datepicker.formatDate('yy-mm-dd', today);
	$('#startDate').val(startDate);

	// 종료일은 시작일 이전 날짜 선택하지 못하도록 비활성화
	$("#endDate").datepicker( "option", "minDate", startDate );

	// 시작일은 종료일 이후 날짜 선택하지 못하도록 비활성화
	$("#startDate").datepicker( "option", "maxDate", endDate );

}


/**
 * 핸드폰 형식 확인
 * @param {string} phoneNum
 */
function isPhone(phoneNum) {
	var regExp =/(01[016789])([1-9]{1}[0-9]{2,3})([0-9]{4})$/;

	var myArray;
	if(regExp.test(phoneNum)){
		return true;
	} else {
		return false;
	}
}

function isMobileCheck(){
	let isMobile 				=	'N'
	if(navigator.platform){
		var filter 			=	'win16|win32|win64|mac';
		if(0 > filter.indexOf(navigator.platform.toLowerCase())){
			isMobile			=	'Y';
			return isMobile;
		} else {
			return isMobile;
		}
	}
}

//주소
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
			document.getElementById('zip').value				=	data.zonecode;
			document.getElementById('addr1').value				=	address;
			document.getElementById('addr2').focus();
			//check_region(data.sido,data.sigungu,data.bname, '', 1);
		}
	}).open();
}

function mobileSearchAddress() {
	// 현재 scroll 위치를 저장해놓는다.
	var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
	new daum.Postcode({
		oncomplete: function(data) {
			// 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

			// 각 주소의 노출 규칙에 따라 주소를 조합한다.
			// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
			var addr = ''; // 주소 변수
			var extraAddr = ''; // 참고항목 변수

			//사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
			if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
				addr = data.roadAddress;
			} else { // 사용자가 지번 주소를 선택했을 경우(J)
				addr = data.jibunAddress;
			}

			// 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
			if(data.userSelectedType === 'R'){
				// 법정동명이 있을 경우 추가한다. (법정리는 제외)
				// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
				if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
					extraAddr += data.bname;
				}
				// 건물명이 있고, 공동주택일 경우 추가한다.
				if(data.buildingName !== '' && data.apartment === 'Y'){
					extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
				}
				// 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
				/*if(extraAddr !== ''){
					extraAddr = ' (' + extraAddr + ')';
				}*/
				// 조합된 참고항목을 해당 필드에 넣는다.
				//document.getElementById("sample3_extraAddress").value = extraAddr;

			} else {
				//document.getElementById("sample3_extraAddress").value = '';
			}

			// 우편번호와 주소 정보를 해당 필드에 넣는다.
			document.getElementById('zip').value					=	data.zonecode;
			document.getElementById('addr1').value					=	addr;
			document.getElementById('addr2').focus();
			// 커서를 상세주소 필드로 이동한다.
			//document.getElementById("sample3_detailAddress").focus();

			// iframe을 넣은 element를 안보이게 한다.
			// (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
			element_wrap.style.display = 'none';

			// 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
			document.body.scrollTop = currentScroll;
		},
		// 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
		onresize : function(size) {
            element_wrap.style.height = size.height+'px';
		},
		width : '100%',
		height : '100%'
	}).embed(element_wrap);

	// iframe을 넣은 element를 보이게 한다.
	element_wrap.style.display = 'block';
}
