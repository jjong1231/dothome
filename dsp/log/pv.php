<?php
// exit('테스트!');

//////////////////////////////////////
// PV로그파일 저장 
// 기본경로 /html/dsp/log
// 분단위 : 2자릿수 00,10,20,30,40,50

// PV : /pv/ymd/분/영역코드(파일)
// click : /click/ymd/분/영역코드(파일)
// mv : /mv/ymd/분/영역코드(파일)
//////////////////////////////////////
header("P3P: CP='CAO PSA CONi OTR OUR DEM ONL'");
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
header("content-type: image/gif");

function pr($str){ echo "<pre>";print_r($str);echo "</pre>"; }

/**
 * 필요한 데이터 
 * 영역, 플랫폼, 캠페인, 소재번호, 캠페인과금제, 랜딩url
 */

//날짜값 생성
$date_i		= date("i");
$time_i		= $date_i-($date_i%10);
$time_i		= str_pad($time_i, 2, "0", STR_PAD_LEFT);		//분단위 2자리수 통일
$ymdH = date("YmdH");

// pr($time_i);exit;

$_zcode = $_GET['zcode'];
$_matData = $_GET['matData'];
$_plf = $_GET['plf'];


//데이터 처리 
$arr_matData = explode('[:divider:]', $_matData);

// pr($arr_matData); //pv데이터 

$log_line_pv = '';
$log_line_mv = 1;

foreach ($arr_matData as $mat) {
  $log_line_pv .= $_plf.'|'.$mat."\n";
}

/*
//기본 디렉토리 생성
fn_make_dir("/html/dsp/log/pv/");
fn_make_dir("/html/dsp//log/mv/");
// mkdir("/html/dsp/log/pv/", 0744); //기본 디렉토리 생성
// mkdir("/html/dsp/log/mv/", 0744); //기본 디렉토리 생성

//디렉토리 날짜 생성 
$dir_path_pv = "/html/dsp/log/pv/".$ymdH;
$dir_path_mv = "/html/dsp/log/mv/".$ymdH;
fn_make_dir($dir_path_pv);
fn_make_dir($dir_path_mv);
// mkdir($dir_path_pv, 0744); 
// mkdir($dir_path_mv, 0744); 

//디렉토리 10분 단위 
$dir_path_pv = "/html/dsp/log/pv/".$ymdH."/".$time_i;
$dir_path_mv = "/html/dsp/log/mv/".$ymdH."/".$time_i;
fn_make_dir($dir_path_pv);
fn_make_dir($dir_path_mv);
// mkdir($dir_path_pv, 0744); 
// mkdir($dir_path_mv, 0744); 
*/

$dir_path_pv = "/html/dsp/log/pv/";
$dir_path_mv = "/html/dsp/log/mv/";
$log_file_path_pv = $dir_path_pv."/".$_zcode;
$log_file_path_mv = $dir_path_mv."/".$_zcode;

fn_write_log($log_file_path_pv, $log_line_pv); //pv 로그파일생성
fn_write_log($log_file_path_mv, 1); //mv 로그파일생성


//MV카운트를 파일용량으로 체크 
// pr(filesize($log_file_path_mv)); 

function fn_make_dir($path){
	if(!@is_dir($path)){
		@mkdir($path, 0744);
	}
}

function fn_write_log($path, $con, $mode="a"){
	$fp=@fopen($path, $mode);
	@fwrite($fp,$con,strlen($con));
	@fclose($fp);
}



?>