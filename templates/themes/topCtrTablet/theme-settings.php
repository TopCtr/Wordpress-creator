<?php
// create custom plugin settings menu
add_action('admin_menu', 'baw_create_menu');

function baw_create_menu() {
    //create new top-level menu
    add_menu_page('Configuration Plugin Settings', 'Configurations', 'administrator', __FILE__, 'baw_settings_page', 'dashicons-hammer');
    //call register settings function
    add_action('admin_init', 'register_mysettings');
}

function register_mysettings() {
    //register our settings

    register_setting('topctr-settings-group', 'advanced-mode');

    register_setting('topctr-settings-group', 'header_title');
    register_setting('topctr-settings-group', 'header_text');

    register_setting('topctr-settings-group', 'under-table-title');
    register_setting('topctr-settings-group', 'small-title-a');
    register_setting('topctr-settings-group', 'small-title-b');
    register_setting('topctr-settings-group', 'small-title-c');
    register_setting('topctr-settings-group', 'small-title-d');

    register_setting('topctr-settings-group', 'small-text-a');
    register_setting('topctr-settings-group', 'small-text-b');
    register_setting('topctr-settings-group', 'small-text-c');
    register_setting('topctr-settings-group', 'small-text-d');

    register_setting('topctr-settings-group', 'footer-text');
}

function baw_settings_page() {
?>
<link rel="stylesheet"  type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/css/theme-settings.css">

<div class="wrap">
<h2><div class="dashicons dashicons-hammer"></div> Configurations</h2>

<form method="post" action="options.php">
    <?php settings_fields('topctr-settings-group'); ?>
    <?php do_settings_sections('topctr-settings-group'); ?>








        <h3>General</h3>
        <?php $adMod = get_option('advanced-mode'); ?>
  <input type="radio" name="advanced-mode" <?php if ($adMod == 'true') echo 'checked="checked"'; ?> id="advanced-mode" value="true">
  <label for="advanced-mode">Advanced mode</label><br>
  <input type="radio" name="advanced-mode" <?php if ($adMod == 'false') echo 'checked="checked"'; ?> id="easy-mode"     value="false">
  <label for="easy-mode" title="This one is better :)" >Easy mode</label><br><br>








    <table class="form-table">
        <tr valign="top">
        <th scope="">Header Title</th>
        <td><input type="text" name="header_title" value="<?php echo esc_attr(get_option('header_title')); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="">Header Text</th>
        <td><input type="text" name="header_text" value="<?php echo esc_attr(get_option('header_text')); ?>" /></td>
        </tr>
    </table>

<div id="tbl-footer">
<div id="tbl-bottom"></div>

<input type="text" id="tbl-footer-title" name="under-table-title" class="input-as-text"
 placeholder="WHO IS THE BEST BROKER IN EACH CATEGORY?"
 value="<?php echo esc_attr(get_option('under-table-title')); ?>" />
 <br>
<div class="col"><div class="circle"><div class="circle-icon icon-A"></div></div>
<input type="text" name="small-title-a" class="small-title input-as-text"
 value="<?php echo esc_attr(get_option('small-title-a')); ?>" />


<textarea name="small-text-a" class="small-text input-as-text">
<?php echo esc_attr(get_option('small-text-a')); ?></textarea>

</div>
<div class="col"><div class="circle"><div class="circle-icon icon-B"></div></div>

<input type="text" name="small-title-b" class="small-title input-as-text"
placeholder="PAYOUT"
 value="<?php echo esc_attr(get_option('small-title-b')); ?>" />

<textarea name="small-text-b" class="small-text input-as-text">
<?php echo esc_attr(get_option('small-text-b')); ?></textarea>
</div>
<div class="col"><div class="circle"><div class="circle-icon icon-C"></div></div>

<input type="text" name="small-title-c" class="small-title input-as-text"
placeholder="CUSTOMER SUPPORT"
 value="<?php echo esc_attr(get_option('small-title-c')); ?>" />

<textarea name="small-text-c" class="small-text input-as-text">
<?php echo esc_attr(get_option('small-text-c')); ?></textarea>
</div>
<div class="last">
<div class="circle"><div class="circle-icon icon-D"></div></div>
<span class="small-title"></span>
<input type="text" name="small-title-d" class="small-title input-as-text"
placeholder="BEST BONUS"
 value="<?php echo esc_attr(get_option('small-title-d')); ?>" />

<textarea name="small-text-d" class="small-text input-as-text">
<?php echo esc_attr(get_option('small-text-d')); ?></textarea>
<!-- <span class="small-text">Cedar Finance offers highest bonuses in the binary options industry</span> -->
</div></div>

<br class="clear">
<br class="clear">
        <label for="footer-text">Footer Text </label><sub>as HTML</sub><br>
        <textarea
        style ="margin: 0px; height: 130px; width: 1499px;"
        name  ="footer-text"
        id    ="footer-text"
        >
<?php echo esc_attr(get_option('footer-text')); ?>
        </textarea>






    <?php submit_button(); ?>

</form>
</div>
<?php
} ?>
