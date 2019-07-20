<?php
session_start();
//전송되는 데이터를 받아줄 변수
include_once("dbconn.php");

$username = $_REQUEST['username'];
$subject = $_REQUEST['subject'];
$contents = $_REQUEST['contents'];
$userid = $_SESSION['userid'];

//부모글.
$idx = $_REQUEST['idx'];
$type = $_REQUEST['type'];

$sms = @$_REQUEST['sms'];
$mail = @$_REQUEST['mail'];

if(isset($sms) && $sms == 'smsok'){
	//sms발송. 상대방 전화번호 lgu, skt, kt. sms호스팅업체.
	$sms = new sms();
	$sms->set("TR_ID","smszanghs");
	$sms->set("TR_KEY","***");//비밀번호.
	$sms->set("TR_TXTMSG",$contents);
	$sms->set("TR_TO","010-8004-1292","장형석","");
	$sms->set("TR_FROM","010-9963-3292");
	$sms->set("TR_DATE","0");	// or 예약  $sms->set("TR_DATE","2011-06-20 12:12:12");
	$sms->set("TR_COMMENT",$subject);
	$recv = $sms->send();
}

if(isset($mail) && $mail =='mail'){
	//메일발송.
   $to = "azanghs@naver.com";
   $headers = "From: azanghs@gmail.com\r\n";
  ini_set('SMTP','localhost');
ini_set('smtp_port',25);
   mail($to, $subject, $contents,$headers);
   exit;
   
   //phpmailer를 활용한 메일 발송.
   //request 날리기.
}
//다음시간 : 메일발송, 답변형게시판, 카톡메세지보내기.


//file upload
$filename = $_FILES['fileupload']['name'];//사용자가 선택한 파일의 실제명.


