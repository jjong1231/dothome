<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>dothome/t/t.php</title>
	<!-- <script src='//plugin.adplex.co.kr/script/2beonAdScript.js' charset='UTF-8'></script> -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
</head>
<body>
<script>

var init2beon = init2beon||{mdcode:'ZDFFFFFP', setZone:[], isBridgeAd:false}, arrZone=init2beon['setZone'];

arrZone.push(['QI4LLLLF', '_2BEONQI4LLLLF']);

console.log(init2beon);

//하드코딩html 감싸고있는 div 걷어내기 
// var targetEl = document.getElementById('bb');
// var parent = targetEl.parentNode;
// targetElement.innerHTML = targetEl.innerHTML;

(()=>{

document.addEventListener("DOMContentLoaded",()=>{

	console.log("document ready");

});

console.log("start");

if(window.adtiveAdScriptLoaded) return;

var topWin = top;
try{topWin.document}catch(e){topWin=window;}
if(window.ADTIVE_SSP_CALLED){topWin=window;}

window.adtiveDrawAD=window.adtiveDrawAD||function(md_key,zone_key,passback,callback){
	var elmId='_2BEON'+zone_key;
console.log((document.getElementById(elmId)!=null));
	if(document.getElementById(elmId)!=null){
		var cnt=1;
		while(true){
			elmId='_2BEON'+zone_key+cnt;
			if(document.getElementById(elmId)==null) break;
			if(++cnt>999) break;
		}
	}
	//배너호출 스크립트 다음에 요소 생성
	document.currentScript.insertAdjacentHTML("afterend","<div id='"+elmId+"'></div>");
	document.currentScript.insertAdjacentHTML("afterend","<div id='"+elmId+"'></div>");
	var targetSelector=elmId;
	adtiveAppendAD(md_key,zone_key,targetSelector,passback,callback); //adtiveAppendAD 호출

	
}

try{
(function(initOptions){
console.log('initOptions',initOptions);

	var browser=(function(){
		var a=navigator.userAgent.toLowerCase();
		var b,v;
		var webkit=(a.indexOf("webkit")>-1);
		var mozilla=(a.indexOf("mozilla")>-1);

		if(a.indexOf("safari/")>-1){
			b="safari";
			var s=a.indexOf("version/");
			var l=a.indexOf(" ", s);
			v=a.substring(s+8, l);
		}
		if(a.indexOf("chrome/")>-1){
			b="chrome";
			var ver=/[ \/]([\w.]+)/.exec(a)||[];
			v=ver[1];
		}
		if(a.indexOf("firefox/")>-1) {
			b="firefox";
			var ver=/(?:.*? rv:([\w.]+)|)/.exec(a)||[];
			v=ver[1];
		}
		if(a.indexOf("opera/")>-1){
			b="opera";
			var ver=/(?:.*version|)[ \/]([\w.]+)/.exec(a)||[];
			v=ver[1];
		}
		if((a.indexOf("msie")>-1)||(a.indexOf(".net")>-1)){
			b="msie";
			var ver=/(?:.*? rv:([\w.]+))?/.exec(a)||[];
			if(ver[1]) v=ver[1];
			else{
				var s=a.indexOf("msie");
				var l=a.indexOf(".", s);
				v=a.substring(s+4, l);
			}
		}
		return { name:b||"", version:Number(v||0), webkit:webkit, mozilla:mozilla};
	}());
	var UA={
		//mobile os
		android:false, ios:false, bada:false, win_ce:false, win_phone:false, symbian:false, polaris:false,
		//mobile app
		kakaotalk:false,
		//pc os
		win_nt:false, mac:false, linux:false,
		//browser
		safari:(browser.name=='safari'),
		chrome:(browser.name=='chrome'),
		opera:(browser.name=='opera'),
		msie:(browser.name=='msie'),
		webkit:browser.webkit,
		mozilla:browser.mozilla,
		plf:"E",
		os:"E",
		brw:"E",
		//common
		olderBrws:false,
		loadInfo:null,
		init:function(){
			var that=this,
				usrAgent = navigator.userAgent.toLowerCase(),
				arrMobileOS	= {"android":"A", "like mac os x":"I", "bada":"B", "windows ce":"C", "windows phone":"H", "symbianos":"S", "polaris":"P"},
				arrPcOS		= {"windows nt":"W", "macintosh":"M", "linux":"L"},
				arrBrowser	= {"msie":"I", "chrome":"C", "firefox":"F", "safari":"S", "webkit":"W", "opera":"O"};

			if(usrAgent.match(/ipad|blackberry|android|lg|mot|samsung|sonyericsson|mobile|windows ce|windows phone|opera mobile|opera mini|polaris/)!=null){
				this.plf="M";	//모바일 플랫폼
				var mobile_match = usrAgent.match(/android|like mac os x|bada|windows ce|windows phone|symbianos|polaris/);
				if(mobile_match!=null){
					this.os			= arrMobileOS[mobile_match];	//os
					this.android	= mobile_match=="android";
					this.ios		= mobile_match=="like mac os x";
					this.bada		= mobile_match=="bada";
					this.win_ce		= mobile_match=="windows ce";
					this.win_phone	= mobile_match=="windows phone";
					this.symbian	= mobile_match=="symbianos";
					this.polaris	= mobile_match=="polaris";
				}
				var mobile_app_match = usrAgent.match(/kakaotalk/);
				if(mobile_app_match!=null){
					this.kakaotalk = mobile_app_match=="kakaotalk";
				}
				if(this.android){
					if(usrAgent.match(/mobile|shw/)==null)	 this.plf = "E";	//기타 (크롬북)
					//안드로이드 버전
					var match_version	= usrAgent.match(/android ([0-9a-zA-Z_?\.?]+){1}/);
					//파폭예외처리
					if(match_version){
						if(match_version.length>0){
							if(Number(match_version[1].substr(0,1))<3)	this.olderBrws=true;
						}
					}
				}
				if(this.chrome || this.opera)		this.webkit=false;	//크롬 or 오페라일 경우 웹킷 아님처리
				if(this.webkit){	//웹킷 브라우저일 경우
					if(usrAgent.indexOf('crios') !== -1){	//모바일 크롬
						this.chrome	= true;
						this.webkit	= false;
					}
					if(this.ios){	//iOS 인데 크롬이 아니면 모두 사파리로 처리
						if(!this.chrome){
							this.safari	= true;
							this.webkit	= false;
						}
						//iOS버전
						var match_version	= usrAgent.match(/([0-9a-zA-Z_?\.?]+) like mac os x{1}/);
						if(match_version.length>0){
							var match_ver = (match_version.toString().indexOf('_')==1)?Number(match_version[1].substr(0,1)):Number(match_version[1].substr(0,2));
							if(match_ver<5)	this.olderBrws=true;
						}
					}
				}//if(this.webkit)
			}else{
				this.plf = "P";	 //PC 플랫폼
				var pc_match = usrAgent.match(/windows nt|macintosh|linux/);
				if(pc_match!=null){
					this.os		= arrPcOS[pc_match];		//os
					this.win_nt	= pc_match=="windows nt";
					this.mac	= pc_match=="macintosh";
					this.linux	= pc_match=="linux";
				}
				if( browser.name=='msie' || (browser.mozilla && usrAgent.match(/trident/)!=null) ){
					this.msie		= true;
					this.firefox	= false;
				}
				if( browser.mozilla && usrAgent.match(/firefox/)!=null ){
					this.msie		= false;
					this.firefox	= true;
				}
				if(this.webkit && !this.chrome && !this.opera)	this.safari=true;	//사파리
				if(this.webkit && (this.chrome || this.safari || this.opera))	this.webkit	= false;	//웹킷
				if(this.msie && browser.version<9) this.olderBrws=true;
			}
			//browser
			for(var i in arrBrowser){
				if(that[i]){
					that.brw = arrBrowser[i];
					break;
				}
			}
			//loadInfo
			this.loadInfo	= this.plf+this.os+this.brw;
			window.adt_loadInfo	= this.plf+this.os+this.brw;
		}
	};
	UA.init();
	var usrProtocol=(document.location.protocol==='https:')?'https://':'http://';
	var adtiveBanner={
		plugin_host:usrProtocol+"plugin.adplex.co.kr",
		log_host:usrProtocol+"log.adplex.co.kr",
		md_key:'',
		mzcodeChk:[],
		bnObj:[],
		bnObj_overlap:[], 		//중복영역체크
		bnObj_overlap_data:{}, 	//중복영역 호출데이터
		bnObj_overlap_mdkey:{},	//미리선언된 zoneID영역의 md_key
		bnObj_zone_id:[], 		//zone_id선언되있는 영역(돔완성후 로딩영역 구분)
		ScriptVer:'2.34',
		//브릿지애드관련 변수
		isBridgeAd:false, 	// 브릿지애드슬라이드(true,false)
		BalPageChk:[], // 브릿지애드레이아웃 페이지 중복로드확인
		isReady:false,
		isTest:false,
		rctSet:'',
		noRtg:false,
		isRepConn:false,
		isConnected:false,
		isComplete:false,
		isSent:false,
		isIE7:false,
		refInfo:false,
		etcData:{},
		znfirstLoad:{},
		znPassback:{},
		clkChk:{},			// 클릭제한 체크
		arr_rand_idx:[],	// 노출될 소재 인덱스
		arr_pan_pvChk:[],	// 판 PV 기록여부
		arr_pan_zvChk:[],	// 판 ZV 기록여부
		arr_rgt_pvChk:[],	// 리타겟팅 PV 기록여부
		arr_zone_mvChk:[],	// 영역별 MV 기록여부

		//jquery 미사용 
		// is_oldMethod:(Number((jQueryVer.split(".")).slice(0,2).join("")) < Number(("1.5".split(".")).slice(0,2).join(""))),

		fontFamily:{"0":"TmpFont","1":"Gulim", "2":"Dotum", "4":"Arial", "5":"Tahoma", "6":"NanumGothic,nanumgothic,Nanum Gothic,Nanum-Gothic", "7":"malgun gothic", "8":"AppleGothic", "9":"Sans-serif", "10":"Helvetica", "11":"AppleSDGothicNeo-Light", "12":"notokr-regular", "13":"Droid Sans fallback", "14":"Noto Sans KR"},
		is_avoidTransforms:true,		//true: webkit 사용
		useTranslate3d:!UA.olderBrws,	//true: 하드웨어 3D가속 사용
		leaveTransforms:!UA.olderBrws,	//true: 좌표값 복구 안함
		Test:function(){this.isTest=true;},	//앞으로 제거예정
		init:function(options){
			var that = this, _mdkey, setZone;
			if(that.isReady)	return;
			if(typeof(options)!=="object"){
				_mdkey = options;
				if(typeof _mdkey==="undefined" || _mdkey==null || _mdkey=="")	return;
			}else{
				_mdkey		= options["mdcode"];
				that.isTest	= (options["isTest"]!=true)?false:true;
				that.rct_set= options["rctSet"];
				that.noRtg	= (options["noRtg"]!=true)?false:true;
				setZone		= options["setZone"];
				that.isBridgeAd	= (options["isBridgeAd"]!=true)?false:true;
				if(typeof _mdkey==="undefined" || _mdkey==null || _mdkey=="") return;
				if(typeof that.rct_set==="undefined" || that.rct_set==null) that.rct_set=="";
			}
			if(!that.isReady){
				that.md_key=_mdkey;
				that.isReady=true;
			}
			if((that.getParam("_adttest")==="true")) that.isTest=true;	// 컨테이너 페이지의 파라미터값에 의한 테스트모드 적용

			document.addEventListener("DOMContentLoaded",()=>{

				console.log("document ready in");

			});








		}

	}
	//각각의 영역별 소재데이터 호출 
	function adtiveSetAD(options){
		var setType=options.setType||'write';
		var md_key=options.md_key;
		var zone_key=options.zone_key;
		var passback=options.passback;
		var callback=options.callback;
		var targetSelector=options.targetSelector;
		var callbackID;
		//호출시 콜백함수가 존재한다면 글로벌객체 adtiveCallbackSet에 저장 후 콜백ID 리턴 
		if(typeof callback==='function') callbackID=setCallback(callback);
console.log(md_key, zone_key);
		//필수항목체크 
		if( !(typeof md_key!=='' && typeof zone_key!=='undefined') && (md_key!='' && zone_key!='') ){ return; }
		var zone_id=''; 				//영역중복생성 카운트 
		adtiveBanner.md_key=md_key; 	//매체코드 
console.log('영역중복체크 =>',adtiveBanner.mzcodeChk, adtiveBanner.mzcodeChk.includes(zone_key));
		//영역중복체크 중복이 아닌경우 
		if( !adtiveBanner.mzcodeChk.includes(zone_key) ){
console.log('영역중복X');

		}else{
console.log('영역중복O');

		}




	}

	var adt_lib = {
		encode_data : function(this_href){
			var get_uid = document.cookie.match('(^|;) ?md_uid=([^;]*)(;|$)');
			if(typeof md_data=='undefined') window.md_data = '';
			var _md_uid = get_uid ? get_uid[2] : md_data;
			var encode_data = '';
			if(typeof md_ver=='undefined') var md_ver = '';
			if(_md_uid){
				var uid_data = JSON.parse(atob(decodeURIComponent(_md_uid)));
				encode_data = encodeURIComponent(btoa(uid_data.md_uid+'||'+this_href+'||'+location.href+'||'+md_ver));
			}
			return encode_data;
		}
	};



	window.adtiveAppendAD=function(md_key,zone_key,targetSelector,passback,callback){
		adtiveSetAD({
			setType:'append',
			md_key:md_key,
			zone_key:zone_key,
			targetSelector:targetSelector,
			passback:passback,
			callback:callback
		});

	}

	console.log(1111);
})(window.init2beon);

}catch(e){console.log(e);}



console.log("end");

window.adtiveAdScriptLoaded = true;

})();


</script>

<ul>
	<li>
		1
		<div id='_2BEONQI4LLLLF'></div>
	</li>
	<li>2</li>
	<li id="tt">3
		<script>adtiveDrawAD('ZDFFFFFP','QI4LLLLF');</script>
	</li>
	<li>4</li>
	<li id="aaa"><span>5</span></li>
</ul>




</body>
</html>