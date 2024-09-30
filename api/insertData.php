<?php
// $_home = "/host/home3/jjong1231/html";
// include $_home."/inc/_inc_Function.php";
// include $_home."/inc/_inc_db.php";

/**
 * query, aquery, pquery 샘플 
 * 
$v_num = 1;
$v_string = '1';

//query
$qry = "SELECT * FROM test";
$rs = $DB->query($qry);

//aquery
$qry = "SELECT * FROM test where num=? and string=?";
$arr_bind[]	= array("i", $v_num);
$arr_bind[]	= array("s", $v_string);
$rs = $DB->aquery($qry, $arr_bind);

//pquery
$qry = "SELECT * FROM test where num=? and string=?";
$arr_params = array("is",$v_num, $v_string);
$rs = $DB->pquery($qry, $arr_params);
*/

// pr('$_GET');
// pr($_GET);
// pr('--------');
// pr('$_POST');
// pr($_POST);
// $arr = array(array('a'=>'aa'),array('b'=>'bb'),array('c'=>'c3c'));
// echo json_encode($arr);
exit('{"name":"kane12344", "age":3}');
?>