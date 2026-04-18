<?php

/**
 * Get Component Title and Subtitle
 */
function get_component_title($h1, $title = array(), $sub_title = array(), $sub_title_below = false)
{

	$h1_element = $h1 ?: '';

	$title_text = isset($title['text']) ? $title['text'] : '';
	$title_color = isset($title['color']) ? "style='color: {$title['color']}'" : '';
	$title_style = isset($title['style']) ? $title['style'] : '';

	$sub_title_text = isset($sub_title['text']) ? $sub_title['text'] : '';
	$sub_title_color = isset($sub_title['color']) ? "style='color: {$sub_title['color']}'" : '';

	if ('component_title' === $h1_element) {
		$title_heading = 'h1';
	} else {
		$title_heading = 'h2';
	}

	$sub_title_heading = 'h5';

	if (!$sub_title_below && '' !== $sub_title_text) {
		echo "<{$sub_title_heading} class='component-sub-title' {$sub_title_color}>{$sub_title_text}</{$sub_title_heading}>";
	}

	if ('' !== $title_text) {
		echo "<{$title_heading} class='component-title {$title_style}' {$title_color}>{$title_text}</{$title_heading}>";
	}

	if ($sub_title_below && '' !== $sub_title_text) {
		echo "<{$sub_title_heading} class='component-sub-title' {$sub_title_color}>{$sub_title_text}</{$sub_title_heading}>";
	}
}

/**
 * Create component tag with id, class and inline-style
 */
function open_component($id, $classes = array(), $styles = array(), $component_name = '', $layout_position = 0)
{
	$class_arr = array();
	if (!empty($classes)) {
		foreach ($classes as $class) {
			if ($class) {
				$class_arr[] = $class;
			}
		}
		$extra_classes = implode(' ', $class_arr);
	} else {
		$extra_classes = null;
	}

	$inline_style = '';
	if (!empty($styles)) {
		foreach ($styles as $key => $value) {
			$inline_style .= "$key:$value;";
		}
	}

	echo "<section id='$id' class='$extra_classes' style='$inline_style' data-layout='$component_name' data-position='$layout_position'>";
}

function close_component()
{
	echo '</section>';
}

function render_link($link, $class = 'more-link', $popup = false)
{
	if ($link):
		$link_url = $link['url'];
		$link_title = $link['title'];
		$link_target = isset($link['target']) ? $link['target'] : '_self'; ?>
		<?php if ($popup): ?>
			<a class="<?php echo $class; ?>" data-bs-toggle="modal" data-bs-target="#exampleModal"
				href="javascript:void(0);"><?php echo $link_title; ?></a>
		<?php else: ?>
			<a class="<?php echo $class; ?>" href="<?php echo esc_url($link_url); ?>"
				target="<?php echo esc_attr($link_target); ?>"><?php echo $link_title; ?></a>
		<?php endif; ?>
	<?php
	endif;
}

/**
 * Set default alt tag image
 * $image Array | ID(Media) | URL(Media)
 */
function get_image_alt($image, $altDefault = 'holateam Codebase')
{
	if (is_array($image)) {
		if (isset($image['alt']) && $image['alt'] != '') {
			return $image['alt'];
		} else {
			$alt = str_replace('-', ' ', $image['title']);
			return $alt;
		}
	}
	if (is_numeric($image)) {
		$image_id = get_post_thumbnail_id($image);
		$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		if ($alt != '') {
			return $alt;
		} else {
			return str_replace('-', ' ', get_post($image_id)->post_title);
		}
	}
	if (is_string($image)) {
		$image_id = attachment_url_to_postid($image);
		$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
		if ($alt != '') {
			return $alt;
		} else {
			return str_replace('-', ' ', get_post($image_id)->post_title);
		}
	}
	return $altDefault;
}

/**
 * Add Missing Alt Tags To content
 */
function auto_add_alt_tags($content)
{
	preg_match_all('/<img.*alt="(.*?)"/', $content, $images);
	if (!is_null($images)) {
		global $post;
		foreach ($images[1] as $index => $value) {
			if ('' === $value) {
				$new_img = str_replace('<img', '<img alt="' . $post->post_title . '"', $images[0][$index]);
				$content = str_replace(array($images[0][$index], 'alt=""'), array($new_img, ''), $content);
			}
		}
	}
	return $content;
}
// add_filter('the_content', 'auto_add_alt_tags', 9999999999);
