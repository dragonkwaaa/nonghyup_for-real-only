
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
	var bottomStr 		=	'';
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

				bottomStr		+=	'<a href="'+url+'" class="recentViewMobile">';
				bottomStr		+=	'	<img src="'+img+'">';
				bottomStr		+=	'</a>';
			}
		}
		if(urlArrList.length){
			RECENT_NUM			=	urlArrList.length;
		}
	} else {
		urlArrList			=	[];
		imgArrList			=	[];
	}
	$('#RECENT_NUM').html(RECENT_NUM);
	$('#RECENT_PRODUCT').html(leftStr);
	$('#RECENT_PRODUCT_M').html(bottomStr);
});


let schUrlArrList 		=	localStorage.getItem('schUrlArr');
let schNameArrList 		=	localStorage.getItem('schNameArr');
$(document).ready(function(){
	schUrlArrList 			=	JSON.parse(schUrlArrList);
	schNameArrList 			=	JSON.parse(schNameArrList);
	var searchStr 		=	'';

	if(schUrlArrList){
		if(schUrlArrList.length > 0){
			for(var i = 0 ; i < schUrlArrList.length ; i ++){
				var url 		=	schUrlArrList[i];
				var name 		=	schNameArrList[i];
				if(url && name){
					searchStr 			+=	'<li class="relative">';
					searchStr 			+=	'<a href="'+url+'" class="searchWordName">'+name+'</a>';
					searchStr 			+=	'<a href="javascript:delete_recentSearch('+i+');" class="deleteBtn absoluteMR"></a>';
					searchStr 			+=	'<input type="hidden" name="TEMP_RECENT_URL'+i+'" value="'+url+'">';
					searchStr 			+=	'<input type="hidden" name="TEMP_RECENT_NAME'+i+'" value="'+name+'">';
					searchStr 			+=	'</li>';
				}
			}
		} else {
			searchStr					+=	'<li class="emptyWordList">';
			searchStr					+=	'	최근 검색한 단어가 없습니다.';
			searchStr					+=	'</li>';

			schUrlArrList				=	[];
			schNameArrList				=	[];
		}
	} else {
		searchStr					+=	'<li class="emptyWordList">';
		searchStr					+=	'	최근 검색한 단어가 없습니다.';
		searchStr					+=	'</li>';

		schUrlArrList				=	[];
		schNameArrList				=	[];
	}
	$('#RECENT_SEARCH').html(searchStr);
});


function delete_recentSearch(num){
	var url 						=	$('input[name="TEMP_RECENT_URL'+num+'"]').val();
	var name 						=	$('input[name="TEMP_RECENT_NAME'+num+'"]').val();
	console.log(url);
	schUrlArrList.splice(schUrlArrList.indexOf(url), 1);
	schNameArrList.splice(schNameArrList.indexOf(name), 1);
	localStorage.setItem('schUrlArr', JSON.stringify(schUrlArrList));
	localStorage.setItem('schNameArr', JSON.stringify(schNameArrList));
	location.reload();
}

// :: 팝업창 외부 클릭 시 닫기 스크립트.
$(document).mouseup(function (e) {
	let overlay = $('.container');
	let popup = $('.popup');
	let hamburgerM = $('.hamburgerListM')



    if(!$('.popup').hasClass("dailyPop")){
	    if (!popup.is(e.target) && popup.has(e.target).length === 0){
	    	popup.hide();
	    	overlay.removeClass('overlay');
        }
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



setTimeout( function(){ 
    $(document).ready(function() {
    // $(window).on('load', function() {
    	// :: 우측 졸졸이의 위치(top)값을 가져와 저장함. 숫자값만. 
    	let floatPosition = parseInt($(".rightFloat.webRightFloat").css('top'));
    	$(window).scroll(function() {
    		// :: 현재 화면 스크롤 위치값 가져옴.
    		let forRightScrollTop = $(window).scrollTop();
    		// :: top 값으로 지정할 졸졸이의 높이. 
    		let forRightNewPosition = forRightScrollTop + floatPosition + "px";
    		// :: 현재 보고 있는 화면의 밑바닥 높이의 값.
    		let forRightScrollBottom = $("body").height() - $(window).height() - $(window).scrollTop();
    		// :: 전체 페이지 꼭대기에서부터 푸터까지의 높이값.
    		let forRightLimitFooter = $('footer').position().top;
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
}  , 1000 );





// :: 모바일 화면 우측 졸졸이 따라다니는 기능 스크립트.
// $(document).ready(function() {
    $(window).on('load', function() {



        // :: 우측 졸졸이의 위치(top)값을 가져와 저장함. 숫자값만. 
        let floatPosition = parseInt($(".rightFloat.mMoveTop").css('top'));
    
        $(window).scroll(function() {
        
            // :: 현재 화면 스크롤 위치값 가져옴.
            let forRightScrollTop = $(window).scrollTop();
            // :: top 값으로 지정할 졸졸이의 높이. 
            let forRightNewPosition = forRightScrollTop + floatPosition + "px";
            // :: 현재 보고 있는 화면의 밑바닥 높이의 값.
            let forRightScrollBottom = $("body").height() - $(window).height() - $(window).scrollTop();
            // :: 전체 페이지 꼭대기에서부터 푸터까지의 높이값.
            let forRightLimitFooter = $('footer').position().top;
            // :: [조건] 현재 보고 있는 화면의 높이가 페이지 꼭대기보다 낮을 때.
            
            console.log(forRightScrollTop);
            
            // :: 화면 최상단을 보고 있을 때는 안 나오게 하는 스크립트.
            // if(1> forRightScrollTop > 0) {
    		// 	$(".rightFloat.mMoveTop").addClass('hide');
            // }


            if(forRightScrollTop > 0) {
                // $(".rightFloat.mMoveTop").removeClass('hide');
                $(".rightFloat.mMoveTop").stop().animate({
                    // "bottom" : forRightNewPosition
                    "bottom" : "20vw"
                }, 500);     

                // :: 상품 상세보기 페이지에만 적용되는 기능.
                $(".prdtBody .rightFloat.mMoveTop").stop().animate({
                    "bottom" : "30vw"
                }, 500);   
            }
            // :: [조건] 현재 보고 있는 화면의 높이가 페이지 밑바닥보다 xx픽셀 높을 때.

            // if (forRightScrollBottom < 400) {

                // $(".rightFloat.mMoveTop").show();

                // $(".rightFloat.mMoveTop").stop().animate({
                //     "bottom" : "72vw"
                // }, 500);

                // :: 상품 상세보기 페이지에만 적용되는 기능.
                // $(".prdtBody .rightFloat.mMoveTop").stop().animate({
                //     "bottom" : "92vw"
                // }, 500);
            // }
            
        }).scroll();
        
    });




/*
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

			/!*	document.getElementById('userSido').value				=	data.sido;
				document.getElementById('userSigungu').value			=	data.sigungu;*!/
			document.getElementById('zip').value					=	data.zonecode;
			document.getElementById('addr1').value					=	address;
			document.getElementById('addr2').focus();
			//getXY(address);
		}
	}).open();
}*/





// :: 메인 페이지 daily 팝업 위치값 설정 스크립트
// setTimeout( function(){ 
//     $(document).ready(function(){
//         $('.popup.dailyPop').css({
//             "top": (($(window).height()-$('.popup.dailyPop').outerHeight())/2+$(window).scrollTop())+"px",
//             "left": (($(window).width()-$('.popup.dailyPop').outerWidth())/2+$(window).scrollLeft())+"px",
//             "transform":"none",
//             "-webkit-transform":"none",
//         });
//     });
// } ,0 );