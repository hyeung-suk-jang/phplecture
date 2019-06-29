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
<form name="f1" action="login_ok.php" method="POST">
로그인하기
<table class="tbl">
<tr>
<td>ID</td>
<td><input type='text' name='userid'></td>
</tr>
<tr>
<td>PW</td>
<td><input type='password' name='userpw'></td>
</tr>
<tr>
<tr>
<td colspan="2" class="alignright">
<input type="button" value="리스트로 돌아가기" class='btn1' id='btnlist'><input type="button" value="확인" id='btnlogin'>
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
	$("#btnlogin").click(function(){
		//validation


		if(!$("input[name='userid']").val()){
			alert('아이디를 입력해주세요');
			$("input[name='userid']").focus();
			return false;
		}
		if(!$("input[name='userpw']").val()){
			alert('패스워드를 입력해주세요');
			$("input[name='userpw']").focus();
			return false;
		}
		
		f1.submit();
		
	});
	$("#btnlist").click(function(){
		location.href='list.php';
	});
});
</script>
</body>
</html>