//upload 파일이 있느냐 없느냐.
if($filename){//사용자가 파일 업로드를 했다면.
	//물리적인 폴더공간에 파일이 저장.
	//폴더지정.
	$uploads_dir = './userfile';
	$result = move_uploaded_file( $_FILES['fileupload']['tmp_name'], "$uploads_dir/$filename");
	
	
	//답변글이냐.
	//현재 저장되는 글이 답변글인지, 새로운 신규 글인지 판단 필요.
	if($type == 'answer'){//답변글이라면,
		$sql = "select * from boardlist where idx = $idx ";
	$result = mysqli_query($connect_db, $sql);
	$row = mysqli_fetch_array($result);
	
	//부모글의 level + 1, depth + 1, boardgroup은 같은 번호.
	$parentlevel = $row['level'];
	$parentdepth = $row['depth'];
	
	$depth = $row['depth']+1;//단순하게 부모글의 +1
	$level = $row['level']+1;
	$boardgroup = $row['boardgroup'];

	/*
	사이에 낑겨들어가기 처리)
	부모글과 같은 뎁스상의 글들이지만, 레벨은 높은(밑에글)글들을 level+1로 내려야 하고,
	부모글의 마지막 답변글의 level을 판단하여 그 밑에 들어가야 한다.
	마지막 답변글 판단시 그 답변글이 자신의 밑에 자식답변글을 갖고 있다면 제일 마지막의 답변글 level을 구해야 한다.

	
	//선택 후 update - select -> level + 1
	*/

	//원글에 답변인지, 답변의 답변인지 판단. 원글에 답변이면 낑겨들어가기 고려x, 답변의 답변이면 낑겨들어가기 판단할 것.
	if($idx == $boardgroup){
		//마지막 level만 고려. 하위단 update 불필요.
		//마지막 자식 level 계산하기.
		$sql = "select max(level)+1 as level from boardlist where boardgroup = $boardgroup and level >= $parentlevel and depth>= $parentdepth";
		$result = mysqli_query($connect_db, $sql);
		$row = mysqli_fetch_array($result);
		$level = $row['level'];
		
		if($fileExist == 'file'){
			$sql = "insert into boardlist(subject, contents, username,userid, regdate, filename, boardgroup, level, depth) values('$subject','$contents','$username','$userid',now(),'$filename', $boardgroup, $level, $depth)";
			$result = mysqli_query($connect_db, $sql);
		}else{
			$sql = "insert into boardlist(subject, contents, username,userid, regdate, boardgroup, level, depth) values('$subject','$contents','$username','$userid',now(), $boardgroup, $level, $depth)";
			$result = mysqli_query($connect_db, $sql);
		}
	}else{
		//부모글과 동일 레벨의 자식이 있는지 판단.
		$sql = "select min(level) as level from boardlist where boardgroup = $boardgroup and level> $parentlevel and depth <= $parentdepth order by level asc ";
		$result = mysqli_query($connect_db, $sql);
		if($row = mysqli_fetch_array($result)){
			//있다면 하위그룹 level +1 update
			$unclelevel = $row['level'];
			
			$sql  = "
			update boardlist a, (
			select * from boardlist where boardgroup = $boardgroup and level >= $unclelevel) b
			set a.level = a.level + 1
			where a.idx = b.idx
			";
			$result = mysqli_query($connect_db, $sql);

			$sql = "insert into boardlist(subject, contents, username,userid, regdate, filename, boardgroup, level, depth) values('$subject','$contents','$username','$userid',now(),'$filename', $boardgroup, $unclelevel, $depth)";
			$result = mysqli_query($connect_db, $sql);
		}else{
			//없으면 하위그룹 update 불필요. 마지막 level 계산하기.
			$sql = "select max(level)+1 as level from boardlist where boardgroup = $boardgroup and level >= $parentlevel and depth>= $parentdepth";
			$result = mysqli_query($connect_db, $sql);
			$row = mysqli_fetch_array($result);
			$level = $row['level'];

			$sql = "insert into boardlist(subject, contents, username,userid, regdate, filename, boardgroup, level, depth) values('$subject','$contents','$username','$userid',now(),'$filename', $boardgroup, $level, $depth)";
			$result = mysqli_query($connect_db, $sql);	
		}
		
	}
	}else{//그냥 신규 글이냐.
		$sql = "insert into boardlist(subject, contents, username,userid, regdate, filename, boardgroup, level, depth) values('$subject','$contents','$username','$userid',now(),'$filename', 0, 0, 0)";
		$result = mysqli_query($connect_db, $sql);
		
		$sql = "select max(idx) as maxidx from boardlist";
		$result = mysqli_query($connect_db, $sql);
		$row = mysqli_fetch_array($result);

		$sql = "update boardlist set boardgroup = idx where idx=".$row[0];
		$result = mysqli_query($connect_db, $sql);
	}
	
}else{//업로드 파일이 없을때.

	//현재 저장되는 글이 답변글인지, 새로운 신규 글인지 판단 필요.
	if($type == 'answer'){//답변글이라면,
		$sql = "select * from boardlist where idx = $idx "; // 내가 답변달고자 하는 대상 부모글의 고유번호.
		$result = mysqli_query($connect_db, $sql);
		$row = mysqli_fetch_array($result);
		
		//부모글의 level + 1, depth + 1, boardgroup은 같은 번호.
		$parentlevel = $row['level'];
		$parentdepth = $row['depth'];
		
		$depth = $row['depth']+1;//단순하게 부모글의 +1
		$level = $row['level']+1;
		$boardgroup = $row['boardgroup'];

		/*
		사이에 낑겨들어가기 처리)
		부모글과 같은 뎁스상의 글들이지만, 레벨은 높은(밑에글)글들을 level+1로 내려야 하고,
		부모글의 마지막 답변글의 level을 판단하여 그 밑에 들어가야 한다.
		마지막 답변글 판단시 그 답변글이 자신의 밑에 자식답변글을 갖고 있다면 제일 마지막의 답변글 level을 구해야 한다.

		
		//선택 후 update - select -> level + 1
		*/

		//원글에 답변인지, 답변의 답변인지 판단. 원글에 답변이면 낑겨들어가기 고려x, 답변의 답변이면 낑겨들어가기 판단할 것.
		if($idx == $boardgroup){//사이에 낑겨들어가는 것을 고려하지 않는다.
			//마지막 level만 고려. 하위단 update 불필요.
			//마지막 자식 level 계산하기.
			$sql = "select max(level)+1 as level from boardlist where boardgroup = $boardgroup and level >= $parentlevel and depth>= $parentdepth";
			$result = mysqli_query($connect_db, $sql);
			$row = mysqli_fetch_array($result);
			$level = $row['level'];
			
			if($fileExist == 'file'){
				$sql = "insert into boardlist(subject, contents, username,userid, regdate, filename, boardgroup, level, depth) values('$subject','$contents','$username','$userid',now(),'$filename', $boardgroup, $level, $depth)";
				$result = mysqli_query($connect_db, $sql);
			}else{
				$sql = "insert into boardlist(subject, contents, username,userid, regdate, boardgroup, level, depth) values('$subject','$contents','$username','$userid',now(), $boardgroup, $level, $depth)";
				$result = mysqli_query($connect_db, $sql);
			}
		}else{//답변의 답변일 경우.
			//부모글과 동일 레벨의 자식이 있는지 판단.
			$sql = "select min(level) as level from boardlist where boardgroup = $boardgroup and level> $parentlevel and depth <= $parentdepth order by level asc ";
			$result = mysqli_query($connect_db, $sql);
			if($row = mysqli_fetch_array($result)){//밑바닥 존재한다면.
				//있다면 하위그룹 level +1 update
				$unclelevel = $row['level'];
				
				//삼촌레벨을 포함해서 그 하위에 존재하는 데이터들을 level +1로 업데이트를 수행.
				$sql  = "
				update boardlist a, (
				select * from boardlist where boardgroup = $boardgroup and level >= $unclelevel) b
				set a.level = a.level + 1
				where a.idx = b.idx
				";

				$result = mysqli_query($connect_db, $sql);

				$sql = "insert into boardlist(subject, contents, username,userid, regdate, filename, boardgroup, level, depth) values('$subject','$contents','$username','$userid',now(),'$filename', $boardgroup, $unclelevel, $depth)";
				$result = mysqli_query($connect_db, $sql);
			}else{
				//없으면 하위그룹 update 불필요. 마지막 level 계산하기.
				$sql = "select max(level)+1 as level from boardlist where boardgroup = $boardgroup and level >= $parentlevel and depth>= $parentdepth";
				$result = mysqli_query($connect_db, $sql);
				$row = mysqli_fetch_array($result);
				$level = $row['level'];

				$sql = "insert into boardlist(subject, contents, username,userid, regdate, filename, boardgroup, level, depth) values('$subject','$contents','$username','$userid',now(),'$filename', $boardgroup, $level, $depth)";
				$result = mysqli_query($connect_db, $sql);	
			}
			
		}
		
	}else{
		$sql = "insert into boardlist(subject, contents, username,userid, regdate, filename, boardgroup, level, depth) values('$subject','$contents','$username','$userid',now(),'$filename', 0, 0, 0)";
		$result = mysqli_query($connect_db, $sql);
		
		$sql = "select max(idx) as maxidx from boardlist";
		$result = mysqli_query($connect_db, $sql);
		$row = mysqli_fetch_array($result);

		$sql = "update boardlist set boardgroup = idx where idx=".$row[0];
		$result = mysqli_query($connect_db, $sql);
	}
}




