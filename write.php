<?php
session_start();

$idx = @$_REQUEST['idx'];
$type = @$_REQUEST['type'];

?>
<!DOCTYPE>
<html lang='ko'>
<head>
<meta charset='utf-8'>
<style>
.tbl .alignright{
	text-align:right;
}
.tbl .btn1{
	margin-right:20px;
}
</style>
</head>
<body>
<form name="f1" action="write_ok.php" method="POST" enctype="multipart/form-data">
<input type='hidden' name='type' value='<?=$type?>'>
<input type='hidden' name='idx' value='<?=$idx?>'>

<table class="tbl">
<tr>
<td>SMS</td>
<td><input type='checkbox' value="smsok" name="sms">관리자에게 sms전송하기.</td>
</tr>
<tr>
<td>mail</td>
<td><input type='checkbox' value='mail' name='mail'>관리자에게 메일보내기</td>
</tr>
<tr>
<td>작성자</td>
<td><input type='text' name='username' value="<?=$_SESSION['username']?>"></td>
</tr>
<tr>
<td>글제목</td>
<td><input type='text' name='subject'></td>
</tr>
<tr>
<td>글본문</td>
<td><textarea cols="100" rows="20" name='contents' id="contents"></textarea></td>
</tr>
<tr>
<td>첨부파일</td>
<td><input type='file' name='fileupload'></td>
</tr>
<tr>
<td colspan="2" class="alignright">
<input type="button" value="취소" class='btn1' id='btncancel'><input type="button" value="리스트로 돌아가기" class='btn1' id='btnlist'><input type="button" value="저장" id='btnsave'>

</td>
</tr>
</table>
</form>
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
<script>
$(function(){
	$("#btnsave").click(function(){
		if(!$("input[name='username']").val()){
			alert('작성자를 입력해주세요');
			$("input[name='username']").focus();
			return false;
		}
		if(!$("input[name='subject']").val()){
			alert('글 제목을 입력해주세요');
			$("input[name='subject']").focus();
			return false;
		}
		if(!$("#contents").val()){
			alert('글 본문을 입력해주세요');
			$("#contents").focus();
			return false;
		}
		//sendmail('azanghs@gmail.com');
		f1.submit();
		//데이터베이스 저장. form, ajax
		
	});
	$("#btnlist").click(function(){
		location.href='list.php';
	});
});

function sendmail(userid){
	var senddata = {usermail : userid}
	$.ajax({
		url:"./mail/sendmail.php",
		method:'post',
		data:senddata,
		async:true,
		dataType:'html',
		success:function(data){
			alert('메일이 발송되었습니다.');
		},
		error:function(data){
			console.log(data);
			alert(msg.ajaxerror);
			return false;
		}
	})

}
</script>
</body>
</html>