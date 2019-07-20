<?php
session_start();
include_once("dbconn.php");

//parameter
$idx = $_REQUEST['idx'];
$replytext = $_REQUEST['replytext'];

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

$sql = "update reply set replytext = '$replytext', regdate = now() where idx = $idx ";
$result = mysqli_query($connect_db, $sql);

$rows =  mysqli_affected_rows($connect_db);
if($rows ==0){ //비정상. 적용된 데이터가 없음.
?>
	 {"res":"F","msg":"수정되지 않았습니다."}
<?
}else{
	//방금 입력된 데이터를 다시 가져와서 밑에 스트링 구조를 만든다.
	$sql = "select * from reply where idx = $idx ";//내림차순.
	$result = mysqli_query($connect_db, $sql);
	$row = mysqli_fetch_array($result);

	//json_encode( $data );
	//json_encode( $row );//{'boardidx':'1','userid':'test1',}
?>
	{"res":"S","msg":"정상수정 되었습니다.","userid":"<?=$row['userid']?>","username":"<?=$username?>","text":"<?=$row['replytext']?>","regdate":"<?=$row['regdate']?>",
	"idx":"<?=$row['idx']?>"}
<?
}
?>