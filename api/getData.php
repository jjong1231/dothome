<?php

$_home = "/host/home3/jjong1231/html";
include $_home."/inc/_inc_Function.php";
include $_home."/inc/_inc_db.php";

// php://input 스트림을 통해 전송된 JSON 데이터를 수신
$input = file_get_contents('php://input');

// exit(json_encode($input));

// JSON 데이터를 연관 배열로 변환
$data = json_decode($input, true);
// exit(json_encode($data));


$data = array( "table"=>"test");

$_where = "";
$arr_bind[] = array(s, $data['table']); //테이블 
// if(isset($data['where'])){
//   foreach ($data['where'] as $k => $v) {
//     $_where .= (!$_where)?" where ".$k."=?":" and ".$k."=?";
//     $arr_bind[] = array(substr(getType($v),0,1), $v);
//   }
// }
$qry = "select * from test".$_where;


// pr($data);
// pr('----');
// pr($qry);
// pr('----');
// pr($_where);
// pr('----');
// pr($arr_bind);
$rs = $DB->query($qry);
// $rs = $DB->aquery($qry, $arr_bind);
// pr($rs);
// exit;


exit(json_encode($rs));
// exit(json_encode($rs));

/**
 * query, aquery, pquery 샘플 
*/
$v_num = 1;
$v_string = '1';

//query
// $qry = "SELECT * FROM test";
// $rs = $DB->query($qry);

//aquery
// $qry = "SELECT * FROM test where num=? and string=?";
// $arr_bind[]	= array("i", $v_num);
// $arr_bind[]	= array("s", $v_string);
// $rs = $DB->aquery($qry, $arr_bind);

//pquery
// $qry = "SELECT * FROM test where num=? and string=?";
// $arr_params = array("is",$v_num, $v_string);
// $rs = $DB->pquery($qry, $arr_params);

// pr('$_GET');
// pr($_GET);
// pr('--------');
// pr('$_POST');
// pr($_POST);
// $arr = array(array('a'=>'aa'),array('b'=>'bb'),array('c'=>'c3c'));
exit(json_encode($rs));
// exit('{"name":"jjong", "age":34}');
?>