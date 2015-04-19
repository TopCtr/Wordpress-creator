<?php
/**
 * TOPCtr WordPress Plugin.
 * @package    topCtr-table
 * @author     Arnon Eilat <Arnon.Eilat@topctr.com>
 * @license    Commercial
 * @link       http://topctr.com
 * @copyright  TopCtr inc. 2014
 *
 * @wordpress-plugin
 * Plugin Name:       TOPCtr Table
 * Plugin URI:        http://topctr.com
 * Description:       Show table on the main page and all are other needs...
 * Version:           1.0.0
 * Author:            Arnon Eilat
 * Author URI:        Arnon.Eilat@topctr.com
 *
 */
if (!defined('WPINC')) // If this file is called directly, abort.
die;

// ini_set('display_errors', 'On');error_reporting(E_ALL | E_STRICT);

include 'topCtr-table-meta-box.php';
include 'topCtr-table-help-n-messages.php';
include 'image-upload.php';
include 'currency-buttons.php';
require_once 'settings.php';
require_once 'mce-table-buttons.php';




$WP_TYPE_PREFIX = "top_ctr_type";
/**
 * The name of the post type.
 * @link create_casino_review create_casino_review
 * @link register_post_type_taxonomies
 */
$WP_POST_TYPE = "casino_reviews";
/**
 * The name of the entity.
 */
$ENTITY_NAME = 'Brand';

add_action('init', 'create_casino_review');
add_action('init', 'register_post_type_taxonomies');
/* Fire up our meta box setup function on the post editor screen. */
add_action('load-post.php', '_post_meta_boxes_setup');
add_action('load-post-new.php', '_post_meta_boxes_setup');

add_action('admin_head', 'head_links');
add_action('in_admin_footer', 'footerJs');
/**
 * Register post type
 * @return void
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function create_casino_review() {
    global $WP_POST_TYPE;
    global $ENTITY_NAME;
    global $wp_rewrite;
    
    $labels = array('name' => $ENTITY_NAME . ' Reviews', 'singular_name' => $ENTITY_NAME . ' Review', 'add_new' => 'Add New ' . $ENTITY_NAME, 'add_new_item' => 'Add New ' . $ENTITY_NAME . ' Review', 'edit' => 'Edit', 'edit_item' => 'Edit ' . $ENTITY_NAME . ' Review', 'new_item' => 'New ' . $ENTITY_NAME . ' Review', 'view' => 'View', 'view_item' => 'View ' . $ENTITY_NAME . ' Review', 'search_items' => 'Search ' . $ENTITY_NAME . ' Reviews', 'not_found' => 'No ' . $ENTITY_NAME . ' Reviews found', 'not_found_in_trash' => 'No ' . $ENTITY_NAME . ' Reviews found in Trash', 'parent' => 'Parent ' . $ENTITY_NAME . ' Review');
    $args = array('labels' => $labels, 'public' => true // Determines the visibility of the custom post type both in the admin panel and front end.
    , 'menu_position' => 5 // Determines the menu position of the custom post type.
    , 'show_ui' => true, 'show_in_menu' => true, 'description' => 'TODO: Add Description', 'capability_type' => 'post', 'hierarchical' => true, 'has_archive' => true, 'rewrite' => array('slug' => 'review') //, 'with_front' => false)
    , 'publicly_queryable' => true, 'query_var' => "review", 'supports' => array( // Ddetermines the features of the custom post type which is to be displayed.
    'title', 'editor', 'excerpt', 'page-attributes'
    // , 'custom-fields'
    , 'thumbnail'), 'menu_icon' => 'dashicons-welcome-write-blog', '_builtin' => false // It's a custom post type, not built in!
    // , 'taxonomies' => array( 'casino_game_type', 'casino_game_type')
    );
    
    register_post_type($WP_POST_TYPE, $args);
    //flush_rewrite_rules(); // http://codex.wordpress.org/Function_Reference/register_post_type#Flushing_Rewrite_on_Activation
    
}
/**
 * Register post type taxonomies
 * @return void
 * @see http://codex.wordpress.org/Function_Reference/register_post_type
 * @see http://codex.wordpress.org/Function_Reference/register_taxonomy
 * @link $WP_POST_TYPE $WP_POST_TYPE
 */
function register_post_type_taxonomies() {
    global $WP_POST_TYPE;
    $labels = array('name' => "Game Categories", 'add_new_item' => "Add New Casino Game", 'new_item_name' => "New Casino Type Game");
    
    $args = array('labels' => $labels, 'show_ui' => true // Make the taxonomy editor visible in the dashboard.
    , 'show_tagcloud' => false // Whether the tag cloud should be visible
    , 'hierarchical' => true, 'rewrite' => array('slug' => 'categoria', 'with_front' => false));
    /*() register_taxonomy(
    'casino_game_type'   // Creating a custom taxonomy with the name 'casino_game_type'
    , $WP_POST_TYPE      // For the custom post type 'casino_reviews'
    , $args
    );*/
}

