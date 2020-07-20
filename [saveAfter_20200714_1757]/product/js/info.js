$(document).ready(function(){
	get_goods();
	get_review();
	get_ask();
});


let opIdxArr 					=	[];

function get_goods(){
	let type				=	$('input[name="type"]').val();
	let code 				=	$('input[name="code"]').val();
	let token 				=	$('input[name="token"]').val();

	let url 				=	'/product/event/info_get_goodsInfo';
	let dataType 			=	'json';
	let param 				=	{
		code				:	code,
		type				:	type
	};
	postService(url, dataType, param, function(data){
		let str 			=	'';
		let opStr 			=	'';
		let opStr_m 		=	'';
		let imgSel 			=	'';
		let imgSlide		=	'';
		let selOpStr1		=	'';							//정기배송 선택상품일시, 기존에 선택한 옵션 나타내기
		let selOpStr1_m		=	'';
		let selOpStr2		=	'';
		let goods 			=	data.goods;
		let opList 			=	data.opList;
		let isOn 			=	data.isOn;
		let isOption 		=	data.isOption;

		let userRegular 	=	data.userRegular;			//회원정기배송유무
		let regularLimit 	=	data.regularLimit;			//정기배송금액

		let cartOp 			=	data.cartOp;

		$('#selectGroup2').remove();
		$('input[name="userRegular"]').val(userRegular);
		$('input[name="regularLimit"]').val(regularLimit);
		$('input[name="isBundle"]').val(goods.isBundle);

		if(goods.isBundle == 1 && goods.isOption == 0){
			let noOptionStr 					=	'';
			$('.selectGroup').remove();
			$('#total1').html(numberWithCommas(goods.goodsPrice)+' 원');
			$('#total2').html(numberWithCommas(goods.goodsPrice)+' 원');
			$('#total_m').html(numberWithCommas(goods.goodsPrice)+' 원');
			$('input[name="total"]').val(goods.goodsPrice);
		}

		if(goods.isRegular == 1){
			$('.cartBtn').addClass('longMod');
			$('input[name="type"]').val(1);
		}

		if(isOn == 1){
			$('.script_favorite').addClass('activated');
		} else {
			$('.script_favorite').removeClass('activated');
		}

		if(goods.goodsImg1){
			imgSel 			+=	'<img src="http://nonghyup.heeyam.com'+goods.goodsImg1+'" class="imgMain">';
			imgSel 			+=	'	<ul class="imgTab">';
			if(goods.goodsImg2){
				for(var i = 2 ; i <= 5 ; i ++){
					if(eval('goods.goodsImg' + i)){
						goodsImg 			=	eval('goods.goodsImg' + i);
						imgSel 				+=	'<li>';
						imgSel 				+=	'	<a href="javascript:void(0)">';
						imgSel 				+=	'		<img src="http://nonghyup.heeyam.com'+goodsImg+'">';
						imgSel 				+=	'	</a>';
						imgSel 				+=	'</li>';
					}
				}
			}
			imgSel 		+=	'	</ul>';
		}

		$('.imgGroup').html(imgSel);
		if(parseInt(goods.goodStock) < 1){
			$('.imgGroup').addClass('soldOut');
			$('.orderBtn').click(function () {return false;});
		}
		$('#name').html(goods.goodsName);
		$('#price').html(numberWithCommas(goods.goodsPrice)+' 원');
		$('#originInfo').html(goods.originInfo);
		$('#standardInfo').html(goods.standardInfo);
		$('#deliveryInfo').html(goods.deliveryInfo);
		$('input[name="isOption"]').val(isOption);
		$('input[name="price"]').val(goods.goodsPrice);

		$('input[name="isRegular"]').val(goods.isRegular);

		$('#name_m').html(goods.goodsName);
		$('#price_m').html(numberWithCommas(goods.goodsPrice)+' 원');
		$('#originInfo_m').html(goods.originInfo);
		$('#standardInfo_m').html(goods.standardInfo);
		$('#deliveryInfo_m').html(goods.deliveryInfo);


		if(isOption == 1){
			$('#opTitle').html(opList[0].goodsOpName);
			$('#opTitle_m').html(opList[0].goodsOpName);
			for(var i = 0 ; i < opList.length ; i ++){
				op 					=	opList[i];
				opStr 				+=	'<input type="hidden" value="'+op.goodsOpPrice+'" id="tmpOpPrice'+op.goodsOpIdx+'">';
				opStr 				+=	'<input type="hidden" value="'+op.goodsOpInfo+'" id="tmpOpInfo'+op.goodsOpIdx+'">';
				if(op.goodsOpState == 3){
					opStr 				+=	'<li class="disabled">'+op.goodsOpInfo+'</li>';
				} else {
					opStr 				+=	'<li onclick="setOp('+op.goodsOpIdx+');">'+op.goodsOpInfo+'</li>';
				}

				opStr_m 				+=	'<input type="hidden" value="'+op.goodsOpPrice+'" id="tmpOpPrice_m'+op.goodsOpIdx+'">';
				opStr_m 				+=	'<input type="hidden" value="'+op.goodsOpInfo+'" id="tmpOpInfo_m'+op.goodsOpIdx+'">';
				if(op.goodsOpState == 3){
					opStr_m 			+=	'<li class="disabled">'+op.goodsOpInfo+' (+'+numberWithCommas(op.goodsOpPrice)+'원)</li>';
				} else {
					opStr_m 			+=	'<li onclick="setOp('+op.goodsOpIdx+');">'+op.goodsOpInfo+' (+'+numberWithCommas(op.goodsOpPrice)+'원)</li>';
				}
			}
		} else {
			$('#opTitle').html('기본');
			opStr 				+=	'<input type="hidden" value="'+goods.goodsPrice+'" id="tmpOpPrice0">';
			opStr 				+=	'<input type="hidden" value="기본" id="tmpOpInfo0">';
			opStr 				+=	'<li onclick="setOp(0);">기본</li>';

			opStr_m 			+=	'<input type="hidden" value="'+goods.goodsPrice+'" id="tmpOpPrice0_m">';
			opStr_m 			+=	'<input type="hidden" value="기본" id="tmpOpInfo0_m">';
			opStr_m 			+=	'<li onclick="setOp(0);">기본</li>';
		}
		$('#opList').html(opStr);
		$('#opList_m').html(opStr_m);
		$('#orderOpList').html('');



		let b_str					=	'';
		if(goods.isBundle == 1){
			for(var i = 0 ; i < opList.length ; i ++){
				let op 					=	opList[i];
				let j 					=	i + 1;
				b_str					+=	'<li>';
				b_str					+=	'	<div class="ratioImgBox">';
				b_str					+=	'		<img src="http://nonghyup.heeyam.com'+op.goodsOpImg+'" class="listImg absoluteL">';
				b_str					+=	'	</div>';
				b_str					+=	'	<div class="mt20 f24 f_bold">'+op.goodsOpInfo+'</div>';

				let op_originInfo 		=	'';
				let op_standardInfo 	=	'';
				let op_levelInfo 		=	'';
				if(op.originInfo){
					op_originInfo 		=	op.originInfo;
				}
				if(op.standardInfo){
					op_standardInfo 	=	op.standardInfo;
				}
				if(op.levelInfo){
					op_levelInfo 		=	op.levelInfo;
				}
                
                b_str					+=	'    <div class="goodsInfo">';
                b_str					+=	'       <span>원산지</span>';
                b_str					+=	'       <span>'+op_originInfo+'</span>';
                b_str					+=	'    </div>';
                b_str					+=	'    <div class="goodsInfo">';
                b_str					+=	'       <span>규격정보</span>';
                b_str					+=	'       <span>'+op_standardInfo+'</span>';
                b_str					+=	'    </div>';
                b_str					+=	'    <div class="goodsInfo">';
                b_str					+=	'       <span>등급정보</span>';
                b_str					+=	'       <span>'+op_levelInfo+'</span>';
                b_str					+=	'    </div>';

                b_str					+=	'	<div class="mt9 f_red f24 f_bold">'+numberWithCommas(op.goodsOpPrice)+'원</div>';
                // :: 이 부분은 클릭 시 다른 페이지로 연결됨.
				if(isOption == 1){
					b_str					+=	'	<a href="javascript:setOp('+op.goodsOpIdx+')" class="cardboxLinkFilter"></a>';
				}
				b_str					+=	'</li>';


			}
			$('.bundleInsideList').append(b_str);
			//$('#underSlide').html(imgSlide);
		}

		$('#info').html(goods.goodsInfo);

		if(cartOp.length){
			for(var i = 0 ; i < cartOp.length ; i ++){
				var cOp 				=	cartOp[i];
				selOpStr1				+=	'<div class="singleOptionBox" id="singleOptionBox1'+cOp.goodsOpIdx+'">';
				selOpStr1				+=	'	<span>'+cOp.opInfo+' ( +'+numberWithCommas(cOp.opPrice)+'원)</span>';
				selOpStr1				+=	'	<div class="absoluteMR">';
				selOpStr1				+=	'		<span class="quantityBox">';
				selOpStr1				+=	'			<a href="javascript:updateOpQty(1, '+cOp.goodsOpIdx+');" class="decreaseIcon">-</a>';
				selOpStr1				+=	'			<input value="'+cOp.cartQty+'" class="quantity onlyNum" onchange="inputUpdateQty1('+cOp.goodsOpIdx+');" id="opQty1'+cOp.goodsOpIdx+'" maxlength="2">';
				selOpStr1				+=	'			<a href="javascript:updateOpQty(2,'+cOp.goodsOpIdx+');" class="increaseIcon">+</a>';
				selOpStr1				+=	'		</span>';
				selOpStr1				+=	'		<input type="hidden" name="opPrice[]" value="'+cOp.opPrice+'" id="opPrice'+cOp.goodsOpIdx+'">';
				selOpStr1				+=	'		<input type="hidden" name="opIdx[]" value="'+cOp.goodsOpIdx+'">';
				selOpStr1				+=	'		<input type="hidden" name="opQty[]" value="'+cOp.cartQty+'" id="tempQty'+cOp.goodsOpIdx+'">';
				selOpStr1				+=	'		<input type="hidden" value="'+cOp.cartQty+'" id="beforeQty'+cOp.goodsOpIdx+'">';

				selOpStr1				+=	'		<a href="javascript:deleteOp('+cOp.goodsOpIdx+','+cOp.cartCode+', 1);" class="rimlessBtn">삭제</a>';
				selOpStr1				+=	'	</div>';
				selOpStr1				+=	'</div>';

				//우측 장바구니
				selOpStr2 				+=		'<div class="singleOptionBox" id="singleOptionBox2'+cOp.goodsOpIdx+'">';
				selOpStr2 				+=		'	<div class="optionName">'+cOp.opInfo+' ( +'+numberWithCommas(cOp.opPrice)+' 원)</div>';
				selOpStr2 				+=		'	<span class="f14">수량</span>';
				selOpStr2 				+=		'	<span class="quantityBox ml30">';
				selOpStr2 				+=		'		<a href="javascript:updateOpQty(1, '+cOp.goodsOpIdx+');" class="decreaseIcon">-</a>';
				selOpStr2 				+=		'		<input value="'+cOp.cartQty+'" class="quantity onlyNum" onchange="inputUpdateQty2('+cOp.goodsOpIdx+');" id="opQty2'+cOp.goodsOpIdx+'" maxlength="2">';
				selOpStr2 				+=		'		<a href="javascript:updateOpQty(2, '+cOp.goodsOpIdx+');" class="increaseIcon">+</a>';
				selOpStr2 				+=		'	</span>';
				selOpStr2 				+=		'	<div class="relative optionPriceBox">';
				selOpStr2 				+=		'		<span>'+numberWithCommas(parseInt(cOp.opPrice + goods.goodsPrice))+'원</span>';
				selOpStr2 				+=		'		<a href="javascript:deleteOp('+cOp.goodsOpIdx+','+cOp.cartCode+', 1);" class="rimlessBtn absoluteMR">삭제</a>';
				selOpStr2 				+=		'	</div>';
				selOpStr2 				+=		'</div>';

				selOpStr1_m				+=	'<div class="singleOptionBox" id="singleOptionBox_m'+cOp.goodsOpIdx+'">';
				selOpStr1_m				+=	'	<span>'+cOp.opInfo+'</span>';
				selOpStr1_m				+=	'	<div class="absoluteMR">';
				selOpStr1_m				+=	'		<span class="quantityBox">';
				selOpStr1_m				+=	'			<a href="javascript:updateOpQty(1, '+cOp.goodsOpIdx+');" class="decreaseIcon">-</a>';
				selOpStr1_m				+=	'			<input value="'+cOp.cartQty+'" class="quantity onlyNum" onchange="inputUpdateQty_m('+cOp.goodsOpIdx+')" id="opQty_m'+cOp.goodsOpIdx+'" maxlength="2">';
				selOpStr1_m				+=				'<a href="javascript:updateOpQty(2, '+cOp.goodsOpIdx+');" class="increaseIcon">+</a>';
				selOpStr1_m				+=	'		</span>';
				selOpStr1_m				+=	'		<span class="f_bold">'+numberWithCommas(cOp.opPrice)+'원</span>';
				selOpStr1_m				+=	'		<a href="javascript:deleteOp('+cOp.goodsOpIdx+','+cOp.cartCode+', 1);" class="rimlessBtn">삭제</a>';
				selOpStr1_m				+=	'	</div>';
				selOpStr1_m				+=	'</div>';

				opIdxArr.push(cOp.goodsOpIdx);
			}
			$('#orderOpList1').html(selOpStr1);
			$('#orderOpList2').html(selOpStr2);
			$('#orderOpList1_m').html(selOpStr1_m);
			opCalculation();
		} else {
			$('#orderOpList1').hide();
			$('#orderOpList2').hide();
			$('#orderOpList1_m').hide();
		}

		if(urlArrList.indexOf(window.location.href) != -1){
			urlArrList.splice(urlArrList.indexOf(window.location.href), 1);
			imgArrList.splice(imgArrList.indexOf('http://nonghyup.heeyam.com'+goods.goodsImg1), 1);
		}
		urlArrList.unshift(window.location.href);
		imgArrList.unshift('http://nonghyup.heeyam.com'+goods.goodsImg1);
		localStorage.setItem('urlArr', JSON.stringify(urlArrList));
		localStorage.setItem('imgArr', JSON.stringify(imgArrList));

		//calculation();
	}, '', '', '', '', 1);
}

