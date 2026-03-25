<div class="<?php echo $container_class; ?> component-image_text">
	<?php
	$image   = $row['image'] ?? null;
	$text    = $body ?? '';
	$reverse = ! empty( $row['reverse_layout'] );
	$img_url = is_array( $image ) && ! empty( $image['url'] ) ? $image['url'] : '';
	$img_alt = is_array( $image ) ? ( $image['alt'] ?? '' ) : '';
	?>

	<?php if ( ! empty( $text ) || ! empty( $img_url ) ) : ?>
		<div class="image-text-row row align-items-center <?php echo $reverse ? 'image-text-reverse flex-row-reverse' : ''; ?>">
			<?php if ( $img_url ) : ?>
				<div class="col-12 col-md-6 image-text-image">
					<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" />
				</div>
			<?php endif; ?>

			<div class="col-12 <?php echo $img_url ? 'col-md-6' : 'col-md-12'; ?> image-text-content">
				<div class="content-wrapper">
					<?php get_component_title( $component_h1, $component_title, $component_sub_title ); ?>
	
					<?php echo apply_filters( 'the_content', $text ); ?>
	
					<?php render_link( $component_link, 'btn btn-' . $component_link_style ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>

