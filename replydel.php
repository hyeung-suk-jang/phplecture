<?php
session_start();
include_once("dbconn.php");

//parameter
$idx = $_REQUEST['idx'];

$sql = "delete from reply  where idx = $idx ";
$result = mysqli_query($connect_db, $sql);

$rows =  mysqli_affected_rows($connect_db);
if($rows ==0){ //비정상. 적용된 데이터가 없음.
?>
	 {"res":"F","msg":"삭제되지 않았습니다."}
<?
}else{
?>
	{"res":"S","msg":"정상삭제 되었습니다."}
<?
}
?>