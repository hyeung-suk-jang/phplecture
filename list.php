<?php
include_once("dbconn.php");

//insert:저장 , select:조회할때, update : 수정, delete:삭제 4대 쿼리. 컬럼5개 : idx, subject, contents, username, regdate
//* : 모든컬럼.
$result = mysqli_query($connect_db,"select * from boardlist");

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
<table class="tbl">
<tr>
<td>번호</td>
<td>제목</td>
<td>작성자</td>
<td>작성일</td>
</tr>
<?php
while($row = mysqli_fetch_array($result)){
?>
<tr>
<td><?=$row['idx']?></td>
<td><?=$row['subject']?></td>
<td><?=$row['username']?></td>
<td><?=$row['regdate']?></td>
</tr>
<?
}
?>
</table>
<div class='alignright'>
<input type='button' id='btnwrite' value='글쓰기'>
</div>
<script>
var btnwrite = document.getElementById("btnwrite");
btnwrite.addEventListener("click",function(){
	//로그인체크
	location.href='write.php';
});
</script>
</body>
</html>