function setOp(opIdx){

	var type 					=	$('input[name="type"]').val();						//1:정기,2:일반묶음
	var userRegular 			=	$('input[name="userRegular"]').val();
	var regularLimit 			=	parseInt($('input[name="regularLimit"]').val());
	var temptotal 				=	parseInt($('input[name="total"]').val());

	//var price 					=	parseInt($('input[name="price"]').val());
	var price 					=	0;
	var opPrice 				=	parseInt($('#tmpOpPrice'+opIdx).val());
	var opInfo					=	$('#tmpOpInfo'+opIdx).val();
	var isBundle 				=	$('input[name="isBundle"]').val();
	//console.log(userRegular);
	if(type == 1) {
		if(userRegular != 1){
			if(confirm('정기회원만 사용하실 수 있습니다. 정기회원 등록페이지로 이동하시겠습니까?')){
				location.href	=	'/my/myRegular';
				return;
			} else {
				return;
			}
		}
		if(regularLimit < (temptotal + price + opPrice)){
			alert('정기배송금액이 초과되었습니다.');
			return;
		}
	}

	$('#orderOpList1').show();
	$('#orderOpList2').show();
	$('#orderOpList1_m').show();
	let selOpStr1				=	'';
	let selOpStr2 				=	'';
	let selOpStr1_m 			=	'';
	if(opIdx == 0){
		$('#opList').html('');
		if(isBundle == 0){
			console.log(opPrice);
			selOpStr1				+=	'<div class="singleOptionBox" id="singleOptionBox1'+opIdx+'">';
			selOpStr1				+=	'	<span>기본</span>';
			selOpStr1				+=	'	<div class="absoluteMR">';
			selOpStr1				+=	'		<span class="quantityBox">';
			selOpStr1				+=	'			<a href="javascript:updateOpQty(1, '+opIdx+');" class="decreaseIcon">-</a>';
			selOpStr1				+=	'			<input value="1" class="quantity onlyNum" onchange="inputUpdateQty1('+opIdx+');" id="opQty1'+opIdx+'" maxlength="2">';
			selOpStr1				+=	'			<a href="javascript:updateOpQty(2,'+opIdx+');" class="increaseIcon">+</a>';
			selOpStr1				+=	'		</span>';
			selOpStr1				+=	'		<input type="hidden" name="opPrice[]" value="'+opPrice+'" id="opPrice'+opIdx+'">';
			selOpStr1				+=	'		<input type="hidden" name="opIdx[]" value="'+opIdx+'">';
			selOpStr1				+=	'		<input type="hidden" name="opQty[]" value="1" id="tempQty'+opIdx+'">';

			selOpStr1				+=	'		<a href="javascript:deleteOp('+opIdx+');" class="rimlessBtn">삭제</a>';
			selOpStr1				+=	'	</div>';
			selOpStr1				+=	'</div>';

			selOpStr1_m				+=	'<div class="singleOptionBox" id="singlie">';
			selOpStr1_m				+=	'	<span>기본</span>';
			selOpStr1_m				+=	'	<div class="absoluteMR">';
			selOpStr1_m				+=	'		<span class="quantityBox">';
			selOpStr1_m				+=	'			<a href="javascript:updateOpQty(1, '+opIdx+');" class="decreaseIcon">-</a>';
			selOpStr1_m				+=	'			<input value="1" class="quantity onlyNum" onchange="inputUpdateQty_m('+opIdx+')" id="opQty_m'+opIdx+'" maxlength="2">';
			selOpStr1_m				+=				'<a href="javascript:updateQty(2, '+opIdx+');" class="increaseIcon">+</a>';
			selOpStr1_m				+=	'		</span>';
		/*	selOpStr1_m				+=	'		<input type="hidden" name="opPrice[]" value="'+opPrice+'" id="opPrice_m'+opIdx+'">';
			selOpStr1_m				+=	'		<input type="hidden" name="opIdx[]" value="'+opIdx+'">';*/
			selOpStr1_m				+=	'		<span class="f_bold"> '+opPrice+'</span>';
			selOpStr1_m				+=	'		<a href="javascript:deleteOp('+opIdx+');" class="rimlessBtn">삭제</a>';
			selOpStr1_m				+=	'	</div>';
			selOpStr1_m				+=	'</div>';
		} else {
			selOpStr1				+=	'<div class="singleOptionBox" id="singleOptionBox1'+opIdx+'">';
			selOpStr1				+=	'	<span>'+opInfo+' ( +'+numberWithCommas(opPrice)+'원)klklklk</span>';
			selOpStr1				+=	'	<div class="absoluteMR">';
			selOpStr1				+=	'		<span class="quantityBox">';
			selOpStr1				+=	'			<a href="javascript:updateOpQty(1, '+opIdx+');" class="decreaseIcon">-</a>';
			selOpStr1				+=	'			<input value="1" class="quantity onlyNum" onchange="inputUpdateQty1('+opIdx+');" id="opQty1'+opIdx+'" maxlength="2">';
			selOpStr1				+=	'			<a href="javascript:updateOpQty(2,'+opIdx+');" class="increaseIcon">+</a>';
			selOpStr1				+=	'		</span>';
			selOpStr1				+=	'		<input type="hidden" name="opPrice[]" value="'+opPrice+'" id="opPrice'+opIdx+'">';
			selOpStr1				+=	'		<input type="hidden" name="opIdx[]" value="'+opIdx+'">';
			selOpStr1				+=	'		<input type="hidden" name="opQty[]" value="1" id="tempQty'+opIdx+'">';
			selOpStr1				+=	'		<input type="hidden" value="1" id="beforeQty'+opIdx+'">';
			selOpStr1				+=	'		<a href="javascript:deleteOp('+opIdx+');" class="rimlessBtn">삭제</a>';
			selOpStr1				+=	'	</div>';
			selOpStr1				+=	'</div>';

			selOpStr1_m				+=	'<div class="singleOptionBox" id="singlie">';
			selOpStr1_m				+=	'	<span>'+opInfo+'</span>';
			selOpStr1_m				+=	'	<div class="absoluteMR">';
			selOpStr1_m				+=	'		<span class="quantityBox">';
			selOpStr1_m				+=	'			<a href="javascript:updateOpQty(1, '+opIdx+');" class="decreaseIcon">-</a>';
			selOpStr1_m				+=	'			<input value="1" class="quantity onlyNum" onchange="inputUpdateQty_m('+opIdx+')" id="opQty_m'+opIdx+'" maxlength="2">';
			selOpStr1_m				+=				'<a href="javascript:updateQty(2, '+opIdx+');" class="increaseIcon">+</a>';
			selOpStr1_m				+=	'		</span>';
			/*selOpStr1_m				+=	'		<input type="hidden" name="opPrice[]" value="'+opPrice+'" id="opPrice'+opIdx+'">';*/
			/*selOpStr1_m				+=	'		<input type="hidden" name="opIdx[]" value="'+opIdx+'">';*/
			selOpStr1_m				+=	'		<span class="f_bold"> '+opPrice+'</span>';
			selOpStr1_m				+=	'		<a href="javascript:deleteOp('+opIdx+');" class="rimlessBtn">삭제</a>';
			selOpStr1_m				+=	'	</div>';
			selOpStr1_m				+=	'</div>';
		}
		opIdxArr.push(opIdx);
		$('#orderOpList1').append(selOpStr1);
		$('#orderOpList2').append(selOpStr2);
		$('#orderOpList1_m').append(selOpStr1_m);
		opCalculation();
	} else if(opIdxArr.indexOf(opIdx) == -1){
		//상단 장바구니
		selOpStr1				+=	'<div class="singleOptionBox" id="singleOptionBox1'+opIdx+'">';
		selOpStr1				+=	'	<span>'+opInfo+' ( +'+numberWithCommas(opPrice)+'원)</span>';
		selOpStr1				+=	'	<div class="absoluteMR">';
		selOpStr1				+=	'		<span class="quantityBox">';
		selOpStr1				+=	'			<a href="javascript:updateOpQty(1, '+opIdx+');" class="decreaseIcon">-</a>';
		selOpStr1				+=	'			<input value="1" class="quantity onlyNum" onchange="inputUpdateQty1('+opIdx+');" id="opQty1'+opIdx+'" maxlength="2">';
		selOpStr1				+=	'			<a href="javascript:updateOpQty(2,'+opIdx+');" class="increaseIcon">+</a>';
		selOpStr1				+=	'		</span>';
		selOpStr1				+=	'		<input type="hidden" name="opPrice[]" value="'+opPrice+'" id="opPrice'+opIdx+'">';
		selOpStr1				+=	'		<input type="hidden" name="opIdx[]" value="'+opIdx+'">';
		selOpStr1				+=	'		<input type="hidden" name="opQty[]" value="1" id="tempQty'+opIdx+'">';
		selOpStr1				+=	'		<input type="hidden" value="1" id="beforeQty'+opIdx+'">';
		selOpStr1				+=	'		<a href="javascript:deleteOp('+opIdx+');" class="rimlessBtn">삭제</a>';
		selOpStr1				+=	'	</div>';
		selOpStr1				+=	'</div>';

		//우측 장바구니
		selOpStr2 				+=		'<div class="singleOptionBox" id="singleOptionBox2'+opIdx+'">';
		selOpStr2 				+=		'	<div class="optionName">'+opInfo+' ( +'+numberWithCommas(opPrice)+' 원)</div>';
		selOpStr2 				+=		'	<span class="f14">수량</span>';
		selOpStr2 				+=		'	<span class="quantityBox ml30">';
		selOpStr2 				+=		'		<a href="javascript:updateOpQty(1, '+opIdx+');" class="decreaseIcon">-</a>';
		selOpStr2 				+=		'		<input value="1" class="quantity onlyNum" onchange="inputUpdateQty2('+opIdx+');" id="opQty2'+opIdx+'" maxlength="2">';
		selOpStr2 				+=		'		<a href="javascript:updateOpQty(2, '+opIdx+');" class="increaseIcon">+</a>';
		selOpStr2 				+=		'	</span>';
		selOpStr2 				+=		'	<div class="relative optionPriceBox">';
		selOpStr2 				+=		'		<span>'+numberWithCommas(opPrice + price)+'원</span>';
		selOpStr2 				+=		'		<a href="javascript:deleteOp('+opIdx+');" class="rimlessBtn absoluteMR">삭제</a>';
		selOpStr2 				+=		'	</div>';
		selOpStr2 				+=		'</div>';

		selOpStr1_m				+=	'<div class="singleOptionBox" id="singleOptionBox_m'+opIdx+'">';
		selOpStr1_m				+=	'	<span>'+opInfo+'</span>';
		selOpStr1_m				+=	'	<div class="absoluteMR">';
		selOpStr1_m				+=	'		<span class="quantityBox">';
		selOpStr1_m				+=	'			<a href="javascript:updateOpQty(1, '+opIdx+');" class="decreaseIcon">-</a>';
		selOpStr1_m				+=	'			<input value="1" class="quantity onlyNum" onchange="inputUpdateQty_m('+opIdx+')" id="opQty_m'+opIdx+'" maxlength="2">';
		selOpStr1_m				+=				'<a href="javascript:updateOpQty(2, '+opIdx+');" class="increaseIcon">+</a>';
		selOpStr1_m				+=	'		</span>';
		selOpStr1_m				+=	'		<span class="f_bold">'+numberWithCommas(opPrice )+'원</span>';
		selOpStr1_m				+=	'		<a href="javascript:deleteOp('+opIdx+');" class="rimlessBtn">삭제</a>';
		selOpStr1_m				+=	'	</div>';
		selOpStr1_m				+=	'</div>';

		opIdxArr.push(opIdx);

		$('#orderOpList1').append(selOpStr1);
		$('#orderOpList2').append(selOpStr2);
		$('#orderOpList1_m').append(selOpStr1_m);

		opCalculation();
	} else {
		var tempQty 			=	parseInt($('#tempQty'+opIdx).val());
		updateOpQty(2, opIdx);
		opCalculation();
	}

	$('#cartButton_m').addClass('linkable');
	$('.goodsBuyInfoGroup').addClass('activated');
	$('.goodsBuyInfoGroup.activated').slideDown(400);

}

