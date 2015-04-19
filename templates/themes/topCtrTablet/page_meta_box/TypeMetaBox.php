<?php
/**
 * The Class.
 */
class TypeMetaBox{

    private $key       = 'postTypeToShow';
    private $boxTitle  = 'Type to Display';
    private $nonce     = 'myplugin_inner_custom_box_nonce';
    private $nonceName = 'myplugin_inner_custom_box';
    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct()    {
        add_action('add_meta_boxes', array($this,'add_meta_box'));
        add_action('save_post', array($this,'save'));
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_box($post_type)    {
        $post_types = array('page'); // Limit meta box to certain post types

        if (in_array($post_type, $post_types)) {
            add_meta_box(
            'topCtr_page_meta_box'
            , $this->boxTitle
            , array($this, 'render_meta_box_content')
            , $post_type
            , 'side'
            , 'high');
        }
    }

    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save($post_id){
        /* We need to verify this came from the our screen and with proper authorization, because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST[$this->nonce]))
            return $post_id;

        $nonce = $_POST[$this->nonce];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, $this->nonceName))
            return $post_id;

        // If this is an autosave, our form has not been submitted,  so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        // Sanitize the user input.
        $mydata = sanitize_text_field($_POST['type_to_show']);

        // Update the meta field.
        update_post_meta($post_id, $this->key , $mydata);
    }

    /**
     * Render Meta Box content.
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content($post)    {

        // Add an nonce field so we can check for it later.
        wp_nonce_field($this->nonceName, $this->nonce);

        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_post_meta($post->ID, $this->key , true);

        $taxonomy  = 'casino_game_type';
        $term_args = array(
            'hide_empty' => false
            , 'orderby' => 'name'
            , 'order' => 'ASC'
        );
        $terms = get_terms($taxonomy, $term_args);

       $currentValue = get_post_meta($post->ID, $this->key  , true);

        echo '<label for="type_to_show">Site type to show: </label>';
        echo '<select id="type_to_show" name="type_to_show">';
        foreach ($terms as $term) {
        if($term->slug === $currentValue )
            echo '<option selected value="' . $term->slug . '">' . $term->name . '</option>';
            else
            echo '<option  value="' . $term->slug . '">' . $term->name . '</option>';
        }
        echo '</select>';

     }
}
