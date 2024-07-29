((w) => {
  "use strict";
  var doc = w.document,
    arr_mtno = [], //슬롯에 사용된 소재리스트
    check_pv = {},
    check_click = {},
    log_host = "https://www.adplex.co.kr",
    log_url_pv = "/_pjh/log/pv.php",
    log_url_click = "/_pjh/log/clk.php",
    get_data = "/_pjh/get_data.php";

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
  console.log(UA);
  var adtiveDSP = {
    //초기화 설정
    init: function () {
      var that = this;
    },
    mkbanner: (zcode, selector, cb) => {
      // console.warn(zcode, selector, cb);
      //영역 데이터가져오기
      let url_get_data = log_host + get_data;
      let callbackName = "CB" + parseInt(Math.random() * 100000000);
      let script = doc.createElement("script");
      window[callbackName] = function (data) {
        var automat = JSON.parse(data.automat);
        // console.warn(typeof automat);

        var styleEl = doc.createElement("style");
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
        var zcode = zone_cfg.zcode, //영역코드
        zone_shadow = zone_cfg.zone_shadow?' shadow-all':'', //영역 그림자효과
        zone_margin = zone_cfg.zone_margin, //영역외부 위치이동
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
        slot_w = (container_w - (container_gap*(slot_num_w-1))) / slot_num_w, //슬롯 가로길이
        slot_h = (container_h - (container_gap*(slot_num_h-1))) / slot_num_h, //슬롯 세로길이
        img_position = zone_cfg.img_position, //썸네일 위치 (T:상,B:하,L:좌,R:우)
        img_ratio = zone_cfg.img_ratio, //이미지 가로세로 비율
        img_txt_gap = zone_cfg.img_txt_gap, //이미지,텍스트 간격
        item_txt_w = 0, //텍스트 기본값 0
        item_txt_h = 0, //텍스트 기본값 0
        item_img_w = slot_w - (item_txt_h+(img_txt_gap*(slot_num_w-1))), //이미지 영역 가로
        item_img_h = slot_h - (item_txt_h+(img_txt_gap*(slot_num_h-1))), //이미지 영역 세로
        font_size = zone_cfg.font_size, //폰트 사이즈
        font_color = zone_cfg.font_color, //폰트 컬러
        font_family = zone_cfg.font_family, //폰트 패밀리
        text_line_height = zone_cfg.line_height?zone_cfg.line_height:font_size, //텍스트 자간
        font_align = zone_cfg.font_align; //텍스트 정렬

        //썸네일영역 이미지 영역 높이 계산
        //prettier-ignore
        if (bn_type == 2) {
          item_txt_h = text_line_height * 2; //텍스트 영역높이(썸네일인경우 2줄 고정이라 2배)
          //이미지 T,B일때 세로계산
          //prettier-ignore
          if(img_position=='T'||img_position=='B'){
            item_img_h = slot_h - (item_txt_h+(img_txt_gap*(slot_num_h-1))); //이미지 영역 세로
          }else{
            item_img_w = (slot_w - (img_txt_gap*(slot_num_w-1))) / slot_num_w; //이미지 영역 가로
            item_txt_w = slot_w - item_img_w; //텍스트 영역 가로
          }
        }
        //슬롯비율, 이미지비율로 기준지정
        //prettier-ignore
        var ratio_wh = item_img_w*0.55 <= item_img_h ? "width" : "height"; //이미지 가로세로 기준

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
        var elmID = "adtiveDSP_" + zcode + "_" + parseInt(Math.random() * 100000000);

        //영역 기본셋팅(이미지영역 기본값)
        // prettier-ignore
        var item_className = "item",
          add_css = "",
          add_item_img = "",
          add_item_txt = "width: " + (slot_w - (bn_type==2?20:0)) + "px;",
          css_container_width = "width: " + ((slot_num_w > 1 && zone_cfg.eff_layer) ? "100%;" : container_w+"px;"),
          css_item_min_width = "width: 100%;",
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
              add_css = "#" + elmID + " .item.horizontal { display: flex; flex-direction: row; align-items: center; }";
              add_item_img = "width: "+item_img_w+"px;"
              add_item_txt = "width: "+item_txt_w+"px;"
              item_img_h = slot_h;
              css_item_min_width = "";
              css_img_img = ratio_wh+": 100%";
              css_img_txt_gap = "margin-left: "+img_txt_gap+"px";
            break;
            case "R":
              item_className = "item horizontal";
              add_css = "#" + elmID + " .item.horizontal { display: flex; flex-direction: row-reverse; align-items: center; }";
              add_item_img = "width: "+item_img_w+"px;"
              add_item_txt = "width: "+item_txt_w+"px;"
              item_img_h = slot_h;
              css_item_min_width = "";
              css_img_img = ratio_wh+": 100%";
              css_img_txt_gap = "margin-left: "+img_txt_gap+"px";
            break;
          }
        }else if(bn_type==1){
          //텍스트영역일때
          item_txt_w = slot_w - container_gap*(slot_num_w-1)/slot_num_w;
          item_txt_h = slot_h - container_gap*(slot_num_h-1);
          add_item_txt = "width: "+item_txt_w+"px;";
          text_line_height = slot_h;
        }

        // 폰트 관련 설정
        var css_font =
          "color: " + font_color + "; font_family:" + font_family + ";";
        // font-family:'맑은 고딕','Malgun Gothic','돋움',Dotum,'굴림',Gulim,Helvetica,sans-serif;

        ///////////////////////////////////////////////////////////////////////
        //prettier-ignore
        // if(zcode=='CCCLLLLF') console.log(slot_h, container_gap, slot_num_h);
        ///////////////////////////////////////////////////////////////////////

        //와이드배너일때
        zone_w = zone_cfg.eff_layer ? "100%" : zone_w + "px"; //와이드배너(true:100%,false:고정사이즈)

        // prettier-ignore
        var cssText = "#" + elmID + " { margin: 0; padding: 0; width: " + zone_w + "; height: " + zone_h + "px; display: flex; justify-content: center; align-items: center; }";
        // prettier-ignore
        cssText += "#" + elmID + " .adt_container { display: grid; grid-template-columns: repeat(" + slot_num_w + ", 1fr); grid-template-rows: repeat(" + slot_num_h + ", auto); gap: "+container_gap+"px; "+css_container_width+" max-width: 1200px; "+css_container_border+"}";
        // prettier-ignore
        cssText += "#" + elmID + " .item { min-width: " + slot_w + "px; background-color: #fff; overflow: hidden; display: flex; flex-direction: column; align-items: center; }";
        // prettier-ignore
        cssText += "#" + elmID + " .item_img {"+add_item_img+" height: " + item_img_h + "px; overflow: hidden; display: flex; justify-content: center; align-items: center; }";
        // prettier-ignore
        // cssText += ".item_img img { height: " + item_img_h + "px; object-fit: cover; }";
        cssText += "#" + elmID + " .item_img img { " + css_img_img + "; object-fit: cover; }";
        // prettier-ignore
        cssText += "#" + elmID + " .item_text { "+add_item_txt+" height: " + item_txt_h + "px; " + css_img_txt_gap + "; text-align: " + font_align + "; font-size: "+font_size+"px;  line-height: " + text_line_height + "px; "+css_font+" overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }";
        // prettier-ignore
        cssText += "#" + elmID + " .shadow-all { box-shadow: 3px 3px 9px #333; }";
        cssText += add_css;

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
              txt: decodeURI(v.text),
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

        arr_mtno = []; //소재리스트 초기화

        //슬롯 삽입
        // prettier-ignore
        arr_mat.forEach((v, i) => {
          var mtno = v.mtno;
          if (i >= slot_cnt) return false; //슬롯수 만큼만 소재 가져옴

          arr_mtno.push(mtno); //사용된 소재번호 저장

          var tmp_item = document.createElement('div'); //item 생성
          tmp_item.className = item_className;
          var set_innerHTML = '';
          // prettier-ignore
          switch(bn_type){
            case 1: //텍스트
            tmp_item.innerHTML = `<div class="item_text">` + v.txt.replace('<br />','') + `</div>`;
              break;
            case 2: //썸네일
            if(img_position=='B'){
                tmp_item.innerHTML = `<div class="item_text">"` + v.txt + `</div> <div class="item_img"><img src="` + v.img + `" alt="" /></div>`;
              }else{
                tmp_item.innerHTML = `<div class="item_img"><img src="` + v.img + `" alt="" /></div> <div class="item_text">` + v.txt + `</div>`;
              }
              break;
            default: //이미지
              tmp_item.innerHTML = `</div> <div class="item_img"><img src="` + v.img + `" alt="" /></div>`;
              break;
            }
            //item에 데이터 저장
            tmp_item.mat = JSON.stringify(v);
            //클릭이벤트
            tmp_item.addEventListener('click',function(){
              //클릭 아이템 소재 데이터
            var matData = this.mat
            console.log('클릭소재 데이터 ',matData);
            //클릭로그 전송
            // adtiveDSP.sendClick(zcode,JSON.parse(this.dataset.matInfo));
            adtiveDSP.sendClick(elmID, JSON.parse(matData));
            //랜딩 이동
            // top.location.href=v.landurl;
            // window.open(v.landurl, '_blank');
          });
          inner_container.appendChild(tmp_item);
        });
        //클릭로그 전송
        adtiveDSP.sendPv(elmID, arr_mtno);
      };
      // prettier-ignore
      script.src = url_get_data + "?jsoncallback=" + callbackName + "&zoneCD=" + zcode;
      doc.body.appendChild(script);
    },
    //PV 로그전송
    sendPv: (elmID, arr_mtno) => {
      //pv 중복 체크
      if (typeof check_pv[elmID] === "undefined") {
        //값이 없을경우 PV로그 전송 및 해당영역 전송 true
        check_pv[elmID] = true;
      }

      console.log(elmID, arr_mtno, check_pv);
    },
    //클릭 로그전송
    sendClick: (elmID, matData) => {
      var this_mtno = matData.mtno,
        arr_key = elmID.split("_"),
        zcode = arr_key[1],
        uniq_num = arr_key[2];

      // console.log(typeof check_click[elmID + "_" + this_mtno]==="undefined");

      //해당영역 중복클릭 체크
      if (typeof check_click[elmID + "_" + this_mtno] === "undefined") {
        //첫클릭일때만 클릭로그 전송 및 클릭여부 저장
        check_click[elmID + "_" + this_mtno] = true;
        // prettier-ignore
        console.log( "matData", matData.mtno, check_click, zcode, uniq_num, matData );

        //영역,캠페인,소재번호,캠페인과금제,plf,과금여부,
      } else {
        console.log("중복클릭", check_click);
        alert("이미 클릭한 소재");
        return;
      }
    },
  };

  adtiveDSP.init();
  // prettier-ignore
  w.adtiveDSP=w.adtiveDSP||function(zcode,selector,cb){adtiveDSP.mkbanner(zcode,selector,cb)}

  $(function () {
    // $('#rs').text(JSON.stringify(UA));
  });
})(window);
