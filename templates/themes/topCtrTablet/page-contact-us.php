<?php
/*
 * Template Name: Contact Us Form Page
 *  Description: A Page Template to display contact form.
 **/
//response generation function
$response = "";
//function to generate response
function my_contact_form_generate_response($type, $message) {
    global $response;
    if ($type == "success") $response = "<div class='success'>{$message}</div>";
    else $response = "<div class='error'>{$message}</div>";
}
//response messages
$not_human = "Human verification incorrect.";
$missing_content = "Please supply all information.";
$email_invalid = "Email Address Invalid.";
$message_unsent = "Message was not sent. Try Again.";
$message_sent = "Thanks! Your message has been sent.";
//user posted variables
$name = isset($_POST['message_name']) ? $_POST['message_name'] : '';
$email = isset($_POST['message_email']) ? $_POST['message_email'] : '';
$message = isset($_POST['message_text']) ? $_POST['message_text'] : '';
$human = isset($_POST['message_human']) ? $_POST['message_human'] : '';
//php mailer variables
$to = get_option('admin_email');
$subject = "Someone sent a message from " . get_bloginfo('name');
$headers = 'From: ' . $email . "\r\n" . 'Reply-To: ' . $email . "\r\n";
if (!$human == 0) {
    if ($human != 2) my_contact_form_generate_response("error", $not_human); //not human!
    else {
        //validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) my_contact_form_generate_response("error", $email_invalid);
        else { //email is valid
            //validate presence of name and message
            if (empty($name) || empty($message)) {
                my_contact_form_generate_response("error", $missing_content);
            } else { //ready to go!
                $sent = wp_mail($to, $subject, strip_tags($message), $headers);
                if ($sent) {
                    my_contact_form_generate_response("success", $message_sent); //message sent!                 
                } else {
                    my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
                }
            }
        }
    }
} else if (isset($_POST['submitted']) && $_POST['submitted']) {
    my_contact_form_generate_response("error", $missing_content);
}
?>
<?php get_header(); ?>
<link
rel="stylesheet"
type="text/css"
media="all"
href="<?php echo get_theme_root_uri() . '/' . get_stylesheet(); ?>/css/contact-us.css"/>


    <div id="" class="contact-us-page page-width">
        <div id="contact-us-form">
            <?php while (have_posts()):
    the_post(); ?>
            <div class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </div>
            <?php the_content(); ?>
            <?php echo $response; ?>
            <form action="<?php the_permalink(); ?>" method="post">
                <p><label for="message_name">Name: <span>*</span><br>
                    <input type="text"
                    id="message_name"
                name="message_name" placeholder="Your Name" value="<?php echo isset($_POST['message_name']) ? esc_attr($_POST['message_name']) : ''; ?>"></label></p>
                <p><label for="message_email">Email: <span>*</span> <br>
                    <input type="text"
                    id="message_email"
                    name="message_email"
                placeholder="Your email" value="<?php echo isset($_POST['message_email']) ? esc_attr($_POST['message_email']) : ''; ?>"></label></p>
                <p><label for="message_text">Message: <span>*</span> <br><textarea type="text"
                    id="message_text"
                name="message_text"><?php echo isset($_POST['message_text']) ? esc_textarea($_POST['message_text']) : ''; ?></textarea></label></p>
                <p><label for="message_human">Human Verification: <span>*</span><br><input type="text" style="width: 60px;"
                    id="message_human"
                name="message_human"> + 3 = 5</label></p>
                <input type="hidden" name="submitted" value="1">
                <br>
                <p><input type="submit" id="send-btn" value="Send"></p>
            </form>
            <?php endwhile; // end of the loop.
?>
            </div><!-- #content -->
            </div><!-- #primary -->
            <?php get_footer(); ?>


