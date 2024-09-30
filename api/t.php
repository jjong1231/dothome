<?php
// 배열 또는 객체 생성
$data = array(
    "name" => "John Doe",
    "email" => "john.doe@example.com",
    "age" => 30
);

// JSON으로 변환
$jsonData = json_encode($data);

// JSON 데이터 출력
echo $jsonData;
?>