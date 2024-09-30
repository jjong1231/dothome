<?php
// Allow from any origin
header("Access-Control-Allow-Origin: *");

// Allow specific HTTP methods
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

//$_home = getcwd();
$_home = "/host/home3/jjong1231/html";
include $_home."/inc/_inc_Function.php";
include $_home."/inc/_inc_db.php";


$rs = $DB->query("SELECT * FROM test");
// pr('=======');
// pr($rs);
echo json_encode($rs);
exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>타임라인 형태의 웹사이트</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="timeline">
  <div class="timeline-years">
    <ul>
      <li><a href="#year-2020">2020</a></li>
      <li><a href="#year-2021">2021</a></li>
      <li><a href="#year-2022">2022</a></li>
      <!-- 추가적인 년도 항목을 필요에 따라 추가할 수 있습니다. -->
    </ul>
  </div>
  <div class="timeline-content">
    <div id="year-2020" class="year">
      <h2>2020년</h2>
      <p>2020년의 내용을 여기에 추가합니다.</p>
      <p>2020년의 내용을 여기에 추가합니다.</p>
      <p>2020년의 내용을 여기에 추가합니다.</p>
      <p>2020년의 내용을 여기에 추가합니다.</p>
      <p>2020년의 내용을 여기에 추가합니다.</p>
      <p>2020년의 내용을 여기에 추가합니다.</p>
      <p>2020년의 내용을 여기에 추가합니다.</p>
      <p>2020년의 내용을 여기에 추가합니다.</p>
      <p>2020년의 내용을 여기에 추가합니다.</p>
      <p>2020년의 내용을 여기에 추가합니다.</p>
      <p>2020년의 내용을 여기에 추가합니다.</p>
      <p>2020년의 내용을 여기에 추가합니다.</p>
    </div>
    <div id="year-2021" class="year">
      <h2>2021년</h2>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
      <p>2021년의 내용을 여기에 추가합니다.</p>
    </div>
    <div id="year-2022" class="year">
      <h2>2022년</h2>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
      <p>2022년의 내용을 여기에 추가합니다.</p>
    </div>
    <!-- 추가적인 년도에 대한 내용을 필요에 따라 추가할 수 있습니다. -->
  </div>
</div>

<script src="script.js"></script>
</body>
</html>