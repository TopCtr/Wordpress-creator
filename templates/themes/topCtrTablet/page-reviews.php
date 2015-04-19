<?php
/*
 * Template Name: Reviews Page
 *  Description: A Page Template to display reviews of brands.
 **/

// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);
get_header();
?>
<br><br><br>
<div id="purple-title" class="page-width">
<?php the_title(); ?>
</div>
<br><br>
<div id="" class="page-width">
  <?php
    $reviews = get_reviews();
    for($i=0; $i < count($reviews); $i++){
  ?>
<div class="element-item">
      <h3 class="reviews-brand-name">
        <?php
         echo get_the_title($reviews[$i]["itmId"]);
        ?>
      </h3>
  <a href="<?php
    $tmp=get_post_meta($reviews[$i]["itmId"], 'affiliate-link');
    echo $tmp[0]; ?>" class="reviews-visit-site-btn" target="_blank" >
  </a>
<a href="<?php echo get_permalink($reviews[$i]["itmId"]); ?>" class="reviews-read-btn"></a>

<div class="reviews-row">
<?php echo get_the_post_thumbnail($reviews[$i]["itmId"], 'full'); ?>
      <div class="reviews-coll reviews-coll-rating">
       <?php
        foreach ($RATING as $key => $value) {
            echo '<span class="srch-rating-text " style="background-image:url(/wp-content/themes/'
            . get_stylesheet() . '/images/rank/'
            . get_post_meta($reviews[$i]["itmId"], $key, true) . '.png);">' . $value . "</span>";
        } ?>
     </div>
   <div class="reviews-coll-text">
    <?php
      $tags = array('<p>', '</p>');
      echo str_replace($tags, " ", get_post_field('post_excerpt', $reviews[$i]["itmId"]));
    ?>
  </div>
 </div>
</div>
<?php
 } // End for
 wp_reset_query();
?>
</div>

<link rel="stylesheet" type="text/css" href="/wp-content/themes/<?php echo get_stylesheet(); ?>/css/reviews.css"/>
<?php
 get_footer();
?>
