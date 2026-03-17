<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package holateam
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'holateam_container_type' );
?>

<div class="wrapper" id="wrapper-footer">

	<div class="footer-info">
			<div class="<?php echo esc_attr( $container ); ?>">
				<div class="row">
					<div class="col-md-4 left">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>

					<div class="col-md-4 center">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>

					<div class="col-md-4 right">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>
				</div>
			</div>
		</div>

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">

						<?php // holateam_site_info(); ?>

					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!--col end -->

		</div><!-- row end -->

	</div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

