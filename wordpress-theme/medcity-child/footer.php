<?php
/* Nairobi ENT child theme footer. Uses the 2026 redesign when enabled, otherwise the original theme footer. */
if (!function_exists('nent_rd') || !nent_rd()) { require get_template_directory() . '/footer.php'; return; }
if (!is_front_page()) { echo '</div></div>'; }
require get_stylesheet_directory() . '/nent/footer-bar.php';
?>
</div>
<?php wp_footer(); ?>
</body>
</html>
