<?php
/**
 * 404 page.
 *
 * @package NightGrid
 */
get_header();
?>
<section class="not-found">
	<div class="code">404</div>
	<h1><?php esc_html_e('Page not found', 'nightgrid'); ?></h1>
	<p><?php esc_html_e('The page you are looking for does not exist or has been moved.', 'nightgrid'); ?></p>
	<?php get_search_form(); ?>
	<p style="margin-top:22px"><a class="btn" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Back to home', 'nightgrid'); ?></a></p>
</section>
<?php
get_footer();
