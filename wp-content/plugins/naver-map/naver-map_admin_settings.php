<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2><?php _e( 'Naver Map Settings', 'naver-map' ); ?></h2>
	<h3><?php _e( 'API Key Setting', 'naver-map' ); ?></h3>
	<form method="post" action="options-general.php?page=naver-map.php">
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="naver_map_api_key"><?php _e( 'Naver Map API Key', 'naver-map' ); ?></label></th>
				<td>
					<input name="naver_map_api_key" type="text" id="naver_map_api_key" value="<?php echo $naver_map_api_key ?>" />
					<span class="submit"><input name="Submit" class="button-primary" value="<?php _e( 'Save change', 'naver-map' ); ?>" type="submit"></span>
					<p class="description"><?php _e( 'Please register the Naver Map API key.', 'naver-map' )?></p>
					<a href="https://dev.naver.com/openapi/register" target="_blank" class="button button-big"><?php _e( 'Naver Map API Key View', 'naver-map' ); ?></a>
				</td>
			</tr>
		</table>
	</form>	
	<hr />
	<h3><?php _e( 'Map Shortcode Generator', 'naver-map' ); ?></h3>
<?php
	require_once dirname( __FILE__ ) . '/naver-map_shortcode_generator.php';
?>
	<hr />
</div>
