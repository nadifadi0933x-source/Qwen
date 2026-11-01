<?php
/**
 * Static page.
 *
 * @package NightGrid
 */
get_header();

if (have_posts()) :
	while (have_posts()) :
		the_post();
		?>
		<article id="page-<?php the_ID(); ?>" <?php post_class('page-article'); ?>>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<?php if (has_post_thumbnail()) : ?>
				<figure class="single-thumb"><?php the_post_thumbnail('large'); ?></figure>
			<?php endif; ?>
			<div class="entry-content"><?php the_content(); ?></div>
		</article>
		<?php
	endwhile;
endif;

get_footer();
