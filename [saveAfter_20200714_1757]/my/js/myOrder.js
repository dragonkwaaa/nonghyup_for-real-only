
$(document).ready(function(){
	get_order(2);
});

function movePage(pno){
	pno						=	pno			?	pno		:	1;
	$('input[name="pno"]').val(pno);
	get_order();
}

function get_order(type){
	let token				=	$('input[name="token"]').val();
	let pno					=	$('input[name="pno"]').val();
	let startDate			=	$('input[name="startDate"]').val();
	let endDate				=	$('input[name="endDate"]').val();
	let year				=	$('input[name="year"]').val();
	let month				=	$('input[name="month"]').val();
	let searchType			=	$('input[name="searchType"]').val();
	let state 				=	$('input[name="state"]').val();
/*	let type 				=	$('input[name="type"]').val();*/


	let url					=	'/my/event/myOrder_get_order';
	let dataType			=	'json';
	let param				= 	{
		pno					:	pno,
		startDate			:	startDate,
		endDate				:	endDate,
		token				:	token,
		year 				:	year,
		month				:	month,
		searchType 			:	searchType,
		state				:	state,
		type				:		type
	};
	postService(url, dataType, param, function(data){
		let pno 			=	data.pno;
		let list			=	data.list;
		let totalCount		=	data.totalCount;
		let recordPerPage	=	data.recordPerPage;
		let pnoPerPage		=	data.pnoPerPage;
		let temp 			=	data.temp;
		let state 			=	data.state;
		let str				=	'';

		$('input[name="type"]').val(type);
		if(type == 1){
			$('#regularOrder').addClass('activated');
			$('#notRegularOrder').removeClass('activated');
		} else {
			$('#regularOrder').removeClass('activated');
			$('#notRegularOrder').addClass('activated');
		}

		$('input[name="pno"]').val(pno);
		$('.todayDate').html('');
		if(searchType == 1){
			if(startDate && endDate){
				$('.todayDate').html(startDate+' ~ '+ endDate);
			}
		} else if(searchType == 2){
			if(year){
				$('.todayDate').html(year+'년');
			}
			if(month){
				$('.todayDate').append(' '+month+'월');
			}
		}

		$('.mainTitle').html('주문배송조회');
		if(state == 2){
			$('.mainTitle').html('취소/교환/반품 조회');
		}

		if(list.length){
			for(var i = 0 ; i < list.length ; i ++){
				let li 		=	list[i];
				str			+=	'<li>';
				str			+=	'	<div class="segmentTop">';
				str			+=	'		<label>';
				str			+=	'			<input type="checkbox" name="orderListCode[]" value="'+li.orderListIdx+'">';
				str			+=	'		</label>';
				str			+=	'		<a href="/order/orderSpec?no='+li.orderCode+'&state='+state+'" class="rimlessBtn viewSpecBtn absoluteR">상세보기</a>';
				str			+=	'	</div>';
				str			+=	'	<div class="mainCon">';
				str			+=	'		<img src="http://nonghyup.heeyam.com'+li.goodsImg+'" class="goodsImg separatedLeft"></img>';
				str			+=	'		<div class="goodsInfo separatedRight relative">';
				str			+=	'			<div class="absoluteT infoText">';
				str			+=	'				<div class="f16 f_semiBold">'+li.goodsName+'</div>';
				if(li.goodsOpIdx > 0){
					str 					+=	'				<div class="f12">';
					str 					+=	'					<div>'+li.goodsOpName+' : '+li.goodsOpInfo+'('+numberWithCommas(li.goodsOpPrice)+'원) X '+li.orderQty+'개</div>';
					str 					+=	'				</div>';
				} else {
					str 					+=	'				<div class="f12">';
					str 					+=	'					<div>기본 : '+li.orderQty+'개</div>';
					str 					+=	'				</div>';
				}
				str			+=	'			</div>';
				str			+=	'			<div class="absoluteMR f_bold f20">'+numberWithCommas(li.perAmount)+'원</div>';
				str			+=	'		</div>';
				str			+=	'	</div>';
				str			+=	'</li>';
			}
		} else {
				str			+=	'<li class="emptyList">주문 목록이 없습니다.</li>';
		}


		$('#orderList').html(str);
		setPaging(recordPerPage, pnoPerPage, pno, totalCount);
	});
}

function delete_orderList(){
	let orderListCode 				=	[]
	$('input:checkbox[name="orderListCode[]"]').each(function() {
		if(this.checked){								//checked 처리된 항목의 값
			orderListCode.push(this.value);
		}
	});

	if(!orderListCode.length){
		alert('삭제할 주문을 선택해주세요.');
		return;
	}

	if(confirm('선택한 주문을 삭제하시겠습니까?')){
		let url 					=	'/my/event/myOrder_delete_order';
		let dataType 				=	'json';
		let param 					=	{
			orderListCode 			:	orderListCode
		}
		postService(url, dataType, param, '', '');
	}
}

function setYear(year){
	$('input[name="year"]').val(year);
	$('#yearSel').html(year+'년');
	$('#searchType').val(2);
	get_order($('input[name="type"]').val());
}

function setMonth(month){

	$('input[name="month"]').val(month);
	$('#monthSel').html(month+'월');
	$('#searchType').val(2);
	get_order($('input[name="type"]').val());
}

function setSearchDate_my(start){

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
	$('#searchType').val(1);

	get_order($('input[name="type"]').val());
}

function codeCheckAll(){
	$("input[name='orderListCode[]']").prop("checked", true);
}