((w)=>{

  var doc = w.document;
  var adt={
    init:()=>{
      //영역 기본설정 
      console.warn('init()');
    },
    mkBanner:(zoneCD,selector,cb)=>{
      //영역 데이터 가져와서 배너 생성 
      console.warn('mkBanner()',zoneCD,selector,cb);
      let url = 'https://www.adplex.co.kr/_pjh/get_data.php';
      
      let callbackName = 'CB'+Math.round(10000000*Math.random());
      let script=doc.createElement('script');
      var zoneData = {};
      let arr_zoneCD = zoneCD.split('|'); //호출한 데이터 영역코드 리스트 
      window[callbackName]=function(arr_zonedata){
        console.warn(arr_zonedata);
        let _idx = 0;
        //영역정보 저장 
        arr_zonedata.forEach(zone_data => {
          let zoneCD = arr_zoneCD[_idx++];
          zoneData[zoneCD] = zone_data; //영역코드를 키값으로 영역 데이터 저장 
          // console.warn(zoneData); //영역별 데이터 확인 

          // 영역생성여부 체크 - 데이터 존재 및 활성화 체크 
          if( !(typeof zone_data==='object' && typeof zone_data.cfg==='object') ){ console.log('data is false'); return; };
          let cfg = zone_data.cfg,
          mz_width = cfg.mz_width,
          mz_height = cfg.mz_height,
          mz_btype = cfg.mz_btype, //배너타입 0:이미지,1:텍스트,2:썸네일,3:콘텐츠배너,4:동영상배너 
          slt_num = cfg.slt_num, //슬롯수 
          slt_num_w = cfg.slt_num_w, //슬롯가로          
          slt_num_h = cfg.slt_num_h, //슬롯세로
          thumb_img_width = cfg.thumb_img_width, //이미지 가로
          thumb_img_height = cfg.thumb_img_height; //이미지 세로
          let automat = {};
          // 기본값 저장 
          if( cfg.mz_automat==1 || cfg.mz_automat==2 ){
            automat = JSON.parse(zone_data.automat);
            console.log(automat);
          }

          //배너생성 
          
          //기본 항목 
          // let EleId='ADT_'+Math.round(10000000000*Math.random());
          let EleId='ADT_'+zoneCD; //영역ID 
          let ElSelector = '#'+EleId; //css selector 
          let styleEl = doc.createElement('style'); //css 내용 

          styleEl.innerText=''
          //최상위 
          +'#'+EleId+'{ min-width: '+mz_width+'px; width:100%; height: '+mz_height+'px; border: 1px solid #000; overflow: hidden;}' 
          //영역 
          +ElSelector+' .container {width: 100%; height: '+mz_height+'px; display: flex; flex-wrap: wrap; justify-content: space-between; text-align: center; }' 
          //슬롯 
          +ElSelector+' .item {width: calc(100%/'+slt_num_w+' - 10px); height: calc(100%/'+slt_num_h+' - 10px); margin-bottom: 10px; position: relative; display: flex; flex-direction: column; justify-content: center; align-items: center; }' 
          //이미지 
          +ElSelector+' .item img {width: 100%; height: auto; max-height: 100px; object-fit: contain; margin-bottom: 5px; }' 
          //텍스트 
          +ElSelector+' .item .text {position: absolute; bottom: 0; left: 0; width: 100%; color: #000; padding: 5px; box-sizing: border-box; font-size: 14px; font-family: "Noto Sans KR", sans-serif; }'; 
          //document append 
          doc.querySelectorAll('head, body')[0].appendChild(styleEl);

          //영역 기본 컨테이너 append 
          let this_ele=''
          +'<div id="'+EleId+'">'
          +'<div class="container">';
          automat.forEach(v => {
            console.log(v);
            let image = decodeURIComponent(v.image),
            text = decodeURIComponent(v.text);
            this_ele+='<div class="item">'
            +'<img src="https://plugin.adplex.co.kr/banner/'+image+'">'
            +'<div class="text">'+text+'</div>'
            +'</div>';
          });
          this_ele+='</div>'
          +'</div>';
          doc.currentScript.insertAdjacentHTML('afterend',this_ele);
        });

      }

      script.src=url+'?jsoncallback='+callbackName+'&zoneCD='+zoneCD;
      doc.body.appendChild(script);

    }

  }
  console.warn(doc);
  adt.init();
  w.adt=w.adt||function(zoneCD,selector,cb){ adt.mkBanner(zoneCD,selector,cb); }

})(window);