<?php
/**
 * Custom search form.
 *
 * @package NightGrid
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
	<label class="screen-reader-text" for="s-<?php echo esc_attr(uniqid()); ?>"><?php esc_html_e('Search for:', 'nightgrid'); ?></label>
	<input type="search" name="s" id="s-<?php echo esc_attr(uniqid()); ?>" placeholder="<?php esc_attr_e('Search&hellip;', 'nightgrid'); ?>" value="<?php echo get_search_query(); ?>">
	<button type="submit" aria-label="<?php esc_attr_e('Search', 'nightgrid'); ?>">&#128269;</button>
</form>
