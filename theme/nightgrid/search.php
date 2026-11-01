<?php
/**
 * Search results.
 *
 * @package NightGrid
 */
get_header();
?>
<section class="section">
	<header class="section-head" style="display:block">
		<h1 class="section-title"><?php printf(esc_html__('Search results for: %s', 'nightgrid'), '<span>' . esc_html(get_search_query()) . '</span>'); ?></h1>
	</header>
	<?php get_search_form(); ?>
	<div style="height:22px"></div>
	<?php nightgrid_render_grid(); ?>
</section>
<?php
get_footer();
