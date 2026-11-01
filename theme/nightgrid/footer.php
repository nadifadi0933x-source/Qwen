<?php
/**
 * The footer.
 *
 * @package NightGrid
 */
?>
</main><!-- #main -->

<footer class="site-footer">
	<div class="wrap footer-grid">
		<div class="footer-col footer-about">
			<a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
				<span class="logo-mark" aria-hidden="true"></span>
				<span><?php bloginfo('name'); ?></span>
			</a>
			<p><?php bloginfo('description'); ?></p>
		</div>
		<div class="footer-col">
			<h3><?php esc_html_e('Menu', 'nightgrid'); ?></h3>
			<?php
			wp_nav_menu([
				'theme_location' => 'footer',
				'container'      => false,
				'fallback_cb'    => false,
				'depth'          => 1,
			]);
			?>
		</div>
		<div class="footer-col">
			<h3><?php esc_html_e('Tags', 'nightgrid'); ?></h3>
			<div class="tagcloud"><?php wp_tag_cloud(['number' => 14, 'smallest' => 11, 'largest' => 16]); ?></div>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="wrap">
			&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?> &middot;
			<?php printf(esc_html__('Powered by %s', 'nightgrid'), '<a href="https://wordpress.org/">WordPress</a>'); ?> &middot;
			<?php esc_html_e('NightGrid theme', 'nightgrid'); ?>
		</div>
	</div>
</footer>

<button class="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'nightgrid'); ?>">&uarr;</button>

<?php wp_footer(); ?>
</body>
</html>
