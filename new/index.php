<?php
// function pr($str){ echo "<pre>";print_r($str);echo "</pre>"; }

$_home = getcwd();

$_home = "/host/home3/jjong1231/html";

include $_home."/inc/_inc_Function.php";
include $_home."/inc/_inc_db.php";


$rs = $DB->query("SELECT * FROM test");
// pr($rs);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<!-- Adtive 광고 선언부 -->
<script src='//plugin.adplex.co.kr/script/2beonAdScript.js' charset='UTF-8'></script>
<script>
adtiveTest();
</script>
<!-- Adtive 광고 표현부 -->
<!--Adtive 2. 상단 통배너-->
<script>adtiveDrawAD('6SPFFFFP','IG3LLLLF');</script>

</body>
</html>