function updateOpQty(type, opIdx){
	var tempQty 			=	$('#tempQty'+opIdx).val();
	//var beforeQty			=	$('#beforeQty'+opIdx).val();
	if(type == 1){
		if(tempQty == 1){
			return;
		} else {
			tempVal 		=	parseInt(tempQty) - 1;
		}
	} else if(type == 2){
		tempVal 			=	parseInt(tempQty) + 1;
	}
	$('#tempQty'+opIdx).val(tempVal);
	/*$('#opQty1'+opIdx).val(tempVal);
	$('#opQty2'+opIdx).val(tempVal);
	$('#opQty_m'+opIdx).val(tempVal);*/
	//console.log('위에'+opIdx);
	opCalculation(opIdx);
}

function deleteOp(opIdx, cartCode, type){

	$('#singleOptionBox1'+opIdx).remove();
	$('#singleOptionBox2'+opIdx).remove();
	$('#singleOptionBox_m'+opIdx).remove();

	opIdxArr.splice(opIdxArr.indexOf(opIdx), 1);

	if(opIdxArr.length == 0){
		$('#orderOpList1').hide();
		$('#orderOpList2').hide();
		$('#orderOpList1_m').hide();
	}

	opCalculation();

	if(type == 1){
		let url 				=	'/product/event/info_delete_cart';
		let dataType 			=	'json';
		let param 				=	{
			cartCode			:	cartCode
		};

		postService(url, dataType, param, function(data) {
		});
	}
}

