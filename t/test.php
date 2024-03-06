<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8" />
<title>호출방식 테스트</title>
<style>body{margin:0;padding:0}</style>
</head>
<body>
<script type='text/javascript'>
if(typeof window.init2beon==='undefined') var init2beon = {mdcode:'ZDFFFFFP', setZone:[], isTest:false},arrZone=init2beon['setZone'];
</script>


<h3>구버전 호출방식</h3>
<script>
arrZone.push(['374LLLLF', '_2BEON374LLLLF']); //텍스트
// arrZone.push(['QI4LLLLF', '_2BEONQI4LLLLF']); //이미지
</script>
<!-- 텍스트 -->
<div id='_2BEON374LLLLF'></div> 

<hr>




<h3>신버전 호출방식</h3>
<!-- <script type='text/javascript' src='http://plugin.2beon.co.kr/script/2beonAdScript.js?ver=1.73' charset='UTF-8'></script> -->
<script src='//www.adplex.co.kr/_pjh/js.js?ver=2.44' charset='UTF-8'></script>
<!-- 이미지 -->
<!-- <div id='_2BEONQI4LLLLF'></div> -->
<script>try{adtiveDrawAD('ZDFFFFFP','QI4LLLLF',()=>{ alert('passback');},()=>{ alert('callback');});}catch(e){console.warn(e);}</script>
</body>
</html>