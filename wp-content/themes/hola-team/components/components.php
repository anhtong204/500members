<?php

$layout          = $row['component_layout'] ?? 'default';
$component_id    = $row['component_id'] ?? '';
$component_class = $row['className'] ?? '';
$component_name  = $row['acf_fc_layout'];

// Get field from Basic fields
$text_color       = $row['component_text_color'];
$text_align       = $row['component_text_align'];
$background_color = $row['component_background_color'];
$background_image = $row['component_background_image'];

$title_text      = $row['component_title'] ?? null;
$title_color     = $row['component_title_color'] ?? null;
$style_for_title = $row['style_for_title'] ?? null;

$sub_title_text  = $row['component_sub_title'] ?? null;
$sub_title_color = $row['component_sub_title_color'] ?? null;

$component_link       = $row['component_link'] ?? null;
$component_link_style = $row['style_link'] ?? null;
$body                 = $row['component_body'] ?? null;

$margin          = $row['component_margin'];
$padding         = $row['component_padding'];
$container_class = $row['container'];

$height        = $row['component_height'];
$custom_height = $row['custom_height'];

$classes = array( $component_class, 'component-' . $component_name, $component_name . '-' . $layout );
$styles  = array();

$component_h1 = $row['component_h1'] ?? null;

$component_title = array();
if ( $title_text ) {
	$component_title['text'] = $title_text;
}

if ( $title_color ) {
	$component_title['color'] = $title_color;
}

if ( $style_for_title ) {
	$component_title['style'] = $style_for_title;
}

$component_sub_title = array();
if ( $sub_title_text ) {
	$component_sub_title['text'] = $sub_title_text;
}

if ( $sub_title_color ) {
	$component_sub_title['color'] = $sub_title_color;
}

if ( $background_color ) {
	$styles['background-color'] = $background_color;
}

if ( $background_image ) {
	$background_image_url = $background_image['url'];
	$styles['background-image'] = "url($background_image_url)";
	$classes[] = 'holateam-custom-background';
}

if ( $text_color ) {
	$styles['color'] = $text_color;
	$classes[] = 'component-custom-color';
}

if ( $height == 'full' ) {
	$styles['height'] = '100vh';

} elseif ( $height == 'custom' && is_numeric( $custom_height ) ) {
	$styles['height'] = $custom_height . 'px;';

}

if ( $text_align ) {
	$classes[] = 'text-' . $text_align;
}

if ( $margin ) {
	$classes[] = $margin;
}

if ( $padding ) {
	$classes[] = $padding;
}

open_component( $component_id, $classes, $styles, $component_name, $layout_position );
	include( locate_template( "components/$component_name/$layout.php" ) );    
close_component();
