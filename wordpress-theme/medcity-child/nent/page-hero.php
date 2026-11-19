<?php
/* Nairobi ENT redesign – inner page banner with title + breadcrumb. */
if (!defined('ABSPATH')) exit;

function nent_page_hero_data() {
    $crumbs = array();
    $title = '';
    if (is_404()) {
        $title = 'Page not found';
    } elseif (is_search()) {
        $title = 'Search results for “' . get_search_query() . '”';
    } elseif (is_home()) {
        $title = 'Health Blog';
    } elseif (function_exists('is_shop') && is_shop()) {
        $title = 'Shop';
    } elseif (is_archive()) {
        $title = wp_strip_all_tags(get_the_archive_title());
        $title = preg_replace('/^(Category|Tag|Archives|Author):\s*/i', '', $title);
        $crumbs[] = array('Blog', home_url('/blog/'));
    } elseif (is_singular()) {
        $post = get_queried_object();
        $title = single_post_title('', false);
        $type = get_post_type($post);
        if ($type === 'post') {
            $crumbs[] = array('Blog', home_url('/blog/'));
        } elseif ($type === 'doctor') {
            $crumbs[] = array('Doctors', home_url('/doctors/'));
        } elseif ($type === 'service') {
            $crumbs[] = array('Services', home_url('/about-us/'));
        } elseif ($type === 'clinics' || $type === 'clinic') {
            $crumbs[] = array('Clinics', home_url('/clinics/'));
        } elseif ($type === 'page' && $post->post_parent) {
            foreach (array_reverse(get_post_ancestors($post)) as $a) {
                $crumbs[] = array(get_the_title($a), get_permalink($a));
            }
        }
    } else {
        $title = wp_get_document_title();
    }
    return array($title, $crumbs);
}

function nent_page_hero() {
    list($title, $crumbs) = nent_page_hero_data();
    if ($title === '') return;
    ?>
    <section class="nent-phero">
      <div class="nent-phero__bg" aria-hidden="true"><span class="nent-blob nent-blob--a"></span><span class="nent-blob nent-blob--b"></span><span class="nent-hero__grid"></span></div>
      <div class="nent-wrap nent-phero__inner">
        <nav class="nent-crumbs nent-anim" aria-label="Breadcrumb">
          <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
          <?php foreach ($crumbs as $c) : ?><span aria-hidden="true">/</span><a href="<?php echo esc_url($c[1]); ?>"><?php echo esc_html($c[0]); ?></a><?php endforeach; ?>
          <span aria-hidden="true">/</span><span aria-current="page"><?php echo esc_html($title); ?></span>
        </nav>
        <h1 class="nent-phero__title nent-anim" style="--d:1"><?php echo esc_html($title); ?></h1>
        <?php if (is_singular('post')) : ?>
          <p class="nent-phero__meta nent-anim" style="--d:2"><?php echo esc_html(get_the_date('j F Y')); ?></p>
        <?php endif; ?>
      </div>
    </section>
    <?php
}
