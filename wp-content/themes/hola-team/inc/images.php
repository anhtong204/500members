<?php

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //

//  This file creates any filters which determin the functionality or
//  implementation of images throughout the theme.
//
//  [_1_] Allow .svg uploads
//  [_2_] Remove width and height attributes from <img>
//  [_3_] Remove <p> tags from <img>
//  [_4_] Set Custom Thumbnail Sizes (if required)
//  [_6_] Image URL Path Request

//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_1_] Allow .svg uploads  //

function prop_mime_types( $mimes ) {

    $mimes['svg'] = 'image/svg+xml';
    return $mimes;

}
add_filter( 'upload_mimes', 'prop_mime_types' );


//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_2_] Remove width and height attributes from <img>  //

function prop_remove_img_dimensions( $html ) {

    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;

}
//  From the_post_thumbnail  //
add_filter( 'post_thumbnail_html', 'prop_remove_img_dimensions', 10 );

//  From the WYSIWYG editor  //
add_filter( 'image_send_to_editor', 'prop_remove_img_dimensions', 10 );

//  From the_content  //
add_filter( 'the_content', 'prop_remove_img_dimensions', 10 );


//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_3_] Remove <p> tags from <img>  //

function prop_acf_filter_ptags_on_images($content){

    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);

}
add_filter( 'acf_the_content', 'prop_acf_filter_ptags_on_images' );

function prop_filter_ptags_on_images($content){

    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);

}
add_filter( 'the_content', 'prop_filter_ptags_on_images' );


//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_4_] Set Custom Thumbnail Sizes (if required)  //
//  https: //developer.wordpress.org/reference/functions/add_image_size/


add_theme_support( 'post-thumbnails' );

// set_post_thumbnail_size( 150, 150, true ); //  Set basic thumbnail size, crop mode  //
add_image_size( 'loader', 12 ); //  Custom featured image size, crop mode  //
add_image_size( 'navigation', 400 ); //  Custom featured image size, crop mode  //
add_image_size( 'hero', 1450 ); //  Custom featured image size, crop mode  //
add_image_size( 'banner', 1450 ); //  Custom featured image size, crop mode  //
add_image_size( 'banner-med', 1200); //  Custom featured image size, crop mode  //
add_image_size( 'banner-sml', 800); //  Custom featured image size, crop mode  //
add_image_size( 'xlarge', 1200 ); //  Custom featured image size, crop mode  //
add_image_size( 'grid', 600, 600, true); //  Custom featured image size, crop mode  //
add_image_size( 'grid-wide', 800, 450, true); //  Custom featured image size, crop mode  //
add_image_size( 'grid-wide-l', 1400, 788, true); //  Custom featured image size, crop mode  //





//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_5_] Disable Thumbnail Dimensions  //

function prop_remove_thumbnail_dimensions( $html ) {

	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;

}
add_filter( 'post_thumbnail_html', 'prop_remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'prop_remove_thumbnail_dimensions', 10 );
add_filter( 'the_content', 'prop_remove_thumbnail_dimensions', 10 );

add_filter( 'xmlrpc_enabled', '__return_false' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );


//  ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** ***** *****  //


//  [_6_] Image URL Path Request  //

//  To be used whenever an image is needed via the uploads directory.
//  Prevents unwanted requests to the site.

function get_upload_path($url){

    $domain = get_home_url();
    $path = str_replace($domain, '', $url);

    return $path;

}
