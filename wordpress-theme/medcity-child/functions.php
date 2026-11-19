<?php

/**
 * Add child styles.
 */
function medcity_enqueue_styles()
{
    $parent_style = 'medcity-style';
    
    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array(
        $parent_style
    ));
}

add_action('wp_enqueue_scripts', 'medcity_enqueue_styles');
/**
add_action('wp_footer', function () {
    ?>
    <script>
    jQuery(function($){

        function updateBranchPhone() {
            var selected = $('.os-selectable-item.selected');
            var phone = selected.data('phone');

            if(phone){
                $('#lpt-branch-phone').html(
                    '<strong>Branch Phone:</strong> <a href="tel:'+phone+'">'+phone+'</a>'
                );
            }else{
                $('#lpt-branch-phone').html('');
            }
        }

        // Update when a branch is clicked
        $(document).on('click', '.os-selectable-item', function () {
            setTimeout(updateBranchPhone, 50);
        });

        // Also update if a branch is already preselected
        setTimeout(updateBranchPhone, 500);

    });
    </script>
    <?php
});
 */

add_action('wp_footer', function () {
    if (!wp_script_is('jquery', 'enqueued') && !wp_script_is('jquery', 'done')) { return; }
?>
<script>
jQuery(function($){

    function updateBranchPhone() {
        var phone = $('.os-selectable-item.selected').attr('data-phone');

		if (phone) {
			var tel = phone.replace(/\s+/g, '');

			$('#lpt-branch-phone').html(
				'<a href="tel:' + tel + '" style="text-decoration:none;color:inherit;">' + phone + '</a>'
			);
		}
    }

    // Run every 300ms because LatePoint rebuilds the DOM with AJAX
    setInterval(updateBranchPhone, 300);

});
</script>
<?php
});


/* ==========================================================================
 * Nairobi ENT performance tweaks (added Nov 2026)
 * Loads plugin assets only on the pages that actually use them.
 * To disable everything below, set NENT_PERF to false.
 * ========================================================================== */
if (!defined('NENT_PERF')) { define('NENT_PERF', true); }

function nent_page_has($needles) {
    static $cache = array();
    $id = get_queried_object_id();
    if (!$id) { return false; }
    if (!isset($cache[$id])) {
        $post = get_post($id);
        $cache[$id] = strtolower(($post ? $post->post_content : '') . ' ' . (string) get_post_meta($id, '_elementor_data', true));
    }
    foreach ((array) $needles as $n) {
        if (strpos($cache[$id], strtolower($n)) !== false) { return true; }
    }
    return false;
}

function nent_is_shop_context() {
    if (!function_exists('is_woocommerce')) { return false; }
    return is_woocommerce() || is_cart() || is_checkout() || is_account_page() || is_singular('product')
        || nent_page_has(array('woocommerce', 'add_to_cart', '[product', 'wc-block'));
}

