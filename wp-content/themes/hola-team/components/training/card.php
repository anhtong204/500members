<?php
/**
 * Training Card Component
 *
 * Shared card partial used by both default and listing layouts.
 * Expects to be called inside a WP_Query loop (the_post() already called).
 */
$training_duration = get_field('training_duration');
$training_media_type = get_field('training_media_type');
$training_media_link = get_field('training_media_link');
$card_terms = get_the_terms(get_the_ID(), 'training_category');
$term_slugs = array();
if (!empty($card_terms) && !is_wp_error($card_terms)) {
	foreach ($card_terms as $card_term) {
		$term_slugs[] = sanitize_html_class($card_term->slug);
	}
}
$term_classes = implode(' ', $term_slugs);
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
			<?php if ($training_duration): ?>
				<div class="training-card-category">
					<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M7 13.5C10.5899 13.5 13.5 10.5899 13.5 7C13.5 3.41015 10.5899 0.5 7 0.5C3.41015 0.5 0.5 3.41015 0.5 7C0.5 10.5899 3.41015 13.5 7 13.5Z"
							stroke="#003F5A" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M6.27777 4.11111V7.72223H9.88888" stroke="#003F5A" stroke-linecap="round"
							stroke-linejoin="round" />
					</svg>
					<div class="training-card-duration"><?php echo esc_html($training_duration); ?></div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article>
