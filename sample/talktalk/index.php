<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width" />
<title>그룹채팅</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<link rel="stylesheet" href="css/style.css" />
<!-- <script type="text/javascript" src="js/main.js"></script> -->
<style type="text/css">
	/* 게임 월드컵 */
	/*body{overflow:hidden;}*/
	.worldcup_box{height:100%;padding:0 5px;/*background:#00F;*/text-align:center;width:94%;z-index:99999;margin:48px auto 0 auto;}
	.worldcup_box .chat_title img{width:100%;}


	.worldcup_box .worldcup_img{overflow:hidden;}
	.worldcup_box .worldcup_img li{width:25%;float:left;padding:5px 0;}
	.worldcup_box .worldcup_img li img{width:90px;height:90px; -webkit-filter:blur(3px)}
	.vs_box{display:block;color:#F00;font-weight:bold;padding:7px 3px;}
	.vs_box img{ width:92px;vertical-align:middle;display: inline-block; box-shadow: 10px 10px 20px -5px rgba(0, 0, 0, 2); }
	/*.worldcup_start{background:#ffff00;padding-top:15px;position:fixed;bottom:0;left:0;width:100%;height:72%;z-index:99999;}*/

	/* 아이폰5 해상도 */
	@media all and (max-height:460px){
		.worldcup_start{background:#f9dc0b;position:fixed;bottom:0;left:0;width:100%;height:36%;z-index:99999;}
	}
	/* 아이폰5 이상 해상도 */
	@media not all and (max-height:460px){
		.worldcup_start{background:#f9dc0b;position:fixed;bottom:0;left:0;width:100%;height:45%;z-index:99999;}
	}
	.worldcup_start img{width: 100%;}
	.worldcup_btn{background:#F00;width:60%;margin:0 auto;padding:10px;text-align:center;color:#FFF;}

</style>
<?

	$arr_wnto_data = array(
						1 => json_encode(array( 'wtno'=>'1','wt_name'=>'어플녀','img'=>'1.jpg','landurl'=>'http://www.anytoon.co.kr/webtoon.htm?pid=tcadult&ind=123'))
						,2 => json_encode(array( 'wtno'=>'2','wt_name'=>'S대 셀카유출','img'=>'2.jpg','landurl'=>'http://partner.zzamtoon.com/event/prologue?cno=528&pid=adtvcpa'))
						,3 => json_encode(array( 'wtno'=>'3','wt_name'=>'미쿡녀 길들이기','img'=>'3.jpg','landurl'=>'http://partner.zzamtoon.com/event/prologue?cno=2282&pid=adtvcpa'))
						,4 => json_encode(array( 'wtno'=>'4','wt_name'=>'미소녀 길거리 캐스팅','img'=>'4.jpg','landurl'=>'http://partner.zzamtoon.com/event/prologue?cno=292724&pid=adtvcpa'))
						,5 => json_encode(array( 'wtno'=>'5','wt_name'=>'은밀한 여대생','img'=>'5.jpg','landurl'=>'http://partner.zzamtoon.com/event/prologue?cno=2936&pid=adtvcpa'))
						,6 => json_encode(array( 'wtno'=>'6','wt_name'=>'발정난 여자친구 도촬 플레이','img'=>'6.jpg','landurl'=>'http://partner.zzamtoon.com/event/prologue?cno=2728&pid=adtvcpa'))
						,7 => json_encode(array( 'wtno'=>'7','wt_name'=>'직장상사','img'=>'7.jpg','landurl'=>'http://partner.zzamtoon.com/event/prologue?cno=2286&pid=adtvcpa'))
						,8 => json_encode(array( 'wtno'=>'8','wt_name'=>'미스터리 그녀','img'=>'8.jpg','landurl'=>'http://partner.zzamtoon.com/event/prologue?cno=2924&pid=adtvcpa'))
					);
	$arr_reaction = array('오~ 좋아!','선호 스타일이 나랑 비슷하군...','이런 취향이구나!','굿~~~','브라보 ㅋㅋ','잘하고있어!','따봉!!');

	$json_wtno_data = json_encode($arr_wnto_data);

// pr($arr_wtno_data);
// exit;

//이제 결승!!<br>한번만 더 고르면 돼!
?>

<script type="text/javascript">


var msg_cnt 		= 0; 			//채팅창카운트
var sel_cnt 		= 0; 			//유저선택카운트
var user_name 		= '서본좌';		//내이름
var mode 			= 'random';		//웹툰소재랜덤
var arr_wnto_data 	= ['<?=implode("','",$arr_wnto_data)?>']; 	//웹툰리스트
var arr_reaction 	= ["<?=implode('","',$arr_reaction)?>"]; 	//선택리액션

var json_wtno_data 	= <?=$json_wtno_data?>; 	//8강전이후 선택항목 데이터 가져올때 사용
var first_msg 		= ['클릭 몇번으로 알아보는<br>네가 좋아하는 스타일 확인~','이제 시작해볼까?<br>자~ 선택해봐!'];
var result_sel 		= []; 	//사용자가 선택결과 저장

	$(document).ready(function(){

	//상단타이틀 클릭시 서브카테고리
	$(".chat_title").on('click', function(){

	});

		var lastScroll = "A";
		$( window ).scroll(function() {
			if(lastScroll === "A"){
				$(".worldcup_start").stop().animate({ bottom: "-=1000" }, 1000);
				if(msg_cnt==0) run_interval();
				lastScroll = "B";
			}
		});
		//메뉴바
		$(".worldcup_start").click(function(){
			$(".worldcup_start").stop().animate({ bottom: "-=1000" }, 1000);
			run_interval();
		});

	});

	//클릭후 메세지 전송
	function run_interval(){

		tm = setInterval(function(){
			var chat = $('#chatMessageList'); 	//대화창
			var _tmp = '';
			//처음실행시 처음멘트후 선택항목 표시
			if(sel_cnt==0){
				var msg = '';
				if(first_msg.length==0){
					clearInterval(tm);
					//유저선택 함수 호출후 종료
					add_selectBox('random');
					return;
				}else{
					msg = first_msg.shift();
				}

				var again_msg = $("#chatMessageList > div:last-child").hasClass('answer');
				_tmp = '<div class="answer talk-zone">'+
					'<span class="reporter"><span class="profile"></span>'+user_name+'</span>'+
					'<p>'+msg+'</p>'+
					'</div>';
				if(again_msg) $('<p>'+msg+'</p>').appendTo("#chatMessageList > div:last-child");
				else chat.append( _tmp );
				move_scroll();
			}
			$(".worldcup_start").remove(); 	//시작버튼레이어 삭제
			if(msg_cnt>10) clearInterval(tm);
		},1000);

	}

	//배열섞기
	function shuffle(o){
		o.sort(function(){return 0.5-Math.random()});
		return o;
	};

	//유저선택항목
	function add_selectBox(mode){
		setTimeout(function(){
			var data1 = '';
			var data2 = '';
			if(mode=='random'){
				shuffle(arr_wnto_data);
				data1 = JSON.parse(arr_wnto_data.shift()); 	//이미지앞
				data2 = JSON.parse(arr_wnto_data.shift()); 	//이미지뒤
			}else{
				//4강전이상인경우 선택웹툰에서 경쟁
				data1 = JSON.parse(json_wtno_data[result_sel.shift()]);
				data2 = JSON.parse(json_wtno_data[result_sel.shift()]);
			}

			var tmp = '<div class="answer talk-zone">'+
					'<span class="reporter"><span class="profile"></span>'+user_name+'</span>'+
					'<p><span class="vs_box box'+sel_cnt+'"><img class="effect" wtno="'+data1.wtno+'" src="images/'+data1.img+'" alt="앞에꺼" /> vs <img class="effect" wtno="'+data2.wtno+'" src="images/'+data2.img+'" alt="뒤에꺼" /></span></p>'+
				'</div>';
			//선택박스추가후 이미지에 클릭이벤트 추가
			$('#chatMessageList').append(tmp).find('.box'+sel_cnt+' img').one('click',function(e){
				$(this).css('border','2px solid red').css('box-shadow','0px 0px 0px 0px rgba(0, 0, 0, 0)');
				result_sel.push($(this).attr('wtno'));
				var sel_text = $(this).attr('alt');
				$('.box'+(sel_cnt-1)).find('img').unbind('click'); 	//선택시 현재 선택박스의 클릭이벤트 해제
				//리액션메세지
				reaction_msg(sel_cnt,sel_text); 	//선택박스카운트,선택메세지
			});
			move_scroll(); 	//스크롤 이동
			sel_cnt++;
		},700);
	}

	//사용자 선택시 리액션 메세지
	function reaction_msg(sel_cnt,sel_text){

		//사용자 선택 메세지
		var user_msg = '<div class="question talk-zone">'+
			'<p>'+sel_text+'</p>'+
		'</div>';
		$( "#chatMessageList > div:last-child" ).after(user_msg); 	//유저선택결과
		move_scroll();

		//결승선택후 메세지 후 중지
		if(sel_cnt==7){
			setTimeout(function(){
				var chat = $('#chatMessageList'); 	//대화창
				var data = JSON.parse(json_wtno_data[result_sel.shift()]);
				chat.append(

					'<div class="answer talk-zone">'+
					'<span class="reporter"><span class="profile"></span>'+user_name+'</span>'+
					'<p>ㅋㅋㅋㅋ<br />브라보! 브라보!! <br />눈이 높구나!<br />바로 만나러 갈래?</p>'+
					'</div>'
				);
				move_scroll();
				setTimeout(function(){
					$( '<p><span class="vs_box"><a class="wk2006_a2" href="'+data.landurl+'" target="_blank"><img src="images/'+data.img+'" alt="두번째" /></span>만나러 가기</a></p>' ).appendTo( "#chatMessageList > div:last-child" );
					move_scroll();
				},700);
			},1000);
			return;
		}

		//유저 선택결과 표시후 사용자 리액션1
		setTimeout(function(){
			shuffle(arr_reaction); 	//리액션메세지 랜덤섞기
			var chat = $('#chatMessageList'); 	//대화창
			var _tmp = '';
			chat.append(
				'<div class="answer talk-zone">'+
				'<span class="reporter"><span class="profile"></span>'+user_name+'</span>'+
				'<p>'+arr_reaction.shift()+'</p>'+
				'</div>'
			);
			move_scroll();
		},800);

		//유저 선택결과 표시후 사용자 리액션2
		setTimeout(function(){
			_tmp = (sel_cnt+1)+'단계!';
			//4번째 선택후 4강전 메세지
			if(sel_cnt==4){ _tmp = '이제 4강전! 신중하게생각해~'; mode = 'levelup'; }
			else if(sel_cnt==5) _tmp = '4강 두번째 선택!';
			else if(sel_cnt==6) _tmp = '좋아!! 결승이다!!<br>마지막 한번만 더 고르면 돼';
			$( '<p>'+_tmp+'</p>' ).appendTo( "#chatMessageList > div:last-child" );
			move_scroll();
			setTimeout(add_selectBox(mode),500);
		},2400);

	}

	//메세지후 스크롤이동
	function move_scroll(){
		msg_cnt++;
		$( "body" ).scrollTop( 250*msg_cnt ); 	//스크롤이동
	}

</script>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-W4R969"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-W4R969');</script>
<!-- End Google Tag Manager -->
</head>
<body>
<style type="text/css">

.cate_list{ background:white; height:30px;border:1px solid gray; }
.cate_list li{width:25%;float:left;}
</style>
	<div class="worldcup_box">
	<div class="chat_title">
		<img src="images/chat_title.png" alt="" /> 
		<ul class="cate_list">
			<li>여행</li>
			<li>쇼핑</li>
			<li>웹툰</li>
			<li>웹툰19</li>
		</ul>
	</div>
		<ul class="worldcup_img">
		<?
			//웹툰리스트
			foreach ($arr_wnto_data as $v) {
				$v = json_decode($v,true);
		?>
			<li><img src="img/<?=$v['img']?>" alt="" /></li>
		<?}?>
 		</ul>
	</div>
	<div class="wrap">
		<nav>
			<h1>그룹채팅</h1>
			<a href="javascript:;" class="go-home">홈으로 가기</a>
		</nav>
		<div class="chat_box">
		<!-- 채팅내용 시작 -->
			<article id="chatMessageList">
			</article>
		<!-- 채팅내용 끝 -->
		</div>
		<footer>
			<span class="btn-foot">더보기</span>
			<div class="foot-input">
				<textarea class="url-copy"></textarea>
				<p class="share-text selected"></p>
			</div>
		</footer>
		<div class="worldcup_start">
			<!-- <p class="worldcup_btn">바로 시작하기</p> -->
			<img src="images/start_btn.gif" alt="" />
		</div>
	</div>
<?/*?>
<style>
	#control_box{position: fixed;top:25px;left: 10px;width: 260px; height: 25px; background: #fff; z-index: 9999999; border: 1px solid #000;}
	#control_box button{ width:30px;height:20px;border: 1px solid red; }
</style>
<div id="control_box">
블러효과 단계 <span>2</span>단계 <span id="a"></span>
</div>
<script>
var blur_no = 3;
$(document).ready(function(){
	$(".chat_title").on('click', function(){
		// var num = $(this).text();
		if(blur_no>3) blur_no=0;
		blur_no++;
		$('.worldcup_box .worldcup_img li img').css('-webkit-filter','blur('+blur_no+'px)');
		$('#control_box span').text(blur_no);

	});
});
</script>
<?*/?>

</body>
</html>
