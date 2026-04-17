<?php
$items_per_page = absint($row['items_per_page'] ?? 8);
$training_terms = get_terms(
	array(
		'taxonomy' => 'training_category',
		'hide_empty' => true,
	)
);
$training_query = new WP_Query(
	array(
		'post_type' => 'training',
		'posts_per_page' => $items_per_page,
		'post_status' => 'publish',
	)
);
?>

<?php if ($row['show_search_form']): ?>
	<div class="training-search-section">
		<div class="container-small">
			<div class="training-header">
				<?php if ($row['title_search']): ?>
					<h2 class="training-title-search">
						<?php echo $row['title_search']; ?>
					</h2>
				<?php endif; ?>

				<?php if ($row['description_search']): ?>
					<div class="training-description-search">
						<?php echo $row['description_search']; ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="training-search">
				<input type="text" class="training-search-input" placeholder="<?php esc_attr_e('Search', 'holateam'); ?>"
					aria-label="<?php esc_attr_e('Search training modules', 'holateam'); ?>">
				<button type="button" class="training-search-btn" aria-label="<?php esc_attr_e('Search', 'holateam'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
						stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="11" cy="11" r="8" />
						<line x1="21" y1="21" x2="16.65" y2="16.65" />
					</svg>
				</button>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="<?php echo esc_attr($container_class); ?> training-component">
	<div class="training-header">
		<?php get_component_title($component_h1, $component_title, $component_sub_title); ?>
	</div>

	<?php if (!empty($training_terms) && !is_wp_error($training_terms)): ?>
		<div class="training-filters">
			<button type="button" class="training-filter active"
				data-category="all"><?php esc_html_e('All modules', 'holateam'); ?></button>
			<?php foreach ($training_terms as $term): ?>
				<button type="button" class="training-filter"
					data-category="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ($training_query->have_posts()): ?>
		<div class="training-list">
			<?php while ($training_query->have_posts()):
				$training_query->the_post(); ?>
				<?php
				$training_duration = get_field('training_duration');
				$training_media_type = get_field('training_media_type');
				$training_media_link = get_field('training_media_link');
				$training_terms = get_the_terms(get_the_ID(), 'training_category');
				$term_slugs = array();
				$term_names = array();
				if (!empty($training_terms) && !is_wp_error($training_terms)) {
					foreach ($training_terms as $term) {
						$term_slugs[] = sanitize_html_class($term->slug);
						$term_names[] = esc_html($term->name);
					}
				}
				$term_classes = implode(' ', $term_slugs);
				$primary_term = !empty($term_names) ? reset($term_names) : '';
				$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
				$card_link = get_permalink();
				?>
				<article class="training-item" data-category="<?php echo esc_attr($term_classes ? $term_classes : 'all'); ?>">
					<div class="training-card">
						<a href="<?php echo esc_url($card_link); ?>">
							<?php if ($thumbnail_url): ?>
								<div class="training-card-image"
									style="background-image:url('<?php echo esc_url($thumbnail_url); ?>')"></div>
							<?php endif; ?>
						</a>
						<div class="training-card-body">
							<h3 class="training-card-title">
								<a href="<?php echo esc_url($card_link); ?>"><?php the_title(); ?></a>
							</h3>
							<?php if ($primary_term): ?>
								<div class="training-card-category">
									<?php echo esc_html($primary_term); ?>
									<span class="training-card-separator">|</span>
									<?php if ($training_duration): ?>
										<div class="training-card-duration"><?php echo esc_html($training_duration); ?></div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php else: ?>
		<p><?php esc_html_e('No training items found.', 'holateam'); ?></p>
	<?php endif; ?>
</div>