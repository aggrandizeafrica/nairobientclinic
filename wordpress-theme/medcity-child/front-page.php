<?php
/* Nairobi ENT homepage. Uses the 2026 redesign when enabled, otherwise the original Elementor homepage. */
if (!function_exists('nent_rd') || !nent_rd()) { require get_template_directory() . '/page.php'; return; }
get_header();
require get_stylesheet_directory() . '/nent/home.php';
get_footer();
