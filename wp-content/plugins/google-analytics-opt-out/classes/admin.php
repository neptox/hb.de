<?php

function gaoo_admin_notice() {
	$code = gaoo_get_ua_code();
	if ( ! empty( $code ) ) {
		return;
	}

	$link    = admin_url( 'options-general.php?page=gaoo-options' );
	$message = __( 'To use the Google Analytics Opt-Out Plugin please enter an UA-Code on the settings page.', 'gaoo' );

	if ( gaoo_yoast_plugin_active() ) {
		$link    = admin_url( 'options-general.php?page=google-analytics-for-wordpress' );
		$message = __( 'To use the Google Analytics Opt-Out Plugin please enter an UA-Code on the settings page of "Google Analytics for WordPress" configuration page.', 'gaoo' );
	}
	?>
	<div class="error">
		<p>
			<a href="<?php echo $link; ?>"><?php echo $message; ?></a>
		</p>
	</div>
<?php
}

add_action( 'admin_notices', 'gaoo_admin_notice' );


/**
 * Adds some action links to the plugin on the list of plugins page
 *
 * @param array $links
 *
 * @since 0.1
 *
 * @return array
 */
function gaoo_plugin_action_links( $links ) {
	$links[] = '<a href="' . admin_url( 'options-general.php?page=gaoo-options' ) . '">' . __( 'Settings', 'gaoo' ) . '</a>';
	$links[] = '<a target="_blank" href="http://wp-buddy.com">' . __( 'More by WP-Buddy', 'gaoo' ) . '</a>';
	return $links;
}

add_filter( 'plugin_action_links_' . plugin_basename( GAOO_FILE ), 'gaoo_plugin_action_links' );


/**
 * Adds the editor button functions
 * @since 0.1
 * @return void
 */
function gaoo_editor_button() {
	if ( get_user_option( 'rich_editing' ) == true ) {
		add_filter( "mce_external_plugins", 'gaoo_add_mce_plugin' );
		add_filter( 'mce_buttons', 'gaoo_register_mce_buttons' );
	}
}

add_action( 'init', 'gaoo_editor_button' );

/**
 * Adds the plugin to tinymce
 *
 * @param array $plugin_array
 *
 * @since 0.1
 *
 * @return array
 */
function gaoo_add_mce_plugin( $plugin_array ) {
	$plugin_array['wpb_analytics_opt_out'] = GAOO_URL . 'js/editor-button.js';
	return $plugin_array;
}

/**
 * Adds the button
 *
 * @param array $buttons
 *
 * @since 0.1
 *
 * @return array
 */
function gaoo_register_mce_buttons( $buttons ) {
	array_push( $buttons, "wpb_analytics_opt_out" );
	return $buttons;
}