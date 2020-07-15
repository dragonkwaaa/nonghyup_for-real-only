
//이미지 삭제
function delImg(e, num){
	let index			=	$('.del_btn').index(e);
	$('input[name="isDel_'+(index+1)+'"]').val(1);

	if(num > 0){
		$('input[name="isDel_'+num+'"]').val(1);
	}

	$(e).siblings('input').val('');
	$(e).siblings('canvas').remove();
	$(e).siblings('img').remove();

	// :: 해당 박스 선택시 표시되는 주황색 테두리를 제거하는 내용
	$(e).parent('.imgUploadBox').removeClass('selected');
	$(e).remove();
}

//이미지 선택시 미리보기
$(document).on('click', '.storeImgSmall .imgUploadBox img', function(){
	let img		=	$(this).attr('src');
	let showImg				=	$('#showImg');

	$(showImg).removeClass('hide');
	$(showImg).attr('src', img);
});

//이미지 업로드 버튼 클릭시
function img_upload(e){
	$(e).siblings('input').trigger('click');
}

//이미지 파일 업로드시
function img_sel(input){
	let ext				=	$(input).val().split(".").pop().toLowerCase();

	if(ext.length > 0){
		if($.inArray(ext, ["gif","png","jpg","jpeg"]) == -1) {
			alert("gif,png,jpg 파일만 업로드 할수 있습니다.");
			let file    =   $(input);

			let agent = navigator.userAgent.toLowerCase();
			if ( (navigator.appName == 'Netscape' && agent.indexOf('trident') != -1) || (agent.indexOf("msie") != -1)) {
				file.replaceWith( file.clone(true) );
			}else{
				file.val("");
			}
			return false;
		}
	} else {
		return;
	}

	//기존에 존재하는 이미지 및 삭제버튼 삭제
	$(input).siblings('img').remove();
	$(input).siblings('.del_btn').remove();

	//이미지, 삭제버튼 추가
	let str				=	'';
	str					+=	'<canvas></canvas>';
	str					+=	'<img src="' + URL.createObjectURL(event.target.files[0]) + '" alt="이미지">';
	str					+=	'<a href="#none" class="del_btn" onclick="delImg(this)">삭제</a>';
	$(input).closest('div').append(str);

	//이미지, 캔버스 태그 가져옴
	let imgTag			=	$(input).siblings('img');
	let canvasTag		=	$(input).siblings('canvas');

	//핸드폰 이미지의 가로세로버그 수정
 	// If file is loaded, create new FileReader
 	if (input.files && input.files[0]) {

		// Create a FileReader
		let reader = new FileReader();
		// Set onloadend function on reader
		reader.onloadend = function (e) {

			// Update an image tag with loaded image source
			// $('.imgShow').attr('src', URL.createObjectURL(event.target.files[0]));
			imgTag.attr('src', e.target.result);
			// Use EXIF library to handle the loaded image exif orientation
			EXIF.getData(input.files[0], function() {

				// Fetch image tag
				let img = imgTag.get(0);
				// Fetch canvas
				let canvas = canvasTag.get(0);
				// run orientation on img in canvas
				orientation(img, canvas);
			});
		};

		// Trigger reader to read the file input
		reader.readAsDataURL(input.files[0]);
	}

}


//모바일 이미지 재조정
function orientation(img, canvas) {
	
	// Set variables
	var ctx = canvas.getContext("2d");
	var exifOrientation = '';
	var width = img.width,
		height = img.height;
		

	// Check orientation in EXIF metadatas
	EXIF.getData(img, function() {
		var allMetaData = EXIF.getAllTags(this);
		exifOrientation = allMetaData.Orientation;
	});

	// set proper canvas dimensions before transform & export
	if (jQuery.inArray(exifOrientation, [5, 6, 7, 8]) > -1) {
		canvas.width = height;
		canvas.height = width;
	} else {
		canvas.width = width;
		canvas.height = height;
	}


	// transform context before drawing image
	switch (exifOrientation) {
		case 2:
			ctx.transform(-1, 0, 0, 1, width, 0);
			break;
		case 3:
			ctx.transform(-1, 0, 0, -1, width, height);
			break;
		case 4:
			ctx.transform(1, 0, 0, -1, 0, height);
			break;
		case 5:
			ctx.transform(0, 1, 1, 0, 0, 0);
			break;
		case 6:
			ctx.transform(0, 1, -1, 0, height, 0);
			break;
		case 7:
			ctx.transform(0, -1, -1, 0, height, width);
			break;
		case 8:
			ctx.transform(0, -1, 1, 0, 0, width);
			break;
		default:
			ctx.transform(1, 0, 0, 1, 0, 0);
	}

	// Draw img into canvas
	ctx.drawImage(img, 0, 0, width, height);

}