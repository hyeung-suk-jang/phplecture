<?php
//전송되는 데이터를 받아줄 변수
include_once("dbconn.php");

$idx = $_REQUEST['idx'];


//첨부 파일 있는지 판단하기.
$sql = "select * from boardlist where idx=$idx";
$result = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
if(!empty($row['filename']) && $row['filename']!=""){//첨부파일이 있을경우.
	//file delete
	unlink("./userfile/".$row['filename']);
}

//딸려있는 댓글도 삭제.
$sql = "delete from reply where boardidx = $idx";
$result = mysqli_query($connect_db, $sql);


//db connection.
$sql = "delete from boardlist where idx = $idx ";
$result = mysqli_query($connect_db, $sql);


$rows =  mysqli_affected_rows($connect_db);



//답변글 삭제.


if($rows ==0){ //비정상. 적용된 데이터가 없음.
?>
{"result":"E","msg":"삭제되지 않았습니다."}
<?
}else{
?>
{"result":"S","msg":"정상 삭제 되었습니다."}
<?
}
?>