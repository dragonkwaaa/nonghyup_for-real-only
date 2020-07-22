<!DOCTYPE html>
<html lang="ko">

<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/head.php';

if(!$User->userCode()){
	$CommonManager->goPage('/intro/login','로그인한 회원만 사용가능합니다.');
}


?>

<body>
<div class="container">

	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/header.php';?>

	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/topMenu.php';?>

	<div class="contents">

		<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/rightFloat.php';?>


		<div class="section cartSect">
			<form name="frm" id="frm" onkeypress="if(event.keyCode==13) {document.frm.submit(); return false;}">
				<input type="hidden" name="token" value="<?=$_SESSION['token'][$Common->nowPage()]?>">
				<input type="hidden" name="isRegular" value="0">
				<input type="hidden" name="orgAmount" value="0">
				<input type="hidden" name="amount" value="0">
				<input type="hidden" name="payMethod" value="0">
				<input type="hidden" name="directOrder" value="0">
			<div class="mainTitle">장바구니</div>
			<!-- 정기배송/일반배송 탭 선택지 파트 -->
			<ul class="findPageTab deliveryTypeTab">
				<li id="regularCart">
					<a href="javascript:get_cart(1)">정기배송</a>
				</li>
				<li id="notRegularCart">
					<a href="javascript:get_cart(2)">일반배송</a>
				</li>
			</ul>
			<!-- :: 상품 리스트 파트 -->
			<div class="separatedLeft cartItemGroup">
				<div class="listGroup">
					<div class="listTop" id="checkSel">
						<label>
							<input type="checkbox" name="checkAll" value="1" onclick="codeCheckAll()" checked>
							<span class="f_semiBold">전체선택</span>
						</label>
					</div>
					<ul class="goodsList">
					</ul>
				<!--	<ul class="notRegularList">
					</ul>-->
					<!-- :: 선택 관련 버튼 파트 -->
					<div class="btnGroup mt20" id="buttonSel">
						<a href="javascript:checkAll();" class="plainBtn">전체선택</a>
						<a href="javascript:delete_cartArr();" class="plainBtn ml7">선택삭제</a>
					</div>

					<ul class="pagingGroup">
					</ul>
				</div>
			</div>
			<!-- :: 장바구니 결제정보 졸졸이 파트 -->
			<div class="separatedRight rightFloat innerFloat">
				<div class="boxTitle">
					<span class="f17 f_bold">결제정보</span>
					<span class="f14 ml3" id="cartNum"></span>
				</div>
				<!-- :: 금액정보 표시 파트 -->
				<div class="mt20 f14">
					<div>
						<span>총 상품 금액</span>
						<span class="floatR f_bold" id="totalPrice"></span>
					</div>
					<div class="mt20">
						<span>총 배송비</span>
						<span class="floatR">무료</span>
					</div>
					<div class="mt20">
						<span>총 할인금액</span>
						<span class="floatR f_bold" id="discountPrice">0원</span>
					</div>
				</div>
				<div class="bg_lightGrey mt20 priceBox">
					<span class="f14">결제 예정 금액</span>
					<span class="floatR f_red f24 f_bold" id="orderPrice"></span>
				</div>
				<a href="javascript:set_order()" class="rimlessBtn bg_yellow f_white mt20 f_bold" id="buyButton">주문하기</a>
			</div>
		</div>
		</form>
	</div>
	<!--<a href="javascript:set_order();">테스트버튼</a>-->
	<!-- :: 푸터 파트 -->
	<?php include $_SERVER['DOCUMENT_ROOT'] .  '/common/pages/footer.php';?>

</div>
<!-- :: 비밀번호 재설정 팝업 -->
<div class="popup changeOptionPop">
	<a href="javascript:void(0);" class="closePopBtn absoluteR"></a>
	<div class="popupTitleBox changeoptionGroup">
		<div class="mainTitle tAlignL" id="tempName">새벽에 수확한 딸기</div>
	</div>
	<ul class="regInfoList changeoptionGroup">
		<li class="infoGroup">
			<div class="mainCon">
				<table class="infoRegTable changeoptionGroup">
					<colgroup>
						<col width="156">
						<col width="485">
					</colgroup>
					<tbody>
					<tr id="tempOpSel">
						<th id="popupOpData"></th>
						<!--<td>
							<span class="sbox">
								<a href="javascript:void(0);">은행 선택</a>
								<ul>
									<li>국민은행</li>
									<li>우리은행</li>
								</ul>
							</span>
						</td>-->
					</tr>
					<input type="hidden" id="tempCartCode" value="">
					<tr>
						<th>수량</th>
						<td>
							<div class="quantityBox">
								<a href="javascript:updateQty('M');" class="decreaseIcon">-</a>
								<input value="" class="quantity" id="tempQty">
								<a href="javascript:updateQty('P');" class="increaseIcon">+</a>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
				<div class="tAlignR mt40">
					<span class="f14 vAlignM">총 합계금액</span>
					<span class="f_red f24 f_bold vAlignM ml14" id="tempPerTotal">0 원</span>
				</div>
			</div>
		</li>
		<li>
			<div class="btnGroup">
				<a href="javascript:void(0);" class="plainBtn cancelBtn f24">취소</a>
				<a href="javascript:update_cartQty();" class="changePW rimlessBtn regBtn f24">변경</a>
			</div>
		</li>
	</ul>
</div>

<script src="/my/js/cart.js"></script>
</body>
</html>