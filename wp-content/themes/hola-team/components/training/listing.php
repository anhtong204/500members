<?php
$modules = $row['modules'] ?? [];
$current_term_slug = null;
$current_post_id = null;
$default_img = get_template_directory_uri() . '/assets/img/default.png';
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
			<?php esc_html_e('Popular lessons', 'holateam'); ?>
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

		<?php
		$training_terms = get_terms(
			array(
				'taxonomy' => 'training_category',
				'hide_empty' => false,
				'include' => $modules
			)
		);
		?>

		<!-- Main Content -->
		<div class="training-listing-main">
			<!-- Header Banner -->
			<div class="training-listing-banner">
				<?php get_component_title($component_h1, $component_title, $component_sub_title, true); ?>
			</div>

			<?php if (!empty($training_terms) && !is_wp_error($training_terms)): ?>
				<h3 class="training-listing-section-title"><?php esc_html_e('Popular Lessons', 'holateam'); ?></h3>

				<div class="training-listing-grid">
					<?php foreach ($training_terms as $term):
						$term_link = get_term_link($term);
						if (is_wp_error($term_link)) {
							continue;
						}
						$term_image = get_field('image', $term);
						$term_img_url = !empty($term_image['url']) ? $term_image['url'] : $default_img;
						$lesson_count = $term->count;
						?>
						<article class="training-item">
							<div class="training-card">
								<a href="<?php echo esc_url($term_link); ?>">
									<div class="training-card-image"
										style="background-image:url('<?php echo esc_url($term_img_url); ?>')">
									</div>
								</a>
								<div class="training-card-body">
									<h3 class="training-card-title">
										<a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($term->name); ?></a>
									</h3>
									<div class="training-card-category">
										<svg width="14" height="14" viewBox="0 0 14 14" fill="none"
											xmlns="http://www.w3.org/2000/svg">
											<path
												d="M7 13.5C10.5899 13.5 13.5 10.5899 13.5 7C13.5 3.41015 10.5899 0.5 7 0.5C3.41015 0.5 0.5 3.41015 0.5 7C0.5 10.5899 3.41015 13.5 7 13.5Z"
												stroke="#003F5A" stroke-linecap="round" stroke-linejoin="round" />
											<path d="M6.27777 4.11111V7.72223H9.88888" stroke="#003F5A" stroke-linecap="round"
												stroke-linejoin="round" />
										</svg>
										<div class="training-card-duration">
											<?php printf(
												/* translators: %d: number of lessons */
												esc_html(_n('%d lesson', '%d lessons', $lesson_count, 'holateam')),
												$lesson_count
											); ?>
										</div>
									</div>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php else: ?>
				<p><?php esc_html_e('No popular lessons found.', 'holateam'); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>