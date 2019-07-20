<?php
session_start();
include_once("dbconn.php");
$idx = $_REQUEST['idx'];
$sql = "select * from boardlist where idx = $idx ";
$result = mysqli_query($connect_db,$sql);
$row = mysqli_fetch_array($result);
$filename = $row['filename'];

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
<colgroup>
	<col width="30%">
	<col width="70%">
</colgroup>
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
	<td>첨부파일</td>
	<td><a href="#" id="download"><?=$row['filename']?></td>
</tr>
<tr>
	<td colspan="2">
	<input type="button" value="리스트로 돌아가기" class='btn1' id='btnlist'>
	<?
	//empty(), isset(), && : and조건 - 둘다 true가 되어야 전체 조건식이 true.
	if(isset($_SESSION['userid']) && $_SESSION['userid'] == $row['userid']){
	?>
	<input type="button" value="수정" class='btn1' id='btnedit'><input type="button" value="삭제" id='btndel'>
	<?}?>
	<input type='button' value='답변달기' id="btnanswer">
	</td>
</tr>
<tr>
	<td colspan="2" id="replylist">
		<?
		//join : 하나의 기준데이터에서 연결고리를 갖는 다른테이블의 데이터도 같이 가져오고 싶을때 join.
			$sql = "select r.*,u.username from reply r join user u on r.userid = u.userid where r.boardidx = $idx ";
			$result = mysqli_query($connect_db,$sql);
			while($replyrow = mysqli_fetch_array($result)){
				echo $replyrow['username']."(".$replyrow['userid'].") : ".$replyrow['replytext']." ".$replyrow['regdate'];
				//내가 쓴 댓글.
				if($_SESSION['userid'] == $replyrow['userid']){
					echo "<input type='button' value='수정' class='btnreplyedit' data-idx='".$replyrow['idx']."'>";
					echo "<input type='button' value='삭제' class='btnreplydelete' data-idx='".$replyrow['idx']."'><br>";
				}
			}
		?>


	</td>
</tr>
<tr>
	<td>댓글입력</td>
	<td><textarea cols="80" rows="5" name="reply" id="reply"></textarea>
	<input type='button' value='입력완료' id="replybtn">
	</td>
</tr>
</table>
</form>
<form name="f3" id='f3' action='download.php'>
<input type='hidden' name='filename' value='<?=$filename?>'>
</form>
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
<script>
$(function(){
	var islogin = false;
	var idx = <?=$idx?>;

	var replyidx;
	$("#replybtn").click(function(e){
		//logincheck
		<?
			if(isset($_SESSION['userid'])){
		?>
			islogin = true;
		<?
			}
		?>
		
		if(!islogin){
			alert("로그인을 먼저해주세요");
			location.href='login.php';
			return false;
		}
		if(!$("#reply").val()){
			alert("댓글을 입력해주세요");
			$("#reply").focus();
			return false;
		}
		
		//댓글 저장.
		var sendvalue = {
			replyvalue : $("#reply").val(),
			boardidx : <?=$idx;?>
		}
		//비동기통신:서버의 응답을 기다리지 않는다. 기다리는 동안 다른 작업을 할 수 있다., 동기통신:서버의 응답을 기다린다. 기다리는 동안 다른 작업을 할 수 없다.
		$.ajax({
			url:'addreply.php',
			data:sendvalue,
			dataType:'json',
			async:true,
			success:function(result){
				alert(result.msg);
				//dom추가.
				if(result.res == 'S'){
					$("#replylist").append(result.username + "(" +result.userid+")"+ result.text+" "+result.regdate);
					$("#replylist").append("<input type='button' value='수정' class='btnreplyedit' data-idx='"+result.idx+"'>");
					$("#replylist").append("<input type='button' value='삭제' class='btnreplydelete' data-idx='"+result.idx+"'>");
				}
			},
			error:function(request,status,error){
				alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
		});
	});

	//답변글 달기.
	$("#btnanswer").click(function(){
		location.href = 'write.php?type=answer&idx='+idx;
	})

	$("#btnlist").click(function(){
		location.href='list.php';
	});

	$("#btnedit").click(function(){
		location.href= 'edit.php?idx=$idx';
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
	$("#download").click(function(e){
		e.preventDefault();
		form = $('#f3');
		form.submit();
	});

	//댓글 수정 버튼을 눌렀을때.
	$(".btnreplyedit").click(function(e){
		replyidx = $(this).attr("data-idx");

		var text = $(this).parent().text();
		var arr = text.split(":");//["장형석(test1), " 본문 2019-07-20 14","30","02];
		console.log(arr[1]);
		var reply = arr[1].substring(0,  arr[1].length - 13);
		console.log(reply);
		$(this).parent().html("<input type='text' name='editbox' value='"+reply+"'><input type='button' value='완료' class='btneditdone'>");
		//$(this).parent().find('input[name="editbox"]').focus();
	});

	//댓글 삭제 버튼을 눌렀을때
	$(".btnreplydelete").click(function(e){
		replyidx = $(this).attr("data-idx");
		var $td = $(this).parent();
		var senddata = {
			idx : replyidx
		}
		//ajax
		$.ajax({
			url:'replydel.php',
			data:senddata,
			dataType:'json',
			success:function(result){
				alert(result.msg);
				//dom추가.
				if(result.res == 'S'){
					$td.html('');
				}
			},
			error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		  }
		});
		
	});

	//동적으로 추가된 요소에 이벤트를 걸때.
	$(document).on("click",".btneditdone",function(e){
		//validation
		if(!$("input[name='editbox']").val()){
			alert("댓글을 입력해주세요");
			$("input[name='editbox']").focus();
			return false;
		}
		var $td = $(this).parent();

		//ajax 수정요청.
		var senddata = {
			idx : replyidx,
			replytext :$("input[name='editbox']").val() 
		};
		//alert(senddata.idx+","+senddata.replytext);
		//return;
		//
		$.ajax({
			url:'replyedit.php',
			data:senddata,
			dataType:'json',
			success:function(result){
				alert(result.msg);
				console.dir(result);
				//this : 통신하고 난 결과.
				console.log($td);
				//dom추가.
				if(result.res == 'S'){
					$td.html('');
				
					$td.append(result.username + "(" +result.userid+")"+ result.text+" "+result.regdate);
					$td.append("<input type='button' value='수정' class='btnreplyedit' data-idx='"+result.idx+"'>");
					$td.append("<input type='button' value='삭제' class='btnreplydelete' data-idx='"+result.idx+"'>");
				}
			},
			error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		  }
		});
	});
});	
	
</script>
</body>
</html>