add_action('init', 'custom_taxonomy_flush_rewrite');
function custom_taxonomy_flush_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}
/**
 * Meta box setup function.
 * @link http://codex.wordpress.org/Plugin_API/Action_Reference/add_meta_boxes Plugin API/Action Reference/add meta boxes
 * @link http://codex.wordpress.org/Plugin_API/Action_Reference/save_post      Plugin API/Action Reference/save post
 * @return void
 */
function _post_meta_boxes_setup() {
    add_action('add_meta_boxes', '_add_post_meta_boxes'); // Add meta boxes on the 'add_meta_boxes' hook.
    add_action('save_post', '_save_all_post_meta_keys', 10, 2); // Save post meta on the 'save_post' hook.
    
    add_action('add_meta_boxes', 'logo_meta_boxes');
    // add_action('save_post', 'meta_boxes_save', 10, 2);
    
    // $hook = add_object_page('Test Object', 'Test Object', 8, 'mt_object', 'mt_object_page');
    // add_contextual_help($hook, 'Testing Help');
    
}
/**
 * Create one or more meta boxes to be displayed on the post editor screen.
 * @link http://codex.wordpress.org/Function_Reference/add_meta_box Function Reference/add meta box
 * @uses topCtr-table-meta-box.php|create_post_class_meta_box
 * @return void
 */
function _add_post_meta_boxes() {
    add_meta_box('casino_reviews'
    // Unique ID
    , 'Casino Properties' // Title
    , 'create_post_class_meta_box' // Callback function to display the post meta box.
    , 'casino_reviews' // Admin page (or post type)
    , 'normal' // Context
    , 'default' // Priority
    );
}
/**
 * Save $field's meta value with value from $_POST[$field]
 * @param int $post_id The ID of the post which you want to save the data for.
 * @param string $field string containing the name of the meta value you want to save.
 * @return void
 * @see http://codex.wordpress.org/Function_Reference/get_post_meta
 */
function save_meta_value($post_id, $field) {
    if (isset($_POST[$field])) // Get the posted data
        $new_meta_value = $_POST[$field];
    else
        $new_meta_value = '';
    
    $meta_value = get_post_meta($post_id, $field, true); // Get the meta value of the custom field key.
    
    if ($new_meta_value && '' == $meta_value) // If a new meta value was added and there was no previous value,  add it.
        add_post_meta($post_id, $field, $new_meta_value, true);
    elseif ($new_meta_value && $new_meta_value != $meta_value) // If the new meta value does not match the old value,             update it.
        update_post_meta($post_id, $field, $new_meta_value);
    elseif ('' == $new_meta_value && $meta_value) // If there is no new meta value but an old value exists,          delete it.
        delete_post_meta($post_id, $field, $meta_value);
}
/**
 * Save all meta box's post metadata.
 * @param int $post_id The ID of the post which you want to save the data for.
 * @return void
 *
 */
function _save_all_post_meta_keys($post_id, $post) {
    global $COLUMNS,$SUPPORT, $PAYMENT_OPTIONS, $RATING;
    
    
    foreach ($COLUMNS as $key => $value)
      save_meta_value($post_id, $key);
    
    foreach ($PAYMENT_OPTIONS as $key => $value)
      save_meta_value($post_id, $key);
    
    foreach ($RATING as $key => $value)
      save_meta_value($post_id, $key);
    
    foreach ($SUPPORT as $key => $value)
      save_meta_value($post_id, $key);
    
    save_meta_value($post_id, 'affiliate-link');
    if (isset($_POST['upload_image_id']))
      update_post_meta($post_id, '_image_id', $_POST['upload_image_id']);
}
/**
 * Add CSS, javascript to head tag of the admin page.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/admin_head Plugin API/Action Reference/admin head
 * @return void
 */
function head_links() {
?>
  <script type="text/javascript">
    var plugin_dir_url = "<?php echo plugin_dir_url(__FILE__); // Use by jquery.raty
     ?>";
  </script>
  <link   type="text/css"        rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>css/style.css"/>
  <script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__); ?>js/jquery.raty.js"></script>
  <?php
}
/**
 * Add javascript to the bottom of the admin page.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/in_admin_footer Plugin API/Action Reference/in admin footer
 * @return void
 */
function footerJs() {
?>
  <script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__); ?>js/script.js"></script>
  <?php
}
