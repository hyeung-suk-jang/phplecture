<?php
//전송되는 데이터를 받아줄 변수
include_once("dbconn.php");

$idx = $_REQUEST['idx'];
$subject = $_REQUEST['subject'];
$contents = $_REQUEST['contents'];

//db connection.
$sql = "update boardlist set subject = '$subject', contents = '$contents' where idx = $idx ";

$result = mysqli_query($connect_db, $sql);
$rows =  mysqli_affected_rows($connect_db);
if($rows ==0){ //비정상. 적용된 데이터가 없음.
	echo "<script>alert('수정되지 않았습니다.');history.back();</script>";
}else{
	echo "<script>alert('정상 수정되었습니다.');location.href='list.php';</script>";
}
?>