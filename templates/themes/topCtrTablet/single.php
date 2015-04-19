<?php
get_header();
?>

<link rel="stylesheet"  type="text/css" media="all" href="/wp-content/themes/topCtrTablet/css/single-page.css">
<div class="page-width single-wrp">
 <h1 class="single-post-title page-width"><?php the_title() ?> REVIEW</h1>
	<div class="review-list"><?php
$image_id = get_post_meta(get_the_ID(), '_image_id', true);
?><a
  href="<?php
  $tmp = get_post_meta(get_the_ID(), 'affiliate-link');
  echo $tmp[0]; ?>"
  class="logo-img"
  style="background-image:url(<?php echo wp_get_attachment_url($image_id); ?>);"></a>

	<span class="review-list-item">
		<span class="info-title info-first">Bonus</span>
		<span class="info-content info-first"><?php
    $tmp=get_post_meta(get_the_ID(), 'bonus');
    echo $tmp[0]; ?></span>
	</span>

	<span class="review-list-item">
		<span class="info-title">MIN DEPOSIT</span>
		<span class="info-content"><?php
    $tmp=get_post_meta(get_the_ID(), 'min-deposit');
    echo $tmp[0]; ?></span>
	</span>

	<span class="review-list-item">
		<span class="info-title">MAX PAYOUT</span>
		<span class="info-content"><?php
    $tmp=get_post_meta(get_the_ID(), 'max-payout');
    echo $tmp[0]; ?></span>
	</span>

	<span class="review-list-item">
		<span class="info-title">CASH BACK</span>
		<span class="info-content"><?php
    $tmp = get_post_meta(get_the_ID(), 'cash-back') ;
    echo $tmp[0]; ?>
		</span>
	</span>

<!--	<span class="review-list-item" id="last-review-item">
  	<a class="visit-site-btn" href="<?php $tmp=get_post_meta(get_the_ID(), 'affiliate-link');
    echo $tmp[0]; ?>">
		</a>
	</span> -->
</div>

<!-- ---------------------------------------------------------------- -->

 <div id="main-container" class="page-width">



  <div id="page-content">
  <?php
  $page_object = get_page(get_the_ID());
  echo $page_object->post_content;
  ?>
  </div>


  <div class="left-coll-wrp">
   <div class="left-coll">
    <h2>Ratings</h2><?php
    $foreach_count = 0;
    foreach ($RATING as $key => $value) {
        echo '<span class="rating-text ' . (($foreach_count == 0) ? 'first-rating' : ' ') . (($foreach_count == count($RATING) - 1) ? 'last-rating' : ' ') . '" style="background-image:url(/wp-content/themes/' . get_stylesheet() . '/images/rank/' . get_post_meta(get_the_ID(), $key, true) . '.png);">' . $value . "</span>";
        $foreach_count++;
    }
    ?>
  </div>

<br>

  <div class="left-coll">
    <h2><?php the_title(); ?> Features</h2><?php
    $foreach_count = 0;
    foreach ($COLUMNS as $key => $value) {
      $tmp=get_post_meta(get_the_ID(), $key);
      echo '<span class="features-text ' . (($foreach_count == 0) ? 'first-features' : ' ') . (($foreach_count == count($COLUMNS) - 1) ? 'last-features' : ' ') . '" >' //
         . '<span class="features-text-title">' //
         . $value . '</span><br><span class="features-text-description">' //
         . $tmp[0] . "</span></span>";
        $foreach_count++;
    }
    ?>
  </div>

<?php
require_once 'topFiveWidget.php';
?>

  </div>
 </div>
</div>




<br>

	<?php get_footer(); ?>
