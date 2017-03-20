<?php 
	$default_map_title = "경복궁"; //독도, 숭례문
	$default_map_x = "309820"; //743372, 309669
	$default_map_y = "553611"; //522430, 551359
?>
	<table class="form-table">
		<tr valign="top">
			<td>
				<input name="query" type="text" onfocus="this.select();" id="query" value="" placeholder="<?php _e( 'Address search', 'naver-map' ); ?>" />
				<a id="map_search" class="button"><?php _e( 'Search', 'naver-map' ); ?></a>
				<p class="description"><?php _e( 'Please enter the address you want to search.', 'naver-map' ); ?></p>
				<div id="result_msg"></div>
			</td>
		</tr>
		<tr valign="top">
			<td>
				<input type="text" name="mapshortcode" id="mapshortcode" onfocus="this.select();" readonly="readonly" value="[naver-map x=&quot;<?php echo $default_map_x; ?>&quot; y=&quot;<?php echo $default_map_y; ?>&quot; r=&quot;false&quot; w=&quot;400&quot; h=&quot;300&quot; mt=&quot;<?php echo $default_map_title; ?>&quot; mtb=&quot;false&quot; tmb=&quot;false&quot; zcb=&quot;false&quot; zl=&quot;10&quot;]" />
				<p class="description"><?php _e( 'Please copy and paste the contents of the blog, the page by copying the above short code.', 'naver-map' ); ?></p>
				<div id="log"></div>
			</td>
		</tr>
		<tr valign="top">
			<td>
				<fieldset id="map_review">
					<legend><strong><?php _e( 'Preview', 'naver-map' ); ?></strong></legend>
					<div id="view_map"></div>
					<script type="text/javascript">
						var oPoint = new nhn.api.map.TM128(<?php echo $default_map_x; ?>, <?php echo $default_map_y; ?>);
						nhn.api.map.setDefaultPoint('TM128');
					<?php
						if ($naver_map_api_key != "") {
					?>
						var oMap = new nhn.api.map.Map('view_map', {
							point : oPoint,
							zoom : 10,
							enableWheelZoom : false,
							enableDragPan : true,
							enableDblClickZoom : false,
							mapMode : 0,
							actiateTrafficMap : false,
							minMaxLevel : [1, 14],
							size : new nhn.api.map.Size(400, 300)
						});
					<?php
						} 
					?>
						var mapTypeChangeButton = new nhn.api.map.MapTypeBtn();
						var trafficButton = new nhn.api.map.TrafficMapBtn();
						var mapZoom = new nhn.api.map.ZoomControl();

						mapTypeChangeButton.setPosition({top:10, left:10});
						trafficButton.setPosition({top:10, left:76});
						mapZoom.setPosition({top:10, right:10});

						var oSize = new nhn.api.map.Size(28, 37);
						var oOffset = new nhn.api.map.Size(14, 37);
						var oIcon = new nhn.api.map.Icon('http://static.naver.com/maps2/icons/pin_spot2.png', oSize, oOffset);

						var oMarker = new nhn.api.map.Marker(oIcon, { title : '<?php echo $default_map_title; ?>' });
						oMarker.setPoint(oMap.getCenter());
						oMap.addOverlay(oMarker);

						var oLabel = new nhn.api.map.MarkerLabel();
						oMap.addOverlay(oLabel);
						oLabel.setVisible(true, oMarker);
						</script>
				</fieldset>
				<fieldset id="map_list">
					<legend><strong><?php _e( 'Address list', 'naver-map' ); ?></strong></legend>
					<div>
						<ul id="address_list"></ul>
					</div>
				</fieldset>
				<fieldset id="map_option">
					<legend><strong><?php _e( 'Map options', 'naver-map' ); ?></strong></legend>
					<input type="checkbox" name="mtb" id="mtb" /><label for="mtb"> <?php _e( 'Map type', 'naver-map' ); ?></label><br/>
					<input type="checkbox" name="tmb" id="tmb" /><label for="tmb"> <?php _e( 'Real-time traffic', 'naver-map' ); ?></label><br/>
					<input type="checkbox" name="zcb" id="zcb" /><label for="zcb"> <?php _e( 'Zoom control', 'naver-map' ); ?></label><br/>
					<label for="zl"><?php _e( 'Zoom level', 'naver-map' ); ?> </label><input type="number" name="zl" id="zl" step="1" min="1" max="14" value="10" /> (1 ~ 14)<br/>
					<label for="mt"><?php _e( 'Marker title', 'naver-map' ); ?></label> <input type="text" name="mt" id="mt" value="<?php echo $default_map_title; ?>" placeholder="<?php _e( 'title', 'naver-map' ); ?>" /><br/>
					<input type="checkbox" name="r" id="r" /><label for="r"> <?php _e( 'Responsive', 'naver-map' ); ?></label><br/>
					<label for="mzw"><?php _e( 'Map size', 'naver-map' ); ?></label> w<input type="text" name="mzw" id="mzw" placeholder="width" value="400" class="map_size" /> h<input type="text" name="mzh" id="mzh" placeholder="height" value="300" class="map_size" /><span id="mzh_desc"><?php _e( 'Minimum height', 'naver-map' ); ?></span><br/>
					<label for="mpx"><?php _e( 'Map coordinates', 'naver-map' ); ?></label> x<input type="text" name="mpx" id="mpx" readonly="readonly" value="<?php echo $default_map_x; ?>" class="map_code" /> y<input type="text" name="mpy" id="mpy" readonly="readonly" value="<?php echo $default_map_y; ?>" class="map_code" />
				</fieldset>
			</td>
		</tr>
	</table>
