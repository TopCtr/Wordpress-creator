<?php
// ini_set('display_errors', 'On');error_reporting(E_ALL | E_STRICT);

function get_homepage_id(){
  $homePageId = get_option('page_on_front');
  return intval($homePageId);
}


function get_all_the_posts() {
  $allPosts = array();
  $args     = array('post_type' => 'casino_reviews');
  $my_query = new WP_Query($args);

  if ($my_query->have_posts()) {
    while ($my_query->have_posts()){
      $my_query->the_post();
      array_push($allPosts, array('itmId' => get_the_ID()));
    }
  }
  wp_reset_query();
//var_dump($allPosts);
  return $allPosts;
}

function compare_by_id($a, $b) {
  //  $eq = ($a["itmId"] == $b["itmId"])?'true':'false'; echo '<pre>a:  ' . gettype($a["itmId"]) . '  ' . $a["itmId"] .' b: ' . gettype($b["itmId"]) . '  ' . $b["itmId"] .  '      ' .  $eq . '</pre>';
  if ($a["itmId"] == $b["itmId"]){
    return 0;
  }
  return ($a["itmId"] > $b["itmId"])? 1 : -1;
}


/**
* Return array of WP_Post objects in the following order:
*  - First the post in the home page - afterwards all the other posts(without the posts of the homepage).
* @see http://codex.wordpress.org/Class_Reference/WP_Post
*/
function get_reviews(){
  $homePageId    = get_homepage_id();
  $homePagePosts = get_post_meta($homePageId, 'postJSON', true);
  $homePagePosts = json_decode($homePagePosts, true);
  // var_dump($homePagePosts);
  $allThePosts   = get_all_the_posts();

  $all_of_the_posts_without_home_post =  array_udiff($allThePosts, $homePagePosts, 'compare_by_id');

  //echo "Home Page Posts:<br>";for($i=0; $i < count($homePagePosts); $i++){echo $homePagePosts[$i]['itmId'].'<br>';}

  /* Reassign array keys
   * @see http://stackoverflow.com/questions/6971778/php-reassign-array-keys
   */
  sort($all_of_the_posts_without_home_post, SORT_NUMERIC);

  //echo "All of the posts without home post:<br>";for($i=0; $i < count($all_of_the_posts_without_home_post); $i++){echo 'i: '.$i." ".$all_of_the_posts_without_home_post[$i]['itmId'] . '<br>';}echo '<pre>';var_dump($all_of_the_posts_without_home_post);echo '</pre>';

  $merge_arrys = array_merge($homePagePosts, $all_of_the_posts_without_home_post);

  //var_dump($merge_arrys);echo "Merge Arrys:<br>";for($i=0; $i < count($merge_arrys); $i++){echo 'i: '.$i." ".$merge_arrys[$i]['itmId'] . '<br>';}
     return $merge_arrys;
}
