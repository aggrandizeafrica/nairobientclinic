<?php
/**
 * Plugin Name: Nairobi ENT – Holiday Speech Therapy Campaign
 * Description: Adds the /holiday-speech-therapy/ landing page with a booking form. Bookings are emailed to the clinic and saved under "Holiday Bookings" in the admin menu.
 * Version: 1.0.0
 * Author: Nairobi ENT Clinic
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) exit;

define('NENT_HC_SLUG', 'holiday-speech-therapy');
define('NENT_HC_DIR', plugin_dir_path(__FILE__));
define('NENT_HC_URL', plugin_dir_url(__FILE__));
define('NENT_HC_VER', '1.0.0');

/* ---------- Page: create on activation, render with our own template ---------- */

register_activation_hook(__FILE__, function () {
    nent_hc_register_post_type();
    $page = get_page_by_path(NENT_HC_SLUG, OBJECT, 'page');
    if (!$page) {
        $id = wp_insert_post(array(
            'post_title'   => 'Holiday Speech Therapy',
            'post_name'    => NENT_HC_SLUG,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => 'This page is displayed by the "Nairobi ENT – Holiday Speech Therapy Campaign" plugin. Edit the offer text under Holiday Bookings → Settings.',
            'post_excerpt' => 'December holiday speech and language therapy for children and adults at Nairobi ENT Clinic.',
        ));
        if ($id && !is_wp_error($id)) update_option('nent_hc_page_id', $id);
    } else {
        update_option('nent_hc_page_id', $page->ID);
    }
    flush_rewrite_rules();
});

function nent_hc_is_page() {
    $id = (int) get_option('nent_hc_page_id');
    return is_page() && ($id ? is_page($id) : is_page(NENT_HC_SLUG));
}

add_filter('template_include', function ($template) {
    return nent_hc_is_page() ? NENT_HC_DIR . 'templates/campaign.php' : $template;
}, 99999);

/* ---------- Settings ---------- */

function nent_hc_opt($key) {
    $defaults = array(
        'offer'    => '',
        'email'    => get_option('admin_email'),
        'whatsapp' => '254725147392',
    );
    $o = (array) get_option('nent_hc_settings', array());
    return isset($o[$key]) && $o[$key] !== '' ? $o[$key] : $defaults[$key];
}

/* ---------- Bookings: stored as a private post type ---------- */

function nent_hc_register_post_type() {
    register_post_type('nent_hc_booking', array(
        'labels' => array(
            'name' => 'Holiday Bookings', 'singular_name' => 'Holiday Booking',
            'menu_name' => 'Holiday Bookings', 'all_items' => 'All bookings',
            'edit_item' => 'Booking', 'search_items' => 'Search bookings',
            'not_found' => 'No bookings yet.',
        ),
        'public' => false, 'show_ui' => true, 'show_in_menu' => true, 'show_in_rest' => false,
        'menu_icon' => 'dashicons-calendar-alt', 'menu_position' => 26,
        'supports' => array('title', 'editor'),
        'capability_type' => 'page', 'map_meta_cap' => true,
        'capabilities' => array('create_posts' => 'do_not_allow'),
    ));
}
add_action('init', 'nent_hc_register_post_type');

add_filter('manage_nent_hc_booking_posts_columns', function ($cols) {
    return array('cb' => $cols['cb'], 'title' => 'Name', 'nent_phone' => 'Phone', 'nent_clinic' => 'Clinic', 'nent_when' => 'Preferred date / time', 'date' => 'Received');
});
add_action('manage_nent_hc_booking_posts_custom_column', function ($col, $id) {
    $m = function ($k) use ($id) { return esc_html((string) get_post_meta($id, $k, true)); };
    if ($col === 'nent_phone')  echo '<a href="tel:' . esc_attr(preg_replace('/[^\d+]/', '', get_post_meta($id, 'phone', true))) . '">' . $m('phone') . '</a>';
    if ($col === 'nent_clinic') echo $m('clinic');
    if ($col === 'nent_when')   echo trim($m('date') . ' ' . $m('slot'));
}, 10, 2);

/* ---------- Booking endpoint: POST /wp-json/nent/v1/holiday-booking ---------- */

add_action('rest_api_init', function () {
    register_rest_route('nent/v1', '/holiday-booking', array(
        'methods' => 'POST',
        'permission_callback' => '__return_true',
        'callback' => 'nent_hc_handle_booking',
    ));
});

