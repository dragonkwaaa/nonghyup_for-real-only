$(document).ready(function(){
	get_favorite();
});

function movePage(pno){
	pno						=	pno			?	pno		:	1;
	$('input[name="pno"]').val(pno);
	document.frm.submit();
}

function get_favorite(){

	$('.goodsList').html('');

	let token				=	$('input[name="token"]').val();
	let pno					=	$('input[name="pno"]').val();

	let url					=	'/my/event/myFavorite_get_favorite';
	let dataType			=	'json';
	let param				= 	{
		pno					:	pno,
		token				:	token
	};

	postService(url, dataType, param, function(data){
		let list			=	data.list;
		let totalCount		=	data.totalCount;
		let recordPerPage	=	data.recordPerPage;
		let pnoPerPage		=	data.pnoPerPage;
		let temp 			=	data.temp;
		let str				=	'';

		if(list.length){
			for(var i = 0 ; i < list.length ; i++){
				let li 	=	list[i];
				let goods 	=	li.goods;
				let type 	=	0;
				if(goods.isRegular == 1){
					type 	=	1;
				} else if(goods.isRegular == 0){
					type 	=	2;
				}
				str		+=	'<li>';
				str		+=	'	<div class="segmentTop">';
				str		+=	'		<label>';
				str		+=	'			<input type="checkbox" name="favoriteIdx[]" value="'+li.favoriteIdx+'">';
				str		+=	'		</label>';
				str		+=	'		<a href="javascript:delete_favorite('+li.favoriteIdx+');" class="deleteBtn absoluteR"></a>';
				str		+=	'	</div>';
				str		+=	'	<div class="mainCon">';
				str		+=	'		<a href="/product/info?code='+li.goodsCode+'&type='+type+'">'
				str		+=	'		<img src="http://nonghyup.heeyam.com'+goods.goodsImg1+'" class="goodsImg separatedLeft"></img>';
				str		+=	'		</a>';
				str		+=	'		<div class="goodsInfo separatedRight relative">';
				str		+=	'			<div class="absoluteL">';
				str		+=	'				<div class="f16 f_semiBold">'+goods.goodsName+'</div></a>';
				str		+=	'				<div class="f20 f_semiBold mt8 f_robotoBold">'+numberWithCommas(goods.goodsPrice)+'원</div>';
				str		+=	'			</div>';
				str		+=	'		</div>';
				str		+=	'	</div>';
				str		+=	'</li>';
			}
		} else {
			str 			+=	'	<li class="emptyList">등록된 찜 목록이 없습니다.</li>';
		}

		$('.goodsList').html(str);
		setPaging(recordPerPage, pnoPerPage, pno, totalCount);
	});
}


function delete_favorite(idx){
	let favoriteIdx 				=	[]
	if(!idx){
		$('input:checkbox[name="favoriteIdx[]"]').each(function() {
			if(this.checked){								//checked 처리된 항목의 값
				favoriteIdx.push(this.value);
			}
		});
	} else {
		favoriteIdx.push(idx);
	}

	if(!favoriteIdx.length){
		alert('삭제할 상품을 선택해주세요.');
		return;
	}

	if(confirm('선택한 상품을 삭제하시겠습니까?')){
		let url 					=	'/my/event/myFavorite_delete_favorite';
		let dataType 				=	'json';
		let param 					=	{
			favoriteIdx 			:	favoriteIdx
		}
		postService(url, dataType, param, '', '');
	}
}

$(document).on('change', '#checkAll', function(){
	if($(this).prop('checked')){
		$("input[name='favoriteIdx[]']").prop("checked", true);
	} else {
		$("input[name='favoriteIdx[]']").prop("checked", false);
	}
})


function idxCheckAll(){
	$("input[name='favoriteIdx[]']").prop("checked", true);
	$("input[id='checkAll']").prop("checked", true);
}