<?php
/**
 * Understrap modify editor
 *
 * @package holateam
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'admin_init', 'holateam_wpdocs_theme_add_editor_styles' );

if ( ! function_exists( 'holateam_wpdocs_theme_add_editor_styles' ) ) {
	/**
	 * Registers an editor stylesheet for the theme.
	 */
	function holateam_wpdocs_theme_add_editor_styles() {
		add_editor_style( 'css/custom-editor-style.min.css' );
	}
}

add_filter( 'mce_buttons_2', 'holateam_tiny_mce_style_formats' );

if ( ! function_exists( 'holateam_tiny_mce_style_formats' ) ) {
	/**
	 * Reveals TinyMCE's hidden Style dropdown.
	 *
	 * @param array $buttons Array of Tiny MCE's button ids.
	 * @return array
	 */
	function holateam_tiny_mce_style_formats( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}
}

add_filter( 'tiny_mce_before_init', 'holateam_tiny_mce_before_init' );

if ( ! function_exists( 'holateam_tiny_mce_before_init' ) ) {
	/**
	 * Adds style options to TinyMCE's Style dropdown.
	 *
	 * @param array $settings TinyMCE settings array.
	 * @return array
	 */
	function holateam_tiny_mce_before_init( $settings ) {

		$style_formats = array(
			array(
				'title'    => __( 'Lead Paragraph', 'holateam' ),
				'selector' => 'p',
				'classes'  => 'lead',
				'wrapper'  => true,
			),
			array(
				'title'  => _x( 'Small', 'Font size name', 'holateam' ),
				'inline' => 'small',
			),
			array(
				'title'   => __( 'Blockquote', 'holateam' ),
				'block'   => 'blockquote',
				'classes' => 'blockquote',
				'wrapper' => true,
			),
			array(
				'title'   => __( 'Blockquote Footer', 'holateam' ),
				'block'   => 'footer',
				'classes' => 'blockquote-footer',
				'wrapper' => true,
			),
			array(
				'title'  => __( 'Cite', 'holateam' ),
				'inline' => 'cite',
			),
		);

		if ( isset( $settings['style_formats'] ) ) {
			$orig_style_formats = json_decode( $settings['style_formats'], true );
			$style_formats      = array_merge( $orig_style_formats, $style_formats );
		}

		$settings['style_formats'] = wp_json_encode( $style_formats );
		return $settings;
	}
}

add_filter( 'mce_buttons', 'holateam_tiny_mce_blockquote_button' );

if ( ! function_exists( 'holateam_tiny_mce_blockquote_button' ) ) {
	/**
	 * Removes the blockquote button from the TinyMCE toolbar.
	 *
	 * We provide the blockquote via the style formats. Using the style formats
	 * blockquote receives the proper Bootstrap classes.
	 *
	 * @see holateam_tiny_mce_before_init()
	 *
	 * @param array $buttons TinyMCE buttons array.
	 * @return array TinyMCE buttons array without the blockquote button.
	 */
	function holateam_tiny_mce_blockquote_button( $buttons ) {
		foreach ( $buttons as $key => $button ) {
			if ( 'blockquote' === $button ) {
				unset( $buttons[ $key ] );
			}
		}
		return $buttons;
	}
}

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//	[_03_] Custom WYSIWYG Formats  //

// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2($buttons)
{
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_2', 'my_mce_buttons_2');

function my_mce_before_init_insert_formats($init_array)
{
    return $init_array;
}
// Attach callback to 'tiny_mce_before_init'
add_filter('tiny_mce_before_init', 'my_mce_before_init_insert_formats');

// Load the editor styles to display the new format in the back end
function my_theme_add_editor_styles()
{
    add_editor_style(get_template_directory_uri() . '/assets/admin/tinymce.css');
}
add_action('init', 'my_theme_add_editor_styles');

// hooks your functions into the correct filters
function wdm_add_mce_button() {
    // check user permissions
    if ( !current_user_can( 'edit_posts' ) &&  !current_user_can( 'edit_pages' ) ) {
        return;
    }
    // check if WYSIWYG is enabled
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'wdm_add_tinymce_plugin' );
        add_filter( 'mce_buttons', 'wdm_register_mce_button' );
    }
}
add_action('admin_head', 'wdm_add_mce_button');

// register new button in the editor
function wdm_register_mce_button( $buttons ) {
    array_push( $buttons, 'tinymce_font_weight' );
    array_push( $buttons, 'tinymce_font_sizes' );
    array_push( $buttons, 'tinymce_font_family' );
    return $buttons;
}

function wdm_register_acf_toolbars($toolbars)
{
    $toolbars['Full'][1][100] = 'tinymce_font_weight';
    $toolbars['Full'][1][101] = 'tinymce_font_sizes';
    $toolbars['Full'][1][102] = 'tinymce_font_family';
    
    return $toolbars;
}
add_filter('acf/fields/wysiwyg/toolbars', 'wdm_register_acf_toolbars');

// declare a script for the new button
// the script will insert the shortcode on the click event
function wdm_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['tinymce_font_weight'] = get_template_directory_uri() . '/assets/admin/tinymce.js';
    $plugin_array['tinymce_font_sizes'] = get_template_directory_uri() . '/assets/admin/tinymce.js';
    $plugin_array['tinymce_font_family'] = get_template_directory_uri() . '/assets/admin/tinymce.js';
    return $plugin_array;
}


//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//	[_04_] Convert HEX to RGB  //

/**
 * Convert HEX color to RGB
 *
 * @param string $hexStr
 * @param "string"|"array" $returnType
 *
 * @return string|array
 */
function hex2RGB(string $hexStr, string $returnType = 'string')
{
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr);
    $rgbArray = array();
    if (strlen($hexStr) === 6) {
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    }

    if ($returnType === 'array') {
        return $rgbArray;
    } else {
        return $rgbArray['red'] . ',' . $rgbArray['green'] . ',' . $rgbArray['blue'];
    }
}

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//	[_05_] Coordinate Calculate Distance  //

function vincentyGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $lonDelta = $lonTo - $lonFrom;
    $a = pow(cos($latTo) * sin($lonDelta), 2) +
        pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
    $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

    $angle = atan2(sqrt($a), $b);
    return $angle * $earthRadius;
}

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


