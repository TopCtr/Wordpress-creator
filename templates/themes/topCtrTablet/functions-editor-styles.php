<?php

// Callback function to insert 'styleselect' into the $buttons array
function topctr_mce_buttons($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_2', 'topctr_mce_buttons');
// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats($init_array) {
    // Define the style_formats array
    $style_formats = array(
    // Each array child is a format with it's own settings
    array('title' => 'Image and Text Table', 'classes' => 'image-and-text-table', 'wrapper' => false, 'selector' => 'table'), //
    array('title' => 'A B C List', 'classes' => 'abc-list', 'wrapper' => false, 'selector' => 'ol'), //
    array('title' => 'Roman Numerals', 'classes' => 'roman-numerals', 'wrapper' => false, 'selector' => 'ol'));
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode($style_formats);
    
    return $init_array;
}
// Attach callback to 'tiny_mce_before_init'
add_filter('tiny_mce_before_init', 'my_mce_before_init_insert_formats');

function add_styles_to_editor() {
    add_editor_style(get_stylesheet_directory_uri() . '/css/custom-editor-style.css');
}
add_action('after_setup_theme', 'add_styles_to_editor');
