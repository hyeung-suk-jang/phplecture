<?php
//전송되는 데이터를 받아줄 변수
include_once("dbconn.php");

$idx = $_REQUEST['idx'];

//db connection.
$sql = "delete from boardlist where idx = $idx ";

$result = mysqli_query($connect_db, $sql);
$rows =  mysqli_affected_rows($connect_db);
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