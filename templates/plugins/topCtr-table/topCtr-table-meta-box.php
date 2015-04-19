<?php
/**
 * Display the post meta box.
 * @param object $post containing the current post
 * @return void
 * @see http://codex.wordpress.org/Function_Reference/add_meta_box
 * TODO: Logo picture
 * TODO: Screen shot picture
 */
function create_post_class_meta_box($post) {
    require 'settings.php';
    /**
     * Return 'checked' if $val equals 'on' otherwise ''(empty string).
     * @return String
     * @param String $val
     */
    function isChecked($val) {
        if (strtolower($val) == 'on') return 'checked';
        else return '';
    }

    $post_fields = get_post_custom($post->ID); // Get all custom fields of post with id=$post->ID
    echo "<pre>";
    // var_dump($post_fields);
    echo "<br>";
    echo "</pre>";
?>
    <?php wp_nonce_field(basename(__FILE__), '_post_class_nonce'); ?>

    <div>
        <label class="col-sm-6 control-label">Affiliate Link</label>
        <input
            id          = "affiliate-link"
            name        = "affiliate-link"
            value       = "<?php echo $post_fields["affiliate-link"][0]; ?>"
            type        = "text"
            placeholder = "Full address to affiliate link"
            class       = "input-xlarge"
            required    = ""
            style       = "width: 600px;"
            >
    </div>
<br>


    <form class="">
        <div class="fld-coll">
            <legend class="text-center">Casino Properties</legend>
            <?php
    unset($COLUMNS["regualted"]);
    foreach ($COLUMNS as $key => $value) { ?>
                <div class="control-group">
                    <label class="control-label" for="<?php echo $key; ?>"><?php echo $value ?></label>
                    <div class="controls">
                    <?php
        if (isset($post_fields[$key])) {
            $val = $post_fields[$key][0];
        } else {
            $val = '';
        }
?>
                        <input
                            id          = "<?php echo $key; ?>"
                            name        = "<?php echo $key; ?>"
                            value       = "<?php echo esc_html($val); ?>"
                            type        = "text"
                            placeholder = ""
                            class       = "input-properties"
                            required    = "">
                        <p class="help-block"></p>
                    </div>
                </div>
            <?php
    } ?>



<?php $regualted = $post_fields['regualted'][0]; ?>

<div class="control-group">
    <label class="control-label" for="regualted">Regualted</label>
    <div class="controls">
    <select id= "regualted" name="regualted" class="input-properties">
    <option value="yes" <?php if ($regualted == 'yes') echo 'selected'; ?>>Yes</option>
    <option value="no"  <?php if ($regualted == 'no') echo 'selected'; ?>>No</option>
    </select>
    <p class="help-block"></p>
    </div>
</div>


















        </div>

        <div class="fld-coll">

            <legend class="text-center">Ranking Properties</legend>

            <script>
            var ratings = [<?php
    $numItems = count($RATING);
    $i = 0;
    foreach ($RATING as $key => $value) { // generate array for the javascript
        if (++$i === $numItems) {
            echo '"' . $key . '"';
        } else {
            echo '"' . $key . '", ';
        }
    }
?>];</script>

            <?php foreach ($RATING as $key => $value) { ?>
                <div class="control-group">
                    <label class="control-label" for="<?php echo $key; ?>"><?php echo $value ?></label>
                    <div class="controls">
                        <input
                            id="<?php echo $key; ?>"
                            name="<?php echo $key; ?>"
                            value = "<?php echo $post_fields[$key][0]; ?>"
                            placeholder=""
                            type="number"
                            min="0"
                            max="5"
                            step="0.5"
                            class="input-xlarge ranking-flds">
                        <p class="help-block"></p>
                    </div>
                </div>
            <?php
    } ?>
              </div>

        <div class="fld-coll">
            <legend class="text-center">Payment Options</legend>
            <a id="mark-all">Mark All</a>
            <?php foreach ($PAYMENT_OPTIONS as $key => $value) { ?>
                <div class="checkbox"><label>
                <?php if (empty($post_fields[$key]) == false): ?>
                        <input <?php echo isChecked($post_fields[$key][0]);
        else: ?>
                       <input
                      <?php
        endif; ?>
                            type = "checkbox"
                            name = "<?php echo $key; ?>"
                            class="payment-options-checkbox"
                            id   = "<?php echo $key; ?>">
                            <?php echo $value; ?>
                    </label>
                </div>
            <?php
    } ?>
        </div>

        <div class="fld-coll">


 <legend class="text-center">Support</legend>



                <div class="control-group">
                    <div class="controls">

        <?php foreach ($SUPPORT as $key => $value) { ?>
                <div class="checkbox"><label>
                <?php if (empty($post_fields[$key]) == false): ?>
                        <input <?php echo isChecked($post_fields[$key][0]);
        else: ?>
                       <input
                      <?php
        endif; ?>
                            type = "checkbox"
                            name = "<?php echo $key; ?>"
                            class="payment-options-checkbox"
                            id   = "<?php echo $key; ?>">
                            <?php echo $value; ?>
                    </label>
                </div>
            <?php
    } ?>



        </div>
        </div>
        </div>

    </form>
    <?php
}
