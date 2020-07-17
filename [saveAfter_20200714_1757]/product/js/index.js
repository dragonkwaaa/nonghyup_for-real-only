$(document).ready(function(){
	get_list();
});

function movePage(pno){
	pno						=	pno			?	pno		:	1;
	$('input[name="pno"]').val(pno);
	document.frm.submit();
}

function get_list(){
	$('#list').html('');
	let token				=	$('input[name="token"]').val();
	let pno					=	$('input[name="pno"]').val();
	let type 				=	$('input[name="type"]').val();			//1:정기,2:묶음
	let category			=	$('input[name="category"]').val();
	let schWord				=	$('input[name="search"]').val();

	let url					=	'/product/event/index_get_list';
	let dataType			=	'json';
	let param				= 	{
		token				:	token,
		type				:	type,
		category			:	category,
		schWord 			:	schWord
	};
	postService(url, dataType, param, function(data){
		let title 			=	data.title;
		let list			=	data.list;
		let totalCount		=	data.totalCount;
		let recordPerPage	=	data.recordPerPage;
		let pnoPerPage		=	data.pnoPerPage;
		let temp 			=	data.temp;
		let isRegular 		=	data.isRegular;						//정기배송유무 1:정기배송해당
		let banner4			=	data.banner4;


		let str				=	'';
		let imgStr 			=	'';

		if(banner4.length){
			for(var i = 0 ; i < banner4.length ; i ++){
				let banner 	=	banner4[i];
				imgStr 		+=	'<a href="javascript:void(0);"><img src="'+banner.bannerImg+'" class="mainSingleBanner"></a>';
			}
		}
		$('#bannerSel').html(imgStr);

		if(list.length){
			$('.listTitle').text('총 '+totalCount+'개');
			$.each(list, function(index, goods) {

				var stock 		=	parseInt(goods.goodsStock);
				var soldOut 	=	'';
				if(stock < 1){
					soldOut 	=	'soldOut';
				}

				str 			+=	'<li>';
				str 			+=	'	<div class="ratioImgBox '+soldOut+'">';
				str 			+=	'		<img src="'+goods.goodsImg1+'" class="listImg absoluteL">';
				str 			+=	'	</div>';
				str 			+=	'	<div class="goodsTitle">'+goods.goodsName+'</div>';
				str 			+=	'	<div class="goodsPriceInfo relative">';
				str 			+=	'		<span class="calculatedPrice">'+numberWithCommas(goods.goodsPrice)+'원</span>';
				if(parseInt(goods.goodsOriginPrice) > 0){
					str 			+=	'		<span class="originalPrice">'+numberWithCommas(goods.goodsOriginPrice)+'원</span>';
				}
				if(parseInt(goods.goodsSaleRatio) > 0){
					str 			+=	'		<span class="discountAmount f_red absoluteR">'+goods.goodsSaleRatio+'%</span>';
				}
				str 			+=	'	</div>';
				str 			+=	'	<a href="/product/info?code='+goods.goodsCode+'&type='+type+'" class="cardboxLinkFilter"></a>';
				str 			+=	'</li>';
			});
			$('#list').html(str);
		} else {
			$('#productSel').html('');
				str				+=	'<div class="carboxList emptyCarboxList">';
				str				+=	'	<ul>';
				str				+=	'		<li>';
				str				+=	'			<div class=" tAlignC">';
				str				+=	'				<i class="emptyGoodsIcon"></i>';
				str				+=	'				<div class="f24 mt50">더 나은 구성을 위한 상품 준비중 입니다.</div>';
				str				+=	'				<div class="f24 mt12">조금만 기다려주세요!</div>';
				str				+=	'				</div>';
				str				+=	'		</li>';
				str				+=	'	</ul>';
				str				+=	'</div>';
			$('#productSel').html(str);
		}

		/*if(schWord){
			if(schUrlArrList.indexOf(window.location.href) != -1){
				schUrlArrList.splice(schUrlArrList.indexOf(window.location.href), 1);
				schNameArrList.splice(schNameArrList.indexOf(schWord), 1);
			}
			schUrlArrList.unshift(window.location.href);
			schNameArrList.unshift(schWord);
			localStorage.setItem('schUrlArr', JSON.stringify(schUrlArrList));
			localStorage.setItem('schNameArr', JSON.stringify(schNameArrList));
		}
*/
		$('.mainTitle').html(title);
		setPaging(recordPerPage, pnoPerPage, pno, totalCount);

	});
}
