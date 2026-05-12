<?php
$current_term_slug = null;
$current_post_id = null;
$training_paged = max(1, get_query_var('paged'));
$training_terms = get_terms(
	array(
		'taxonomy' => 'training_category',
		'hide_empty' => true,
	)
);
$training_query = new WP_Query(
	array(
		'post_type' => 'training',
		'posts_per_page' => 15,
		'paged' => $training_paged,
		'post_status' => 'publish',
	)
);
?>

<div class="<?php echo esc_attr($container_class); ?> training-component training-listing-layout">
	<div class="training-listing-wrapper">
		<!-- Mobile: Category trigger button -->
		<button class="training-mobile-trigger" type="button">
			<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M2.25 4.5H15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
				<path d="M2.25 9H15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
				<path d="M2.25 13.5H15.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
			</svg>
			<?php esc_html_e('All lessons', 'holateam'); ?>
		</button>

		<!-- Mobile: Category modal -->
		<div class="training-mobile-modal">
			<div class="training-mobile-modal-content">
				<div class="training-mobile-modal-header">
					<h4 class="training-mobile-modal-title"><?php esc_html_e('', 'holateam'); ?></h4>
					<button class="training-mobile-modal-close" type="button" aria-label="Close">
						<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M15 5L5 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
							<path d="M5 5L15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
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
				<?php get_component_title($component_h1, $component_title, $component_sub_title, true); ?>
			</div>

			<?php if ($training_query->have_posts()): ?>
				<h3 class="training-listing-section-title"><?php esc_html_e('Popular lessons', 'holateam'); ?></h3>

				<div class="training-listing-grid">
					<?php while ($training_query->have_posts()):
						$training_query->the_post(); ?>
						<?php include(locate_template('components/training/card.php')); ?>
					<?php endwhile; ?>
				</div>

				<?php
				// Pagination
				holateam_pagination(array(
					'total' => $training_query->max_num_pages,
					'current' => $training_paged,
				));
				?>

				<?php wp_reset_postdata(); ?>
			<?php else: ?>
				<p><?php esc_html_e('No training items found.', 'holateam'); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>