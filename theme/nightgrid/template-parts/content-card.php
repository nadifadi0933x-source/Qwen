<?php
/**
 * Poster card used in grids.
 *
 * @package NightGrid
 */
$cats = get_the_category();
?>
<article class="card">
	<a class="card-thumb" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
		<?php if (has_post_thumbnail()) : ?>
			<?php the_post_thumbnail('nightgrid-card'); ?>
		<?php else : ?>
			<img src="<?php echo esc_url(nightgrid_placeholder_url()); ?>" alt="" loading="lazy">
		<?php endif; ?>
		<?php if ($cats) : ?>
			<span class="card-badge"><?php echo esc_html($cats[0]->name); ?></span>
		<?php endif; ?>
		<span class="card-hover"><?php esc_html_e('View', 'nightgrid'); ?></span>
	</a>
	<div class="card-body">
		<h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="card-meta">
			<span><?php echo esc_html(get_the_date('M j, Y')); ?></span>
			<span><?php echo esc_html(number_format_i18n(nightgrid_get_views())); ?> <?php esc_html_e('views', 'nightgrid'); ?></span>
		</div>
	</div>
</article>
