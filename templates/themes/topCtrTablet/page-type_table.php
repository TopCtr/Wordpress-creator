<?php
/**
 * Template Name: Table Page
 * Description: A Page Template to display table with brands.
 **/
require 'functions-stars.php';
$thePostsOfPage  = get_post_meta($post->ID, 'postJSON', true);
$thePostsOfPage  = orderPosts($thePostsOfPage);
$postBonusesJSON = get_post_meta($post->ID, 'postBonusesJSON', true);
$postBonusesJSON = json_decode($postBonusesJSON);
$thePostsOfPage  = add_bonuses($thePostsOfPage, $postBonusesJSON);

get_header();
?>
<link type="text/css" rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/page-type_table.css">
<link type="text/css" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" >
<div id="page-title" class="page-width">
<span>
<?php echo esc_attr(get_option('header_title')); ?>
</span>
<span>
<?php echo esc_attr(get_option('header_text')); ?>
</span>
</div>


<div id="date-title" class="page-width left-fix"></div>

<div id="" class="page-width">

<table class="tableSorter" id="brand-table">
    <thead>
      <tr id="table-header">
        <td class="" data-sortBy="numeric">RANK</td>
        <td class="no-sort">BROKER</td>
        <td class="no-sort">BONUS</td>
        <td class="no-sort">TRADABLE<br>ASSETS</td>
        <td class="no-sort">USER<br>RATING</td>
        <td class="no-sort">MIN<br>DEPOSIT</td>
        <td class="no-sort">MAX<br>PAYOUT</td>
        <td class="no-sort">SUPPORT</td>
        <td class="no-sort">ACTION</td>
      </tr>
    </thead>
    <tbody>
      <?php
$rankIdx = 0;
foreach ($thePostsOfPage as $brand) {
    // echo get_post_meta($brand->itmId, 'platform') [0] . "<br>";
    $image_id = get_post_meta($brand->itmId, '_image_id', true);
    $image_src = wp_get_attachment_image($image_id);
    $rankIdx++;
    $tmp = get_post_meta($brand->itmId, 'affiliate-link');
    $affiliateLink = $tmp [0];
?>
        <tr class="">
            <td class="coll-rank-number"><a href="<?php
            echo $affiliateLink;
            ?>" target="_blank" class="rank-number"><?php
            echo $rankIdx;
            ?></a>
            </td>
            <td class="coll-casinoimg">

            <a target="_blank" href="<?php
$tmp=            get_post_meta($brand->itmId, 'affiliate-link');
    echo $tmp[0];
?>">
            <?php echo $image_src; ?>
            </a>
          </td>
          <td class="coll-bonus">
            <a href="<?php echo $affiliateLink; ?>" target="_blank" class="text-link"><?php
    $bonusText = $brand->bonusText;
    if ($bonusText == "") {
      $tmp=get_post_meta($brand->itmId, 'bonus');
          echo  $tmp[0];
    } else {
        echo $bonusText;
    }
?></a></td>
          <td class="coll-tradable-assets">
            <a href="<?php echo $affiliateLink; ?>" target="_blank"  class="text-link"><?php
            $tmp=get_post_meta($brand->itmId, 'tradable-assets');
            echo $tmp[0];
?></a>
</td>

  <td class="coll-ratings">
   <div class="stars" style="background-image: url(
   <?php
    echo '/wp-content/themes/' . get_stylesheet() . '/images/rank/' . getStars(count($thePostsOfPage), $rankIdx);
    ?>.png);">
  </div>
                <a
                href="http://topbinarybrokersonline.com/<?php echo get_post($brand->itmId)->post_name; ?>"
                >Read Review</a>
              </td>
 <td class="coll-min-deposit">
   <a href="<?php echo $affiliateLink; ?>" target="_blank" class="text-link">
   <?php
   $tmp=get_post_meta($brand->itmId, 'min-deposit');
   echo $tmp[0];
