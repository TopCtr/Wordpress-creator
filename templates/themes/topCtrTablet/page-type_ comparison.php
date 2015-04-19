<?php
/*
 * Template Name: Comparison Page
 * Description: A Page Template to display comparison table with brands.
 **/
require 'functions-stars.php';
$thePostsOfPage = get_post_meta($post->ID, 'postJSON', true);
$thePostsOfPage = orderPosts($thePostsOfPage);
$postBonusesJSON = get_post_meta($post->ID, 'postBonusesJSON', true);
$postBonusesJSON = json_decode($postBonusesJSON);
$thePostsOfPage = add_bonuses($thePostsOfPage, $postBonusesJSON);
// print_r($thePostOfPage);
// print_r(get_post_meta($thePostOfPage[0]->itmId, 'platform'));
// var_dump(getAllThePosts());
get_header();
// echo wp_get_attachment_url( get_post_thumbnail_id( $brand->itmId ) );


?>

<link rel="stylesheet"  type="text/css" media="all" href="/wp-content/themes/topCtrTablet/css/page-type_comparison.css">
<br><br>
<div id="" class="page-width">
<span id="page-title-comparison">
<?php echo the_title(); ?>
</span>
<span id="page-subtitle-comparison">
<?php
the_content();
?>
</span>
</div>


  <table class="page-width" id="brand-table">
    <thead>
      <tr id="table-header">
        <td class="coll-width">RANK</td>
        <td class="coll-width">1</td>
        <td class="coll-width">2</td>
        <td class="coll-width">3</td>
        <td class="coll-width">4</td>
        <td class="coll-width">5</td>
      </tr>
    </thead>
    <tbody>

        <tr id="first-row" class="">
        <td class="">Brand name</td>
      <?php
       foreach ($thePostsOfPage as $brand) {
        $image_id = get_post_meta($brand->itmId, '_image_id', true);
        $image_src = wp_get_attachment_image($image_id);
      ?>
            <td class="coll-casinoimg">
              <a target ="_blank" href="<?php $tmp=get_post_meta($brand->itmId, 'affiliate-link') ;echo $tmp[0]; ?>">
                <?php echo $image_src; ?>
              </a>
              <a
              class ="read-review-link"
              href  ="http://canada.topbinarybrokersonline.com/<?php echo get_post($brand->itmId)->post_name; ?>"
              >Read Review</a>
          </td>
          <?php
} ?>
      </tr>
<tr class="table-group">
<td colspan="6">CUSTOMER RATINGS</td>
</tr>

<tr class="">
<?php foreach ($RATING as $key => $value) { ?>
<td class="rating-title"><?php echo $value; ?></td>
      <?php foreach ($thePostsOfPage as $brand) { ?>

<td class="star-cell"
style="background-image:url(/wp-content/themes/topCtrTablet/images/rank/<?php
echo get_post_meta($brand->itmId, $key, true); ?>.png)">

</td>
<?php
    } ?>
</tr>
<?php
} ?>

<tr class="table-group">
<td colspan="6">FEATURES</td>
</tr>


<tr class="">
<?php
unset($COLUMNS["regualted"]);
foreach ($COLUMNS as $key => $value) { ?>
<td class="rating-title"><?php echo $value; ?></td>
      <?php foreach ($thePostsOfPage as $brand) { ?>
      <td class="cell-features" style="">
      <?php echo get_post_meta($brand->itmId, $key, true); ?>
      </td>
      <?php
    } ?>
      </tr>
      <?php
} ?>



<tr class="">
<td class="rating-title">Regualted</td>
<?php foreach ($thePostsOfPage as $brand) { ?>
<td class="yes-no-cell cell-features"
style="background-image:url(/wp-content/themes/topCtrTablet/images/<?php echo get_post_meta($brand->itmId, 'regualted', true); ?>.png)">
</td>
<?php
} ?>
</tr>



<tr class="table-group">
<td colspan="6">HELP & SUPPORT</td>
</tr>



<?php
function yesOrNo($val) {
    if (strtolower($val) == 'on') return 'yes';
    else return 'no';
}
?>
<tr class="">
<?php foreach ($SUPPORT as $key => $value) { ?>
<td class="rating-title"><?php echo $value; ?></td>
      <?php foreach ($thePostsOfPage as $brand) { ?>
<td class="cell-help-support"
style="background-image:url(/wp-content/themes/topCtrTablet/images/<?php
        echo yesOrNo(get_post_meta($brand->itmId, $key, true));
?>.png)">
</td>
<?php
    } ?>
</tr>
<?php
} ?>

<tr class="table-group">
<td colspan="6"></td>
</tr>
        <tr id="first-row" class="">
        <td class=""></td>
      <?php
foreach ($thePostsOfPage as $brand) {
    $image_id = get_post_meta($brand->itmId, '_image_id', true);
    $image_src = wp_get_attachment_image($image_id);
?>
<td class="coll-casinoimg">
  <a target ="_blank" href="<?php $tmp=get_post_meta($brand->itmId, 'affiliate-link') ;echo $tmp[0]; ?>">
    <?php echo $image_src; ?>
  </a>
  <a
  class ="read-review-link"
  href  ="http://canada.topbinarybrokersonline.com/<?php echo get_post($brand->itmId)->post_name; ?>"
  >Read Review</a>
</td>
          <?php
} ?>
      </tr>
 </tbody>
</table>






        <div class="bottom-text">

        </div>
      </div>


<?php
get_footer();
?>