$rows =  mysqli_affected_rows($connect_db);//한 줄이 들어갔느냐.
if($rows == 1){ //정상케이스
	echo "<script>alert('정상적으로 저장되었습니다.');location.href='list.php';</script>";
}else{
	echo "<script>alert('저장되지 않았습니다.');history.back();</script>";
}



class sms {
	var $server_url;
	var $cut;
	var $status;
	var $params;
	var $encoding;

	/**
	 *
	 *
	 * @param
	 * @return
	 */
	function sms($encoding='UTF-8') {
		$this->server_url = "";
		$this->cut = 5000;
		$this->params = array();
		$this->encoding = $encoding;
	}

	/**
	 * 변수 얻기
	 *
	 * @param
	 * @return
	 */
	function get() {
		return $this->params;
	}

	/**
	 * 변수 셋팅
	 *
	 * @param
	 * @return
	 */
	function set($key="",$val1="",$val2="",$val3="") {
		if($key == 'TR_TO' && $val1 != "") {
			$this->params['TR_TO'][$val1] = array("name"=>$val2,"name2"=>$val3);
		} else {
			if (empty($val1)) {
				unset($this->params[$key]);
			} else {
				$this->params[$key] = $val1;
			}
		}
		return true;
	}

	/**
	 * SMS개수 확인
	 *
	 * @param
	 * @return
	 */
	function view($params = null) {

		if ($params === null) { $params = $this->params; }
		if (empty($params['TR_ID'])) { return array('msg'=>'TR_ID is empty','status'=>'fail'); }
		if (empty($params['TR_KEY'])) { return array('msg'=>'TR_KEY is empty','status'=>'fail'); }

		$return = array();
		$post = array('adminuser'=>$params['TR_ID'],
			'authkey'=>$params['TR_KEY'],
			'type'=>'view');

		$this->server_url = "http://sms.phps.kr/lib/send.sms";
		if (function_exists('mb_convert_encoding')) {

			if (function_exists('curl_exec')) {
				$return = $this->curl_send($post);
			} else if (function_exists('fsockopen')) {
				$return = $this->sock_send($post);
			} else {
				$return = "undefine function curl_exec or fsockopen";
			}
		} else {
			$return = "undefine function mb_convert_encoding";
		}
		return $return;
	}