?>
</a>
    </td>
    <td class="coll-max-payout">
      <a href="<?php echo $affiliateLink; ?>" target="_blank" class="text-link"><?php
      $tmp=get_post_meta($brand->itmId, 'max-payout');
      echo  $tmp[0];
?></a>
</td>

           <td class="coll-support">


      <?php
    $SUPPORT = array('email' => 'Email/Form'
    //
    , 'faq' => 'FAQ' //
    , 'telephone' => 'Telephone' //
    , 'live-help' => 'Live Help' //
    );


    foreach ($SUPPORT as $key => $value) {
        $text = get_post_meta($brand->itmId, $key);
          //echo "<li>" . $value . "</li>";
          //if(!isset($text[0]))var_dump($text);

        if (isset($text[0]) && $text[0] == 'on'){
          switch($value){
            case 'Email/Form':
            echo '<a href="'. $affiliateLink .'" target="_blank" title="Email/Form" class="support-icon icon-mail"></a>';
            break;
            case 'FAQ':
            echo '<a href="'. $affiliateLink .'" target="_blank" title="FAQ"        class="support-icon icon-bubbles2"></a>';
            break;
            case 'Telephone':
            echo '<a href="'. $affiliateLink .'" target="_blank" title="Telephone"  class="support-icon icon-phone"></a>';
            break;
            case 'Live Help':
            echo '<a href="'. $affiliateLink .'" target="_blank" title="Live Help"  class="support-icon icon-headset-m"></a>';
            break;
          }
        }

    }
?>
</td>

              <td class="coll-tbl-play-now">
                <a class="visit-site-btn"
              target="_blank"
                 href="<?php
                 $tmp=get_post_meta($brand->itmId, 'affiliate-link') ;
                 echo $tmp[0];
?>">
              </a>
            </td>
            <?php
}
?>
        </tbody>
      </table>
  </div>

<div id="tbl-footer" class="page-width">
  <div id="tbl-bottom"></div>
  <div id="tbl-footer-title"><?php echo (get_option('under-table-title')); ?></div>
  <div class="col"><div class="circle"><div class="circle-icon icon-A"></div></div>
  <span class="small-title"><?php echo (get_option('small-title-a')); ?></span>
  <span class="small-text"><?php echo (get_option('small-text-a')); ?></span>
  </div>
  <div class="col"><div class="circle"><div class="circle-icon icon-B"></div></div>
  <span class="small-title"><?php echo (get_option('small-title-b')); ?></span>
  <span class="small-text"><?php echo (get_option('small-text-b')); ?></span>
  </div>
  <div class="col"><div class="circle"><div class="circle-icon icon-C"></div></div>
  <span class="small-title"><?php echo (get_option('small-title-c')); ?></span>
  <span class="small-text"><?php echo (get_option('small-text-c')); ?></span>
  </div>
  <div class="last">
  <div class="circle"><div class="circle-icon icon-D"></div></div>
  <span class="small-title"><?php echo (get_option('small-title-d')); ?></span>
  <span class="small-text"><?php echo (get_option('small-text-d')); ?></span>
  </div>
</div>

  <div class="bottom-text"><?php
  the_content();
  ?></div>
</div>

<div id="stockTicker" class="marquee page-width"></div>

<script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.js'></script>
<script src='/wp-content/themes/<?php echo get_stylesheet() ?>/js/home.date.js'></script>
<script src='/wp-content/themes/<?php echo get_stylesheet() ?>/js/jquery.marquee.min.js'></script>
<script src='/wp-content/themes/<?php echo get_stylesheet() ?>/js/stockTicker.js'></script>

<link  type="text/css"  rel="stylesheet" href="/wp-content/themes/<?php echo get_stylesheet() ?>/js/animatedtablesorter-0.2.2/style.css"/>
<script src='/wp-content/themes/<?php echo get_stylesheet() ?>/js/animatedtablesorter-0.2.2/tsort.js'></script>
<script src='/wp-content/themes/<?php echo get_stylesheet() ?>/js/home.js'></script>
<?php
get_footer();
?>
