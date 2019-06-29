<?php
//db 서버에 저장.
$mysql_host = "localhost";//db 서버의 주소.
$mysql_user = 'root';//계정정보.
$mysql_password = '';//비밀번호
$mysql_db = 'phpstudy';

//$db = new PDO('mysql:host=localhost;dbname=vimeodb;charset=utf8mb4', $mysql_user, $mysql_password);
//$result = $db -> exec("INSERT INTO board(username, title, reg_date, contents ) VAULES('$username', '$title','$contents',now())");
//echo $result;

$connect_db = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_db) or die("<meta http-equiv='content-type' content='text/html; charset=utf-8'><script language='JavaScript'> alert('DB 접속 오류'); </script>");

//db서버에 전송하는 명령어. string/문자. SET NAMES 'utf8' : database서버가 문자셋 정보를 utf8로 이해하게 세팅한다.
//utf8 : 언어(한국어,영어,..기타) 가 = 010101: utf8방식이라는 약속중의 하나. encoding 방식 중에 하나.
//utf8 : 한글, 영어, 일본어.
mysqli_query($connect_db,"SET NAMES 'utf8'");
?>