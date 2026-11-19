<?php
/* Nairobi ENT 2026 redesign – bootstrapping. Switch: option "nent_redesign_live" (1 = live for everyone).
   While it is off, only logged-in administrators see the new design. Admins can add ?nent_old=1 to see the old one. */
if (!defined('ABSPATH')) exit;
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/icons.php';
require_once __DIR__ . '/page-hero.php';

function nent_rd() {
    static $on = null;
    if ($on !== null) return $on;
    if (is_admin() || (defined('REST_REQUEST') && REST_REQUEST) || wp_doing_ajax()) return $on = false;
    if (isset($_GET['elementor-preview']) || isset($_GET['nent_old'])) return $on = false;
    $on = (bool) get_option('nent_redesign_live') || current_user_can('manage_options');
    return $on;
}

function nent_asset_ver($rel) {
    $f = get_stylesheet_directory() . '/' . $rel;
    return file_exists($f) ? (string) filemtime($f) : '1';
}

add_action('wp_enqueue_scripts', function () {
    if (!nent_rd()) return;
    wp_enqueue_style('nent-fonts', 'https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap', array(), null);
    wp_enqueue_style('nent-rd', get_stylesheet_directory_uri() . '/nent/nent.css', array(), nent_asset_ver('nent/nent.css'));
    wp_enqueue_script('nent-lenis', get_stylesheet_directory_uri() . '/nent/lenis.min.js', array(), '1.1.13', true);
    wp_enqueue_script('nent-rd', get_stylesheet_directory_uri() . '/nent/nent.js', array('nent-lenis'), nent_asset_ver('nent/nent.js'), true);
}, 20);

/* ElementsKit's header/footer builder swaps in its own header and footer; the redesign uses ours instead. */
add_action('wp', function () {
    if (!nent_rd()) return;
    global $wp_filter;
    foreach (array('get_header', 'get_footer') as $hook) {
        if (empty($wp_filter[$hook])) continue;
        foreach ($wp_filter[$hook]->callbacks as $prio => $cbs) {
            foreach ($cbs as $cb) {
                if (is_array($cb['function']) && is_object($cb['function'][0]) && strpos(get_class($cb['function'][0]), 'ElementsKit_Lite\\Modules\\Header_Footer') === 0) {
                    remove_action($hook, $cb['function'], $prio);
                }
            }
        }
    }
}, 99);

/* Homepage: the new page is hand-built, so drop the page-builder, slider and theme bundles it no longer uses. */
function nent_home_trim() {
    if (!nent_rd() || !is_front_page()) return;
    $keep = '/^(nent|nta-|google_gtagjs|googlesitekit|admin-bar|dashicons|jquery-core|jquery-migrate|jquery$|hoverintent)/i';
    foreach (wp_styles()->queue as $h) { if (!preg_match($keep, $h)) wp_dequeue_style($h); }
    foreach (wp_scripts()->queue as $h) { if (!preg_match($keep, $h)) wp_dequeue_script($h); }
}
add_action('wp_enqueue_scripts', 'nent_home_trim', 100000);
add_action('wp_footer', 'nent_home_trim', 1);
add_action('wp_print_footer_scripts', 'nent_home_trim', 5);

add_action('wp_head', function () {
    if (!nent_rd()) return;
    echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    if (is_front_page()) {
        echo '<link rel="preload" as="image" href="' . esc_url(nent_img('2024/10/IMG_2720-1024x683.jpg')) . '" imagesrcset="' . esc_url(nent_img('2024/10/IMG_2720-768x512.jpg')) . ' 768w, ' . esc_url(nent_img('2024/10/IMG_2720-1024x683.jpg')) . ' 1024w, ' . esc_url(nent_img('2024/10/IMG_2720.jpg')) . ' 1600w" imagesizes="(max-width: 900px) 92vw, 46vw">' . "\n";
    }
}, 1);

/* Admin switch: /wp-admin/?nent_redesign=on (live for everyone) or =off (back to the old design; admins still preview the new one). */
add_action('admin_init', function () {
    if (!isset($_GET['nent_redesign']) || !current_user_can('manage_options')) return;
    update_option('nent_redesign_live', $_GET['nent_redesign'] === 'on' ? 1 : 0, true);
    do_action('cache_enabler_clear_complete_cache');
    wp_safe_redirect(home_url('/')); exit;
});

/* Debug helper for admins: ?nent_dbg=1 lists enqueued handles. */
add_action('wp_footer', function () {
    if (!isset($_GET['nent_dbg']) || !current_user_can('manage_options')) return;
    echo "\n<!-- nent styles: " . esc_html(implode(',', wp_styles()->done)) . " -->\n<!-- nent scripts: " . esc_html(implode(',', wp_scripts()->done)) . " -->\n";
}, 9999);

/* Inner pages: the new banner replaces the old Elementor title banner (a first section holding a single heading). */
add_action('template_redirect', function () {
    if (!nent_rd() || is_front_page() || is_feed() || is_customize_preview()) return;
    ob_start('nent_strip_old_banner');
}, 2);

function nent_strip_old_banner($html) {
    $ci = strpos($html, 'content-inner');
    if ($ci === false) return $html;
    $head = substr($html, 0, $ci);
    $body = substr($html, $ci);
    // Theme Builder title widgets duplicate the new banner title.
    $b = preg_replace('#<div[^>]*elementor-widget-theme-page-title[^>]*>\s*<div class="elementor-widget-container">\s*<(h[1-6])[^>]*>.*?</\1>\s*</div>\s*</div>#is', '', $body, 1);
    if ($b !== null) $body = $b;
    $s = strpos($body, '<section class="elementor-section elementor-top-section');
    if ($s === false || $s > 3000) return $head . $body;
    $e = strpos($body, '</section>', $s);
    if ($e === false) return $head . $body;
    $chunk = substr($body, $s, $e + 10 - $s);
    if (strpos($chunk, '<section', 10) !== false) return $head . $body;
    $widgets = preg_match_all('/data-widget_type="([^"]+)"/', $chunk, $m);
    if ($widgets === 1 && preg_match('/^(cms_heading|heading)\./', $m[1][0]) && strpos($chunk, 'background_background') !== false) {
        $body = substr($body, 0, $s) . substr($body, $e + 10);
    }
    return $head . $body;
}
