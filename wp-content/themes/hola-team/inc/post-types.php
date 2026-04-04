<?php
/**
 * Register custom post types and taxonomies.
 *
 * @package holateam
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {
	$labels = array(
		'name'                  => __( 'Trainings', 'holateam' ),
		'singular_name'         => __( 'Training', 'holateam' ),
		'menu_name'             => __( 'Trainings', 'holateam' ),
		'name_admin_bar'        => __( 'Training', 'holateam' ),
		'add_new'               => __( 'Add New', 'holateam' ),
		'add_new_item'          => __( 'Add New Training', 'holateam' ),
		'new_item'              => __( 'New Training', 'holateam' ),
		'edit_item'             => __( 'Edit Training', 'holateam' ),
		'view_item'             => __( 'View Training', 'holateam' ),
		'all_items'             => __( 'All Trainings', 'holateam' ),
		'search_items'          => __( 'Search Trainings', 'holateam' ),
		'parent_item_colon'     => __( 'Parent Trainings:', 'holateam' ),
		'not_found'             => __( 'No trainings found.', 'holateam' ),
		'not_found_in_trash'    => __( 'No trainings found in Trash.', 'holateam' ),
	);

	register_post_type( 'training', array(
		'labels'             => $labels,
		'public'             => true,
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'training' ),
		'show_in_rest'       => true,
		'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-welcome-learn-more',
		'taxonomies'         => array( 'training_category' ),
	) );

	register_taxonomy( 'training_category', array( 'training' ), array(
		'label'             => __( 'Training Categories', 'holateam' ),
		'rewrite'           => array( 'slug' => 'training-category' ),
		'hierarchical'      => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
	) );
} );