function inputUpdateQty1(opIdx){
	var tempQty 			=	parseInt($('#opQty1'+opIdx).val());
	if(tempQty == 0){
		tempQty				=	1;
	}
	$('#tempQty'+opIdx).val(tempQty);
	opCalculation(opIdx);
}

function inputUpdateQty2(opIdx){
	var tempQty 			=	parseInt($('#opQty2'+opIdx).val());
	if(tempQty == 0){
		tempQty				=	1;
	}
	$('#tempQty'+opIdx).val(tempQty);
	opCalculation(opIdx);
}


function inputUpdateQty_m(opIdx){
	var tempQty 			=	parseInt($('#opQty_m'+opIdx).val());
	if(tempQty == 0){
		tempQty				=	1;
	}
	$('#tempQty'+opIdx).val(tempQty);
	opCalculation(opIdx);
}

function opCalculation(idx){

	var type 				=	$('input[name="type"]').val();
	var regularLimit 		=	parseInt($('input[name="regularLimit"]').val());
	var total 				=	0;
	//var price 				=	parseInt($('input[name="price"]').val());
	var price 				=	0;
	var opPrice 			=	0;
	var tempQty 			=	parseInt($('#tempQty'+idx).val());
	var beforeQty 			=	parseInt($('#beforeQty'+idx).val());
	for(var i = 0 ; i < opIdxArr.length ; i ++){
		var opIdx 			=	opIdxArr[i];
		var opPrice			=	parseInt($('#opPrice'+opIdx).val());
		var tmpQty 			=	parseInt($('#tempQty'+opIdx).val());
		var perPrice 		=	(opPrice + price) * tmpQty;
		total 				+=	perPrice;
		/*if(opIdx > 0){
			opPrice				=	parseInt($('#opPrice'+opIdx).val());
			tempQty 			=	parseInt($('#tempQty'+opIdx).val());
			perPrice 			=	(opPrice + price) * tempQty;
			total 				+=	perPrice;
		} else {
			total 				=	parseInt($('input[name="price"]').val());
			break;
		}*/
	}

	if(type == 1){
		if(regularLimit < total){
			alert('정기배송금액이 초과되었습니다.');
			tempQty 		=	beforeQty;
			$('#tempQty'+idx).val(tempQty);
			$('#opQty1'+idx).val(tempQty);
			$('#opQty2'+idx).val(tempQty);
			$('#opQty_m'+idx).val(tempQty);
			return false;
		} /*else {
			$('#beforeQty'+idx).val(tempQty);
			$('#tempQty'+idx).val(tempQty);
			$('#opQty1'+idx).val(tempQty);
			$('#opQty2'+idx).val(tempQty);
			$('#opQty_m'+idx).val(tempQty);
		}*/
	}

	$('#tempQty'+idx).val(tempQty);
	$('#opQty1'+idx).val(tempQty);
	$('#opQty2'+idx).val(tempQty);
	$('#opQty_m'+idx).val(tempQty);
	$('#beforeQty'+idx).val(tempQty);
	$('input[name="total"]').val(total);
	$('#total1').html(numberWithCommas(total)+' 원');
	$('#total2').html(numberWithCommas(total)+' 원');
	$('#total_m').html(numberWithCommas(total)+' 원');

}
/*
function opCalculation(){
	var total 				=	0;
	var price 				=	parseInt($('input[name="price"]').val());
	var opPrice 			=	0;
	var opQty 				=	0;
	for(var i = 0 ; i < opIdxArr.length ; i ++){
		opIdx 				=	opIdxArr[i];
		opPrice				=	parseInt($('#opPrice'+opIdx).val());
		opQty 				=	parseInt($('#opQty1'+opIdx).val());
		perPrice 			=	(opPrice + price) * opQty;
		total 				+=	perPrice;
	}

	$('input[name="total"]').val(total);
	$('#total1').html(numberWithCommas(total)+' 원');
	$('#total2').html(numberWithCommas(total)+' 원');
}*/

