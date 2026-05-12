<?php
/**
 * Register custom post types and taxonomies.
 *
 * @package holateam
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

add_action('init', function () {
	$labels = array(
		'name' => __('Trainings', 'holateam'),
		'singular_name' => __('Training', 'holateam'),
		'menu_name' => __('Trainings', 'holateam'),
		'name_admin_bar' => __('Training', 'holateam'),
		'add_new' => __('Add New', 'holateam'),
		'add_new_item' => __('Add New Training', 'holateam'),
		'new_item' => __('New Training', 'holateam'),
		'edit_item' => __('Edit Training', 'holateam'),
		'view_item' => __('View Training', 'holateam'),
		'all_items' => __('All Trainings', 'holateam'),
		'search_items' => __('Search Trainings', 'holateam'),
		'parent_item_colon' => __('Parent Trainings:', 'holateam'),
		'not_found' => __('No trainings found.', 'holateam'),
		'not_found_in_trash' => __('No trainings found in Trash.', 'holateam'),
	);

	register_post_type('training', array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'training'),
		'show_in_rest' => true,
		'supports' => array('title', 'excerpt', 'thumbnail'),
		'menu_position' => 5,
		'menu_icon' => 'dashicons-welcome-learn-more',
		'taxonomies' => array('training_category'),
	));

	register_taxonomy('training_category', array('training'), array(
		'label' => __('Training Categories', 'holateam'),
		'rewrite' => array('slug' => 'training-category'),
		'hierarchical' => true,
		'show_admin_column' => true,
		'show_in_rest' => true,
	));

	register_post_type('state', array(
		'labels' => array(
			'name' => __('States', 'holateam'),
			'singular_name' => __('State', 'holateam'),
			'menu_name' => __('States', 'holateam'),
			'name_admin_bar' => __('State', 'holateam'),
			'add_new' => __('Add New', 'holateam'),
			'add_new_item' => __('Add New State', 'holateam'),
			'new_item' => __('New State', 'holateam'),
			'edit_item' => __('Edit State', 'holateam'),
			'view_item' => __('View State', 'holateam'),
			'all_items' => __('All States', 'holateam'),
			'search_items' => __('Search States', 'holateam'),
			'not_found' => __('No states found.', 'holateam'),
			'not_found_in_trash' => __('No states found in Trash.', 'holateam'),
		),
		'public' => true,
		'has_archive' => false,
		'rewrite' => array('slug' => 'state'),
		'show_in_rest' => true,
		'supports' => array('title'),
		'menu_position' => 6,
		'menu_icon' => 'dashicons-location-alt',
	));

});

// add_action( 'admin_init', function () {
// 	if ( ! get_option( 'holateam_states_imported', false ) ) {
// 		holateam_import_states();
// 		update_option( 'holateam_states_imported', true );
// 	}
// } );

// function holateam_import_states() {
// 	$states = array(
// 		'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia',
// 		'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland',
// 		'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey',
// 		'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina',
// 		'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
// 	);

// 	foreach ( $states as $state ) {
// 		if ( ! post_exists( $state ) ) {
// 			wp_insert_post(
// 				array(
// 					'post_title'  => $state,
// 					'post_type'   => 'state',
// 					'post_status' => 'publish',
// 					'post_author' => get_current_user_id() ? get_current_user_id() : 1,
// 				)
// 			);
// 		}
// 	}
// }