function nent_trim_assets() {
    if (!NENT_PERF || is_admin() || (isset($_GET['elementor-preview'])) || (function_exists('is_customize_preview') && is_customize_preview())) { return; }

    $groups = array();

    if (!nent_is_shop_context()) {
        $groups[] = array(
            'styles'  => array('woocommerce-layout', 'woocommerce-smallscreen', 'woocommerce-general', 'wc-blocks-style', 'ph_booking_style', 'ph_booking_calendar_style'),
            'scripts' => array('wc-add-to-cart', 'woocommerce', 'wc-cart-fragments', 'ph_booking_general_script', 'ph_booking_product', 'jquery-blockui', 'wc-order-attribution', 'sourcebuster-js', 'medcity-woocommerce', 'googlesitekit-events-provider-woocommerce', 'wc-account-i18n'),
        );
    }
    if (!nent_page_has(array('latepoint'))) {
        $groups[] = array('styles' => array('latepoint-main-front'), 'scripts' => array('latepoint-vendor-front', 'latepoint-main-front'));
    }
    if (!nent_page_has(array('contact-form-7', 'wpcf7'))) {
        $groups[] = array('styles' => array('contact-form-7'), 'scripts' => array('contact-form-7', 'swv', 'google-recaptcha', 'wpcf7-recaptcha', 'googlesitekit-events-provider-contact-form-7'));
    }
    if (!is_singular('awsm_job_openings') && !is_post_type_archive('awsm_job_openings') && !nent_page_has(array('awsm', 'job_openings', 'job-openings'))) {
        $groups[] = array('styles' => array('awsm-jobs-general', 'awsm-jobs-style'), 'scripts' => array('awsm-job-scripts'));
    }
    if (!nent_page_has(array('visual-form-builder', 'vfb', 'visual_form_builder'))) {
        $groups[] = array('styles' => array('visual-form-builder-css', 'vfb-jqueryui-css'), 'scripts' => array());
    }

    foreach ($groups as $g) {
        foreach ($g['styles'] as $h)  { wp_dequeue_style($h); }
        foreach ($g['scripts'] as $h) { wp_dequeue_script($h); }
    }

    // Block library CSS is not needed on Elementor-built pages.
    if (function_exists('get_the_ID') && get_post_meta(get_queried_object_id(), '_elementor_edit_mode', true) === 'builder') {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
        wp_dequeue_style('classic-theme-styles');
    }
}
add_action('wp_enqueue_scripts', 'nent_trim_assets', 9999);
add_action('wp_print_footer_scripts', 'nent_trim_assets', 1);

// Remove emoji scripts (saves a request on every page).
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

/* ==========================================================================
 * SEO: make each page's banner title its main <h1> (added Nov 2026).
 * The first heading widget whose text matches the page title becomes <h1>,
 * but only if the page has no <h1> of its own.
 * ========================================================================== */
function nent_norm_text($s) { return strtolower(trim(preg_replace('/\s+/', ' ', html_entity_decode(wp_strip_all_tags($s), ENT_QUOTES, 'UTF-8')))); }
add_filter('elementor/widget/render_content', function ($content, $widget) {
    static $done = false;
    if ($done || is_admin() || !is_singular() || is_front_page()) { return $content; }
    $name = $widget->get_name();
    if ($name !== 'cms_heading' && $name !== 'heading') { return $content; }
    if (stripos($content, '<h1') !== false) { $done = true; return $content; }
    $title = nent_norm_text(get_the_title(get_queried_object_id()));
    $title = nent_norm_text(preg_replace('/\s+[–-]\s+Nairobi ENT.*$/u', '', $title));
    if (!preg_match('/<h([2-6])([^>]*)>(.*?)<\/h\1>/is', $content, $m)) { return $content; }
    $text = nent_norm_text($m[3]);
    if ($text === '' || ($text !== $title && strpos($title, $text) === false && strpos($text, $title) === false)) { return $content; }
    $done = true;
    return preg_replace('/<h' . $m[1] . '([^>]*)>(.*?)<\/h' . $m[1] . '>/is', '<h1$1>$2</h1>', $content, 1);
}, 10, 2);

/* Cache-bust the child stylesheet whenever it changes. */
add_action('wp_enqueue_scripts', function () {
    $f = get_stylesheet_directory() . '/style.css';
    if (wp_style_is('child-style', 'enqueued')) {
        wp_dequeue_style('child-style'); wp_deregister_style('child-style');
        wp_enqueue_style('child-style', get_stylesheet_uri(), array('medcity-style'), file_exists($f) ? filemtime($f) : null);
    }
}, 20);


