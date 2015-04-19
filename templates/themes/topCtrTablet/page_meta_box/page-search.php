<?php
/*
 * Template Name: TopCtr Search Page
 *  Description: A Page Template to display table with brands.
 **/

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
get_header();
?>
<script type="text/javascript">
  $=jQuery;
</script>

<div class="sort-bar-warp">
<div class="page-width sort-bar">

<input type="text" id="quicksearch" placeholder="Search" />

  <div id="sorts" class="button-group">
  <span>Sort by:</span>  
    <button class="button is-checked" data-sort-value="original-order">original order</button>
    <button class="button" data-sort-value="name">name</button>
    <button class="button" data-sort-value="calculated-sum">Calculated Sum</button>
  </div>
  </div>
</div>

<br><br><br><br><br>
<div id="" class=" isotope">

  <?php
$args = array('post_type' => 'casino_reviews', 'nopaging' => true);
$my_query = new WP_Query($args);
if ($my_query->have_posts()) {
    while ($my_query->have_posts()):
        $my_query->the_post();
?>
    <div class="element-item" data-category="actinoid">
<a target="_blank"
href="
<?php
        echo get_post_meta(get_the_ID(), 'affiliate-link') [0];
?>"
class="btn btn-2 btn-2c">Visit site</a>
<a href="<?php echo get_permalink(get_the_ID()); ?>" class="btn btn-2 btn-3c">Read Review</a>
      <div class="srch-coll srch-coll-l">
       <div class="screenshot-img-search"
       style="background-image:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>);"></div>
       <?php
        foreach ($RATING as $key => $value) {
            echo '<span class="srch-rating-text ' . $key . '" style="background-image:url(/wp-content/themes/' . get_stylesheet() . '/images/defaults/' . get_post_meta(get_the_ID(), $key, true) . '.png);">' . $value . "</span>";
        } ?>
    </div>
    <div class="srch-coll srch-coll-r">
      <?php
        $image_id = get_post_meta(get_the_ID(), '_image_id', true);
        $image_src = wp_get_attachment_image($image_id);
        echo $image_src;
?>
      <h3 class="name"><?php echo get_the_title(); ?></h3>
      <?php echo the_excerpt(); ?>
    </div>
    
  </div>

  <!-- <a href="<?php echo get_post_meta(get_the_ID(), 'affiliate-link') [0]; ?>">link</a> -->

  <?php
    endwhile;
}
wp_reset_query();
?>
</div>

<style>

</style>
<script type="text/javascript" src="/wp-content/themes/<?php echo get_stylesheet(); ?>/js/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="/wp-content/themes/<?php echo get_stylesheet(); ?>/js/search.js"></script>
<link rel="stylesheet" type="text/css" href="/wp-content/themes/<?php echo get_stylesheet(); ?>/search.css"/>
<?php
get_footer();
?>
