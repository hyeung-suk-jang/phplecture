<?php
//전송되는 데이터를 받아줄 변수
include_once("dbconn.php");

$username = $_REQUEST['username'];
$subject = $_REQUEST['subject'];
$contents = $_REQUEST['contents'];

//db connection.
$sql = "insert into boardlist(subject, contents, username, regdate) values('$subject','$contents','$username',now())";

$result = mysqli_query($connect_db, $sql);
$rows =  mysqli_affected_rows($connect_db);
if($rows ==1){ //정상케이스
	echo "<script>alert('정상적으로 저장되었습니다.');history.back();</script>";
}else{
	echo "<script>alert('저장되지 않았습니다.');history.back();</script>";
}
?>