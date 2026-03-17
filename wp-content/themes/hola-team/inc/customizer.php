<?php
/**
 * Understrap Theme Customizer
 *
 * @package holateam
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
if ( ! function_exists( 'holateam_customize_register' ) ) {
	/**
	 * Register basic customizer support.
	 *
	 * @param object $wp_customize Customizer reference.
	 */
	function holateam_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'holateam_customize_register' );

if ( ! function_exists( 'holateam_theme_customize_register' ) ) {
	/**
	 * Register individual settings through customizer's API.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer reference.
	 */
	function holateam_theme_customize_register( $wp_customize ) {

		// Theme layout settings.
		$wp_customize->add_section(
			'holateam_theme_layout_options',
			array(
				'title'       => __( 'Theme Layout Settings', 'holateam' ),
				'capability'  => 'edit_theme_options',
				'description' => __( 'Container width and sidebar defaults', 'holateam' ),
				'priority'    => apply_filters( 'holateam_theme_layout_options_priority', 160 ),
			)
		);

		/**
		 * Select sanitization function
		 *
		 * @param string               $input   Slug to sanitize.
		 * @param WP_Customize_Setting $setting Setting instance.
		 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
		 */
		function holateam_theme_slug_sanitize_select( $input, $setting ) {

			// Ensure input is a slug (lowercase alphanumeric characters, dashes and underscores are allowed only).
			$input = sanitize_key( $input );

			// Get the list of possible select options.
			$choices = $setting->manager->get_control( $setting->id )->choices;

			// If the input is a valid key, return it; otherwise, return the default.
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

		}

		$wp_customize->add_setting(
			'holateam_container_type',
			array(
				'default'           => 'container',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'holateam_theme_slug_sanitize_select',
				'capability'        => 'edit_theme_options',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'holateam_container_type',
				array(
					'label'       => __( 'Container Width', 'holateam' ),
					'description' => __( 'Choose between Bootstrap\'s container and container-fluid', 'holateam' ),
					'section'     => 'holateam_theme_layout_options',
					'settings'    => 'holateam_container_type',
					'type'        => 'select',
					'choices'     => array(
						'container'       => __( 'Fixed width container', 'holateam' ),
						'container-fluid' => __( 'Full width container', 'holateam' ),
					),
					'priority'    => apply_filters( 'holateam_container_type_priority', 10 ),
				)
			)
		);

		$wp_customize->add_setting(
			'holateam_navbar_type',
			array(
				'default'           => 'collapse',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'capability'        => 'edit_theme_options',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'holateam_navbar_type',
				array(
					'label'             => __( 'Responsive Navigation Type', 'holateam' ),
					'description'       => __(
						'Choose between an expanding and collapsing navbar or an offcanvas drawer.',
						'holateam'
					),
					'section'           => 'holateam_theme_layout_options',
					'settings'          => 'holateam_navbar_type',
					'type'              => 'select',
					'sanitize_callback' => 'holateam_theme_slug_sanitize_select',
					'choices'           => array(
						'collapse'  => __( 'Collapse', 'holateam' ),
						'offcanvas' => __( 'Offcanvas', 'holateam' ),
					),
					'priority'          => apply_filters( 'holateam_navbar_type_priority', 20 ),
				)
			)
		);

	}
} // End of if function_exists( 'holateam_theme_customize_register' ).
add_action( 'customize_register', 'holateam_theme_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
if ( ! function_exists( 'holateam_customize_preview_js' ) ) {
	/**
	 * Setup JS integration for live previewing.
	 */
	function holateam_customize_preview_js() {
		wp_enqueue_script(
			'holateam_customizer',
			get_template_directory_uri() . '/js/customizer.js',
			array( 'customize-preview' ),
			'20130508',
			true
		);
	}
}
add_action( 'customize_preview_init', 'holateam_customize_preview_js' );

/**
 * Loads javascript for conditionally showing customizer controls.
 */
if ( ! function_exists( 'holateam_customize_controls_js' ) ) {
	/**
	 * Setup JS integration for live previewing.
	 */
	function holateam_customize_controls_js() {
		wp_enqueue_script(
			'holateam_customizer',
			get_template_directory_uri() . '/js/customizer-controls.js',
			array( 'customize-preview' ),
			'20130508',
			true
		);
	}
}
add_action( 'customize_controls_enqueue_scripts', 'holateam_customize_controls_js' );
