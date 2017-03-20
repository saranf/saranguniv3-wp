<?php
/*
Plugin Name: Naver Map
Plugin URI: http://www.1efthander.com/category/plug-in/naver-map/
Description: Naver Map 플러그인은 네이버 지도 API를 이용하여 워드프레스에서 쉽게 사용할 수 있도록 도와줍니다. This plugin uses Naver API and helps users easy to use in WordPress.
Version: 1.10
Author: 1eftHander
Author URI: http://www.1efthander.com
*/

define( 'NAVER_MAP_VERSION', '1.10' );
define( 'CRLF', "\n" );

/*
 * 저장시 메시지 표시
 */
function display_submenu_page() {
	add_option( 'naver_map_api_key', '', '', 'yes' );
	
	if ( isset( $_POST['naver_map_api_key'] ) ) {
		update_option( 'naver_map_api_key', $_POST['naver_map_api_key'], '', 'yes' );
		naver_map_load();
?>
<div id="setting-error-settings_updated" class="updated settings-error">
	<p><strong><?php _e( 'Settings saved.', 'naver-map' ); ?></strong></p>
</div>
<?php
	}
	$naver_map_api_key = get_option( 'naver_map_api_key' );
	require_once dirname( __FILE__ ) . '/naver-map_admin_settings.php';
}

/*
 * 
 */
function naver_map_load() {
	if ( get_option( 'naver_map_api_key' ) != '') {
		echo '<script type="text/javascript" src="http://openapi.map.naver.com/openapi/naverMap.naver?ver=2.0&key=' . get_option( 'naver_map_api_key' ) . '"></script>' . CRLF;
	}
}

/*
 * 서브메뉴 추가
 */
function register_submenu_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		//2013-12-29, 수진(@sujin2f)님 버그리포팅, 캐퍼빌리티가 없는 유저들이 어드민 접근을 못하는 버그
		return false;
		//wp_die( _e( 'You do not have sufficient permissions to access this page.', 'naver-map' ) );
	}
	$plugin_page = add_submenu_page( 'options-general.php', __( 'Naver Map', 'naver-map' ), __( 'Naver Map', 'naver-map' ), 'manage_options', basename( __FILE__ ), 'display_submenu_page' );

	add_action( 'admin_head-'. $plugin_page, 'naver_map_load' );
}
add_action( 'admin_menu', 'register_submenu_page' );

/*
 * 네이버 지도 좌표 추출 
 */
function ajax_request_geo_code() {
	$query = $_POST['query'];
	//tm128
	$url = 'http://openapi.map.naver.com/api/geocode.php?key=' . get_option( 'naver_map_api_key' ) . '&encoding=utf-8&coord=tm128&query=' . preg_replace("/\s+/", "%20", $query);
	//latlng
	//$url = 'http://openapi.map.naver.com/api/geocode.php?key=' . get_option( 'naver_map_api_key' ) . '&encoding=utf-8&coord=latlng&query=' . preg_replace("/\s+/", "%20", $query);
	
	$args = array(
			'method'      =>    'POST',
			'timeout'     =>    5,
			'redirection' =>    5,
			'httpversion' =>    '1.1',
			'blocking'    =>    true,
			'headers'     =>    array(),
			'body'        =>    null,
			'cookies'     =>    array()
	);
	
	$response = wp_remote_post( $url, $args );

	if( is_wp_error( $response ) ) {
		$error_message = $response->get_error_message();
		//echo "Something went wrong: $error_message";
	} else {
		/*
		<?xml version="1.0" encoding="UTF-8" ?>
		<root>
			<e/>
			<t>3</t>
			<i>
				<x>100000</x>
				<y>522267</y>
				<d>서울시</d>
			</i>
			<i>
				<x>200000</x>
				<y>522267</y>
				<d>부산시</d>
			</i>
			<i>
				<x>300000</x>
				<y>522267</y>
				<d>인천시</d>
			</i>
		</root>
		*/
		$result = simplexml_load_string($response['body']);
		$addr_info = '';
		foreach($result->item as $item){
			$addr_info = $addr_info . '<i>';
			$addr_info = $addr_info . '<x>' . (String)$item->point->x . '</x>';
			$addr_info = $addr_info . '<y>' . (String)$item->point->y . '</y>';
			$addr_info = $addr_info . '<d>' . (String)$item->address . '</d>';
			$addr_info = $addr_info . '</i>';
		}

		$result_xml = '';
		$result_xml = $result_xml . '<?xml version="1.0" encoding="UTF-8" ?>';
		$result_xml = $result_xml . '<root>';
		$result_xml = $result_xml . '<e>' . (String)$result->error_code . '</e>';
		$result_xml = $result_xml . '<t>' . (String)$result->total . '</t>';
		$result_xml = $result_xml . $addr_info;
		$result_xml = $result_xml . '</root>';
		$xml_object = simplexml_load_string( $result_xml );
		print_r( $xml_object->asXML() );
	}
	die();
}
add_action( 'wp_ajax_request_geo_code', 'ajax_request_geo_code' );