/* Performance: lazy-load images below the header/hero (added Nov 2026). */
function nent_lazy_images($html) {
    $pos = stripos($html, 'content-container');
    if ($pos === false) { return $html; }
    $head = substr($html, 0, $pos); $body = substr($html, $pos);
    // Skip slider-revolution blocks (hero) - they manage their own loading.
    $parts = preg_split('/(<sr7-module.*?<\/sr7-module>)/is', $body, -1, PREG_SPLIT_DELIM_CAPTURE);
    if ($parts === false) { return $html; }
    $seen = 0;
    foreach ($parts as $i => $part) {
        if (stripos($part, '<sr7-module') === 0) { continue; }
        $parts[$i] = preg_replace_callback('/<img\b(?![^>]*\bloading=)([^>]*)>/i', function ($m) use (&$seen) {
            $seen++;
            if ($seen <= 1) { return '<img fetchpriority="high"' . $m[1] . '>'; }
            return '<img loading="lazy" decoding="async"' . $m[1] . '>';
        }, $part);
        if ($parts[$i] === null) { return $html; }
    }
    return $head . implode('', $parts);
}

/* SEO fallback: guarantee exactly one <h1> per page (added Nov 2026). */
add_action('template_redirect', function () {
    if (is_admin() || is_feed() || wp_doing_ajax() || (defined('REST_REQUEST') && REST_REQUEST) || isset($_GET['elementor-preview']) || is_customize_preview()) { return; }
    ob_start(function ($html) { return nent_footer_year(nent_img_alts(nent_single_h1(nent_lazy_images(nent_ensure_h1($html))))); });
}, 1);

function nent_ensure_h1($html) {
        if (stripos($html, '<html') === false || preg_match('/<h1[\s>]/i', $html)) { return $html; }
        $pos = stripos($html, 'content-container');
        if ($pos === false) { $pos = stripos($html, '<main'); }
        if ($pos === false) { return $html; }
        $head = substr($html, 0, $pos); $body = substr($html, $pos);
        if (is_front_page()) {
            $title = get_bloginfo('name') . ' – Expert Ear, Nose &amp; Throat Care in Kenya';
        } else {
            $title = esc_html(wp_strip_all_tags(get_the_title(get_queried_object_id())));
            $want = nent_norm_text($title);
            if (preg_match_all('/<h([2-4])([^>]*)>(.*?)<\/h\1>/is', $body, $all, PREG_OFFSET_CAPTURE)) {
                foreach ($all[0] as $i => $m) {
                    if (nent_norm_text($all[3][$i][0]) === $want) {
                        $new = '<h1 data-nent-was="h' . $all[1][$i][0] . '"' . $all[2][$i][0] . '>' . $all[3][$i][0] . '</h1>';
                        return $head . substr($body, 0, $m[1]) . $new . substr($body, $m[1] + strlen($m[0]));
                    }
                }
            }
        }
        $gt = strpos($body, '>');
        if ($gt === false) { return $html; }
        return $head . substr($body, 0, $gt + 1) . '<h1 class="screen-reader-text nent-sr-h1">' . $title . '</h1>' . substr($body, $gt + 1);
}


/* Clear the page cache automatically when this child theme's files change. */
add_action('admin_init', function () {
    $d = get_stylesheet_directory();
    $sig = (string) @filemtime($d . '/style.css') . '-' . (string) @filemtime($d . '/functions.php');
    foreach (array_merge(glob($d . '/nent/*') ?: array(), array($d . '/header.php', $d . '/footer.php', $d . '/front-page.php')) as $f) { $sig .= '-' . (string) @filemtime($f); }
    $sig .= '-' . (string) get_option('nent_redesign_live');
    if (get_option('nent_theme_sig') !== $sig) {
        update_option('nent_theme_sig', $sig, false);
        do_action('cache_enabler_clear_complete_cache');
        if (function_exists('autoptimize') || class_exists('autoptimizeCache')) { /* CSS bundle is content-hashed; no clear needed */ }
    }
});

/* Keep the footer copyright year current. */
function nent_footer_year($html) {
    return preg_replace('/(?:\x{00A9}|&copy;|&#169;)\s?20\d\d Nairobi ENT Clinic/u', '&copy; ' . date('Y') . ' Nairobi ENT Clinic', $html);
}

