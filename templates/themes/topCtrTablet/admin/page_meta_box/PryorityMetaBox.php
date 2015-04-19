<?php
/**
 * The Pryority MetaBox Class.
 */
class PryorityMetaBox {

    private $key = 'OrderAndPryority';
    private $boxTitle = 'Order and Pryority';
    private $nonce = 'OrderAndPryority_inner_custom_box_nonce';
    private $nonceName = 'OrderAndPryority_inner_custom_boxxx';
    /**
     * Hook into the appropriate actions when the class is constructed.
     */
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
        add_action('save_post', array($this, 'save'));
    }
    /**
     * Adds the meta box container.
     */
    public function add_meta_box($post_type) {
        $post_types = array('page'); // Limit meta box to certain post types
        
        if (in_array($post_type, $post_types)) add_meta_box('topCtr_orderAndPryority_page_meta_box', $this->boxTitle, array($this, 'render_meta_box_content'), $post_type, 'advanced', 'high');
    }
    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save($post_id) {
        // We need to verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times.

        // Check if our nonce is set.
        if (!isset($_POST[$this->nonce])) return $post_id;
        
        $nonce = $_POST[$this->nonce];
        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, $this->nonceName)) return $post_id;
        // If this is an autosave, our form has not been submitted,  so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) return $post_id;
        } else {
            if (!current_user_can('edit_post', $post_id)) return $post_id;
        }
        /* OK, its safe for us to save the data now.
        Sanitize the user input.*/
        $mydata = sanitize_text_field($_POST['postJSON']);
        // Update the meta field.
        update_post_meta($post_id, 'postJSON', $mydata);
        
        $mydata = sanitize_text_field($_POST['postBonusesJSON']);
        // Update the meta field.
        update_post_meta($post_id, 'postBonusesJSON', $mydata);
    }
    /**
     * Render Meta Box content.
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content($post) {
        // Add an nonce field so we can check for it later.
        wp_nonce_field($this->nonceName, $this->nonce);
        // Use get_post_meta to retrieve an existing value from the database.
        // $value = get_post_meta($post->ID, $this->key, true);
        include get_theme_root() . '/' . get_stylesheet() . '/admin/loadingAnimation/loadingAnimation.php';
        echo '<textarea id="postJSON"         name="postJSON"         style="width: 1271px; height: 64px;">' . get_post_meta($post->ID, 'postJSON', true) . '</textarea>';
        echo '<textarea id="postBonusesJSON"  name="postBonusesJSON"  style="width: 1271px; height: 64px;">' . get_post_meta($post->ID, 'postBonusesJSON', true) . '</textarea>';
        
        $allPosts = array();
        $jsonPost = array();
        $args = array('post_type' => 'casino_reviews', 'nopaging' => true);
        $my_query = null;
        $my_query = new WP_Query($args);
        if ($my_query->have_posts()) {

            while ($my_query->have_posts()):
                $my_query->the_post();
            $jsonPost["itmId"] = intval(get_the_ID());
            $jsonPost["title"] = get_the_title();
            array_push($allPosts, $jsonPost);
            endwhile;
        }
        wp_reset_query();
        
        $json = json_encode($allPosts);
        ?>
        <script>
    /**
    * Array to hold all the post in the page.
    * The Zero  place is the first  one
    * The First place is the second one
    * and so on...
    * @global 
    */
    var allOfThePosts = <?php echo $json; ?>;
    var ALL_THE_POSTS = <?php echo $json; ?>;
    /**
     * @global
     * @type {number}
     */
     var editableIndex = null;
    /**
     * @global
     * @type {object}
     */
     var theDialog = null;

    /**
     * @global
     * @type {number}
     */
     var bonuseIDToEdit = null;
 </script>

 <!-- Dialog -->
 <div id="dialog-form" title="Edit" class="">
    <label class="description" for="sample">Select Behavior:</label>
    <select id="behavior-select" name="behavior-select">
        <option style="padding-right: 10px;" value="random"                    >Random</option>
        <option style="padding-right: 10px;" value="fixed" selected="selected" >Fixed</option>
        <option style="padding-right: 10px;" value="list"                      >List</option>
    </select>
    <br><br>
    <br><br>
    <div id="priority-list-warp" class="not-selectable">
        <div class="ui-list-wrp not-selectable">
            <div class="ui-list-title not-selectable">Available Brands</div>
            <ul id="priority-available-list" class="droptrue-ailable-brands not-selectable">

            </ul>
        </div>
        <div class="ui-list-wrp not-selectable">
            <div class="ui-list-title not-selectable">Brands To Display</div>
            <ul id="spot-list" class="dropfalse-ailable-brands not-selectable">
                <li class="placeholder not-selectable">Drop here</li>
            </ul>
        </div>
    </div>
</div>


<br><br>
<div id="bonus-btn" class="not-selectable"><div class="dashicons dashicons-awards"></div> Edit Bonus</div>


<div id="edit-bonus-dialog" title="Edit Bonus">
    <p id="current-edit"></p>
    <div id="bonus-posts-to-edit">


    </div>
    <div class="bonus-small-btn" id="pound-btn">£</div>
    <div class="bonus-small-btn" id="ero-btn">€</div>

    <textarea id="bonus-textarea"
    placeholder="Bonus Text">
    </textarea>

</div>











<div class="ui-list-wrp not-selectable">
    <div class="ui-list-title not-selectable">Available Brands<div
        id="available_brands_help"
        class="dashicons dashicons-sos helpBtn"></div>
    </div>

    <ul id="available-list" class="droptrue not-selectable">

    </ul>
</div>
<div class="ui-list-wrp not-selectable">
    <div class="ui-list-title not-selectable">Brands To Display<div
        data-code="f468"
        id="brands_to_display_help"
        class="dashicons dashicons-sos helpBtn"></div>
    </div>
    <ul id="page-list" class="dropfalse">
        <li class="placeholder not-selectable">Drop here</li>
    </ul>
</div>


<div id="dialog-message" title="Opss">
  <p>
    Your list is empty.<br><br>
    Fill it or change the Behavior to something different.
</p>
</div>

<br style="clear:both">
<?php
}
}
