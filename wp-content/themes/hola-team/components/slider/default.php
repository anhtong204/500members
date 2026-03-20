<div class="<?php echo $container_class; ?>">
	<?php 
		$mode               = $row['mode'];
		$autoplay           = $row['autoplay'];
		$infinite_loop      = $row['infinite_loop'];
		$transition_speed   = $row['transition_speed'];
		$dots               = $row['show_dots'];
		$mode               = $mode == 'fade' ? true : false;

		$settings = array(
			'autoplay'  => $autoplay,
			'infinite'  => $infinite_loop,
			'speed'     => $transition_speed,
			'fade'      => $mode,
			'dots'      => $dots,
		);
		?>

	<?php if ( ! empty( $row['list_slider'] ) ) : ?>
		<div class="holateam-slides" data-settings='<?php echo json_encode( $settings ); ?>'>
			
			<?php 
			foreach ( $row['list_slider'] as $slide ) :
				$background         = $slide['image'];
				$title              = $slide['title'];
				$slide_description  = $slide['description'];
				$button             = $slide['button'];
				
				$img_url = isset( $background['url'] ) ? $background['url'] : '';
				?>
				<div>
					<div class="slider-item">
						<div class="container">
							<div class="row align-items-center">
								<div class="col-md">
									<div class="wrap-info">

										<?php if ( $title ) : ?>
										<<?php echo get_row_index() == 1 ? 'h1' : 'h2'; ?> class="h1 slider-title"><?php echo $title; ?></<?php echo get_row_index() == 1 ? 'h1' : 'h2'; ?>>
										<?php endif; ?>

										<?php if ( $slide_description ) : ?>
										<div class="description"><?php echo $slide_description; ?></div>
										<?php endif; ?>

										<?php render_link( $button, 'btn btn-primary' ); ?>

										<?php if ( $settings['dots'] ) : ?>
										<div class="holateam-dots"></div>
										<?php endif; ?>
									</div>
								</div>

								<?php if ( $img_url ) : ?>
								<div class="col-md-6">
									<img class="slider-img" src="<?php echo $img_url; ?>" alt="<?php echo get_image_alt( $background ); ?>">
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>

<?php
	$layout = null;
	$component_name = null;
?>
