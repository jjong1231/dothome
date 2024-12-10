((w) => {
  "use strict";
  var doc = w.document,
    // arr_mtno = [], //슬롯에 사용된 소재리스트
    check_pv = {},
    check_click = {},
    pv_data = {},
    clk_data = {},
    log_host = "http://www.adplex.co.kr/_pjh",
    log_url_pv = "/log/pv.php",
    log_url_click = "/log/clk.php",
    get_data = "/log/get_data.php";
    // log_host = "http://jjong1231.dothome.co.kr",
    // log_url_pv = "/dsp/log/pv.php",
    // log_url_click = "/dsp/log/clk.php",
    // get_data = "/dsp/get_data.php";

  //기존 로드되있는경우 멈춤
  if (typeof adtiveDSP === "function") {
    console.warn("Already loaded!");
    return;
  }

  //디바이스 정보
  var UA = (function () {
    var ua = navigator.userAgent.toLowerCase();
    var res = {
      touchDevice: "ontouchstart" in window,
      mobile: Boolean(ua.match(/iphone|ipad|android|mobile/) != null),
      appleDevice: Boolean(ua.match(/ mac os /) != null),
      ie: Boolean(ua.match(/trident|msie/) != null),
      chrome: Boolean(ua.match(/chrome/) != null),
    };
    res.safari = Boolean(ua.match(/safari/) != null && !res.chrome);
    return res;
  })();

  // console.log(UA.mobile, UA.appleDevice);

  var adtiveDSP = {
    //초기화 설정
    init: function () {
      var that = this;
    },
    mkbanner: (zcode, selector, cb) => {
      // console.warn(zcode, selector, cb);
      //영역 데이터가져오기
      const url_get_data = log_host + get_data;
      const callbackName = "CB" + adtiveDSP.getRand();
      const script = doc.createElement("script");
      window[callbackName] = function (data) {
        const automat = JSON.parse(data.automat);
        const styleEl = doc.createElement("style");
        /*
        썸네일 높이구하는 방법
        1슬롯의 높이값 = (전체 높이값-슬롯간격)/세로슬롯갯수
        텍스트 높이값 = 폰트사이즈*2
        이미지 텍스트간격 = 셋팅값
        이미지 높이 = 1슬롯의 높이값-(텍스트 높이값+이미지 텍스트간격)
        와이드배너 true일때 영역 가로사이즈 100%
        */
        var zone_cfg = data.cfg, //영역설정
          arr_mat = data.mat; //소재데이터
        // console.log(zone_cfg);
        // prettier-ignore
        // var zcode = zone_cfg.zcode, //영역코드
        var zone_shadow = zone_cfg.zone_shadow?' shadow-all':'', //영역 그림자효과
        zone_margin = zone_cfg.zone_margin, //영역외부 위치이동
        slot_padding = zone_cfg.slot_padding, //슬롯내부 위치이동
        zborder_px = zone_cfg.zborder_px, //영역테두리 px
        zborder_type = zone_cfg.zborder_type, //영역테두리 타입
        zborder_color = zone_cfg.zborder_color, //영역테두리 색상
        bn_type = zone_cfg.bn_type, //배너타입 0:이미지, 1:텍스트, 2:썸네일
        slot_type = zone_cfg.slot_type, //슬롯타입 P:판, S:슬롯
        zone_w = zone_cfg.width, //영역가로
        zone_h = zone_cfg.height, //영역세로
        slot_num_w = zone_cfg.slot_num_w, //슬롯 가로갯수
        slot_num_h = zone_cfg.slot_num_h, //슬롯 세로갯수
        slot_cnt = slot_num_w*slot_num_h, //슬롯 전체갯수
        container_w = zone_w-(zborder_px*2), //컨테이너 가로
        container_h = zone_h-(zborder_px*2), //컨테이너 세로
        container_gap = (zone_cfg.slot_gap==0||zone_cfg.slot_gap)?zone_cfg.slot_gap:2, //슬롯간 간격
        item_padding = zone_cfg.item_padding, //슬롯내부 위치이동
        item_padding_px = typeof zone_cfg.item_padding!=='undefined'?zone_cfg.item_padding_px:0, //슬롯패딩px값
        slot_w = (container_w - (container_gap*(slot_num_w-1))  ) / slot_num_w, //슬롯 가로길이
        slot_h = (container_h - (container_gap*(slot_num_h-1))) / slot_num_h, //슬롯 세로길이
        img_position = zone_cfg.img_position, //썸네일 위치 (T:상,B:하,L:좌,R:우)
        img_ratio = zone_cfg.img_ratio, //이미지 가로세로 비율
        img_txt_gap = zone_cfg.img_txt_gap, //이미지,텍스트 간격
        item_txt_w = 0, //텍스트 기본값 0
        item_txt_h = 0, //텍스트 기본값 0
        item_img_w = slot_w - (item_txt_h+(img_txt_gap*(slot_num_w-1))), //이미지 영역 가로
        item_img_h = slot_h - (item_txt_h+(img_txt_gap*(slot_num_h-1))), //이미지 영역 세로
        font_size = zone_cfg.font_size?zone_cfg.font_size:15, //폰트 사이즈
        font_color = zone_cfg.font_color?zone_cfg.font_color:'#333', //폰트 컬러
        font_family = zone_cfg.font_family, //폰트 패밀리
        text_line_height = zone_cfg.line_height?zone_cfg.line_height:font_size, //텍스트 자간
        item_align = zone_cfg.item_align, //정렬위치
        css_item_padding = '',

        float = zone_cfg.float, //플로팅 여부
        zindex = typeof zone_cfg.zindex!=='undefined'?zone_cfg.zindex:1, //z-index
        scroll_move = typeof zone_cfg.scroll_move!=='undefined'?zone_cfg.scroll_move:'fixed', //z-index
        show_effect = float?zone_cfg.show_effect:false, //노출효과
        fix_position = float?zone_cfg.fix_position:false, //최종위치 css 문법 상,우,하,좌

        //노출조건
        show_event = float?zone_cfg.show_event:'now', //즉시, 스크롤, 시간지연
        show_opt = float?zone_cfg.show_opt:'px', //셀렉터, px
        show_opt_selector = (float&&show_opt=='selector')?zone_cfg.show_opt_selector:false, //셀렉터이름
        show_px = (float&&show_opt!='now')?zone_cfg.show_px:0, //px값

        hide_event = zone_cfg.hide_event, //숨김조건 false:사용안함, selector:셀렉터, timer:시간지연
        hide_selector = zone_cfg.hide_selector, //숨김 셀렉터
        hide_num = zone_cfg.hide_num, //숨김 px, timer

        eff_layer = zone_cfg.eff_layer; //와이드배너 true,false

        if(item_padding){
          css_item_padding = ' padding-'+zone_cfg.item_padding_target+': '+zone_cfg.item_padding_px+'px;';
        }

        //썸네일영역 이미지 영역 높이 계산
        //prettier-ignore
        if (bn_type == 2) {
          item_txt_h = text_line_height * 2; //텍스트 영역높이(썸네일인경우 2줄 고정이라 2배)
          //이미지 T,B일때 세로계산
          //prettier-ignore
          if(img_position=='T'||img_position=='B'){
            // item_img_h = slot_h - (item_txt_h+(img_txt_gap*(slot_num_h-1))); //이미지 영역 세로
            item_img_h = (slot_h*0.95) - (item_txt_h+(img_txt_gap*(slot_num_h-1))); //이미지 영역 세로
            item_txt_h = slot_h - item_img_h;
            item_txt_w = slot_w - (img_txt_gap*(slot_num_w-1));
          }else{
            item_img_w = slot_w/2; //이미지 영역 가로
            item_txt_w = slot_w - item_img_w - img_txt_gap; //텍스트 영역 가로
          }
          console.log('slot_w',slot_w);
          console.log('slot_h',slot_h);
          console.log('item_img_w',item_img_w);
          console.log('item_img_h',item_img_h);
          console.log('item_txt_w',item_txt_w);
        }
        //슬롯비율, 이미지비율로 기준지정
        //prettier-ignore
        // var ratio_wh = item_img_w <= item_img_h ? "width" : "height", //이미지 가로세로 기준
        var ratio_wh = "width"; //이미지 가로세로 기준

        //영역 위치,테두리 설정
        var css_container_border = "";
        //영역 위치
        if (zone_margin != false) {
          css_container_border += zone_margin;
        }
        //영역 테두리
        if (zborder_px > 0) {
          // prettier-ignore
          css_container_border += " border: "+zborder_px+"px "+zborder_type+" "+zborder_color+";";
        }

        // prettier-ignore
        var elmID = "adtiveDSP_" + zcode + "_" + adtiveDSP.getRand();

        //영역 기본셋팅(이미지영역 기본값)
        var item_className = "item",
          add_css = "",
          a_display_flex = "",
          add_item_img = "",
          add_item_txt = "width: " + (slot_w - (bn_type==2?20:0)) + "px;",
          css_container_width = "width: " + (eff_layer ? "100%;" : container_w+"px;"),
          // css_img_img = img_ratio+": 100%",
          css_img_img = ratio_wh+": 100%; max-width: "+(item_img_h*1.6)+"px",
          // css_img_img = ratio_wh+": 100%;",
          css_img_txt_gap = "margin-top: " + img_txt_gap + "px";

        // prettier-ignore
        if(bn_type==2){
          //썸네일영역일때
          switch (img_position) {
            case "B":
              item_className = "item";
              break;
            case "L":
              item_className = "item horizontal";
              a_display_flex = " display: flex;";
              add_css = "#" + elmID + " .item.horizontal { display: flex; flex-direction: row; align-items: center; }";
              add_item_img = "width: "+item_img_w+'px;';
              add_item_txt = "width: "+item_txt_w+'px;';
              item_img_h = slot_h;
              item_txt_h = slot_h;
              css_img_img = ratio_wh+": 100%";
              css_img_txt_gap = "margin-left: "+img_txt_gap+"px";
              break;
            case "R":
              item_className = "item horizontal";
              a_display_flex = " display: flex;";
              add_css = "#" + elmID + " .item.horizontal { display: flex; flex-direction: row-reverse; align-items: center; }";
              add_item_img = "width: "+item_img_w+'px;';
              add_item_txt = "width: "+item_txt_w+'px;';
              item_img_h = slot_h;
              item_txt_h = slot_h;
              css_img_img = ratio_wh+": 100%";
              css_img_txt_gap = "margin-left: "+img_txt_gap+"px";
              break;
              default:
              add_item_txt = "width: "+item_txt_w+'px;';

              break;
          }
        }else if(bn_type==1){
          //텍스트영역일때
          item_txt_w = eff_layer?"100%":(slot_w - container_gap*(slot_num_w-1)/slot_num_w)+"px";
          item_txt_h = slot_h - container_gap*(slot_num_h-1);
          add_item_txt = "width: "+item_txt_w;
          text_line_height = slot_h;
        }
        //플로팅, 썸네일, 이미지, 좌,우 일때 최소가로길이 설정 
        // if(img_position=='L'||img_position=='R') add_item_img = ' width: '+(((document.body.offsetWidth/2)/slot_num_w)-((zborder_px*2)+(container_gap*(slot_num_w-1))))+'px;';
        console.log('item_img_h',item_img_h);
        console.log('add_item_img',add_item_img);

        // 폰트 관련 설정
        var css_font = "color: " + font_color + "; font-family:" + font_family + ";";
        var css_item_align = "";

        //와이드배너일때
        zone_w = eff_layer ? "100%" : zone_w + "px"; //와이드배너(true:100%,false:고정사이즈)

        //플로팅 css 적용
        if(float){
          //최종위치 적용
          var arr_px = fix_position.split(','), arr_bearing = ['top','right','bottom','left'];
          var css_float = " position: "+scroll_move+";";
          var css_move = "0, "+container_h+"px";
          switch(show_effect){
            case "left":    css_move = (eff_layer)?'103vw':((10+parseInt(zone_w)+parseInt(arr_px[1])))+"px ,0"; break;
            case "right":   css_move = (eff_layer)?'-103vw':((10+parseInt(zone_w)+parseInt(arr_px[3]))*-1)+"px ,0"; break;
            case "down":    css_move = "0, "+((10+parseInt(zone_h)+parseInt(arr_px[0]))*-1)+"px"; break;
            default:        css_move = "0, "+(parseInt(zone_h)+parseInt(arr_px[2]))+"px"; break;
          }
          arr_px.map((v,i)=>{
            if(parseInt(v)>0){
              css_float += " "+arr_bearing[i]+": "+v+"px;";
            }
          });

            console.log('show_effect',show_effect);
            console.log('css_move',css_move);

            css_float += " transition: width 400ms ease, height 400ms ease, left 400ms ease, top 400ms ease, transform 400ms ease, opacity 80ms linear, margin-left 0s linear; transform: translate("+css_move+");";

          }

        // prettier-ignore
        var cssText = "#" + elmID + " { margin: 0; padding: 0; width: " + zone_w + "; height: " + zone_h + "px; display: flex; justify-content: center; "+css_float+" z-index: "+zindex+"; }";
        // prettier-ignore
        cssText += "#" + elmID + " .adt_container {  display: grid; grid-template-columns: repeat(" + slot_num_w + ", 1fr); grid-template-rows: repeat(" + slot_num_h + ", auto); gap: "+container_gap+"px; "+css_container_width+css_container_border+"; }";
        // prettier-ignore
        cssText += "#" + elmID + " .item { min-width: " + slot_w + "px; background-color: #fff; overflow: hidden; display: flex; flex-direction: column; align-items: "+item_align+";"+css_item_padding+"}";
        cssText += "#" + elmID + " .item a{ text-decoration: none; "+a_display_flex+"}";
        cssText += "#" + elmID + " .shadow-all { box-shadow: 3px 3px 9px #333; }";
        cssText += "#" + elmID + ".adtive_float { transform: translate(0, 0) !important; }";
        cssText += "#" + elmID + ".adtive_float_hide { "+css_float+" }";
        //배너타입 bn_type 0:이미지, 1:텍스트, 2:썸네일
        if(bn_type==0||bn_type==2){
          if(img_position=="T"||img_position=="B"){
            css_item_align = " align-items: "+item_align+";";
          }
          // prettier-ignore
          cssText += "#" + elmID + " .item_img {"+add_item_img+" height: " + item_img_h + "px; overflow: hidden; display: flex; justify-content: center;"+css_item_align+"}";
          // prettier-ignore
          cssText += "#" + elmID + " .item_img img { object-fit: contain; }";
        }
        //배너타입 bn_type 0:이미지, 1:텍스트, 2:썸네일
        if(bn_type==1||bn_type==2){
          // prettier-ignore
          cssText += "#" + elmID + " .item_text { "+add_item_txt+" height: " + item_txt_h + "px; " + css_img_txt_gap + "; font-size: "+font_size+"px;  line-height: " + text_line_height + "px; "+css_font+" position: relative; }";
          //썸네일 텍스트인경우 세로중앙정렬 css 
          cssText += "#" + elmID + " .item_text .inner_text { "+add_item_txt+" position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); overflow: hidden; text-align: " + item_align + "; text-overflow: ellipsis; white-space: nowrap; }";
        }
        cssText += add_css;

        //css 적용
        styleEl.innerText = cssText;
        doc.head.appendChild(styleEl);

        //영역 삽입
        // prettier-ignore
        doc.currentScript.insertAdjacentHTML('afterend','<div id='+elmID+'><div class="adt_container'+zone_shadow+'"></div></div>');
        var outer_elmID = doc.getElementById(elmID);
        // prettier-ignore
        var inner_container = outer_elmID.getElementsByClassName("adt_container")[0];

        ///////////////////////////////////////////////////
        //자동소재로 테스트
        if (zcode == "1111BBBLLLLF") {
          arr_mat = [];
          automat.forEach((v, i) => {
            if (i > 3) return false;
            // prettier-ignore
            arr_mat.push({
              mtno: parseInt(i+Math.random()*1000),
              img: "https://plugin.adplex.co.kr/banner/" + decodeURIComponent(v.image),
              text: decodeURI(v.text),
              landurl: decodeURI(v.landurl)
            });
          });
        }
        ///////////////////////////////////////////////////

        //슬롯타입이 S일때 소재 섞기
        if (slot_type == "S") {
          // prettier-ignore
          arr_mat.sort(() =>  Math.random() - 0.5 ); //소재순서 랜덤섞기
        }

        var arr_pvData = []; //소재별 데이터 임시저장

        //슬롯 삽입
        // prettier-ignore
        arr_mat.forEach((v, i) => {
          var mtno = v.mtno;
          if (i >= slot_cnt) return false; //슬롯수 만큼만 소재 가져옴

          var tmp_item = document.createElement('div'); //item 생성
          tmp_item.className = item_className;

          //이미지영역 높이값을 기준으로 이미지 가로길이가 영역 가로길이보다 큰경우
          if(bn_type==0||bn_type==2){
            var arr_img_size = v.img_size.split('x'),
            img_rate = arr_img_size[0]/arr_img_size[1],
            img_resize_wid = arr_img_size[0]*(item_img_h/arr_img_size[1]),
            standard_wid_hei = 'style="'+(item_img_w>=img_resize_wid?'height':'width') +': 100%"';
          }

          var set_innerHTML = '';
          // prettier-ignore
          switch(bn_type){
            case 1: //텍스트
            tmp_item.innerHTML = `<a href="`+v.landurl+`" target="_blank"><div class="item_text">` + v.text.replace('<br />','') + `</div></a>`;
              break;
            case 2: //썸네일
            if(img_position=='B'){
                tmp_item.innerHTML = `<a href="`+v.landurl+`" target="_blank"><div class="item_text">"` + v.text + `</div> <div class="item_img"><img `+standard_wid_hei+` src="` + v.img + `" alt="" /></div></a>`;
              }else{
                tmp_item.innerHTML = `<a href="`+v.landurl+`" target="_blank"><div class="item_img"><img `+standard_wid_hei+` src="` + v.img + `" alt="" /></div> <div class="item_text"><div class="inner_text">` + v.text + `</div></div></a>`;
              }
              break;
            default: //이미지
              tmp_item.innerHTML = `<a href="`+v.landurl+`" target="_blank"></div> <div class="item_img"><img `+standard_wid_hei+` src="` + v.img + `" alt="" /></div></a>`;
              break;
            }
            //item에 데이터 저장
            tmp_item.mat = JSON.stringify(v);
            //클릭이벤트
            tmp_item.addEventListener('click',function(){
              //클릭 아이템 소재 데이터
            var matData = this.mat
            // console.log('클릭소재 데이터 ',matData);
            //클릭로그 전송
            // adtiveDSP.sendClick(zcode,JSON.parse(this.dataset.matInfo));
            adtiveDSP.sendClick(elmID, JSON.parse(matData));
            //랜딩 이동
            // top.location.href=v.landurl;
            // window.open(v.landurl, '_blank');
          });
          inner_container.appendChild(tmp_item);
          //현재소재 pv로그 (캠페인번호|캠페인과금제|랜딩주소)
          arr_pvData.push(v.cpno+'|'+v.mtno+'|'+v.cp_kind+'|'+v.landurl);
        });
        //pv로그 전송
        adtiveDSP.sendPv(elmID,arr_pvData);

        //플로팅 일때
        if(float){
          switch(show_event){
            case 'scroll': //특정높이(셀렉터,px)에서 실행
              adtiveDSP.scrollAcrion(elmID, {'show_opt':show_opt, 'show_opt_selector':show_opt_selector, 'show_px':show_px, 'hide_event':hide_event, 'hide_selector':hide_selector, 'hide_num':hide_num }); //대상ID, 이벤트 조건 {}
            break;
            case 'timer': //설정시간이 지나면 실행
              show_px = show_px>0?show_px:2000; //기본값 2초
              setTimeout(function(){ document.getElementById(elmID).classList.add("adtive_float"); }, show_px);
            break;
            default:
              //딜레이 0.5초
              setTimeout(function(){ document.getElementById(elmID).classList.add("adtive_float"); }, 500);
            break;
          }
        }

        document.addEventListener("DOMContentLoaded", function(){
          // inner_container.style.transform = 'translate(0,0)';
          console.log("----------------zcode");
        });

      };
      // prettier-ignore
      script.src = url_get_data + "?jsoncallback=" + callbackName + "&zoneCD=" + zcode;

      //기존 스크립트 추가방식 
      // doc.body.appendChild(script);

      //현재 위치에 스크립트 추가 
      // 현재 스크립트를 참조
      const scriptTag = document.currentScript;
      // 스크립트 바로 다음에 추가
      scriptTag.parentNode.insertBefore(script, scriptTag.nextSibling);
      
    },
    //PV 로그전송
    sendPv: (elmID,arr_pvData) => {
      //pv 중복 체크
      if (typeof check_pv[elmID] === "undefined") {
        //값이 없을경우 PV로그 전송 및 해당영역 전송 true
        check_pv[elmID] = true;

        var that = this,
        arr_key = elmID.split("_"),
        zcode = arr_key[1],
        uniq_num = arr_key[2];

        var str_codeSet	= encodeURIComponent(arr_pvData.join("[:divider:]"));

        // var rs_pvData = {
        //   zcode: zcode,
        //   plf: (UA.mobile?'M':'P'),
        //   codeSet: str_codeSet
        // };
        // console.log('==>',rs_pvData);

        var pv_url = log_host+log_url_pv;

        //PV일괄처리
        var _Img = new Image(),
          add_param = "?zcode="+zcode
          +"&matData="+str_codeSet
          +"&plf="+(UA.mobile?'M':'P')
          +"&rnd="+adtiveDSP.getRand()
          +"&md_domain="+encodeURIComponent(document.domain);
          _Img.src = pv_url+add_param;
          // console.log( pv_url+add_param );

      }else{
        alert('로그중복!!');
      }

    },
    //클릭 로그전송
    sendClick: (elmID, matData) => {
      var this_mtno = matData.mtno,
        arr_key = elmID.split("_"),
        zcode = arr_key[1],
        uniq_num = arr_key[2];

      //해당영역 중복클릭 체크
      if (typeof check_click[elmID + "_" + this_mtno] === "undefined") {
        //첫클릭일때만 클릭로그 전송 및 클릭여부 저장
        check_click[elmID + "_" + this_mtno] = true;
        // prettier-ignore
        var clk_url = log_host+log_url_click;
        //영역,캠페인,소재번호,캠페인과금제,plf,클릭사이트
        var _mtno = matData.mtno,
            _cp_kind = matData.cp_kind,
            _cpno = matData.cpno,
            _plf = UA.mobile?'M':'P',
            _href = window.location.href;
        if(window.location!==window.top.location){
          _href = window.top[0].location.href;
        }
        var clickSet = btoa(encodeURI(_cpno+'|'+_mtno+'|'+_cp_kind+'|'+_plf+'|'+_href));
        //클릭로그 처리
        var _Img = new Image(),
          add_param = "?zcode="+zcode
          +"&clkData="+clickSet
          +"&rnd="+adtiveDSP.getRand();
          _Img.src = clk_url+add_param;
      } else {
        console.log("중복클릭", check_click);
      }
    },
    //스크롤이벤트
    scrollAcrion: (elmID,opt)=>{
      var El = document.getElementById(elmID),
        show_opt = opt.show_opt, //셀렉터, px 구분
        show_opt_selector = opt.show_opt_selector, //셀렉터
        show_px = opt.show_px, //노출설정px
        view_px = show_px, //노출px
        hide_event = opt.hide_event, //숨김이벤트
        hide_px = document.body.offsetHeight, //문서전체 높이값
        hide_selector = opt.hide_selector, //숨김 셀렉터
        hide_num = opt.hide_num, //숨김 px, timer
        now_px = window.pageYOffset || document.documentElement.scrollTop; //현재 스크롤위치
      //숨김이벤트 true, 셀렉터가 존재할때만
      if(hide_event&&document.querySelector(hide_selector)!=null){
        hide_px = document.querySelector(hide_selector).offsetTop-window.innerHeight+hide_num;
      }
      //셀렉터 높이값 도달시 노출
      if(show_opt=='selector'){
        //셀렉터 노출포인트 = 셀렉터 스크롤값-스크린높이값+사용자정의px
        show_px = document.querySelector(show_opt_selector).offsetTop-window.innerHeight+show_px;
      }
      if(now_px>=show_px && hide_px && now_px<hide_px) El.classList.add("adtive_float"); //첫스크롤값이 설정값보다 크면 배너 노출

      // Throttle 함수 구현
      function throttle(fn, wait) {
        var time = Date.now();
        return function() {
          if ((time + wait - Date.now()) < 0) {
            fn();
            time = Date.now();
          }
        }
      }

      document.querySelector('#now_scroll').textContent = "노출:"+show_px+'px / 스크롤:'+now_px+"px / 감춤:"+hide_px+"px";
      // 스크롤 이벤트를 throttle하여 성능을 최적화
      window.addEventListener('scroll', throttle(function() {
        var now_px = window.pageYOffset || document.documentElement.scrollTop; //현재 스크롤위치
        document.querySelector('#now_scroll').textContent = "노출:"+show_px+'px / 스크롤:'+now_px+"px / 감춤:"+hide_px+"px";
        if(now_px>=show_px && now_px<hide_px) El.classList.add("adtive_float");
        else El.classList.remove("adtive_float");
        // console.log('스크롤 중입니다! (Throttle 적용)');
      }, 200));
    },
    getRand:function(){
      var rand = Math.random()*999999;
      return Math.ceil(rand);
    }
  };

  adtiveDSP.init();
  w.adtiveDSP=w.adtiveDSP||function(zcode,selector,cb){adtiveDSP.mkbanner(zcode,selector,cb)}

})(window);