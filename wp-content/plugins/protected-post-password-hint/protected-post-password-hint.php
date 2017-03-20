<?php
/*
Plugin Name: Protected Post Password Hint
Plugin URI: http://me.abelcheung.org/devel/protected-post-password-hint/
Description: Replace boiler-plate password form shown in protected posts with a form containing hints, which is taken from 'password_hint' custom field within posts.
Author: Abel Cheung
Author URI: http://me.abelcheung.org/
Version: 2.0.2

Copyright (c) 2008-2012, Abel Cheung.
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:

  * Redistributions of source code must retain the above copyright
    notice, this list of conditions and the following disclaimer.
  * Redistributions in binary form must reproduce the above copyright
    notice, this list of conditions and the following disclaimer in the
    documentation and/or other materials provided with the distribution.
  * Neither the name of the author nor the names of its
    contributors may be used to endorse or promote products derived
    from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

*/

define ('PASSWORD_HINT_FIELD_KEY', 'password_hint');

function get_the_password_form_with_hint() {
	global $post, $wp_version;

	$custom_value = get_post_custom_values (PASSWORD_HINT_FIELD_KEY, $post->ID);
	$password_hint = is_array($custom_value) ? $custom_value[0] : $custom_value;
	if ( empty( $password_hint ) )
		$password_hint = __("This post is password protected. To view it please enter your password below:");

	$label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );

	# For WP < 2.7 this hook is not called at all, so no need to check
	if( version_compare( $wp_version, '3.4', '<' ) ) {
		$url = get_option('siteurl') . '/wp-pass.php';
	} else {
		$url = esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) );
	}

	$output = '<form action="' . $url . '" method="post">
	<div class="password-hint">' . $password_hint . '</div>
	<div class="password-box"><label for="' . $label . '">' . __("Password:") . ' <input name="post_password" id="' . $label . '" type="password" size="20" /></label> <input type="submit" name="Submit" value="' . esc_attr__("Submit") . '" /></div>
	</form>
	';

	return $output;
}

add_action( 'the_password_form', 'get_the_password_form_with_hint' );
?>
