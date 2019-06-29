<?php
session_start();
include_once("dbconn.php");

//insert:저장 , select:조회할때, update : 수정, delete:삭제 4대 쿼리. 컬럼5개 : idx, subject, contents, username, regdate
//* : 모든컬럼.

//echo $_SESSION['userid'];
?>
<!DOCTYPE>
<html lang='ko'>
<head>
<meta charset='utf-8'>
<link rel='stylesheet' type='text/css' href='css/common.css'>
<style>
.tbl{
	 border-collapse: collapse;
	 width:800px;
}
.tbl tr td{
	width:200px;
	border:1px solid;
}
.alignright{
	text-align:right;
	display:inline-block;
	width:800px;
}
</style>
</head>
<body>
<a href="#layer2" class="btn-example">딤처리 팝업레이어 1</a>
<div class="dim-layer">
    <div class="dimBg"></div>
    <div id="layer2" class="pop-layer">
        <div class="pop-container">
            <div class="pop-conts">
                <!--content //-->
                <p class="ctxt mb20">Thank you.<br>
                    Your registration was submitted successfully.<br>
                    Selected invitees will be notified by e-mail on JANUARY 24th.<br><br>
                    Hope to see you soon!
                </p>

                <div class="btn-r">
					<input type='checkbox' name='notshow'>오늘하루 안보기
                    <a href="#" class="btn-layerClose">Close</a>
                </div>
                <!--// content-->
            </div>
        </div>
    </div>
</div>

<table class="tbl">
<tr>
<td>번호</td>
<td>제목</td>
<td>작성자</td>
<td>작성일</td>
</tr>
<?php
//페이지처리.

//(조건식) ? (명령문1) : (명령문2)
$page = !empty($_REQUEST['page']) ? $_REQUEST['page']:1;//현재 페이지번호.

// 페이지 설정
$page_set = 10; // 한페이지에 보여줄 글 수
$block_set = 10; // 한화면에 보여줄 페이지 갯수 블럭수

$limit_idx = ($page - 1) * $page_set; // limit시작위치

$sql = "select * from boardlist";
$sql = $sql ." LIMIT $limit_idx, $page_set";

$result = mysqli_query($connect_db, $sql);

$sqltotal = "select * from boardlist";
$resulttotal = mysqli_query($connect_db , $sqltotal);
$total = mysqli_num_rows($resulttotal);//전체글수.


$total_page = ceil ($total / $page_set); // 총페이지수(올림함수)

$total_block = ceil ($total_page / $block_set); // 총블럭수(올림함수)

$block = ceil ($page / $block_set); // 현재블럭(올림함수)

								// 페이지번호 & 블럭 설정
$first_page = (($block - 1) * $block_set) + 1; // 첫번째 페이지번호

$last_page = min ($total_page, $block * $block_set); // 마지막 페이지번호

 $prev_page = $page - 1; // 이전페이지
$next_page = $page + 1; // 다음페이지

$prev_block = $block - 1; // 이전블럭
$next_block = $block + 1; // 다음블럭

// 이전블럭을 블럭의 마지막으로 하려면...
$prev_block_page = $prev_block * $block_set; // 이전블럭 페이지번호

// 이전블럭을 블럭의 첫페이지로 하려면...
//$prev_block_page = $prev_block * $block_set - ($block_set - 1);
$next_block_page = $next_block * $block_set - ($block_set - 1); // 다음블럭 페이지번호


while($row = mysqli_fetch_array($result)){
?>
<tr>
<td><?=$row['idx']?></td>
<td><a href="detail.php?idx=<?=$row['idx']?>"><?=$row['subject']?></a></td>
<td><?=$row['username']?></td>
<td><?=$row['regdate']?></td>
</tr>
<?
}
//페이지번호.
?>
</table>
<?php
// 페이징 화면
echo ($prev_page > 0) ? "<a href='?page=$prev_page'>[prev]</a> " : "[prev] ";
echo ($prev_block > 0) ? "<a href='?page=$prev_block_page'>...</a> " : "... ";

for ($i=$first_page; $i<=$last_page; $i++) {
echo ($i != $page) ? "<a href='?page=$i'>$i</a> " : "<b>$i</b> ";
}

echo ($next_block <= $total_block) ? "<a href='?page=$next_block_page'>...</a> " : "... ";
echo ($next_page <= $total_page) ? "<a href='?page=$next_page'>[next]</a>" : "[next]";
?>
<div class='alignright'>
<input type='button' id='btnwrite' value='글쓰기'>
</div>
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
<script>
var islogin = false;
<?
//비어있지 않다면 => 로그인이 되어있다면
	if(!empty($_SESSION['userid'])){
?>
	islogin = true;
<?}?>

var btnwrite = document.getElementById("btnwrite");
btnwrite.addEventListener("click",function(){
	//로그인체크(로그인 상태값 : session)
	if(islogin)
		location.href='write.php';
	else{
		alert('로그인 후 이용해주세요');
		location.href='login.php';
	}
});

var getCookie = function(name) {
  var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
  return value? value[2] : null;
};

//key, value, 유효기간.
var setCookie = function(name, value, exp) {
  var date = new Date();
  date.setTime(date.getTime() + exp*24*60*60*1000);//하루 24* 60 * 60 * 1000:1초. 하루.
  document.cookie = name + '=' + value + ';expires=' + date.toUTCString() + ';path=/';
};

//쿠키 데이터를 과거날짜로 세팅해서 만료시켜버림.
var deleteCookie = function(name) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

//$(function(){});
$(function(){
	//쿠키가 있는지 판단. 쿠키가 없으면 layer팝업 띄움.
	console.log(!getCookie('myck'));
	if(!getCookie('myck')){
		var $href = $('.btn-example').attr('href');
		layer_popup($href);
	}
	
});


$('.btn-example').click(function(){
	var $href = $(this).attr('href');
	layer_popup($href);
});
function layer_popup(el){

	var $el = $(el);        //레이어의 id를 $el 변수에 저장
	var isDim = $el.prev().hasClass('dimBg');   //dimmed 레이어를 감지하기 위한 boolean 변수

	isDim ? $('.dim-layer').fadeIn() : $el.fadeIn();

	var $elWidth = ~~($el.outerWidth()),
		$elHeight = ~~($el.outerHeight()),
		docWidth = $(document).width(),
		docHeight = $(document).height();

	// 화면의 중앙에 레이어를 띄운다.
	if ($elHeight < docHeight || $elWidth < docWidth) {
		$el.css({
			marginTop: -$elHeight /2,
			marginLeft: -$elWidth/2
		})
	} else {
		$el.css({top: 0, left: 0});
	}

	$el.find('a.btn-layerClose').click(function(){
		//쿠키값 세팅.
		console.log($("input[name='notshow']").is(":checked"));
		//if($("input[name='notshow']:ischecked"))
		if($("input[name='notshow']").is(":checked")){
			setCookie('myck','checkdone',1);
		}
		isDim ? $('.dim-layer').fadeOut() : $el.fadeOut(); // 닫기 버튼을 클릭하면 레이어가 닫힌다.
		return false;
	});

	$('.layer .dimBg').click(function(){
		$('.dim-layer').fadeOut();
		return false;
	});

}
</script>
</body>
</html>