/*
 * 숏코드 처리
 */
function naver_map_shortcode( $atts ) {
//[naver-map x="309820" y="553611" r="false" w="400" h="300" mt="경복궁" mtb="false" tmb="false" zcb="false" zl="10"]
	extract(shortcode_atts(
			array(
				'x' => $atts[x],
				'y' => $atts[y],
				'r' => $atts[r],
				'w' => $atts[w],
				'h' => $atts[h],
				'mt' => $atts[mt],
				'mtb' => $atts[mtb],
				'tmb' => $atts[tmb],
				'zcb' => $atts[zcb],
				'zl' => $atts[zl]
			), $atts)
	);
	
	$source = '';
	
	$source .= CRLF. '<div id="map_area">';
	$source .= CRLF. '	<div class="view_map" id="view_map_' . $x . $y .'"></div>';
	$source .= CRLF. '</div>';
	$source .= CRLF. '<script type="text/javascript">';
	$source .= CRLF. '	var minHeight = ' . $h . ';';
	$source .= CRLF. '	var oPoint = new nhn.api.map.TM128(' . $x . ', ' . $y . ');';
	$source .= CRLF. '	nhn.api.map.setDefaultPoint(\'TM128\');';
	$source .= CRLF. '	var oMap = new nhn.api.map.Map(\'view_map_' . $x . $y .'\', {';
	$source .= CRLF. '		point : oPoint,';
	$source .= CRLF. '		zoom : ' . $zl . ',';
	$source .= CRLF. '		enableWheelZoom : false,';
	$source .= CRLF. '		enableDragPan : true,';
	$source .= CRLF. '		enableDblClickZoom : false,';
	$source .= CRLF. '		mapMode : 0,';
	$source .= CRLF. '		actiateTrafficMap : false,';
	$source .= CRLF. '		minMaxLevel : [1, 14],';
	$source .= CRLF. '		size : new nhn.api.map.Size(' . $w . ', ' . $h . ')';
	$source .= CRLF. '	});';
	$source .= CRLF. '	var mapTypeChangeButton = new nhn.api.map.MapTypeBtn();';
	$source .= CRLF. '	var trafficButton = new nhn.api.map.TrafficMapBtn();';
	$source .= CRLF. '	var mapZoom = new nhn.api.map.ZoomControl();';
	$source .= CRLF. '	mapTypeChangeButton.setPosition({top:10, left:10});';
	$source .= CRLF. '	trafficButton.setPosition({top:10, left:76});';
	$source .= CRLF. '	mapZoom.setPosition({top:10, right:10});';
	$source .= ($mtb == "true") ? CRLF. '	oMap.addControl(mapTypeChangeButton);' : '';
	$source .= ($tmb == "true") ? CRLF. '	oMap.addControl(trafficButton);' : '';
	$source .= ($zcb == "true") ? CRLF. '	oMap.addControl(mapZoom);' : '';
	$source .= CRLF. '	var oSize = new nhn.api.map.Size(28, 37);';
	$source .= CRLF. '	var oOffset = new nhn.api.map.Size(14, 37);';
	$source .= CRLF. '	var oIcon = new nhn.api.map.Icon(\'http://static.naver.com/maps2/icons/pin_spot2.png\', oSize, oOffset);';
	$source .= CRLF. '	var oMarker = new nhn.api.map.Marker(oIcon, { title : \'' . $mt . '\' });';
	$source .= CRLF. '	oMarker.setPoint(oMap.getCenter());';
	$source .= CRLF. '	oMap.addOverlay(oMarker);';
	$source .= CRLF. '	var oLabel = new nhn.api.map.MarkerLabel();';
	$source .= CRLF. '	oMap.addOverlay(oLabel);';
	$source .= CRLF. '	oLabel.setVisible(true, oMarker);';

	if ( $r == "true" ) {
		$source .= CRLF. '';
		$source .= CRLF. '	(function($) {';
		$source .= CRLF. '		$(window).resize(function(){';
		$source .= CRLF. '			var resizeWidth = $("#map_area").width();';
		$source .= CRLF. '			var resizeHeight = resizeWidth / 2;';
		$source .= CRLF. '			resizeHeight = (resizeHeight < minHeight ? minHeight : resizeHeight);';
		$source .= CRLF. '			oMap.setSize(new nhn.api.map.Size(resizeWidth, resizeHeight));';
		$source .= CRLF. '		});';
		$source .= CRLF. '	})(jQuery);';
	}
	$source .= CRLF. '</script>';
	
	return $source;
}
add_shortcode( 'naver-map', 'naver_map_shortcode' );

