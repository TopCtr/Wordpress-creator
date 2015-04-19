<?php
/*
 * Description: A Page Template to display table with brands.
 **/
require 'functions-stars.php';
$postId = get_option('page_on_front');
$numberOfBrands = 5;
$thePostsOfPage = get_post_meta($postId, 'postJSON', true);
$thePostsOfPage = orderPosts($thePostsOfPage);
// $postBonusesJSON = get_post_meta($postId, 'postBonusesJSON', true);
// $postBonusesJSON = json_decode($postBonusesJSON);
// $thePostsOfPage = add_bonuses($thePostsOfPage, $postBonusesJSON);
// print_r($thePostOfPage);print_r(get_post_meta($thePostOfPage[0]->itmId, 'platform'));var_dump(getAllThePosts());

// get_header();
?>
<link type="text/css" rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/css/topFiveWidget.css">


<div class="left-coll">

<h2>Top <?php echo $numberOfBrands;?> Binary Brokers</h2>
<div id="topWidget-wrp"><?php
$rankIdx = 0;


foreach ($thePostsOfPage as $brand) {
	// echo get_post_meta($brand->itmId, 'platform') [0] . "<br />";

	$image_id = get_post_meta($brand->itmId, '_image_id', true);
	$image_src = wp_get_attachment_url($image_id);
	$rankIdx++;
	if ($rankIdx == ($numberOfBrands + 1)) {
		break;
	}

	?>
<div class="tw-brnd">

<a class="tw-casino-img" target="_blank" href="<?php $tmp = get_post_meta($brand->itmId, 'affiliate-link');
	echo $tmp[0];?>"
style="background-image: url(<?php
echo $image_src;
	?>);"></a>
<a class="topWidget-visit-site-link tw-link"
                   target="_blank"
                   href="<?php $tmp = get_post_meta($brand->itmId, 'affiliate-link');
	echo $tmp[0];
	?>">Visit Site</a>
<a
    class="topWidget-review tw-link"
    href="/review/<?php echo get_post($brand->itmId)->post_name;?>"
                    >Review</a>
<span class="tw-stars"
 style="background-image: url(
  <?php echo '/wp-content/themes/' . get_stylesheet() . '/images/rank/' . getStars(count($thePostsOfPage), $rankIdx);?>.png
 );">
</span>
</div>
<?php
}
?>
</div>
</div>
