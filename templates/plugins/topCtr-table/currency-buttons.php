<?php
/**
 * Add currency buttons to tinyMCE editor.
 */
add_action('init', 'currency_buttons');
function currency_buttons() {
    add_filter("mce_external_plugins", "add_currency_buttons");
    add_filter('mce_buttons', 'register_currency_buttons');
}

function add_currency_buttons($plugin_array) {
    $plugin_array['Currency'] = plugin_dir_url(__FILE__) . '/js/currency-buttons.js';
    return $plugin_array;
}

function register_currency_buttons($buttons) {
    array_push($buttons, 'euroSign', 'poundSign', 'vSign');
    return $buttons;
}
