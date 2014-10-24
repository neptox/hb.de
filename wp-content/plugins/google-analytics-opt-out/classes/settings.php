<?php

/**
 * Creating the menu item
 * @since 0.1
 * @return void
 */
function gaoo_admin_menu() {
	$hook = add_submenu_page( 'options-general.php', __( 'Analytics Opt-Out', 'gaoo' ), __( 'Analytics Opt-Out', 'gaoo' ), 'manage_options', 'gaoo-options', 'gaoo_settings_page' );
	add_action( "load-$hook", 'gaoo_settings_scripts' );
}

add_action( 'admin_menu', 'gaoo_admin_menu' );


/**
 * Creating the settings page HTML output
 * @since 0.1
 * @return void
 */
function gaoo_settings_page() {
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"></div>
		<h2><?php _e( 'Google Analaytics Opt-Out', 'gaoo' ); ?> </h2>

		<form action="options.php" method="post">
			<?php
			settings_fields( 'gaoo_options_page' );
			do_settings_sections( 'gaoo_options_page' );
			submit_button();
			?>
		</form>
	</div>
<?php
}


/**
 * Enqueues the settings page scripts and styles
 * @since 0.1
 * @return void
 */
function gaoo_settings_scripts() {
	wp_enqueue_script( 'equipment', GAOO_URL . '/js/settings.js', array( 'jquery' ), false, true );
}


/**
 * Registers Settings sections and fields
 * @since 0.1
 * @return void
 */
function gaoo_register_theme_options_section() {

	add_settings_section( 'gaoo_settings_section', __( 'Analytics Opt-Out', 'gaoo' ), null, 'gaoo_options_page' );

	add_settings_field( 'gaoo_yoast', __( 'Use Yoast Analytics Settings', 'gaoo' ), 'gaoo_options_yoast', 'gaoo_options_page', 'gaoo_settings_section', array( 'label_for' => 'gaoo_options_yoast' ) );
	register_setting( 'gaoo_options_page', 'gaoo_yoast' );

	add_settings_field( 'gaoo_property', __( 'UA-Code', 'gaoo' ), 'gaoo_options_property', 'gaoo_options_page', 'gaoo_settings_section', array( 'label_for' => 'gaoo_options_property' ) );
	register_setting( 'gaoo_options_page', 'gaoo_property', 'sanitize_text_field' );
}

add_action( 'admin_init', 'gaoo_register_theme_options_section' );


/**
 * Settings field for the Yoast Checkbox
 * @since 0.1
 * @return void
 */
function gaoo_options_yoast() {

	$yoast_active = gaoo_yoast_plugin_active();

	$option = get_option( 'gaoo_yoast', null );

	// if the plugin is used the first time it has the value of NULL. In this case we set the option to 1
	if ( is_null( $option ) ) {
		$option = 1;
	}

	if ( ! $yoast_active ) {
		$option = 0;
	}

	echo '<input ' . disabled( ! $yoast_active, true, false ) . ' ' . checked( $option, 1, false ) . ' id="gaoo_options_yoast" type="checkbox" name="gaoo_yoast" value="1" />';
	echo '<p class="description">';
	if ( $yoast_active ) {
		echo '<span style="color: #5EB95E;">' . __( 'Yoast Analytics Plugin has been detected.', 'gaoo' ) . '</span>';
	}
	else {
		echo '<span style="color: #DD514C;">' . __( 'Yoast Analytics Plugin has NOT been detected. Please enter your UA code manually and then check the sourcode of your website. Make sure that Analytics code appears AFTER the opt-out code (which starts with <code>/* Google Analytics Opt-Out</code>).', 'gaoo' ) . '</span>';
	}
	echo '</p>';
}


/**
 * Settings field for the UA property
 * @since 0.1
 * @return void
 */
function gaoo_options_property() {
	$yoast_active = gaoo_yoast_plugin_active();
	$option       = get_option( 'gaoo_yoast', null );

	if ( $yoast_active && 1 == $option ) {
		$value = gaoo_get_yoast_ua();
	}
	else {
		$value = sanitize_text_field( get_option( 'gaoo_property', '' ) );
	}

	echo '<input id="gaoo_options_property" placeholder="UA-XXXXXX-X" type="text" class="regular-text" value="' . $value . '" name="gaoo_property" /> ';

}