<?php
/**
 * UnderStrap functions and definitions
 *
 * @package holateam
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$holateam_inc_dir = 'inc';

// Array of files to include.
$holateam_includes = array(
	'/acf.php',                             // Load ACF functions.
	'/advanced-theme-settings.php',         // Advanced theme settings.
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/editor.php',                          // Load Editor functions.
	'/deprecated.php',                      // Load deprecated functions.
	'/disable-emoji.php',                   // Disable emoji.
	'/disable-oembed.php',                  // Disable oEmbed.
	'/shortcodes.php',                  	// Shortcodes.
	'/images.php',                          // Load Images Optimize
	'/admin/wp-styles.php',
	'/admin/wysiwyg.php',
	'/functions.php',                       // Load customize functions.
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
	$holateam_includes[] = '/woocommerce.php';
}

// Include files.
foreach ( $holateam_includes as $file ) {
	require_once get_theme_file_path( $holateam_inc_dir . $file );
}
