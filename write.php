<?php
session_start();

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
<form name="f1" action="write_ok.php" method="POST">
<table class="tbl">
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
		
		f1.submit();
		//데이터베이스 저장. form, ajax
		
	});
	$("#btnlist").click(function(){
		location.href='list.php';
	});
});
</script>
</body>
</html>