/* Redirect retired URLs (demo posts, demo categories/tags, broken links) - added Nov 2026. */
add_action('template_redirect', function () {
    if (!is_404()) { return; }
    $path = trim((string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $map = array(
        'solution/feeding-and-swallowing-therapy' => '/solution/swallowing/',
        'why-do-people-get-kidney-stones-in-the-summer' => '/blog/',
        'do-any-drugs-really-work-to-treat-coronavirus' => '/blog/',
        'why-coronavirus-cases-at-young-is-bad-news' => '/blog/',
        'tips-for-eating-healthy-when-youre-working-from-home' => '/blog/',
        '6-tips-to-protect-your-mental-health-when-youre-sick' => '/blog/',
        'unsure-about-wearing-face-mask-heres-how-and-why' => '/blog/',
        'heres-how-and-why-unsure-about-wearing-a-face-mask' => '/blog/',
        'https-nairobientclinic-com-8-reasons-to-visit-an-ent-specialist' => '/reasons-to-visit-an-ent-specialist/',
    );
    if (isset($map[$path])) { wp_safe_redirect(home_url($map[$path]), 301); exit; }
    if (preg_match('#^(category|tag)/(cardiology|laboratory|neurology|pathology|pediatric|uncategorized|covid-19|disease|highlight|infectious|insights|life-style|nutrition|tips)(/|$)#', $path)) {
        wp_safe_redirect(home_url('/blog/'), 301); exit;
    }
}, 5);

/* Keep only one <h1> per page: later ones become <h2> (same styling classes). */
function nent_single_h1($html) {
    $seen = 0;
    $out = preg_replace_callback('/<h1(\s[^>]*)?>(.*?)<\/h1>/is', function ($m) use (&$seen) {
        $seen++;
        return $seen === 1 ? $m[0] : '<h2' . $m[1] . '>' . $m[2] . '</h2>';
    }, $html);
    return $out === null ? $html : $out;
}

/* Fallback alt text for content photos that have none. */
function nent_img_alts($html) {
    $pos = stripos($html, 'content-container');
    if ($pos === false) { return $html; }
    $label = is_front_page() ? 'Nairobi ENT Clinic' : wp_strip_all_tags(get_the_title(get_queried_object_id())) . ' – Nairobi ENT Clinic';
    $label = esc_attr($label);
    $body = preg_replace_callback('/<img\b[^>]*>/i', function ($m) use ($label) {
        $t = $m[0];
        if (preg_match('/\balt="[^"]+"/i', $t) || !preg_match('#/uploads/[^"]+\.(jpe?g|webp)#i', $t)) { return $t; }
        $t = preg_replace('/\salt=""/i', '', $t);
        return preg_replace('/^<img\b/i', '<img alt="' . $label . '"', $t);
    }, substr($html, $pos));
    return $body === null ? $html : substr($html, 0, $pos) . $body;
}

/* 2026 redesign (new header, footer, homepage and page banners) – see /nent/setup.php. */
if (file_exists(get_stylesheet_directory() . '/nent/setup.php')) { require_once get_stylesheet_directory() . '/nent/setup.php'; }

/* Old design: Elementor Pro's sticky-header library must be loaded, or Elementor's
   page script stops early (breaking the full-width hero). Added Nov 2026 on rollback. */
add_action('wp_enqueue_scripts', function () {
    if (function_exists('nent_rd') && nent_rd()) return;
    if (wp_script_is('e-sticky', 'registered')) wp_enqueue_script('e-sticky');
}, 10000);

/* Old design: the hero slider can size itself before Elementor stretches its section to
   full width (now that pages load faster). A resize nudge after load makes it re-measure. */
add_action('wp_footer', function () {
    if (function_exists('nent_rd') && nent_rd()) return;
    echo "<script>window.addEventListener('load',function(){if(document.querySelector('sr7-module')){setTimeout(function(){window.dispatchEvent(new Event('resize'));},200);}});</script>\n";
}, 99);
