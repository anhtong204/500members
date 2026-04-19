<?php
/**
 * Training Sidebar Component (Shared)
 *
 * Used by: listing layout, taxonomy archive, and single training detail.
 *
 * Expected variables:
 * - $training_terms    (array)       — All training_category terms
 * - $current_term_slug (string|null) — Slug of the currently active category
 * - $current_post_id   (int|null)    — ID of the current training post (single page only)
 */

if (empty($training_terms) || is_wp_error($training_terms)) {
	return;
}

$active_slug = isset($current_term_slug) ? $current_term_slug : '';
$active_post_id = isset($current_post_id) ? (int) $current_post_id : 0;
$all_active = empty($active_slug);
?>

<ul class="training-sidebar-categories">
	<li class="training-sidebar-category training-sidebar-category--all<?php echo $all_active ? ' active' : ''; ?>"
		data-term="all">
		<a href="/free-training/" class="training-sidebar-category-btn<?php echo $all_active ? ' active' : ''; ?>">
			<?php esc_html_e('All lessons', 'holateam'); ?>
		</a>
	</li>
	<?php foreach ($training_terms as $term):
		$term_link = get_term_link($term);
		if (is_wp_error($term_link)) {
			continue;
		}

		$term_trainings = new WP_Query(array(
			'post_type' => 'training',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'training_category',
					'field' => 'term_id',
					'terms' => $term->term_id,
				),
			),
		));

		$is_active = ($active_slug === $term->slug);
		?>
		<li class="training-sidebar-category<?php echo $is_active ? ' active' : ''; ?>"
			data-term="<?php echo esc_attr($term->slug); ?>">
			<a href="<?php echo esc_url($term_link); ?>"
				class="training-sidebar-category-btn<?php echo $is_active ? ' active' : ''; ?>">
				<?php echo esc_html($term->name); ?>
			</a>

			<?php if ($term_trainings->have_posts()): ?>
				<ul class="training-sidebar-lessons">
					<?php while ($term_trainings->have_posts()):
						$term_trainings->the_post();
						$duration = get_field('training_duration');
						$lesson_id = get_the_ID();
						$is_current = ($active_post_id && $lesson_id === $active_post_id);
						?>
						<li class="training-sidebar-lesson<?php echo $is_current ? ' is-current' : ''; ?>"
							data-post-id="<?php echo esc_attr($lesson_id); ?>">
							<a href="<?php echo esc_url(get_permalink()); ?>" class="training-sidebar-lesson-link">
								<span class="training-sidebar-lesson-icon-wrapper">
									<?php if ($is_current): ?>
										<span class="training-sidebar-lesson-icon training-sidebar-lesson-icon--playing">
											<svg width="18" height="18" viewBox="0 0 14 14" fill="none"
												xmlns="http://www.w3.org/2000/svg">
												<circle cx="7" cy="7" r="6.5" stroke="#F70056" />
												<path d="M5.5 4.5L9.5 7L5.5 9.5V4.5Z" fill="#F70056" />
											</svg>
										</span>
									<?php endif; ?>
									<span class="training-sidebar-lesson-icon training-sidebar-lesson-icon--done"
										style="display:none;">
										<svg width="18" height="18" viewBox="0 0 14 14" fill="none"
											xmlns="http://www.w3.org/2000/svg">
											<path d="M3 7L6 10L11 4" stroke="#F70056" stroke-width="2" stroke-linecap="round"
												stroke-linejoin="round" />
										</svg>
									</span>
								</span>
								<span class="training-sidebar-lesson-title"><?php the_title(); ?></span>
								<?php if ($duration): ?>
									<span class="training-sidebar-lesson-duration"><?php echo esc_html($duration); ?></span>
								<?php endif; ?>
							</a>
						</li>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
		</li>
		<?php
		wp_reset_postdata();
	endforeach; ?>
</ul>