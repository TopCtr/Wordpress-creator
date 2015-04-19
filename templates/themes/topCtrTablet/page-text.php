<?php
/*
 * Template Name: Text Page
 *  Description: A Page Template to display table with brands.
 **/
// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);
get_header();
?>
<link rel="stylesheet"  type="text/css" media="all" href="<?php echo get_theme_root_uri() . '/' . get_stylesheet(); ?>/css/text-page.css"/>
<?php
while (have_posts()): ?>
<h1 id="purple-title" class="page-width"><?php the_title(); ?></h1><?php
    the_post();
?>
    <br>
    <br>
<div id="text-page" class="page-width">
<!-- <div id="left-coll"> -->
<?php the_content(); ?>
    <!-- </div> -->
<?php endwhile; ?>

    
</div>
<?php get_footer(); ?>