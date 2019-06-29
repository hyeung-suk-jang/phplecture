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
<form name="f1" action="write_ok.php" method="POST">
<table class="tbl">
<tr>
<td>작성자</td>
<td><?=$row['username'];?></td>
</tr>
<tr>
<td>글제목</td>
<td><?=$row['subject'];?></td>
</tr>
<tr>
<td>글본문</td>
<td><?=$row['contents'];?></td>
</tr>
<tr>
	<td colspan="2">
	<input type="button" value="리스트로 돌아가기" class='btn1' id='btnlist'>
	<?
	if($_SESSION['userid'] == $row['userid']){
	?>
	<input type="button" value="수정" class='btn1' id='btnedit'><input type="button" value="삭제" id='btndel'>
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

	$("#btnedit").click(function(){
		location.href= 'edit.php?idx=<?=$idx?>';
	});

	$("#btndel").click(function(){
		if(confirm("정말 삭제하시겠습니까?")){
			var senddata = {
				idx : <?=$idx?>
			};
			//ajax 삭제.
			$.ajax({
			  url: "del.php",
			  //POST, GET
			  method: "POST",
			  data: senddata,
				  //json : {"name":"value","name":"value"}, html : <ul><li></li><li></li></ul>
			  dataType: "json",
		      async:true,
			  success:function(data){//data = "{'result':'E','msg':'삭제되지 않았습니다.'}";
				console.log(data);
				if(data.result == "S"){
					alert(data.msg);
					location.href='list.php';
				}else{
					alert(data.msg);
				}
				

			  },
				error:function(request,status,error){
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			  }
			});
		}

	});
</script>
</body>
</html>