	/**
	 * 삭제
	 *
	 * @param
	 * @return
	 */

	function cancel($params = null) {

		if ($params === null) { $params = $this->params; }
		if (empty($params['TR_ID'])) { return array('msg'=>'TR_ID is empty','status'=>'fail'); }
		if (empty($params['TR_KEY'])) { return array('msg'=>'TR_KEY is empty','status'=>'fail'); }

		$return = array();
		$post = array('adminuser'=>$params['TR_ID'],
			'authkey'=>$params['TR_KEY'],
			'date'=>date("Y-m-d H:i:s",strtotime("+1 day")),
			'tr_num'=>$params['TR_NUM']);

		$this->server_url = "http://sms.phps.kr/lib/send.sms";
		if (function_exists('mb_convert_encoding')) {

			if (function_exists('curl_exec')) {
				$return = $this->curl_send($post);
			} else if (function_exists('fsockopen')) {
				$return = $this->sock_send($post);
			} else {
				$return = "undefine function curl_exec or fsockopen";
			}
		} else {
			$return = "undefine function mb_convert_encoding";
		}
		return $return;
	}


	/**
	 * 전송
	 *
	 * @param
	 * @return
	 */
	function send($params = null) {
		if ($params === null) { $params = $this->params; }
		if (empty($params['TR_ID'])) { return array('msg'=>'TR_ID is empty','status'=>'fail'); }
		if (empty($params['TR_KEY'])) { return array('msg'=>'TR_KEY is empty','status'=>'fail'); }
		if (empty($params['TR_TXTMSG'])) { return array('msg'=>'TR_TXTMSG is empty','status'=>'fail'); }
		if (!is_array($params['TR_TO'])) { return array('msg'=>'TR_TO is not array','status'=>'fail'); }
		$tmpto = each($params['TR_TO']);
		if (empty($tmpto[0])) { return array('msg'=>'TR_TO is empty','status'=>'fail'); }
		if (empty($params['TR_DATE'])) { $params['TR_DATE']=0; }
		if (empty($params['TR_FROM'])) { return array('msg'=>'TR_FROM is empty','status'=>'fail'); }

		$phone		= "";
		$name		= "";
		$cnt		= 1;
		$index		= 0;
		$group = array();
        $group[$index]['phone'] = $group[$index]['name'] = $group[$index]['name2'] = '';
		foreach ($params['TR_TO'] as $key => $val) {
			$group[$index]['phone'] .= preg_replace("/[^0-9]/","",$key).",";
			$group[$index]['name'] .= preg_replace("/[,]/","",$val['name']).",";
			$group[$index]['name2'] .= preg_replace("/[,]/","",$val['name2']).",";
			if ($cnt % $this->cut == 0) { $index++; }
			$cnt++;
		}

		if (strtoupper($this->encoding) == 'UTF-8') {
			if (function_exists('mb_convert_encoding')) {
				if(isset($params['TR_COMMENT']))	{ $params['TR_COMMENT'] = mb_convert_encoding($params['TR_COMMENT'],'EUC-KR','UTF-8'); }
				$params['TR_TXTMSG'] = mb_convert_encoding($params['TR_TXTMSG'],'EUC-KR','UTF-8');
			} else if (function_exists('iconv')) {
				if(isset($params['TR_COMMENT']))	{ $params['TR_COMMENT'] = iconv('UTF-8','EUC-KR',$params['TR_COMMENT']); }
				$params['TR_TXTMSG'] = iconv('UTF-8','EUC-KR',$params['TR_TXTMSG']);
			} else {
				 return array('msg'=>'no encoding function','status'=>'fail');
			}
		}


		$return = array();
		foreach ($group as $key => $pdata) {
			$phone = preg_replace("/,$/","",$pdata['phone']);
			$name = preg_replace("/,$/","",$pdata['name']);
			$name2 = preg_replace("/,$/","",$pdata['name2']);

			if (strtoupper($this->encoding) == 'UTF-8') {
				if (function_exists('mb_convert_encoding')) {
					$name = mb_convert_encoding($name,'EUC-KR','UTF-8');
					$name2 = mb_convert_encoding($name2,'EUC-KR','UTF-8');
				} else if (function_exists('iconv')) {
					$name = iconv('UTF-8','EUC-KR',$name);
					$name2 = iconv('UTF-8','EUC-KR',$name2);
				} else {
					 return array('msg'=>'no encoding function','status'=>'fail');
				}
			}

			$post = array('adminuser'=>$params['TR_ID'],
				'authkey'=>$params['TR_KEY'],
				'phone'=>$phone,
				'name'=>$name,
				'name2'=>$name2,
				'rphone'=>$params['TR_FROM'],
				'msg'=>(isset($params['TR_COMMENT']))?$params['TR_COMMENT']:'',
				'sms'=>$params['TR_TXTMSG'],
				'date'=>$params['TR_DATE'],
				'ip'=>getenv("REMOTE_ADDR"));

			$this->server_url = "http://sms.phps.kr/lib/send.sms";


				if (function_exists('curl_exec')) {
					$return[] = $this->curl_send($post);
				} else if (function_exists('fsockopen')) {
					$return[] = $this->sock_send($post);
				} else {
					$return[] = "undefine function curl_exec or fsockopen";
				}

		}

		unset($this->params);
		return $return;
	}


