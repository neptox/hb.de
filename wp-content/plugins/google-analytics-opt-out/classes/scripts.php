<?php
/**
 * Echos out the JavaScript for the opt-out
 * @since 0.1
 * @return void
 */
function gaoo_head_script() {

	if ( apply_filters( 'gaoo_stop_head', false ) ) {
		return;
	}

	gaoo_js();
}

// To call it before the Yoast Analytics Plugin (2) this has a priority of 1
add_action( 'wp_head', 'gaoo_head_script', 1 );

/**
 * Echos out the Javascript or returns it (if $echo is set to TRUE)
 *
 * @since 0.1
 *
 * @param bool $echo
 *
 * @return void|string
 */
function gaoo_js( $echo = true ) {
	$ua_code = gaoo_get_ua_code();
	if ( empty( $ua_code ) ) {
		return '';
	}
	ob_start();
	?>
	<script type="text/javascript">
		/* <![CDATA[ */
		/* Google Analytics Opt-Out WordPress by WP-Buddy | http://wp-buddy.com/products/plugins/google-analytics-opt-out */
		<?php do_action('gaoo_js_before_script'); ?>
		var gaoo_property = '<?php echo $ua_code; ?>';
		var gaoo_disable_str = 'ga-disable-' + gaoo_property;
		if (document.cookie.indexOf(gaoo_disable_str + '=true') > -1) {
			window[gaoo_disable_str] = true;
		}
		function gaoo_analytics_optout() {
			document.cookie = gaoo_disable_str + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
			window[gaoo_disable_str] = true;
			<?php echo apply_filters( 'gaoo_', "alert('" . __( 'Thanks. We have set a cookie so that Google Analytics data collection will be disabled on your next visit.', 'gaoo' ) . "');" ); ?>
		}
		<?php do_action('gaoo_js_after_script'); ?>
		/* ]]> */
	</script>
	<?php
	$content = ob_get_clean();
	if ( $echo ) {
		echo $content;
	}
	else {
		return $content;
	}
}