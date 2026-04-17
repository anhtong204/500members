<?php
/**
 * Template Name: Container Components Page
 *
 * @package holateam
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>
<div class="container-small-xs container-component-page">
    <?php locate_template('parts/layout.php', true); ?>
</div>
<?php
get_footer();
