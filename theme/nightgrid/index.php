<?php
/**
 * Blog index / fallback loop.
 *
 * @package NightGrid
 */
get_header();
?>
<section class="section">
	<div class="section-head">
		<h1 class="section-title"><?php esc_html_e('Latest posts', 'nightgrid'); ?></h1>
	</div>
	<?php nightgrid_render_grid(); ?>
</section>
<?php
get_footer();
