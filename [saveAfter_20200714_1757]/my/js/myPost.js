$(document).ready(function(){
	get_post();
});

function movePage(pno){
	pno						=	pno			?	pno		:	1;
	$('input[name="pno"]').val(pno);
	document.frm.submit();
}

function get_post(){

	$('#postList').html('');

	let token				=	$('input[name="token"]').val();
	let pno					=	$('input[name="pno"]').val();
	let cate				=	$('input[name="cate"]').val();
	let searchWord			=	$('input[name="searchWord"]').val();
	let searchType			=	$('input[name="searchType"]').val();

	let url					=	'/my/event/myPost_get_myPost';
	let dataType			=	'json';
	let param				= 	{
		pno					:	pno,
		token				:	token,
		cate 				:	cate,
		searchType 			:	searchType,
		searchWord 			:	searchWord
	};

	postService(url, dataType, param, function(data){
		let list			=	data.list;
		let totalCount		=	data.totalCount;
		let recordPerPage	=	data.recordPerPage;
		let pnoPerPage		=	data.pnoPerPage;
		let temp 			=	data.temp;
		let str				=	'';

		if(cate == 4){
			$('#selTab1').addClass('activated');
		} else if(cate == 2){
			$('#selTab2').addClass('activated');
		}
		if(list.length){
			if(cate == 4){
				$('.section').addClass('myPostMod');
				$('.section').removeClass('inquiryMod');

				str			+=	'<ul class="goodsList" id="postList">';
				for(var i = 0 ; i < list.length ; i++){
					let li 						=	list[i];
					let regDate					=	li.regDate;
					let review 					=	li.review;
					let type 					=	li.type;
					regDate 					=	regDate.substring(0, 10);


					str		+=	'<li>';
					str		+=	'	<div class="segmentTop f16 f_bold">';
					str		+=	'		<label class="f_robotoBold">'+regDate+'</lavel>';
					str		+=	'		<a href="javascript:void(0);" class="deleteBtn absoluteR"></a>';
					str		+=	'	</div>';
					str		+=	'	<div class="mainCon">';
					str		+=	'		<a href="/product/info?code='+review.goodsCode+'&type='+type+'">'
					str		+=	'		<img src="/common/img/goodsTag_1.png" class="goodsImg separatedLeft"></img>';
					str		+=	'		</a>';
					str		+=	'		<div class="goodsInfo separatedRight relative">';
					str		+=	'			<div class="absoluteT infoText">';
					str		+=	'				<div class="f16 f_semiBold">'+review.goodsName+' ('+numberWithCommas(review.goodsPrice)+'원)</div>';
					if(review.goodsOpIdx > 0){
						str		+=	'				<div class="f12">';
						str		+=	'					<div>'+review.goodsOpName+' : '+review.goodsOpInfo+'('+numberWithCommas(review.goodsOpPrice)+'원) X '+review.orderQty+'개</div>';
						str		+=	'				</div>';
					} else {
						str 					+=	'				<div class="f12">';
						str 					+=	'					<div>기본 : '+review.orderQty+'개</div>';
						str 					+=	'				</div>';
					}
					str			+=	'			</div>';
					str			+=	'		</div>';
					str			+=	'	</div>';
					str			+=	'</li>';
				}
				str 			+=	'</ul>';
			} else if(cate == 2){
				$('.section').removeClass('myPostMod');
				$('.section').addClass('inquiryMod');
				str		+=	'<ul class="noticeList">';
				str		+=	'	<li class="infoGroup">';
				str		+=	'		<ul class="infoList">';

				for(var i = 0 ; i < list.length ; i++){
					var li 						=	list[i];
					var regDate					=	li.regDate;
					regDate 					=	regDate.substring(0, 10);

					var reStr 					=	'답변 미완료';
					if(li.reContents){
						reStr 					=	'답변완료';
					}

					str	+=	'<li class="relative">';
					str	+=	'	<a href="javascript:void(0);" class="noticeSpecShow noticeListTitle">';
					str	+=	'		<span class="ml30">'+li.subject+'</span>';
					str	+=	'		<span class="absoluteR f_roboto">'+li.regDate+'</span>';
					str	+=	'	</a>';
					str	+=	'	<div class="noticeSpecInfo questionGroup">';
					str	+=	'		<div class="goodsInfo separatedRight relative">';
					str	+=	'			<div class="infoText">';
					str	+=	'				<span class="f18 f_Bold f_red">Q</span>';
					str	+=	'				<span class="f12 ml25">'+li.contents+'</span>';
					str	+=	'			</div>';
					if(li.bbsFile1){
						str	+=	'			<div class="mt5">';
						for(var k = 1; k <= 5 ; k ++){
							if(eval('li.bbsFile'+ k)){
								bbsFile 				=	eval('li.bbsFile' + k);
								str	+=	'	<img src="http://nonghyup.heeyam.com'+bbsFile+'" class="goodsImg separatedLeft ml10">';
							}
						}
						str	+=	'			</div>';
					}
					str	+=	'			<div class="absoluteMR f_bold f20 f_red">'+reStr+'</div>';
					str	+=	'		</div>';
					str	+=	'	</div>';
					if(li.reContents){
						str	+=	'	<div class="noticeSpecInfo aswerGroup">';
						str	+=	'		<span class="f18 f_bold f_red absoluteL">A</span>';
						str	+=	'		<pre>'+li.reContents+'</pre>';
						str	+=	'		<span class="f14 absoluteR">'+li.reConDate+'</span>';
						str	+=	'	</div>';
					}
					str	+=	'</li>';

				}
				str			+=	'		</ul>';
				str			+=	'	</li>';
				str			+=	'</ul>';
			}
		} else {
			str 			+=	'	<li class="emptyList">등록된 글 목록이 없습니다.</li>';
		}

		$('.listGroup').html(str);
		setPaging(recordPerPage, pnoPerPage, pno, totalCount);
	});
}

function setSearchType(type){
	$('input[name="searchType"]').val(type);
	let typeStr 				=	'';
	if(type == 1){
		typeStr 				=	'제목';
	} else if(type == 2){
		typeStr 				=	'내용';
	} else if(type == 3){
		typeStr 				=	'제목 + 내용';
	}
	$('#searchType').html(typeStr);
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

// :: 문의사항 상세내용 표시 스크립트.
$(document).on('click', '.noticeSpecShow', function(){
	$(this).siblings('.noticeSpecInfo').slideToggle();
});
