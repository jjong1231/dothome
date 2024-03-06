	var user_name="이름";		// 유저 A명 
	var tm;						// 타이머 
	var user='';					// 유저 A, B
	var nth_cnt = 0;				// 유저구분표시
	var arr_talk = [];				// 대화 배열

	arr_talk.push(['대화1', 'A']);
	arr_talk.push(['대화2', 'A']);
	arr_talk.push(['대화3', 'B']);
	arr_talk.push(['대화4', 'A']);
	arr_talk.push(['대화5', 'B']);
	arr_talk.push(['대화6', 'B']);
	arr_talk.push(['대화7', 'A']);
	arr_talk.push(['대화8', 'B']);
	arr_talk.push(['대화9', 'B']);
	arr_talk.push(['대화10', 'B']);
	arr_talk.push(['대화11', 'A']);
	arr_talk.push(['대화12', 'A']);
	arr_talk.push(['대화13', 'B']);
	arr_talk.push(['대화14', 'A']);
	arr_talk.push(['대화15', 'B']);
	arr_talk.push(['대화16', 'B']);
	arr_talk.push(['대화17', 'A']);
	arr_talk.push(['대화18', 'B']);
	arr_talk.push(['대화19', 'B']);
	arr_talk.push(['대화20', 'B']);

	// msg_auto : 0.5초 간격으로 대화
	function msg_auto() {
		tm = setInterval(function(){
			if(arr_talk.length){
				
				var arr_t = arr_talk.shift();
				var chat = $('#chatMessageList')
				
				if(arr_t[1]!=user){
					nth_cnt = nth_cnt + 1; // 유저구분표시 
				
					if(arr_t[1] === 'A'){ // 유저 = 'A'
						chat.append(
							'<div class="answer talk-zone">'+
							'<span class="reporter"><span class="profile"></span>'+user_name+'</span>'+
							'</div>'
						);
					}else{
						chat.append(
							'<div class="question talk-zone">'+
							'</div>'
						);
					}
					user=arr_t[1];
					
				}
				$( '<p>'+arr_t[0]+'</p>' ).appendTo( "#chatMessageList > div:nth-child("+nth_cnt+")" );
				console.log(arr_t[0]);
				console.log(nth_cnt);
			}
			else clearInterval(tm);
		}, 500);
	}
	// msg_fix : 스크롤시 대화
	function msg_fix() {
		clearInterval(tm);
		tm = setInterval(function(){
			if(arr_talk.length){
				
				var arr_t = arr_talk.shift();
				var chat = $('#chatMessageList')
				
				if(arr_t[1]!=user){
					nth_cnt = nth_cnt + 1; // 유저구분표시 
				
					if(arr_t[1] === 'A'){ // 유저 = 'A'
						chat.append(
							'<div class="answer talk-zone">'+
							'<span class="reporter"><span class="profile"></span>'+user_name+'</span>'+
							'</div>'
						);
					}else{
						chat.append(
							'<div class="question talk-zone">'+
							'</div>'
						);
					}
					user=arr_t[1];
					
				}
				$( '<p>'+arr_t[0]+'</p>' ).appendTo( "#chatMessageList > div:nth-child("+nth_cnt+")" );
				console.log(arr_t[0]);
				console.log(nth_cnt);
			}
			else clearInterval(tm);
		}, 0);
	}

	$(document).ready(function(){
		msg_auto();				// msg_auto : 0.5초 간격으로 대화

		var lastScroll = "A";
		$( window ).scroll(function() {
			if(lastScroll === "A"){
				msg_fix();			// msg_fix : 스크롤시 대화
				lastScroll = "B";
			}
		});

	});