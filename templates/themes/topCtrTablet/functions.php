<?php
//ini_set('display_errors', 'On');error_reporting(E_ALL | E_STRICT);

require_once 'functions-table.php';
require_once 'functions-reviews.php';
require_once 'functions-editor-styles.php';
require_once 'theme-settings.php';

add_action('init', 'eshopsession', 1);
if (!function_exists('eshopsession')) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/admin_lead_manager/includes/config.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/admin_lead_manager/includes/functions.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/admin_lead_manager/includes/classes/db.php';
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/admin_lead_manager/includes/classes/lead.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/admin_lead_manager/includes/classes/Mobile_Detect.php');

    function eshopsession() {

        if (!session_id()) {
            session_start();
        }
        if (!isset($_SESSION['lead_id'])) {
            global $db_config, $sites, $db;
            $db = DBC::GetDefault($db_config);
            $lead = new lead();
        }
    }
}


add_action('admin_init', 'register_scripts_admin_init');
function register_scripts_admin_init() {
    if (!is_admin()) return;

    $jsPath = '/wp-content/themes/' . get_stylesheet() . '/admin/js/';

    wp_register_script('jQueryUiScript', $jsPath . 'jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js', array('jquery'));
    wp_enqueue_script('jQueryUiScript');

    wp_register_style('jQueryUiStyle', $jsPath . 'jquery-ui-1.10.4.custom/css/cupertino/jquery-ui-topctr-style.css'); //jquery-ui-1.10.4.custom.min.css');
    wp_enqueue_style('jQueryUiStyle');

    wp_register_style('loadingAnimation', '/wp-content/themes/' . get_stylesheet() . '/admin/loadingAnimation/style.css');
    wp_enqueue_style('loadingAnimation');

    wp_register_script('lengExtension', $jsPath . 'lengExtension.js');
    wp_enqueue_script('lengExtension');
    wp_register_script('underscore-min', $jsPath . 'underscore-min.js');
    wp_enqueue_script('underscore-min');
    wp_register_script('pagePosts', $jsPath . 'pagePosts.js');
    wp_enqueue_script('pagePosts');
    wp_register_script('pryorityMetaBoxScript_position_dialog', $jsPath . 'position_dialog.js', array('jquery'));
    wp_enqueue_script('pryorityMetaBoxScript_position_dialog');

    wp_register_script('pryorityMetaBoxScript', $jsPath . 'script.js', array('jquery', 'pagePosts', 'script_utill', 'script_help'), '', true);
    wp_enqueue_script('pryorityMetaBoxScript');

    wp_register_script('bonuses', $jsPath . 'bonuses.js', array('pryorityMetaBoxScript'), '', true);
    wp_enqueue_script('bonuses');

    wp_register_style('pryorityMetaBoxStyle', $jsPath . '../style.css');
    wp_enqueue_style('pryorityMetaBoxStyle');

    wp_enqueue_style('wp-pointer');
    wp_enqueue_script('wp-pointer');

    wp_register_script('script_help', $jsPath . 'script_help.js', array('jquery'), true);
    wp_register_script('script_utill', $jsPath . 'utill.js', array('jquery'));

    remove_meta_box('commentsdiv', 'page', 'normal');

}
/**
 * Calls the class on the post edit screen.
 */
function createMetaBox() {
    require_once (get_theme_root() . '/' . get_stylesheet() . '/admin/page_meta_box/PryorityMetaBox.php');
    new PryorityMetaBox();
}

if (is_admin()) {
    add_action('load-post.php', 'createMetaBox');
    add_action('load-post-new.php', 'createMetaBox');
}

add_action('get_header', 'my_filter_head');
/**
 * Remove the 28px Push Down from the Admin Bar
 * @see http://css-tricks.com/snippets/wordpress/remove-the-28px-push-down-from-the-admin-bar/
 */
function my_filter_head() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}

