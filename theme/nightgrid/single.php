<?php
/**
 * Single post.
 *
 * @package NightGrid
 */
get_header();

if (have_posts()) :
	while (have_posts()) :
		the_post();
		nightgrid_bump_views(get_the_ID());
		$cats = get_the_category();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
			<header class="single-head">
				<?php if ($cats) : ?>
					<span class="badge"><?php echo esc_html($cats[0]->name); ?></span>
				<?php endif; ?>
				<h1 class="single-title"><?php the_title(); ?></h1>
				<div class="card-meta single-meta">
					<span><?php echo esc_html(get_the_date()); ?></span>
					<span><?php echo esc_html(number_format_i18n(nightgrid_get_views())); ?> <?php esc_html_e('views', 'nightgrid'); ?></span>
					<span><?php comments_number(esc_html__('0 comments', 'nightgrid'), esc_html__('1 comment', 'nightgrid'), esc_html__('% comments', 'nightgrid')); ?></span>
				</div>
			</header>

			<?php if (has_post_thumbnail()) : ?>
				<figure class="single-thumb"><?php the_post_thumbnail('large'); ?></figure>
			<?php endif; ?>

			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages([
					'before' => '<nav class="page-links">' . esc_html__('Pages:', 'nightgrid'),
					'after'  => '</nav>',
				]);
				?>
			</div>

			<?php the_tags('<div class="post-tags">', ' ', '</div>'); ?>

			<nav class="post-nav" aria-label="<?php esc_attr_e('Post navigation', 'nightgrid'); ?>">
				<div class="prev"><?php previous_post_link('%link', '&larr; %title'); ?></div>
				<div class="next"><?php next_post_link('%link', '%title &rarr;'); ?></div>
			</nav>
		</article>

		<section class="section related">
			<div class="section-head">
				<h2 class="section-title"><?php esc_html_e('You may also like', 'nightgrid'); ?></h2>
			</div>
			<?php
			$related = new WP_Query([
				'posts_per_page' => 4,
				'post__not_in'   => [get_the_ID()],
				'category__in'   => wp_get_post_categories(get_the_ID()),
			]);
			nightgrid_render_grid($related);
			?>
		</section>
		<?php
	endwhile;
endif;

get_footer();
