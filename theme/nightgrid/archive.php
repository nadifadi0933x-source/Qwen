<?php
/**
 * Archive (category, tag, author, date).
 *
 * @package NightGrid
 */
get_header();
?>
<section class="section">
	<header class="section-head" style="display:block">
		<h1 class="section-title"><?php the_archive_title(); ?></h1>
		<?php the_archive_description('<p class="section-desc">', '</p>'); ?>
	</header>
	<?php nightgrid_render_grid(); ?>
</section>
<?php
get_footer();
