<?php

/**
 * Add and remove meta boxes from the edit page
 */
function logo_meta_boxes() {
    global $WP_POST_TYPE;
    add_meta_box('logo-image', 'Logo Image', 'logo_image_meta_box', $WP_POST_TYPE, 'side', 'low');
}

/**
 * Display the image meta box
 */
function logo_image_meta_box() {
    global $post;
    
    $image_src = '';
    
    $image_id = get_post_meta($post->ID, '_image_id', true);
    $image_src = wp_get_attachment_url($image_id);
?>
		<img id="logo_image" src="<?php
    echo $image_src;
?>" style="max-width:100%;" />
		<input type="hidden" name="upload_image_id" id="upload_image_id" value="<?php
    echo $image_id; ?>" />
		<p>
        <?php //echo gettype($post->ID) ;?>
			<a title="Set logo image"    href="#" id="set-logo-image">Set logo image</a>
			<a title="Remove logo image" href="#" id="remove-logo-image"
			style="<?php
    echo (!$image_id ? 'display:none;' : ''); ?>">Remove logo image</a>
		</p>

		<script type="text/javascript">
			jQuery(document).ready(function($) {

			// save the send_to_editor handler function
			window.send_to_editor_default = window.send_to_editor;

			$('#set-logo-image').click(function(){

				// replace the default send_to_editor handler function with our own
				window.send_to_editor = window.attach_image;
				tb_show('', 'media-upload.php?post_id=<?php
    echo $post->ID
?>&amp;type=image&amp;TB_iframe=true');
				return false;
			});

			$('#remove-logo-image').click(function() {
				$('#upload_image_id').val('');
				$('img').attr('src', '');
				$(this).hide();

				return false;
			});

                    // handler function which is invoked after the user selects an image from the gallery popup.
                    // this function displays the image and sets the id so it can be persisted to the post meta
                    window.attach_image = function(html) {

                    // turn the returned image html into a hidden image element so we can easily pull the relevant attributes we need
                    $('body').append('<div id="temp_image">' + html + '</div>');

                    var img = $('#temp_image').find('img');

                    imgurl   = img.attr('src');
                    imgclass = img.attr('class');
                    imgid    = parseInt(imgclass.replace(/\D/g, ''), 10);

                    $('#upload_image_id').val(imgid);
                    $('#remove-logo-image').show();

                    $('img#logo_image').attr('src', imgurl);
                    try{tb_remove();}catch(e){};
                    $('#temp_image').remove();

                    // restore the send_to_editor handler function
                    window.send_to_editor = window.send_to_editor_default;
                }
            });
</script>
<?php
}
