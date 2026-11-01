<?php
/**
 * NightGrid theme functions.
 *
 * @package NightGrid
 */

if (!defined('NIGHTGRID_VERSION')) {
    define('NIGHTGRID_VERSION', '1.0.0');
}

/**
 * Theme setup: menus, thumbnails, HTML5 support, image sizes.
 */
function nightgrid_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-logo', [
        'height'      => 40,
        'width'       => 40,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ]);
    register_nav_menus([
        'primary' => __('Primary Menu', 'nightgrid'),
        'footer'  => __('Footer Menu', 'nightgrid'),
    ]);
    // Poster-style card thumbnails + a wide hero image.
    add_image_size('nightgrid-card', 400, 600, true);
    add_image_size('nightgrid-hero', 1280, 760, true);
}
add_action('after_setup_theme', 'nightgrid_setup');

/**
 * Content width.
 */
function nightgrid_content_width() {
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'nightgrid_content_width');

/**
 * Enqueue styles & scripts.
 */
function nightgrid_scripts() {
    wp_enqueue_style(
        'nightgrid-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Vazirmatn:wght@400;600;800&display=swap',
        [],
        null
    );
    wp_enqueue_style('nightgrid-style', get_stylesheet_uri(), [], NIGHTGRID_VERSION);
    wp_enqueue_script('nightgrid-main', get_template_directory_uri() . '/js/main.js', [], NIGHTGRID_VERSION, true);
}
add_action('wp_enqueue_scripts', 'nightgrid_scripts');

/**
 * Fallback menu when no menu is assigned.
 */
function nightgrid_fallback_menu() {
    echo '<ul class="menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'nightgrid') . '</a></li>';
    wp_list_pages(['title_li' => '', 'depth' => 1]);
    echo '</ul>';
}

/**
 * Excerpt tweaks.
 */
function nightgrid_excerpt_length() {
    return 24;
}
add_filter('excerpt_length', 'nightgrid_excerpt_length');

function nightgrid_excerpt_more() {
    return '&hellip;';
}
add_filter('excerpt_more', 'nightgrid_excerpt_more');

/* ------------------------------------------------------------------
 * Post view counter (stored in post meta, like image-board sites show).
 * ----------------------------------------------------------------- */
function nightgrid_get_views($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    return (int) get_post_meta($post_id, 'nightgrid_views', true);
}

function nightgrid_bump_views($post_id) {
    if (!$post_id || wp_is_post_revision($post_id)) {
        return;
    }
    update_post_meta($post_id, 'nightgrid_views', nightgrid_get_views($post_id) + 1);
}

/* ------------------------------------------------------------------
 * Card grid renderer + pagination.
 * ----------------------------------------------------------------- */
function nightgrid_render_grid($query = null) {
    global $wp_query;
    $q = $query ?: $wp_query;

    if (!$q->have_posts()) {
        get_template_part('template-parts/content', 'none');
        return;
    }

    echo '<div class="grid">';
    while ($q->have_posts()) {
        $q->the_post();
        get_template_part('template-parts/content', 'card');
    }
    echo '</div>';

    nightgrid_pagination($q);

    if ($q !== $wp_query) {
        wp_reset_postdata();
    }
}

function nightgrid_pagination($query = null) {
    global $wp_query;
    $q = $query ?: $wp_query;
    $total = (int) $q->max_num_pages;
    if ($total < 2) {
        return;
    }
    $current = $q === $wp_query
        ? max(1, (int) get_query_var('paged'))
        : max(1, (int) $q->get('paged'));

    $links = paginate_links([
        'total'     => $total,
        'current'   => $current,
        'mid_size'  => 1,
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
        'type'      => 'array',
    ]);
    if (empty($links)) {
        return;
    }
    echo '<nav class="pagination" aria-label="' . esc_attr__('Posts navigation', 'nightgrid') . '"><ul>';
    foreach ($links as $link) {
        echo '<li>' . $link . '</li>';
    }
    echo '</ul></nav>';
}

/**
 * Placeholder thumbnail used when a post has no featured image.
 */
function nightgrid_placeholder_url() {
    return get_template_directory_uri() . '/assets/placeholder.svg';
}
