<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_shortcode('year', 'year_shortcode');
function year_shortcode(){
	return date('Y');
}

function site_social() {
	ob_start();
?>
	<?php if ( have_rows( 'social_media', 'option' ) ) : ?>
	<ul class="social-media-list list-inline">
		<?php while ( have_rows( 'social_media', 'option' ) ) : the_row(); ?>
			<?php
				$channel = get_sub_field( 'social_media_channel' );
				$icon = get_sub_field( 'social_media_fa_icon' );
				$url = get_sub_field( 'social_media_url' );
			?>
			<li class="social-media-item list-inline-item">
				<a target="_blank" href="<?php echo $url; ?>" class="channel-<?php echo $channel; ?>">
				<?php if( $icon != '' ) : ?>
					<span class='<?php echo $icon; ?>'></span>
				<?php else: ?>
					<i class='fa fa-<?php echo $channel; ?>'></i>
				<?php endif; ?>
				</a>
			</li>
		<?php endwhile; ?>
	</ul>	
<?php endif; ?>

<?php
	return ob_get_clean();
}
add_shortcode( 'site_social', 'site_social' );
