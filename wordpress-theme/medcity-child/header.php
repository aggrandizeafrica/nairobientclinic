<?php
/* Nairobi ENT child theme header. Uses the 2026 redesign when enabled, otherwise the original theme header. */
if (!function_exists('nent_rd') || !nent_rd()) { require get_template_directory() . '/header.php'; return; }
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#3d0b5c">
<?php wp_head(); ?>
</head>
<body <?php body_class('nent-rd'); ?>>
<?php if (function_exists('wp_body_open')) { wp_body_open(); } ?>
<div id="page" class="site">
<?php
require get_stylesheet_directory() . '/nent/header-bar.php';
if (!is_front_page()) {
    nent_page_hero();
    echo '<div id="content" class="site-content"><div class="content-inner">';
}