function nent_hc_handle_booking(WP_REST_Request $req) {
    $p = $req->get_json_params();
    if (!is_array($p)) $p = $req->get_body_params();
    if (!empty($p['_gotcha'])) return new WP_REST_Response(array('ok' => true), 200); // spam bot

    $allowed = array(
        'who'     => array('Child', 'Teen', 'Adult'),
        'concern' => array('Speech delay', 'Stammering', 'Pronunciation', 'Language', 'Voice', 'Swallowing', 'Not sure'),
        'slot'    => array('Morning', 'Afternoon', 'Saturday'),
        'clinic'  => array('Nairobi Hospital Clinic', 'Aga Khan University Hospital Clinic', 'Greenspan Mall Clinic (Donholm)', 'Eastleigh Clinic', 'Kisumu Clinic (Mega City)'),
    );
    $d = array(
        'name'  => sanitize_text_field(isset($p['name']) ? $p['name'] : ''),
        'phone' => sanitize_text_field(isset($p['phone']) ? $p['phone'] : ''),
        'email' => sanitize_email(isset($p['email']) ? $p['email'] : ''),
        'date'  => preg_match('/^\d{4}-\d{2}-\d{2}$/', isset($p['date']) ? $p['date'] : '') ? $p['date'] : '',
        'notes' => sanitize_textarea_field(isset($p['notes']) ? $p['notes'] : ''),
    );
    foreach ($allowed as $k => $list) {
        $v = isset($p[$k]) ? (string) $p[$k] : '';
        $d[$k] = in_array($v, $list, true) ? $v : $list[0];
    }
    $d['name']  = mb_substr($d['name'], 0, 120);
    $d['phone'] = mb_substr($d['phone'], 0, 40);
    $d['notes'] = mb_substr($d['notes'], 0, 2000);

    if ($d['name'] === '' || strlen(preg_replace('/\D/', '', $d['phone'])) < 9) {
        return new WP_REST_Response(array('ok' => false, 'error' => 'missing_fields'), 400);
    }

    // Simple flood guard: at most 6 requests per hour from one address.
    $ip  = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    $key = 'nent_hc_rl_' . md5($ip);
    $n   = (int) get_transient($key);
    if ($n >= 6) return new WP_REST_Response(array('ok' => false, 'error' => 'rate_limited'), 429);
    set_transient($key, $n + 1, HOUR_IN_SECONDS);

    $lines = array(
        'Name'       => $d['name'],
        'Phone'      => $d['phone'],
        'Email'      => $d['email'] ?: '-',
        'Session for'=> $d['who'],
        'Concern'    => $d['concern'],
        'Clinic'     => $d['clinic'],
        'Date'       => $d['date'] ?: 'No preference',
        'Time'       => $d['slot'],
        'Notes'      => $d['notes'] ?: '-',
    );
    $body = '';
    foreach ($lines as $k => $v) $body .= $k . ': ' . $v . "\n";

    $id = wp_insert_post(array(
        'post_type' => 'nent_hc_booking', 'post_status' => 'private',
        'post_title' => $d['name'], 'post_content' => $body,
    ));
    if ($id && !is_wp_error($id)) {
        foreach (array('phone', 'email', 'who', 'concern', 'clinic', 'date', 'slot') as $k) update_post_meta($id, $k, $d[$k]);
    }

    $headers = array();
    if ($d['email']) $headers[] = 'Reply-To: ' . $d['name'] . ' <' . $d['email'] . '>';
    wp_mail(
        nent_hc_opt('email'),
        'New holiday speech therapy booking: ' . $d['name'] . ' (' . $d['clinic'] . ')',
        "A new booking request came in from the holiday speech therapy page.\n\n" . $body .
        "\nPlease call to confirm.\nAll bookings: " . admin_url('edit.php?post_type=nent_hc_booking'),
        $headers
    );

    return new WP_REST_Response(array('ok' => true), 200);
}

/* ---------- Settings screen: Holiday Bookings → Settings ---------- */

add_action('admin_menu', function () {
    add_submenu_page('edit.php?post_type=nent_hc_booking', 'Campaign settings', 'Settings', 'manage_options', 'nent-hc-settings', 'nent_hc_settings_page');
});
add_action('admin_init', function () {
    register_setting('nent_hc', 'nent_hc_settings', array('sanitize_callback' => function ($in) {
        return array(
            'offer'    => sanitize_text_field(isset($in['offer']) ? $in['offer'] : ''),
            'email'    => sanitize_email(isset($in['email']) ? $in['email'] : ''),
            'whatsapp' => preg_replace('/\D/', '', isset($in['whatsapp']) ? $in['whatsapp'] : ''),
        );
    }));
});
function nent_hc_settings_page() {
    $o = (array) get_option('nent_hc_settings', array());
    $v = function ($k) use ($o) { return esc_attr(isset($o[$k]) ? $o[$k] : ''); };
    ?>
    <div class="wrap">
      <h1>Holiday campaign settings</h1>
      <p>Landing page: <a href="<?php echo esc_url(home_url('/' . NENT_HC_SLUG . '/')); ?>" target="_blank"><?php echo esc_html(home_url('/' . NENT_HC_SLUG . '/')); ?></a></p>
      <form method="post" action="options.php">
        <?php settings_fields('nent_hc'); ?>
        <table class="form-table" role="presentation">
          <tr><th scope="row"><label for="nent-offer">Holiday offer</label></th>
            <td><input id="nent-offer" class="large-text" name="nent_hc_settings[offer]" value="<?php echo $v('offer'); ?>" placeholder="e.g. Holiday assessment at KES X,XXX, valid until 10 January">
            <p class="description">Shown under the buttons at the top of the page. Leave empty to hide it.</p></td></tr>
          <tr><th scope="row"><label for="nent-email">Send bookings to</label></th>
            <td><input id="nent-email" type="email" class="regular-text" name="nent_hc_settings[email]" value="<?php echo $v('email'); ?>" placeholder="<?php echo esc_attr(get_option('admin_email')); ?>">
            <p class="description">Empty = the site's admin email. Every booking is also saved under Holiday Bookings.</p></td></tr>
          <tr><th scope="row"><label for="nent-wa">WhatsApp number</label></th>
            <td><input id="nent-wa" class="regular-text" name="nent_hc_settings[whatsapp]" value="<?php echo $v('whatsapp'); ?>" placeholder="254725147392">
            <p class="description">International format without + or spaces. Empty = 254725147392 (the number used by the site's WhatsApp button).</p></td></tr>
        </table>
        <?php submit_button(); ?>
      </form>
    </div>
    <?php
}

add_filter('plugin_action_links_' . plugin_basename(__FILE__), function ($links) {
    array_unshift($links, '<a href="' . esc_url(admin_url('edit.php?post_type=nent_hc_booking&page=nent-hc-settings')) . '">Settings</a>');
    return $links;
});