	/**
	 * curl 전송
	 *
	 * @param
	 * @return
	 */
	function curl_send($post = array()) {

		//curl
		$CURL = curl_init($this->server_url);
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($CURL, CURLOPT_HEADER,false);
		curl_setopt($CURL, CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($CURL, CURLOPT_ENCODING,"");
		curl_setopt($CURL, CURLOPT_USERAGENT,"");
		curl_setopt($CURL, CURLOPT_AUTOREFERER,true);
		curl_setopt($CURL, CURLOPT_CONNECTTIMEOUT,120);
		curl_setopt($CURL, CURLOPT_TIMEOUT,120);
		curl_setopt($CURL, CURLOPT_MAXREDIRS,10);
		curl_setopt($CURL, CURLOPT_POST,1);
		curl_setopt($CURL, CURLOPT_POSTFIELDS,$post);
		curl_setopt($CURL, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($CURL, CURLOPT_VERBOSE,0);
		$undate		= curl_exec($CURL);
		curl_close($CURL);

		return unserialize($undate);
	}

	/**
	 * 소켓 전송
	 *
	 * @param
	 * @return
	 */
	function sock_send($post = array()) {

		//default
		$aPost = array();
		foreach($post as $key=>$val) {
			$aPost[] = $key."=".$val;
		}
		$posturl = join("&",$aPost);
		$tmpurl = parse_url($this->server_url);

		if ($tmpurl['scheme'] =='http') { $port = 80; } else { $port = 443; }
		$host = $tmpurl['host'];
		$path = $tmpurl['path'];

		//header
		$header ="POST ".$path."  HTTP/1.1\r\n";
		$header.="Host: ".$host."\r\n";
		$header.="User-Agent: PHP Script\r\n";
		$header.="Content-Type: application/x-www-form-urlencoded\r\n";
		$header.="Content-Length: ".strlen($posturl)."\r\n";
		$header.="Connection: close\r\n\r\n";
		$header.=$posturl;

		//fsockopen
		$sock = fsockopen($host, $port, $errno, $errstr);
		fwrite($sock, $header);
		while (!feof($sock)) { $response.=fgets($sock, 128); }

		//parse
		$response=explode("\r\n\r\n",$response);
		$header=$response[0];
		$responsecontent=$response[1];
		if(!(strpos($header,"Transfer-Encoding: chunked")===false)){
			$aux=split("\r\n",$responsecontent);
			for($i=0;$i<count($aux);$i++)
				if($i==0 || ($i%2==0))
					$aux[$i]="";
			$responsecontent=implode("",$aux);
		}//if
		return unserialize(chop($responsecontent));
	}
}
?>