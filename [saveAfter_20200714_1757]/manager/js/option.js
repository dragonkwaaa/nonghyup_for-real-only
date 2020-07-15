
// :: 기본 옵션 추가 스크립트
function setOpType1(){
	var str 	=	'';
	var trNum1		=	$('#opList1 tr').length;

	//var opOrder	=	$('input[name="tmpOpOrder"]').val();
	var opName				=	$('input[name="tmpOpName1"]').val();
	var opInfoString 		=	$('input[name="tmpOpInfo1"]').val();
	var opPrice				=	$('input[name="tmpOpPrice1"]').val();
	var opState				=	$('input[name="tmpOpState1"]:checked').val();
	var opInfoArr			=	opInfoString.split(',');

	if(!opName || !opInfoString || !opPrice){
		alert('옵션값을 체워주세요.');
		return;
	}

	if($('#isExist1').val() == 1){							//등록된 카테고리가 없습니다 삭제조건
		$('#opList1').html('');
		trNum1 		=	0;
	} else {
		if(trNum1 > 0){
			alert('생성된 옵션값이 존재합니다. 삭제하신 후, 다시 시도해주세요.');
			return;
		}
	}

	for(var i = 0 ; i < opInfoArr.length ; i ++){
		var num 	=	trNum1+i;
		var opInfo	=	opInfoArr[i];
		str			+=	'<tr>';
		str			+=	'<input type="hidden" name="opIdx1[]" value="0">';
		str			+=	'	<td>';
		str			+=	'		<input class="tbox full center" value="'+opName+'" name="opName1[]">';
		str			+=	'	</td>';
		str			+=	'	<td>';
		str			+=	'		<input class="tbox full center" value="'+opInfo+'" name="opInfo1[]">';
		str			+=	'	</td>';
		str			+=	'	<td>';
		str			+=	'		<input class="tbox full center onlyNum" value="'+opPrice+'" name="opPrice1[]">';
		str			+=	'	</td>';
		str			+=	'	<td>';
		str			+=	'		<input class="tbox full center onlyNum" value="0" name="opStock1[]">';
		str			+=	'	</td>';
		str			+=	'	<td>';
		str			+=	'		<div class="optStatChkBox">';
		str			+=	'			<label>';
		str			+=	'				<input type="radio" name="opState1_'+num+'" value="1" '+(opState == 1 ? " checked" : "")+'>';
		str			+=	'				<span>사용</span>';
		str			+=	'			</label>';
		str			+=	'		</div>';
		str			+=	'		<div class="optStatChkBox">';
		str			+=	'			<label>';
		str			+=	'				<input type="radio" name="opState1_'+num+'" value="0" '+(opState == 0 ? " checked" : "")+'>';
		str			+=	'				<span>미사용</span>';
		str			+=	'			</label>';
		str			+=	'		</div>';
		str			+=	'		<div class="optStatChkBox">';
		str			+=	'			<label>';
		str			+=	'				<input type="radio" name="opState1_'+num+'" value="2" '+(opState == 2 ? " checked" : "")+'>';
		str			+=	'				<span>품절</span>';
		str			+=	'			</label>';
		str			+=	'		</div>';
		str			+=	'	</td>';
		str			+=	'	<td>';
		str			+=	'		<span>';
		str			+=	'			<a href="javascript:void(0);" class="btn small col_darkGrey f_w delTr1">삭제</a>';
		str			+=	'		</span>';
		str			+=	'	</td>';
		str			+=	'</tr>';

		console.log(num);
	}


	$('#opList1').append(str);
}

