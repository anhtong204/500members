<?php
/**
 * Template for displaying training_category taxonomy archives.
 *
 * URL: /training-category/{slug}/
 *
 * @package holateam
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = get_theme_mod('holateam_container_type');
$current_term = get_queried_object();
$current_term_slug = $current_term ? $current_term->slug : '';
$current_post_id = null;
$paged = max(1, get_query_var('paged'));

$training_terms = get_terms(
	array(
		'taxonomy' => 'training_category',
		'hide_empty' => true,
	)
);
?>

<div class="wrapper" id="archive-wrapper">
	<div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">
		<main class="site-main" id="main">

			<div class="container-small pb-1x">
				<div class="training-component training-listing-layout">
					<div class="training-listing-wrapper">
						<!-- Mobile: Category trigger button -->
						<button class="training-mobile-trigger" type="button">
							<svg width="18" height="18" viewBox="0 0 18 18" fill="none"
								xmlns="http://www.w3.org/2000/svg">
								<path d="M2.25 4.5H15.75" stroke="currentColor" stroke-width="1.5"
									stroke-linecap="round" />
								<path d="M2.25 9H15.75" stroke="currentColor" stroke-width="1.5"
									stroke-linecap="round" />
								<path d="M2.25 13.5H15.75" stroke="currentColor" stroke-width="1.5"
									stroke-linecap="round" />
							</svg>
							<?php esc_html_e('All lessons', 'holateam'); ?>
						</button>

						<!-- Mobile: Category modal -->
						<div class="training-mobile-modal">
							<div class="training-mobile-modal-content">
								<div class="training-mobile-modal-header">
									<h4 class="training-mobile-modal-title">
										<?php esc_html_e('', 'holateam'); ?>
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
						<div class="training-listing-main">
							<!-- Header Banner -->
							<div class="training-listing-banner">
								<h1 class="component-title">
									<?php echo esc_html($current_term->name); ?>
								</h1>
								<?php if ($current_term->description): ?>
									<p class="component-sub-title">
										<?php echo esc_html($current_term->description); ?>
									</p>
								<?php endif; ?>
							</div>

							<?php if (have_posts()): ?>
								<h3 class="training-listing-section-title">
									<?php
									printf(
										/* translators: %s: category name */
										esc_html__('%s lessons', 'holateam'),
										esc_html($current_term->name)
									);
									?>
								</h3>

								<div class="training-listing-grid">
									<?php while (have_posts()):
										the_post(); ?>
										<?php include(locate_template('components/training/card.php')); ?>
									<?php endwhile; ?>
								</div>

								<?php
								// Pagination using the main query
								holateam_pagination();
								?>

							<?php else: ?>
								<p>
									<?php esc_html_e('No training items found in this category.', 'holateam'); ?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #content -->
</div><!-- #archive-wrapper -->

<?php
get_footer();
