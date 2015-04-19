<?php
/**
 * returns user number from cookie if exists if not, generate from option last user num id + 1 and updates cookie
 */
function getUserNumId() {
    $cookieName = 'topsport_user_number';
    $cookieOption = 'user_numid';
    
    $user_numid = isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : '';
    if (empty($user_numid)) {
        $user_numid = get_option($cookieOption);
        $user_numid+= 1;
        setcookie($cookieName, $user_numid, time() + (86400));
        update_option($cookieOption, $user_numid);
    } else {
        $user_numid = get_option($cookieOption);
        $user_numid+= 1;
        setcookie($cookieName, $user_numid, time() + (86400));
        update_option($cookieOption, $user_numid);
    }
    
    return $user_numid;
}

function getAllThePosts() {
    $allPosts = array();
    $jsonPost = array();
    $args = array('post_type' => 'casino_reviews');
    
    $my_query = new WP_Query($args);
    if ($my_query->have_posts()) {
        while ($my_query->have_posts()):
            $my_query->the_post();
            array_push($allPosts, get_post(get_the_ID()));
        endwhile;
    }
    wp_reset_query();
    return $allPosts;
}

function orderPosts($postsToOrder) {
    $postsToOrder = json_decode($postsToOrder);
    $finalResults = array();
    $randArr = array();
    $idx = getUserNumId();
    $allPosts = getAllThePosts();
    // echo $allPosts[0]->ID;
    // print_r(get_post_meta($allPosts[0]->ID, 'platform'));
    
    foreach ($postsToOrder as $key => $post) {
        if (gettype($post) == 'array') {
            $arr_idx = $idx % count($post);
            array_push($finalResults, $post[$arr_idx]);
        } else {
            if ($post->positionType == 'fixed') {
                array_push($finalResults, $post);
            } elseif ($post->positionType == 'random') {
                array_push($randArr, $post);
                array_push($finalResults, 'random_placeholder');
            } else {
                throw new Exception("Error Processing type", 1);
                die();
            }
        }
    }
    
    shuffle($randArr);
    $i = 0;
    for ($j = 0;$j < count($finalResults);$j++) {
        if (gettype($finalResults[$j]) == 'string' && $finalResults[$j] == 'random_placeholder') {
            $finalResults[$j] = $randArr[$i];
            $i++;
        }
    }
    
    return $finalResults;
}

function add_bonuses($thePostsOfPage, $postBonusesJSON) {
    for ($i = 0;$i < count($thePostsOfPage);$i++) {
        for ($j = 0;$j < count($postBonusesJSON);$j++) {
            if ($thePostsOfPage[$i]->itmId == $postBonusesJSON[$j]->itmId) {
                $thePostsOfPage[$i]->bonusText = $postBonusesJSON[$j]->bonusText;
            }
        }
    }
    return $thePostsOfPage;
}