function print_stars($numOfStars) {
    $numOfStars = (float)$numOfStars;
    echo $numOfStars;
    $have = 0;
    echo gettype($numOfStars);
    for ($index = 1;$index <= $numOfStars;$index++) {
        echo '<div class="star star-light"></div>';
        $have++;
    }
    $fraction = $numOfStars - floor($numOfStars);
    if ($fraction != 0) {
        echo '<div class="star half-star"></div>';
        $have++;
    }

    for ($index = 0;$index < 5 - $have;$index++) echo '<div class="star star-off"></div>';
}

// function dd($numOfStars) {$taxonomy = 'casino_game_type'; $terms = get_terms($taxonomy); // convert array of term objects to array of term IDs $term_ids = wp_list_pluck($terms, 'slug'); $args = array('tax_query' => array(array('taxonomy' => 'casino_game_type', 'field' => 'slug', 'terms' => $term_ids))); $the_query = new WP_Query($args); }

function remove_admin_menu_items() {
    $advancedMode = get_option('advanced-mode');
    if ($advancedMode == 'false') {
        remove_menu_page('edit-comments.php');
        remove_menu_page('index.php');
        remove_menu_page('link-manager.php');
        remove_menu_page('tools.php');
        remove_menu_page('plugins.php');
        remove_menu_page('users.php');
        remove_menu_page('options-general.php');
        remove_menu_page('upload.php');
        remove_menu_page('edit.php');
        // remove_menu_page('edit.php?post_type=page');
        remove_menu_page('themes.php');
    }
}
add_action('admin_menu', 'remove_admin_menu_items');


/**
 * Add a nice favicon :)
 */
add_action('admin_head', 'show_favicon');
function show_favicon() {
    echo '<link  rel="icon" type="image/x-icon" href="data:image/x-icon;base64,AAABAAEAEBAAAAEACABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAAAAAAAAv7+/AFa68wDU3eYA+fn5AJKSkgDN2+QA9/f3AOjo6ABHktAAzNniAKOinwCO1PMAlaGrAPX19QDm5uYAacPzADiKzwDK1+AAubm5AKmyvQDz8/MA5OTkAJna8wBpwfEAt7e3APHx8QDi4uIAOI3QAOTk7QB8zPMAtbW1AO/v7wDW3uYA4ODgAO3t7QDe3t4AsbGxAOvr6wDc3NwAS4K+AMXR2wBJRbQAr6+vAPj4+AB1kK4A6enpAIDN8gA5kNIAvLy8AEyDvAA6k9IA9vb2ALW0sgDn5+cA3OHoAM3Y4QBFk9IASI3KAPT09ADl5eUAWrzzANDa5ABXt/EAcrzqAM3W3wDy8vIA4+PjAMLB4QDFxcUAXLrxAEqHwwB2yPIAMH/CAPDw8ADY3+cA4eHhAL3N4QDDw8MAO5bUABE+WQC9u7kA39/fAHup1gDI1N4AwcHBALKysgDs7OwA3d3dAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAArKytQPysrKysrKysrAAAABVhYFD8/SQ1YWFhYKwAAACUnWFhTAj8RKSRYWCsAAABWUlJMQTk9RhxUIlIrAAAAHxtDFjw4CRAYMBJDKwAAABkWDzYILj46HkgzCisAAAATCC4mV1cjA0cML08GAAAAMSZRUVFRUSAhMhdALQAAAAEjIEoaQkJCQksoTTUqAABVSkIVOw40Dg47NwtEKioATkJRUVEHLFFRUQ5DKioqAEU7NAcsBDsEBCwODh0qAABFOzs7Ozs7Ozs7OztFAAAARTtRUVFRUVE7UVE7RQAAAEU7Ozs7Ozs7Ozs7O0UAAP//AACAAwAAgAMAAIADAACAAwAAgAMAAIADAACAAwAAgAMAAIABAACAAAAAgAAAAIABAACAAwAAgAMAAIADAAA=">';
}
