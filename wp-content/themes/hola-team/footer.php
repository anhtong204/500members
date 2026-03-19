<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package holateam
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('holateam_container_type');
?>

<div class="wrapper" id="wrapper-footer">
	<div class="<?php echo esc_attr($container); ?>">
		<div class="row mb-4">
			<div class="col-12 text-center">
				<nav class="footer-nav d-flex flex-wrap justify-content-center gap-4 fw-bold">
					<?php
					$menu_location = 'footer';

					if ( ! has_nav_menu( $menu_location ) ) {
						$menu_location = 'primary';
					}

					$locations = get_nav_menu_locations();
					$menu      = ! empty( $locations[ $menu_location ] ) ? wp_get_nav_menu_object( $locations[ $menu_location ] ) : false;

					if ( $menu ) {
						$menu_items = wp_get_nav_menu_items( $menu->term_id );

						if ( $menu_items ) {
							foreach ( $menu_items as $item ) {
								$target = $item->target ? ' target="' . esc_attr( $item->target ) . '"' : '';
								$rel    = $item->xfn ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
								echo '<a href="' . esc_url( $item->url ) . '"' . $target . $rel . ' style="color: inherit; text-decoration: none; font-size: 14px; letter-spacing: 0.5px;">' . esc_html( $item->title ) . '</a>';
							}
						}
					}
					?>
				</nav>
			</div>
		</div>

		<div class="row">
			<div class="col-12 text-center footer-contact">
				<?php
				$contact_html = '';
				if ( function_exists( 'get_field' ) ) {
					$contact_info = get_field( 'contact_main_info', 'option' );
					if ( ! empty( $contact_info['contact_main_description'] ) ) {
						$contact_html = $contact_info['contact_main_description'];
					}
				}

				if ( ! $contact_html ) {
					$contact_html = '<div class="fw-bold mb-1">JBlake Consulting, Inc</div>' .
						'<div>2110 Kaneka St. #160</div>' .
						'<div>Lihue, HI 96766</div>' .
						'<div>+808-652-5210</div>' .
						'<div>themedicaregeek@gmail.com</div>';
				}

				echo wp_kses_post( $contact_html );
				?>
			</div>
		</div>
	</div><!-- container end -->
</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>