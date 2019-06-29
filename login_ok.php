<?php
session_start();

//전송되는 데이터를 받아줄 변수
include_once("dbconn.php");

$userid = $_REQUEST['userid'];
$userpw = $_REQUEST['userpw'];

$sql = "select * from user where userid= '$userid' and userpw = '$userpw' ";

$result = mysqli_query($connect_db, $sql);

//마지막 수행된 명령어의 결과 데이터가 몇건이냐?
$rows =  mysqli_affected_rows($connect_db);
if($rows ==0){ //해당하는 유저 데이터가 없을때
	echo "<script>alert('해당하는 유저정보가 없습니다.');history.back();</script>";
}else{//정상 로그인처리.
	$row = mysqli_fetch_array($result);
	//SESSION변수저장.
	$_SESSION['userid'] = $row['userid'];
	$_SESSION['username'] = $row['username'];
	echo "<script>alert('정상 로그인되었습니다.');location.href='list.php';</script>";
}
?>