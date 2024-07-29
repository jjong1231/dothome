<?
$jsoncallback=trim($_REQUEST['jsoncallback']);
$zonecode=trim($_REQUEST['zoneCD']);
$is_drawAD=isset($_GET['is_drawAD'])?trim($_GET['is_drawAD']):'0';
if($jsoncallback=='' || $zonecode=='') die($jsoncallback."({})");
define('PATH_ZONE_FILE', '/home/2beon/sync_data/Banner_Zone_Json/');
$arr_zonecode = explode('|',$zonecode);
//파일 데이터 읽기 
$arr_all_zoneData = array();
$zonedata = array();





// foreach($arr_zonecode as $zone_key){
// 	$_PATH_DATA_ZONE_KEY = PATH_ZONE_FILE.$zone_key;
// 	// if(!file_exists($_PATH_DATA_ZONE_KEY)){
// 	// 	continue;
// 	// }
// 	// else{
// 		$zonedata = fn_readFile($_PATH_DATA_ZONE_KEY); //데이터가져오기 

		/*
		썸네일 이미지왼쪽,텍스트오른쪽
		영역코드 MC6LLLLF 
		영역 290x106		
		썸네일 140x84 => 높이에 맞게 사이즈 자동 
		슬롯 1x1
		썸네일 텍스트 간격 10px
		썸네일 위치 (T:상,B:하,L:좌,R:우)
		*/

		//이미지 
		$zonedata['cfg'] = array(
          'zcode' => $zonecode,
					'zone_shadow' => true, //영역 그림자 
					'zone_margin' => ' margin: 0 0 0 0px;', //영역외부 위치이동 기본값 false
					'zborder_px' => 0, //영역테두리 두께 
					'zborder_type' => 'solid', //영역테두리 px 
					'zborder_color' => 'red', //영역테두리 색상
          'bn_type' => 0, // 0:이미지, 1:텍스트, 2:썸네일
          'width' => 320, //영역 가로사이즈
          'height' => 200, //영역 세로사이즈
          'slot_num_w' => 2, //슬롯 가로갯수
          'slot_num_h' => 2, //슬롯 세로갯수
					'slot_gap' => 2, //슬롯간격 
          'img_position' => 'T', //썸네일 위치 (T:상,B:하,L:좌,R:우)
          // 'img_rate' => 'width', //이미지 가로세로 비율 width:가로가길때,height:세로가길때 
          'img_txt_gap' => 0, //이미지,텍스트 간격(썸네일일때만사용 기본값:0)
          'font_size' => 13, //폰트사이즈(==line-height)
          'line_height' => 16, //폰트사이즈(==line-height)
          'font_align' => "center",
          'eff_layer' => false, //와이드배너(true:100%,false:고정사이즈)
          'slot_type' => 'S' //슬롯타입 P:판, S:슬롯 
        );

		//썸네일 이미지 위쪽
		if($zonecode=='AAALLLLF'){
			$zonedata['cfg'] = array(
				'zcode' => $zonecode,
				'zone_shadow' => true, //영역 그림자 
				'zone_margin' => ' margin: 0 0 0 0px;', //영역외부 위치이동 기본값 false
				'zborder_px' => 0, //영역테두리 두께 
				'zborder_type' => 'solid', //영역테두리 px 
				'zborder_color' => '#333', //영역테두리 색상
				'width' => 320, //영역 가로사이즈
				'height' => 250, //영역 세로사이즈
				'slot_num_w' => 2, //슬롯 가로갯수
				'slot_num_h' => 2, //슬롯 세로갯수
				'bn_type' => 2, // 0:이미지, 1:텍스트, 2:썸네일
				'slot_type' => 'S', //슬롯타입 P:판, S:슬롯 
				'img_position' => 'T', //썸네일 위치 (T:상,B:하,L:좌,R:우)
				// 'img_rate' => 'width', //이미지 가로세로 비율 width:가로가길때,height:세로가길때 
				'img_txt_gap' => 0, //이미지,텍스트 간격
				'font_family' => '"맑은 고딕", dotum, 돋움, sans-serif',
				'font_size' => 13, //폰트사이즈(==line-height)
				'line_height' => 16, //폰트사이즈(==line-height)
				'font_align' => "center",
				'eff_layer' => false //와이드배너(true:100%,false:고정사이즈)
				);
		}

		//썸네일 이미지 왼쪽 
		if($zonecode=='BBBLLLLF'){
			$zonedata['cfg'] = array(
				'zcode' => $zonecode,
				'zone_shadow' => true, //영역 그림자 
				'zone_margin' => ' margin: 0 0 0 0px;', //영역외부 위치이동 기본값 false
				'zborder_px' => 1, //영역테두리 두께 
				'zborder_type' => 'solid', //영역테두리 px 
				'zborder_color' => '#333', //영역테두리 색상
				'width' => 320, //영역 가로사이즈
				'height' => 75*3, //영역 세로사이즈
				'slot_num_w' => 1, //슬롯 가로갯수
				'slot_num_h' => 3, //슬롯 세로갯수
				'bn_type' => 2, // 0:이미지, 1:텍스트, 2:썸네일
				'slot_type' => 'S', //슬롯타입 P:판, S:슬롯 
				'img_position' => 'L', //썸네일 위치 (T:상,B:하,L:좌,R:우)
				// 'img_rate' => 'width', //이미지 가로세로 비율 width:가로가길때,height:세로가길때 
				'img_txt_gap' => 20, //이미지,텍스트 간격
				'font_size' => 16, //폰트사이즈(==line-height)
				'line_height' => 36, //폰트사이즈(==line-height)
				'font_align' => "left",
				'eff_layer' => false //와이드배너(true:100%,false:고정사이즈)
				);

		}
		
		//텍스트 
		if($zonecode=='CCCLLLLF'){
			$zonedata['cfg'] = array(
				'zcode' => $zonecode,
				'zone_shadow' => true, //영역 그림자 
				'zone_margin' => ' margin: 0 0 0 0px;', //영역외부 위치이동 기본값 false
				'zborder_px' => 1, //영역테두리 두께 
				'zborder_type' => 'solid', //영역테두리 px 
				'zborder_color' => 'red', //영역테두리 색상
				'width' => 320, //영역 가로사이즈
				'height' => 36*3, //영역 세로사이즈
				'slot_num_w' => 1, //슬롯 가로갯수
				'slot_num_h' => 3, //슬롯 세로갯수
				'bn_type' => 1, // 0:이미지, 1:텍스트, 2:썸네일
				'img_position' => 'T', //썸네일 위치 (T:상,B:하,L:좌,R:우)
				// 'img_rate' => 'width', //이미지 가로세로 비율 width:가로가길때,height:세로가길때 
				'img_txt_gap' => 0, //이미지,텍스트 간격(썸네일일때만사용 기본값:0)
				'font_size' => 18, //폰트사이즈(==line-height)
				'font_color' => 'blue', //폰트 색상 
				'font_family' => '"맑은 고딕", dotum, 돋움, sans-serif',
				'line_height' => 18, //폰트사이즈(==line-height)
				'font_align' => "left",
				'eff_layer' => false, //와이드배너(true:100%,false:고정사이즈)
				'slot_type' => 'S' //슬롯타입 P:판, S:슬롯 
			);
	}

		$zonedata['mat'] = array();
		$zonedata['mat'][] = array(
			'mtno' => 1001,
			'cpno' => 1111,
			'cp_kind' => 'A', //캠페인 과금방식 
			'img' => "https://plugin.adplex.co.kr/banner/1837/d808d1aaa74baa71525ffffa4f7f8ad9.gif",
			'img_rate' => 284/180,
			'img_size' => '284x180',
			'text' => "1썸네일 텍스트<br />CPA 과금 테스트, CPA 과금 테스트, CPA 과금 테스트, CPA 과금 테스트",
			'landurl' => 'https://news.targetview.com/pine14/'
		);
		$zonedata['mat'][] = array(
			'mtno' => 1002,
			'cpno' => 2222,
			'cp_kind' => 'M', //캠페인 과금방식 
			'img' => "https://plugin.adplex.co.kr/banner/1837/de929547a089466995dc9ba7677fdda2.gif",
			'img_rate' => 284/180,
			'img_size' => '284x180',
			'text' => "2썸네일 텍스트<br />CPM 과금 테스트",
			'landurl' => 'https://www.adplex.co.kr/_pjh/t.php?no=22'
		);
		$zonedata['mat'][] = array(
			'mtno' => 1003,
			'cpno' => 3333,
			'cp_kind' => 'P', //캠페인 과금방식 
			'img' => "https://plugin.adplex.co.kr/banner/1837/bccfcdd45e3611599ccb10574e1743dc.gif",
			'img_rate' => 284/180,
			'img_size' => '284x180',
			'text' => "3썸네일 텍스트<br />CPP 과금 테스트",
			'landurl' => 'https://www.adplex.co.kr/_pjh/t.php?no=33'
		);
		$zonedata['mat'][] = array(
			'mtno' => 1004,
			'cpno' => 4444,
			'cp_kind' => 'C', //캠페인 과금방식 
			'img' => "https://plugin.adplex.co.kr/banner/1837/a83c5f540b4c6200f72feae8eb786936.png",
			'img_rate' => 284/180,
			'img_size' => '284x180',
			'text' => "4썸네일 텍스트<br />CPC 과금 테스트, CPC 과금 테스트",
			'landurl' => 'https://www.adplex.co.kr/_pjh/t.php?no=44'
		);
		$zonedata['mat'][] = array(
			'mtno' => 1005,
			'cpno' => 5555,
			'cp_kind' => 'I', //캠페인 과금방식 
			'img' => "https://plugin.adplex.co.kr/banner/744/cddafed4a7ac5b4468e718cd4c281a58.gif",
			'img_rate' => 284/194,
			'img_size' => '284x194',
			'text' => "5썸네일 텍스트<br />CPI 과금 테스트",
			'landurl' => 'https://www.adplex.co.kr/_pjh/t.php?no=55'
		);
		$zonedata['mat'][] = array(
			'mtno' => 1006,
			'cpno' => 6666,
			'cp_kind' => 'N', //캠페인 과금방식 
			'img' => "https://plugin.adplex.co.kr/banner/2819/72066345762ed77c5e1fb6a87bd71db1.png",
			'img_rate' => 284/284,
			'img_size' => '284x284',
			'text' => "6썸네일 텍스트<br />비과금 테스트",
			'landurl' => 'https://www.adplex.co.kr/_pjh/t.php?no=66'
		);



		//테스트용 자동소재 데이터 강제 추가 
		$zonedata['automat'] = '[{"repdata":"O","cpsno":"","rate":"16.6","account":"1","cps_order":"1","cps_pan":"1","catecode":"qMwQRDOsvB","cpncode":"DWYRRRRV","cpnkind":"M","mtno":"72264","image":"1089%2F502ec9e118786a79f30e2985d013e82c.png","text":"%3Cb%3E%EC%8D%B8%EB%84%A4%EC%9D%BC%20%ED%85%8C%EC%8A%A4%ED%8A%B8%3C%2Fb%3E%3Cbr%3ECPM%ED%85%8C%EC%8A%A4%ED%8A%B8%20%EC%9E%90%EB%8F%99%EC%86%8C%EC%9E%AC","landurl":"http:\/\/adtive.co.kr\/?adpx_be_cd=226_2685_3476_72264","bgcolor":"","effwin":0},{"repdata":"O","cpsno":"","rate":"16.6","account":"1","cps_order":"2","cps_pan":"1","catecode":"caff6fbf14","cpncode":"DHVRRRRV","cpnkind":"P","mtno":"73294","image":"240%2Fc2588c16d1ae78f2c7bc7ece54bcfe71.png","text":"%3Cb%3E%EC%8D%B8%EB%84%A4%EC%9D%BC%ED%85%8D%EC%8A%A4%ED%8A%B8%3C%2Fb%3E%3Cbr%3E%EC%95%A0%EB%93%9C%ED%8B%B0%EB%B8%8C%20%EC%9D%B4%EB%85%B8%EB%B2%A0%EC%9D%B4%EC%85%98%28%EC%A3%BC%29","landurl":"http:\/\/www.adtive.co.kr\/?adpx_be_cd=226_2685_1892_73294","bgcolor":"","effwin":0},{"repdata":"O","cpsno":"","rate":"16.6","account":"1","cps_order":"3","cps_pan":"1","catecode":"4ba1bb265a","cpncode":"6RYRRRRV","cpnkind":"M","mtno":"84697","image":"802%2F2a2738b1156905bc94f596b2875f3f5c.png","text":"%ED%85%8C%EC%8A%A4%ED%8A%B8%20cpm","landurl":"http:\/\/www.adtive.co.kr?adpx_be_cd=226_2685_2597_84697","bgcolor":"","effwin":0},{"repdata":"O","cpsno":"","rate":"16.6","account":"1","cps_order":"4","cps_pan":"1","catecode":"caff6fbf14","cpncode":"ODYRRRRV","cpnkind":"M","mtno":"74728","image":"240%2F57e0f192ed53ec96e1c1397c73185022.jpg","text":"%EC%8D%B8%EB%84%A4%EC%9D%BC%20%26%2334%3Badtive%26%2339%3B%20%3C%20%EC%95%A0%20%60%20%EB%93%9C%20%26%2339%3B%20%ED%8B%B0%20%26%2334%3B%20%EB%B8%8C%20%3E","landurl":"http:\/\/www.adtive.co.kr?adpx_be_cd=226_2685_3330_74728","bgcolor":"","effwin":0},{"repdata":"O","cpsno":"","rate":"16.6","account":"1","cps_order":"5","cps_pan":"1","catecode":"caff6fbf14","cpncode":"DHVRRRRV","cpnkind":"P","mtno":"76443","image":"240%2F02b2a06e89c7ba8ef5f2d18a9d07d4a4.png","text":"%ED%85%8C%EC%8A%A4%ED%8A%B8%EC%86%8C%EC%9E%AC%20%3Cbr%3Etest_idid%20%ED%85%8C%EC%8A%A4%ED%8A%B8%201234","landurl":"http:\/\/www.adtive.co.kr\/?adpx_be_cd=226_2685_1892_76443","bgcolor":"","effwin":0},{"repdata":"O","cpsno":"","rate":"16.6","account":"1","cps_order":"6","cps_pan":"1","catecode":"52ReLtC3Rb","cpncode":"C7NRRRRV","cpnkind":"N","mtno":"84694","image":"840%2Fd5c85ac537aa9e24775ec6dcac26d443.gif","text":"%EC%9E%90%EB%8F%99%EC%86%8C%EC%9E%AC%20%ED%85%8C%EC%8A%A4%ED%8A%B81%20%EC%8D%B8%EB%84%A4%EC%9D%BC","landurl":"http:\/\/www.adtive.co.kr?adpx_be_cd=226_2685_4434_84694","bgcolor":"","effwin":0}]';

		$arr_all_zoneData = $zonedata;
	// }
// }
function fn_readFile($_PATH){
	$zoneFile_json = file_get_contents($_PATH);
	return json_decode($zoneFile_json,true);
}
$json_data = json_encode($arr_all_zoneData);
echo $jsoncallback."(".$json_data.")";		// jsonp 객체로 반환
?>