//선택 옵션 추가
function setOpType2(){

	var str 	=	'';

	var opName	=	$('input[name="tmpOpName2"]').val();
	var opInfo 	=	$('input[name="tmpOpInfo2"]').val();
	var opPrice	=	$('input[name="tmpOpPrice2"]').val();
	var opState	=	$('input[name="tmpOpState2"]:checked').val();

	var str 	=	'';
	var trNum2		=	($('#opList2 tr').length);
	if($('#isExist2').val() == 1){							//등록된 카테고리가 없습니다 삭제조건
		$('#opList2').html('');
		trNum2 		=	0;
	}

	str			+=	'';
	str			+=	'<tr>';
	str			+=	'	<td>';
	str			+=	'		<input class="tbox indexInput" value="'+trNum2+'" name="opOrder2[]">';
	str			+=	'	</td>';
	str			+=	'	<td>';
	str			+=	'		<input class="tbox full center" value="'+opName+'" name="opName2[]">';
	str			+=	'	</td>';
	str			+=	'	<td>';
	str			+=	'		<input class="tbox full center" value="'+opInfo+'" name="opInfo2[]">';
	str			+=	'	</td>';
	str			+=	'	<td>';
	str			+=	'		<input class="tbox full center" value="'+numberWithCommas(opPrice)+'" name="opPrice2[]">';
	str			+=	'	</td>';
	str			+=	'	<td>';
	str			+=	'		<div class="optStatChkBox">';
	str			+=	'			<label>';
	str			+=	'				<input type="radio" name="opState2_'+trNum2+'" value="1" '+(opState == 1 ? " checked" : "")+'>';
	str			+=	'				<span>사용</span>';
	str			+=	'			</label>';
	str			+=	'		</div>';
	str			+=	'		<div class="optStatChkBox">';
	str			+=	'			<label>';
	str			+=	'				<input type="radio" name="opState2_'+trNum2+'" value="0" '+(opState == 0 ? " checked" : "")+'>';
	str			+=	'				<span>미사용</span>';
	str			+=	'				</label>';
	str			+=	'		</div>';
	str			+=	'		<div class="optStatChkBox">';
	str			+=	'			<label>';
	str			+=	'				<input type="radio" name="opState2_'+trNum2+'" value="2" '+(opState == 2 ? " checked" : "")+'>';
	str			+=	'				<span>품절</span>';
	str			+=	'			</label>';
	str			+=	'		</div>';
	str			+=	'	</td>';
	str			+=	'	<td>';
	str			+=	'		<span>';
	str			+=	'			<a href="javascript:void(0);" class="btn small col_darkGrey f_w delTr2">삭제</a>';
	str			+=	'		</span>';
	str			+=	'	</td>';
	str			+=	'</tr>';

	$('#opList2').append(str);
	trNum2		=	($('#opTable2 tbody tr').length);
}

$(document).on('click', '.delTr1', function(){
	let	$targetTr	=	$(this).closest('tr');
	let	$isDel		=	$(this).siblings('input');
	$targetTr.remove();
	checkDefault1();
});
$(document).on('click', '.delTr2', function(){
	let	$targetTr	=	$(this).closest('tr');
	//let	$isDel		=	$(this).siblings('input');
	$targetTr.remove();
	checkDefault2();
});


// 기본 tr 나타냄
function checkDefault1(){
	var trSize 		=	$('#opList1 tr').length;
	let str 		=	'';
	if(trSize < 1){
		str			+=	'<tr id="default1">';
		str			+=	'<td colspan="11">등록된 옵션이 없습니다.</td>';
		str 		+=	'<input type="hidden" id="isExist1" value="1">';
		str			+=	'</tr>';
	}
	$('#opList1').append(str);
}

// 기본 tr 나타냄
function checkDefault2(){
	var trSize 		=	$('#opList2 tr').length;
	let str 		=	'';
	if(trSize < 1){
		str			+=	'<tr id="default2">';
		str			+=	'<td colspan="11">등록된 옵션이 없습니다.</td>';
		str 		+=	'<input type="hidden" id="isExist2" value="1">';
		str			+=	'</tr>';
	}
	$('#opList2').append(str);
}

//  :: 선택옵션 사용/미사용 스크립트
$(document).on('click', '.statusCheckBox.optionCheck_1 input[type=radio]',function(){

	if (this.value	==	"1") {
		$('.optionSet_1').removeClass('hide');
		$('.optionList_1').removeClass('hide');
		$('.optionCheck_1').addClass('active');
	}
	else if (this.value	==	"0") {
		$('.optionSet_1').addClass('hide');
		$('.optionList_1').addClass('hide');
		$('.optionCheck_1').removeClass('active');
	}
});