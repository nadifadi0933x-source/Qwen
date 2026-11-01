<?php
/**
 * Shown when no posts match.
 *
 * @package NightGrid
 */
?>
<div class="not-found" style="padding:50px 0">
	<h2><?php esc_html_e('Nothing found', 'nightgrid'); ?></h2>
	<p><?php esc_html_e('Try a different search or browse the latest uploads.', 'nightgrid'); ?></p>
	<?php get_search_form(); ?>
</div>
