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

<div class="<?php echo esc_attr($container_class); ?> training-component">
	<div class="training-header">
		<?php get_component_title($component_h1, $component_title, $component_sub_title, true); ?>

		<?php render_link($component_link, 'btn btn-primary'); ?>
	</div>

	<?php if ($training_query->have_posts()): ?>
		<div class="training-list">
			<?php while ($training_query->have_posts()):
				$training_query->the_post(); ?>
				<?php include(locate_template('components/training/card.php')); ?>
			<?php endwhile; ?>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php else: ?>
		<p><?php esc_html_e('No training items found.', 'holateam'); ?></p>
	<?php endif; ?>
</div>