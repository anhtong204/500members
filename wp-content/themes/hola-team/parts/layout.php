<?php
/**
 * Template part for displaying primary ACF Flexible Layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package holateam
 */
?>

<?php
if ( class_exists( 'acf' ) ) {
	if ( have_rows( 'components' ) ) {
		$layout_position = 0;

		while ( have_rows( 'components' ) ) {
			$layout_position++;
			$row = the_row( true );
			include get_template_directory() . '/components/components.php';
		}
	}
}
?>
