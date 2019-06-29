<?php
session_start();
include_once("dbconn.php");
$idx = $_REQUEST['idx'];
$sql = "select * from boardlist where idx = $idx ";
$result = mysqli_query($connect_db,$sql);
$row = mysqli_fetch_array($result);

?>
<!DOCTYPE>
<html lang='ko'>
<head>
<meta charset='utf-8'>
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
<form name="f1" action="edit_ok.php" method="POST">
<input type='hidden' name='idx' value="<?=$idx?>">
<table class="tbl">
<tr>
<td>작성자</td>
<td><input type='text' name='username' value="<?=$row['username'];?>" readonly></td>
</tr>
<tr>
<td>글제목</td>
<td><input type='text' name='subject' value="<?=$row['subject'];?>"></td>
</tr>
<tr>
<td>글본문</td>
<td><textarea cols="100" rows="20" name='contents' id="contents"><?=$row['contents'];?></textarea></td>
</tr>
<tr>
	<td colspan="2">
	<input type="button" value="리스트로 돌아가기" class='btn1' id='btnlist'>
	<?
	if($_SESSION['userid'] == $row['userid']){
	?>
	<input type="button" value="수정완료" class='btn1' id='btneditdone'>
	<?}?>
	</td>
</tr>
</table>
</form>
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
<script>
$("#btnlist").click(function(){
		location.href='list.php';
	});
	$("#btneditdone").click(function(){
		//validation.
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
	});
</script>
</body>
</html>