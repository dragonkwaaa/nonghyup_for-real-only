$(document).ready(function(){
	get_bundle();
	get_review();
	get_ask();
});


function get_bundle(){
	let type				=	$('input[name="type"]').val();
	let code 				=	$('input[name="code"]').val();
	let token 				=	$('input[name="token"]').val();

	let url 				=	'/product/event/bundleInfo_get_bundle';
	let dataType 			=	'json';
	let param 				=	{
		code				:	code,
		type				:	type
	};

	postService(url, dataType, param, function(data){
		let str 			=	'';
		let imgSel 			=	'';
		let bundle 			=	data.bundle;
		let bundleList 		=	data.bundleList;
		let isOn 			=	data.isOn;

		if(isOn == 1){
			$('.script_favorite').addClass('activated');
		} else {
			$('.script_favorite').removeClass('activated');
		}

		if(bundle.bundleImg1){
			imgSel 			+=	'<img src="http://nonghyup.heeyam.com'+bundle.bundleImg1+'" class="imgMain">';
			imgSel 			+=	'	<ul class="imgTab">';
			if(bundle.bundleImg2){
				for(var i = 2 ; i <= 5 ; i ++){
					if(eval('bundle.bundleImg' + i)){
						bundleImg 			=	eval('bundle.bundleImg' + i);
						imgSel 				+=	'<li>';
						imgSel 				+=	'	<a href="javascript:void(0)">';
						imgSel 				+=	'		<img src="http://nonghyup.heeyam.com'+bundleImg+'">';
						imgSel 				+=	'	</a>';
						imgSel 				+=	'</li>';
					}
				}
			}
			imgSel 		+=	'	</ul>';
		}

		$('.imgGroup').html(imgSel);
		if(parseInt(bundle.bundleStock) < 1){
			$('.imgGroup').addClass('soldOut');
			$('.orderBtn').click(function () {return false;});
		}
		$('#name').html(bundle.bundleName);
		$('#price').html(numberWithCommas(bundle.bundlePrice)+' 원');
		$('#perPrice').html(numberWithCommas(bundle.bundlePrice)+' 원');
		$('input[name="price"]').val(bundle.bundlePrice);
		$('#originInfo').html(bundle.originInfo);
		$('#standardInfo').html(bundle.standardInfo);
		$('#deliveryInfo').html(bundle.deliveryInfo);
		$('#subName').html(bundle.bundleName);

		for(var i = 0 ; i < bundleList.length ; i ++){
			var bList 			=	bundleList[i];
			str					+=	'<li>';
			str					+=	'	<div class="ratioImgBox">';
			str					+=	'		<img src="http://nonghyup.heeyam.com'+bList.bundleListImg1+'" class="listImg absoluteL">';
			str					+=	'	</div>';
			str					+=	'	<div class="mt20 f24 f_bold">'+bList.bundleListName+'</div>';
			str					+=	'	<div class="mt9 f_red f24 f_bold">'+numberWithCommas(bList.bundleListPrice)+'원</div>';
			str					+=	'	<a href="javascript:void(0)" class="cardboxLinkFilter"></a>';
			str					+=	'</li>';
		}
		$('.bundleInsideList').append(str);
		$('#info').html(bundle.bundleInfo);

		calculation();
		if(urlArrList.indexOf(window.location.href) != -1){
			urlArrList.splice(urlArrList.indexOf(window.location.href), 1);
			imgArrList.splice(imgArrList.indexOf('http://nonghyup.heeyam.com'+bundle.bundleImg1), 1);
		}
		urlArrList.unshift(window.location.href);
		imgArrList.unshift('http://nonghyup.heeyam.com'+bundle.bundleImg1);
		localStorage.setItem('urlArr', JSON.stringify(urlArrList));
		localStorage.setItem('imgArr', JSON.stringify(imgArrList));
			//ui.js

	}, '', '', '', '', 1);

}

function updateQty(type){
	var tempQty 			=	$('input[name="qty"]').val();
	var tempVal 			=	1;
	if(type == 'M'){
		if(tempQty == 1){
			return;
		} else {
			tempVal 		=	parseInt(tempQty) - 1;
		}
	} else if(type == 'P'){
		tempVal 			=	parseInt(tempQty) + 1;
	}

	$('input[name="qty"]').val(tempVal);
	$('#qty1').val(tempVal);
	$('#qty2').val(tempVal);
	calculation();
}

function calculation(e){
	let total				=	0;
	let qty 				=	$('input[name="qty"]').val();
	let price 				=	$('input[name="price"]').val();

	if(e > 0){
		qty 				=	e;
	}

	total 					=	parseInt(qty * price);
	$('input[name="total"]').val(total);

	$('#total1').html(numberWithCommas(total)+' 원');
	$('#total2').html(numberWithCommas(total)+' 원');
	$('#qty1').val(qty);
	$('#qty2').val(qty);
}