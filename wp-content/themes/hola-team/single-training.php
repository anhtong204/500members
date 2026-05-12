<?php
/**
 * Template for displaying single training posts.
 *
 * @package holateam
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = get_theme_mod('holateam_container_type');
$current_post_id = get_the_ID();
$training_duration = get_field('training_duration');
$training_media_type = get_field('training_media_type');
$training_media_link = get_field('training_media_link');

// Get the active category from URL param (e.g. ?cat=category-slug)
// Falls back to the first category if no param is present
$post_terms = get_the_terms($current_post_id, 'training_category');
$current_term_slug = '';
if (isset($_GET['cat']) && !empty($_GET['cat'])) {
	$current_term_slug = sanitize_text_field($_GET['cat']);
} elseif (!empty($post_terms) && !is_wp_error($post_terms)) {
	$current_term_slug = $post_terms[0]->slug;
}

// Get all training categories for sidebar
$training_terms = get_terms(
	array(
		'taxonomy' => 'training_category',
		'hide_empty' => true,
	)
);

// Build the video embed
$video_embed = '';
if ($training_media_link) {
	if ($training_media_type === 'vimeo') {
		// Extract Vimeo ID
		preg_match('/(?:vimeo\.com\/(?:video\/)?|player\.vimeo\.com\/video\/)(\d+)/', $training_media_link, $matches);
		$vimeo_id = !empty($matches[1]) ? $matches[1] : '';
		if ($vimeo_id) {
			$video_embed = '<iframe src="https://player.vimeo.com/video/' . esc_attr($vimeo_id) . '?badge=0&autopause=0&player_id=0&app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
		}
	} elseif ($training_media_type === 'youtube') {
		// Extract YouTube ID
		preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $training_media_link, $matches);
		$youtube_id = !empty($matches[1]) ? $matches[1] : '';
		if ($youtube_id) {
			$video_embed = '<iframe src="https://www.youtube.com/embed/' . esc_attr($youtube_id) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
		}
	} elseif ($training_media_type === 'html5') {
		$video_embed = '<video controls><source src="' . esc_url($training_media_link) . '" type="video/mp4"></video>';
	}
}
?>

<div class="wrapper" id="single-wrapper">
	<div class="container-small pb-1x" id="content" tabindex="-1">
		<main class="site-main" id="main">

			<div class="training-component training-detail-layout">
				<div class="training-detail-wrapper">
					<!-- Mobile: Category trigger button -->
					<button class="training-mobile-trigger" type="button">
						<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M2.25 4.5H15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
							<path d="M2.25 9H15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
							<path d="M2.25 13.5H15.75" stroke="currentColor" stroke-width="1.5"
								stroke-linecap="round" />
						</svg>
						<?php esc_html_e('All lessons', 'holateam'); ?>
					</button>

					<!-- Mobile: Category modal -->
					<div class="training-mobile-modal">
						<div class="training-mobile-modal-content">
							<div class="training-mobile-modal-header">
								<h4 class="training-mobile-modal-title"><?php esc_html_e('', 'holateam'); ?>
								</h4>
								<button class="training-mobile-modal-close" type="button" aria-label="Close">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none"
										xmlns="http://www.w3.org/2000/svg">
										<path d="M15 5L5 15" stroke="currentColor" stroke-width="1.5"
											stroke-linecap="round" />
										<path d="M5 5L15 15" stroke="currentColor" stroke-width="1.5"
											stroke-linecap="round" />
									</svg>
								</button>
							</div>
							<div class="training-mobile-modal-body">
								<?php include(locate_template('components/training/sidebar.php')); ?>
							</div>
						</div>
					</div>

					<!-- Desktop: Sidebar -->
					<aside class="training-sidebar">
						<?php include(locate_template('components/training/sidebar.php')); ?>
					</aside>

					<!-- Main Content -->
					<div class="training-detail-main">
						<div class="training-detail-header training-listing-banner">
							<h1 class="training-detail-title"><?php the_title(); ?></h1>
							<?php if (get_field('sub_title')): ?>
								<p class="training-detail-subtitle"><?php echo get_field('sub_title'); ?></p>
							<?php endif; ?>
						</div>

						<?php if ($video_embed): ?>
							<div class="training-detail-video">
								<?php echo $video_embed; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>

							<div class="training-done-wrapper">
								<button class="training-done-btn" type="button"
									data-post-id="<?php echo esc_attr($current_post_id); ?>">
									<span class="training-done-text"><?php esc_html_e('Mark as done', 'holateam'); ?></span>
								</button>
							</div>
						<?php endif; ?>

						<?php if (get_the_content()): ?>
							<div class="training-detail-content">
								<?php the_content(); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #content -->
</div><!-- #single-wrapper -->

<?php
get_footer();
