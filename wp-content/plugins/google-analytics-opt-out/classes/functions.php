<?php

/**
 * Checks if the Yoast Analytics Plugin is active
 * @since 0.1
 * @return bool
 */
function gaoo_yoast_plugin_active() {
	if ( is_admin() ) {
		global $ga_admin;

		if ( ! isset( $ga_admin ) ) {
			return false;
		}

		if ( ! $ga_admin instanceof GA_Admin ) {
			return false;
		}

		return true;
	}
	else {
		global $yoast_ga;

		if ( ! isset( $yoast_ga ) ) {
			return false;
		}

		if ( ! $yoast_ga instanceof GA_Filter ) {
			return false;
		}

		return true;
	}
}

/**
 * Checks if the Yoast Analytics Plugin is active
 * @since 0.1.2
 * @return bool
 */
function gaoop_yoast_plugin_active() {
	if ( is_admin() ) {
		global $ga_admin;

		if ( ! isset( $ga_admin ) ) {
			return false;
		}

		if ( ! $ga_admin instanceof GA_Admin ) {
			return false;
		}

		return true;
	}
	else {
		global $yoast_ga;

		if ( ! isset( $yoast_ga ) ) {
			return false;
		}

		if ( ! $yoast_ga instanceof GA_Filter ) {
			return false;
		}

		return true;
	}
}

/**
 * Return the UA from Yoast settings, if Yoast Analytics plugin is installed
 * If Yoast Analytics is not installed this will return an empty string
 *
 * @since 0.1
 * @return string
 */
function gaoo_get_yoast_ua() {

	if ( ! gaoop_yoast_plugin_active() ) {
		return '';
	}

	if ( is_admin() ) {
		global $ga_admin;

		if ( ! isset( $ga_admin->optionname ) ) {
			return '';
		}

		$yoast_settings = get_option( $ga_admin->optionname );
	}
	else {
		global $yoast_ga;

		if ( ! isset( $yoast_ga->options ) ) {
			return '';
		}

		$yoast_settings = $yoast_ga->options;

	}


	if ( ! isset( $yoast_settings['uastring'] ) ) {
		return '';
	}

	return $yoast_settings['uastring'];

}

/**
 * Returns the UA-Code
 * @since 0.1
 * @return string
 */
function gaoo_get_ua_code() {

	if ( gaoo_yoast_plugin_active() ) {
		return apply_filters( 'gaoo_get_ua_code', gaoo_get_yoast_ua() );
	}

	// if yoast returns an empty string OR if the checkbox was set to 0 return the textbox content
	return apply_filters( 'gaoo_get_ua_code', esc_attr( get_option( 'gaoo_property', '' ) ) );

}