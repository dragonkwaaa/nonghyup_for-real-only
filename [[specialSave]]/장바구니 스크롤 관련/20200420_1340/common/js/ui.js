
// :: 셀렉트박스 스크립트(공용)
$(document).on('click', '.sbox a', function(){
	$(this).siblings('ul').slideToggle();
})

// :: 셀렉트박스 내용 선택시, 셀렉트박스 리스트 닫기 스크립트(공용)
$(document).on('click', '.sbox ul li', function(){
	$(this).parent('ul').slideToggle();
})

// :: 팝업 닫기 스크립트
$(document).on('click', '.closePopBtn', function(){
	$('.popup').hide();
	$('.container').removeClass('overlay');
});

// :: 팝업창 "취소" 버튼 클릭 시 팝업 닫기 스크립트
$(document).on('click', '.popup .cancelBtn', function(){
	$('.popup').hide();
	$('.container').removeClass('overlay');
});


let urlArrList 			=	localStorage.getItem('urlArr');
let imgArrList 			=	localStorage.getItem('imgArr');
$(document).ready(function(){

	urlArrList 				=	JSON.parse(urlArrList);
	imgArrList 				=	JSON.parse(imgArrList);
	var leftStr			=	'';
	let RECENT_NUM 		=	0;
	if(urlArrList){
		for(var i = 0 ; i < 4 ; i ++){
		/*for(var i = 0 ; i < urlArrList.length ; i ++){*/

			var url 		=	urlArrList[i];
			var img 		=	imgArrList[i];
			if(url && img){
				leftStr			+=	'<li>';
				leftStr			+=	'	<a href="'+url+'">';
				leftStr			+=	'		<img src="'+img+'">';
				leftStr			+=	'	</a>';
				leftStr			+=	'</li>';
			}
		}
		RECENT_NUM			=	urlArrList.length;
	} else {
		urlArrList			=	[];
		imgArrList			=	[];
	}
	$('#RECENT_NUM').html(RECENT_NUM);
	$('#RECENT_PRODUCT').html(leftStr);
});





// :: 팝업창 외부 클릭 시 닫기 스크립트.
$(document).mouseup(function (e) {
	let overlay = $('.container');
	let popup = $('.popup');
	let hamburgerM = $('.hamburgerListM')

	if (!popup.is(e.target) && popup.has(e.target).length === 0){
		popup.hide();
		// hamburgerM.hide("slide", { direction: "left" }, 250);
		overlay.removeClass('overlay');
	}
});


// :: 모바일 햄버거 메뉴 클릭 시 닫기 스크립트
$(document).mouseup(function (e) {
	let overlay = $('.container');
	let hamburgerM = $('.hamburgerListM')

	if (!hamburgerM.is(e.target) && hamburgerM.has(e.target).length === 0){
		hamburgerM.hide("slide", { direction: "left" }, 250);
		overlay.removeClass('hamOverlay');
	}
});


// :: 버튼 누르면 페이지 최상단으로 이동하는 버튼 스크립트
function moveTopFunction() {

	$('html').stop().animate({
		scrollTop : 0
	}, 500);
}




// :: 웹 화면 우측 졸졸이 따라다니는 기능 스크립트.
$(document).ready(function() {
	$(window).scroll(function() {
		// :: 우측 졸졸이의 위치(top)값을 가져와 저장함. 숫자값만.
		var floatPosition = parseInt($(".rightFloat.webRightFloat").css('top'));
		// :: 현재 화면 스크롤 위치값 가져옴.
		var forRightScrollTop = $(window).scrollTop();
		// :: top 값으로 지정할 졸졸이의 높이. 
		var forRightNewPosition = forRightScrollTop + floatPosition + "px";
		// :: 현재 보고 있는 화면의 밑바닥 높이의 값.
		var forRightScrollBottom = $("body").height() - $(window).height() - $(window).scrollTop();
		// :: 전체 페이지 꼭대기에서부터 푸터까지의 높이값.
		var forRightLimitFooter = $('footer').position().top;
		// :: [조건] 현재 보고 있는 화면의 높이가 페이지 꼭대기보다 낮을 때.
		if(forRightScrollTop > 0) {
			$(".rightFloat.webRightFloat").stop().animate({
				"top" : forRightNewPosition
			}, 500);
		}
		// :: [조건] 현재 보고 있는 화면의 높이가 페이지 밑바닥보다 480픽셀 높을 때.
		if (forRightScrollBottom < 480) {
			$(".rightFloat.webRightFloat").stop().animate({
				"top" : forRightLimitFooter - 900
			}, 500);
		}

	
	}).scroll();
	
});
