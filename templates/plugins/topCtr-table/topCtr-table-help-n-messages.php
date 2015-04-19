<?php

/**
 * Add update messages and customized contextual help.
 */
add_filter('post_updated_messages', 'topCtr_updated_messages');
/**
 * casino_reviews update messages.
 * @param array $messages Existing post update messages.
 * @return array Amended post update messages with new CPT(Custom Post Type) update messages.
 */
function topCtr_updated_messages($messages) {
    global $post, $post_ID;

    $entity = 'Casino';

    $messages['casino_reviews'] = array(// casino_reviews is the post type
        0 => ''
        , 1 => sprintf(__("$entity updated. <a href=\"%s\">View $entity</a>"), esc_url(get_permalink($post_ID)))
        , 2 => __("Custom field updated.")
        , 3 => __("Custom field deleted.")
        , 4 => __("$entity updated.")
        , 5 => isset($_GET['revision']) ? sprintf(__("$entity restored to revision from %s"), wp_post_revision_title((int) $_GET['revision'], false)) : false
        , 6 => sprintf(__("$entity published. <a href=\"%s\">View it</a>"), esc_url(get_permalink($post_ID)))
        , 7 => __("$entity saved.")
        , 8 => sprintf(__("$entity submitted. <a target=\"_blank\" href=\"%s\">View $entity</a>"), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID))))
        , 9 => sprintf(__("$entity scheduled for: <strong>%1</strong>. <a target=\"_blank\" href=\"%2\">$entity product</a>"), date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID)))
        , 10 => sprintf(__("$entity draft updated. <a target=\"_blank\" href=\"%s\">Preview $entity</a>"), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );
    return $messages;
}

add_filter('contextual_help', 'help_writer', 'casino_reviews' // Help For casino_reviews
        , 3);
/**
 * Add customized contextual help.
 * The contextual help feature is a descending tab which can be seen in the top right of pages where available.
 * @see http://codex.wordpress.org/Class_Reference/WP_Screen/add_help_tab
 */
function help_writer($contextual_help, $screen_id, $screen) {
    //// <editor-fold defaultstate="collapsed" desc="comment">
    /* var_dump($screen_id); string(19) "edit-casino_reviews"
      var_dump($screen_id); string(14) "casino_reviews"
      var_dump($screen_id); string(21) "edit-casino_game_type"
      $screen = get_current_screen(); */
// </editor-fold>

    $entities = 'casinos';
    $entity = 'casino';

    switch ($screen_id) {
        case "edit-casino_reviews" :
            $screen->add_help_tab(array(
                'id' => 'casino-reviews',
                'title' => __('Casino Reviews'),
                'content' => __("This screen provides access to all of your $entities. You can customize the display of this screen to suit your workflow."),
            ));
            $screen->add_help_tab(array(
                'id' => 'screen-content',
                'title' => __('Screen Content'),
                'content' => __("<p>You can customize the display of this screen’s contents in a number of ways:</p><ul><li>You can hide/display columns based on your needs and decide how many  $entities to list per screen using the Screen Options tab.</li><li>You can filter the list of $entities by $entity status using the text links in the upper left to show All, Published, Draft, or Trashed  $entities. The default view is to show all  $entities.</li><li>You can view  $entities in a simple title list or with an excerpt. Choose the view you prefer by clicking on the icons at the top of the list on the right.</li><li>You can refine the list to show only  $entities in a specific category or from a specific month by using the dropdown menus above the  $entities list. Click the Filter button after making your selection. You also can refine the list by clicking on the $entity author, category or tag in the  $entities list.</li></ul>"),
            ));
            $screen->add_help_tab(array(
                'id' => 'available_actions',
                'title' => __('Available Actions'),
                'content' => __("<p>Hovering over a row in the $entities list will display action links that allow you to manage your $entity. You can perform the following actions:</p><ul><li><strong>Edit</strong> takes you to the editing screen for that $entity. You can also reach that screen by clicking on the $entity title.</li><li><strong>Quick Edit</strong> provides inline access to the metadata of your $entity, allowing you to update $entity details without leaving this screen.</li><li><strong>Trash</strong> removes your $entity from this list and places it in the trash, from which you can permanently delete it.</li><li><strong>Preview</strong> will show you what your draft $entity will look like if you publish it. View will take you to your live site to view the $entity. Which link is available depends on your $entity’s status.</li></ul>"),
            ));
            $screen->add_help_tab(array(
                'id' => 'bulk-actions',
                'title' => __('Bulk Actions'),
                'content' => __("<p>You can also edit or move multiple $entities to the trash at once. Select the $entities you want to act on using the checkboxes, then select the action you want to take from the Bulk Actions menu and click Apply.</p><p>When using Bulk Edit, you can change the metadata (categories, author, etc.) for all selected $entities at once. To remove a $entity from the grouping, just click the x next to its name in the Bulk Edit area that appears.</p>"),
            ));
            break;
        case "casino_reviews":
            $screen->add_help_tab(array(
                'id' => 'add-new-casino',
                'title' => __('Add New Casino'),
                'content' => __("<p>This screen allow to add new $entity or edit one.</p>"),
            ));
            $screen->add_help_tab(array(
                'id' => 'million-dollars',
                'title' => __('How to earn million dollar'),
                'content' => __("Go to work!"),
            ));
            break;
        case "edit-casino_game_type":
            $screen->add_help_tab(array(
                'id' => 'adding-categories',
                'title' => __('Adding Categories'),
                'content' => __("<p>When adding a new category on this screen, you’ll fill in the following fields:</p><ul><li><strong>Name</strong> - The name is how it appears on your site.</li><li><strong>Slug</strong> - The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</li><li><strong>Parent</strong> - Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have child categories for Bebop and Big Band. Totally optional. To create a subcategory, just choose another category from the Parent dropdown.</li><li><strong>Description</strong> - The description is not prominent by default; however, some themes may display it.</li></ul><p>You can change the display of this screen using the Screen Options tab to set how many items are displayed per screen and to display/hide columns in the table.</p>"),
            ));
            $screen->add_help_tab(array(
                'id' => 'help',
                'title' => __('Help'),
                'content' => __("<p>I need somebody<br>Help, not just anybody<br>Help, you know, I need someone<br>Help <br><br>(When)<br>When I wasyounger, so much younger than today (I never needed)<br>I never needed anybody's help in any way (now)<br>But now these days are gone, I'm not so self assured (and now I find)<br>Now I find, I've changed my mind, I've opened up the doors <br><br>Help me if you can, I'm feeling down<br>And I do appreciate you being 'round<br>Help me get my feet back on the ground<br>Won't you, please, please help me?<br><br>(Now)<br>And now my life has changed in, oh, so many ways (my independence)<br>My independence seems to vanish in the haze (but)<br>But every now and then I feel so insecure (I know that I)<br>I know that I just need you like I've never done before <br><br>Help me if you can, I'm feeling down<br>And I do appreciate you being 'round<br>Help me get my feet back on the ground<br>Won't you, please, please help me? <br><br>When I was younger, so much younger than today<br>I never needed anybody's help in any way (now)<br>But now these days are gone, I'm not so self assured (and now I find)<br>Now I find, I've changed my mind, I've opened up the doors <br><br>Help me if you can, I'm feeling down<br>And I do appreciate you being 'round<br>Help me get my feet back on the ground<br>Won't you, please, please help me?<br>Help me, help me</p>"),
            ));
            break;
        default:
            break;
    }
}
