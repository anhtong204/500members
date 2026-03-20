<div class="<?php echo $container_class; ?>">
	<?php get_component_title( $component_h1, $component_title, $component_sub_title ); ?>

	<?php if ( $body ) : ?>
		<div class="block-content">
			<?php echo apply_filters( 'the_content', $body ); ?>
		</div>
	<?php endif; ?>    

	<?php render_link( $component_link, 'btn' ); ?>
</div>
