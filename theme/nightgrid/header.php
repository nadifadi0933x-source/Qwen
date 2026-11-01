<?php
/**
 * The header: doctype, head, sticky site header with branding, menu, search.
 *
 * @package NightGrid
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e('Skip to content', 'nightgrid'); ?></a>

<header class="site-header">
	<div class="wrap header-inner">
		<div class="site-branding">
			<a class="brand" href="<?php echo esc_url(home_url('/')); ?>" rel="home">
				<span class="logo-mark" aria-hidden="true"></span>
				<span class="site-title"><?php bloginfo('name'); ?></span>
			</a>
		</div>

		<nav class="main-navigation" id="site-navigation" aria-label="<?php esc_attr_e('Primary menu', 'nightgrid'); ?>">
			<?php
			wp_nav_menu([
				'theme_location' => 'primary',
				'container'      => false,
				'fallback_cb'    => 'nightgrid_fallback_menu',
			]);
			?>
		</nav>

		<?php get_search_form(); ?>

		<button class="nav-toggle" aria-expanded="false" aria-controls="site-navigation" aria-label="<?php esc_attr_e('Toggle menu', 'nightgrid'); ?>">
			<span></span><span></span><span></span>
		</button>
	</div>
</header>

<main id="main" class="site-main wrap">
