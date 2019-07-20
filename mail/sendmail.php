<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('Exception.php');
require_once('PHPMailer.php');
require_once('SMTP.php');

//리퀘스트.
$usermail = $_REQUEST['usermail'];//유저메일정보.

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
$mail->IsSMTP(); // telling the class to use SMTP

try {
    $mail->Host = "smtp.gmail.com"; // email 보낼때 사용할 서버를 지정
    $mail->SMTPAuth = true; // SMTP 인증을 사용함
    $mail->Port = 465; // email 보낼때 사용할 포트를 지정
    $mail->SMTPSecure = "ssl"; // SSL을 사용함
    $mail->Username   = "azanghs@gmail.com"; // Gmail 계정
    $mail->Password   = "supremegosu1"; // 패스워드
    $mail->SMTPDebug = 2;
    $mail->CharSet = "utf-8";  //한글깨짐 방지를 위한 문자 인코딩설정
    $mail->SetFrom('azanghs@gmail.com', 'PHP강의관리자'); // 보내는 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)
    $mail->AddAddress($usermail, '고객님'); // 받을 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)
    $mail->Subject = 'PHP강의 인증메일입니다.'; // 메일 제목
    $mail->MsgHTML("메일내용 : 1234"); // 메일 내용 (HTML 형식도 되고 그냥 일반 텍스트도 사용 가능함)
    $mail->Send();
    echo "메일이 정상적으로 전송되었습니다.";

}catch (phpmailerException $e) {
    echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
    echo $e->getMessage(); //Boring error messages from anything else!
}
?>