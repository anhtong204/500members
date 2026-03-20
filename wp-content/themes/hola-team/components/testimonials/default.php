<div class="<?php echo $container_class; ?>">
	<?php get_component_title( $component_h1, $component_title, $component_sub_title ); ?>

	<?php if ( ! empty( $row['testimonials'] ) ) : ?>
		<?php
		$settings = array(
			'dots' => false,
			'arrows' => false,
			'infinite' => true,
            'autoplay' => true,
			'speed' => 600,
			'slidesToShow' => 3,
			'slidesToScroll' => 3,
			'responsive' => array(
				array(
					'breakpoint' => 992,
					'settings' => array(
						'slidesToShow' => 2,
						'slidesToScroll' => 2,
					),
				),
				array(
					'breakpoint' => 768,
					'settings' => array(
						'slidesToShow' => 1,
						'slidesToScroll' => 1,
					),
				),
			),
		);
		?>

		<div class="holateam-testimonials" data-settings='<?php echo json_encode( $settings ); ?>'>
			<?php foreach ( $row['testimonials'] as $item ) :
				$quote       = $item['testimonial_quote'] ?? '';
				$author      = $item['testimonial_author'] ?? '';
				$author_job  = $item['testimonial_author_title'] ?? '';
				$avatar      = $item['testimonial_author_avatar'] ?? null;
				$avatar_url  = is_array( $avatar ) && isset( $avatar['url'] ) ? $avatar['url'] : '';
				$avatar_alt  = is_array( $avatar ) ? ( $avatar['alt'] ?? '' ) : '';
			?>

				<div class="testimonial-card">
					<div class="testimonial-text">
						<span class="quote-open" aria-hidden="true">
                            <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.85778e-06 9.79069C4.85778e-06 9.34474 0.0405461 8.87851 0.121628 8.39202C0.567582 5.35143 2.00679 2.55409 4.43927 -1.09524e-05L5.6555 0.912166C4.19602 2.45273 3.44601 3.83113 3.40547 5.04737C3.44601 5.73657 3.95277 6.22306 4.92576 6.50685C5.20955 6.58794 5.51361 6.68929 5.83794 6.81091C7.41905 7.54065 8.2096 8.77716 8.2096 10.5204C8.2096 11.1691 8.06771 11.7772 7.78392 12.3448C7.05417 13.8854 5.87848 14.6556 4.25683 14.6556C3.68925 14.6556 3.16222 14.5543 2.67572 14.3516C0.891911 13.7029 4.85778e-06 12.1826 4.85778e-06 9.79069ZM9.79071 9.79069C9.79071 9.34474 9.83125 8.87851 9.91233 8.39202C10.3583 5.35143 11.7975 2.55409 14.23 -1.09524e-05L15.4462 0.912166C13.9867 2.45273 13.2367 3.83113 13.1962 5.04737C13.2367 5.73657 13.7435 6.22306 14.7165 6.50685C15.0003 6.58794 15.3043 6.68929 15.6286 6.81091C17.2097 7.54065 18.0003 8.77716 18.0003 10.5204C18.0003 11.1691 17.8584 11.7772 17.5746 12.3448C16.8449 13.8854 15.6692 14.6556 14.0475 14.6556C13.48 14.6556 12.9529 14.5543 12.4664 14.3516C10.6826 13.7029 9.79071 12.1826 9.79071 9.79069Z" fill="#003952"/>
                            </svg>
                        </span>
						<?php echo apply_filters( 'the_content', $quote ); ?>
						<span class="quote-close" aria-hidden="true">
                            <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.0003 4.86494C18.0003 5.31089 17.9598 5.77711 17.8787 6.26361C17.4327 9.3042 15.9935 12.1015 13.561 14.6556L12.3448 13.7435C13.8043 12.2029 14.5543 10.8245 14.5948 9.60826C14.5543 8.91906 14.0475 8.43256 13.0745 8.14877C12.7908 8.06769 12.4867 7.96634 12.1624 7.84471C10.5813 7.11497 9.79071 5.87847 9.79071 4.13519C9.79071 3.48653 9.9326 2.87842 10.2164 2.31084C10.9461 0.770273 12.1218 -9.6038e-06 13.7435 -9.6038e-06C14.3111 -9.6038e-06 14.8381 0.101343 15.3246 0.304049C17.1084 0.952709 18.0003 2.473 18.0003 4.86494ZM8.2096 4.86494C8.2096 5.31089 8.16906 5.77711 8.08798 6.26361C7.64202 9.3042 6.20281 12.1015 3.77034 14.6556L2.5541 13.7435C4.01358 12.2029 4.7636 10.8245 4.80414 9.60826C4.7636 8.91906 4.25683 8.43256 3.28384 8.14877C3.00005 8.06769 2.696 7.96634 2.37167 7.84471C0.790558 7.11497 4.85778e-06 5.87847 4.85778e-06 4.13519C4.85778e-06 3.48653 0.141899 2.87842 0.425688 2.31084C1.15543 0.770273 2.33112 -9.6038e-06 3.95277 -9.6038e-06C4.52035 -9.6038e-06 5.04739 0.101343 5.53388 0.304049C7.31769 0.952709 8.2096 2.473 8.2096 4.86494Z" fill="#003952"/>
                            </svg>
                        </span>
					</div>

					<div class="testimonial-author">
						<?php if ( $avatar_url ) : ?>
							<div class="testimonial-avatar"><img src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $avatar_alt ); ?>" /></div>
						<?php endif; ?>

						<div class="testimonial-info">
							<?php if ( $author ) : ?>
								<div class="testimonial-author-name"><?php echo esc_html( $author ); ?></div>
							<?php endif; ?>
							<?php if ( $author_job ) : ?>
								<div class="testimonial-author-role"><?php echo esc_html( $author_job ); ?></div>
							<?php endif; ?>
						</div>
					</div>
				</div>

			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