/*
 * 페이지에서 Javascript & CSS 추가
 */
function naver_map_load_css_js() {
	wp_enqueue_script('jquery');
	
	wp_register_style( 'naver_map', plugins_url( '/naver-map.css', __FILE__ ), false, NAVER_MAP_VERSION );
	wp_enqueue_style( 'naver_map' );

	wp_register_script( 'naver_map', plugins_url( '/naver-map.js', __FILE__ ), false, NAVER_MAP_VERSION );
	wp_enqueue_script( 'naver_map' );
	
	add_action( 'wp_head', 'naver_map_load' );
}
add_action( 'wp_enqueue_scripts', 'naver_map_load_css_js' );

/*
 * 관리자페이지에서 Javascript & CSS 추가
 */
function naver_map_admin_load_css_js() {
	wp_register_style( 'naver_map', plugins_url( '/naver-map.css', __FILE__ ), false, NAVER_MAP_VERSION );
	wp_enqueue_style( 'naver_map' );

	wp_register_script( 'naver_map', plugins_url( '/naver-map.js', __FILE__ ), false, NAVER_MAP_VERSION );
	wp_enqueue_script( 'naver_map' );
	$textdomain_array = array(
		'check_key' => __( 'Please set the Naver Map API key.', 'naver-map' ),
		'check_address' => __( 'Please enter an address.', 'naver-map' ),
		'res_error_010' => __( 'Request limit exceeded.', 'naver-map' ),
		'res_error_011' => __( 'Address has not been entered.', 'naver-map' ),
		'res_error_020' => __( 'Naver Maps API key is not registered.', 'naver-map' ),
		'res_error_200' => __( 'Naver Maps API key is not registered.', 'naver-map' ),
		'res_success_01' => __( 'Failed to search.', 'naver-map' ),
		'res_success_02' => __( 'Search Results: ', 'naver-map' )
	);
	wp_localize_script( 'naver_map', 'msg_object', $textdomain_array );
	
	wp_localize_script( 'naver_map', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'query' => $query ) );
}
add_action( 'admin_enqueue_scripts', 'naver_map_admin_load_css_js' );

/*
 * 다국어 설정
 */
function naver_map_textdomain() {
	load_plugin_textdomain( 'naver-map', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action('admin_init', 'naver_map_textdomain');
?>
