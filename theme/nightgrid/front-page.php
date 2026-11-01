<?php
/**
 * Front page: featured hero (sticky post if any) + latest grid.
 *
 * @package NightGrid
 */
get_header();

$sticky = get_option('sticky_posts');
$hero_args = [
    'posts_per_page'      => 1,
    'ignore_sticky_posts' => true,
];
if (!empty($sticky)) {
    $hero_args['post__in'] = $sticky;
}
$hero    = new WP_Query($hero_args);
$hero_id = 0;
?>

<?php if ($hero->have_posts()) : ?>
	<?php while ($hero->have_posts()) : $hero->the_post(); $hero_id = get_the_ID(); ?>
	<section class="hero" aria-label="<?php esc_attr_e('Featured', 'nightgrid'); ?>">
		<article class="hero-card">
			<?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail('nightgrid-hero'); ?>
			<?php else : ?>
				<img src="<?php echo esc_url(nightgrid_placeholder_url()); ?>" alt="">
			<?php endif; ?>
			<div class="hero-overlay" aria-hidden="true"></div>
			<div class="hero-info">
				<?php $cats = get_the_category(); if ($cats) : ?>
					<span class="badge"><?php echo esc_html($cats[0]->name); ?></span>
				<?php endif; ?>
				<h1 class="hero-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<p class="hero-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
				<div class="card-meta">
					<span><?php echo esc_html(get_the_date()); ?></span>
					<span><?php echo esc_html(number_format_i18n(nightgrid_get_views())); ?> <?php esc_html_e('views', 'nightgrid'); ?></span>
				</div>
				<p style="margin:16px 0 0"><a class="btn" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'nightgrid'); ?></a></p>
			</div>
		</article>
	</section>
	<?php endwhile; wp_reset_postdata(); ?>
<?php endif; ?>

<section class="section">
	<div class="section-head">
		<h2 class="section-title"><?php esc_html_e('Latest uploads', 'nightgrid'); ?></h2>
		<a class="see-all" href="<?php echo esc_url(home_url('/?post_type=post')); ?>"><?php esc_html_e('View all &rarr;', 'nightgrid'); ?></a>
	</div>
	<?php
	$grid = new WP_Query([
		'posts_per_page' => 18,
		'post__not_in'   => $hero_id ? [$hero_id] : [],
	]);
	nightgrid_render_grid($grid);
	?>
</section>

<?php
get_footer();
