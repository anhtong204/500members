<?php
$modules = $row['modules'] ?? [];
$training_terms = get_terms(
	array(
		'taxonomy' => 'training_category',
		'hide_empty' => true,
		'include' => $modules,
	)
);
$default_img = get_template_directory_uri() . '/assets/img/default.png';
?>

<div class="<?php echo esc_attr($container_class); ?> training-component">
	<div class="training-header">
		<?php get_component_title($component_h1, $component_title, $component_sub_title, true); ?>
	</div>

	<?php if (!empty($training_terms) && !is_wp_error($training_terms)): ?>
		<div class="training-list">
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
								<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
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
		<p><?php esc_html_e('No training categories found.', 'holateam'); ?></p>
	<?php endif; ?>

	<div class="training-footer">
		<?php render_link($component_link, 'btn btn-primary'); ?>
	</div>
</div>