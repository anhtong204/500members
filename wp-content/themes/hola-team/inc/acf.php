<?php
/**
 * ACF functions.
 *
 * @package holateam
 */


add_filter(
	'acf/settings/save_json',
	function() {
		return get_stylesheet_directory() . '/assets/acf-json';
	}
);

add_filter(
	'acf/settings/load_json',
	function( $paths ) {
		$paths = array( get_template_directory() . '/assets/acf-json' );

		if ( is_child_theme() ) {
			$paths[] = get_stylesheet_directory() . '/assets/acf-json';
		}

		return $paths;
	}
);

if ( is_admin() ) {
	add_action( 'init', 'acf_sync_warning' );

	function acf_sync_warning() {
		// Taken from ACF Pro plugin
		$groups = acf_get_field_groups();

		// Bail early if no field groups
		if ( empty( $groups ) ) {
			return;
		}

		// Find JSON field groups which have not yet been imported
		$sync = array();

		foreach ( $groups as $group ) {
			$local = acf_maybe_get( $group, 'local', false );
			$modified = acf_maybe_get( $group, 'modified', 0 );
			$private = acf_maybe_get( $group, 'private', false );
			$post_modified = get_post_modified_time( 'U', true, $group['ID'], true );

			// Ignore DB / PHP / private field groups
			if ( $local !== 'json' || $private ) {
				// Do nothing
			} elseif ( ! $group['ID'] ) {
				$sync[ $group['key'] ] = $group;
			} elseif ( $modified > $post_modified ) {
				$sync[ $group['key'] ] = $group;
			}
		}

		// If nothing to sync, return.
		if ( empty( $sync ) ) {
			return;
		}

		add_action(
			'admin_notices',
			function () {
				echo '
            <div class="notice  notice-error">
                <h1>
                    <strong>Warning</strong>: ACF Needs Syncing!
                    <a href="' . site_url() . '/wp-admin/edit.php?post_type=acf-field-group&post_status=sync">Sync now</a>
                </h1>
            </div>';
			}
		);
	}
}

/**
 * Create holateam Theme Settings Page
 */

add_action( 'acf/init', 'holateam_acf_init' );
function holateam_acf_init() {

	if ( function_exists( 'acf_add_options_page' ) ) {

		$option_page = acf_add_options_page(
			array(
				'page_title' => __( 'Advanced Theme Settings', 'holateam' ),
				'menu_title' => __( 'Advanced Theme Settings', 'holateam' ),
				'menu_slug'  => 'holateam-advanced-theme-settings',
				'capability' => 'create_users',
				'icon_url'   => 'dashicons-admin-customizer',
				'position'   => 60,
				'redirect'   => false,
			)
		);
	}
}
