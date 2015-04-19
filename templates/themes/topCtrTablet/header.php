<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 */

function topctr_get_menu($menu_name) {
    $current_id = get_the_ID();
    $menu_list = '';

    $menu = wp_get_nav_menu_object($menu_name);
    if ($menu) {
        $menu_items = wp_get_nav_menu_items($menu->term_id);

        $menu_list = '<nav class="' . str_replace(' ', '', $menu_name) . '">';
        $menu_list.= "<ul>\n";
        foreach ($menu_items as $key => $menu_item) {
            $title = $menu_item->title;
            $url = $menu_item->url;
            if ($current_id == $menu_item->object_id) {
                $current_class = "current";
            } else {
                $current_class = '';
            }
            $menu_list.= "<li class='$current_class'><a href='$url'>$title</a></li>\n";
        }
        $menu_list.= "</ul>\n";
        $menu_list.= "</nav>\n";
    }
    return $menu_list;
}
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >

    <link href="data:image/x-icon;base64,AAABAAEAEBAAAAAAAABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAAAAAAAABasQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAEBAAABAAAAAAAAAAAAAAAAAQABAQEAAAABAAAAAAAAAAEBAQABAAAAAQEAAAAAAAAAAQAAAQEAAQEBAAAAAAAAAAEAAAABAAEAAQEAAAAAAAAAAAAAAQEBAAEBAAAAAAAAAAAAAAABAAAAAQEAAAEAAAAAAAAAAQAAAAEBAAEBAAAAAAAAAAAAAAAAAQEBAQAAAAAAAAAAAAAAAQEBAQEAAAAAAAAAAAAAAQEBAQEBAAAAAAAAAAAAAAABAQEBAQAAAAAAAAAAAAAAAAEBAQEAAAAAAAAAAAAAAAAAAQEBAAAAAAAAAAAAAAAAAAABAX//AAA3/wAAo78AAIufAADZHwAA3U8AAPxPAAD+5gAA/uQAAP/wAAD/4AAA/8AAAP/gAAD/8AAA//gAAP/8AAA=" rel="icon" type="image/x-icon" />

    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="title" content="<?php wp_title('|', true, 'right'); ?>"/>
    <meta name="" content=""/>
    <link type="text/css" rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/header.css">
    <link type="text/css" rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/flag-icon-css/css/flag-icon.min.css">

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <header id="masthead" class="site-header" role="banner">
        <div id="header-inner-wrp" class="page-width">
              <a href="http://topbinarybrokersonline.com" id="logo"></a>
              <div id="header-menu">
                 <?php echo topctr_get_menu('Top Menu'); ?>
             </div>
             <div id="countryChange" class="bubble bubble-hidden">

               <span class="flag-icon flag-icon-au"><a href="http://australia.topbinarybrokersonline.com">Australia</a></span>
               <span class="flag-icon flag-icon-de"><a href="http://germany.topbinarybrokersonline.com">Germany</a></span>
               <span class="flag-icon flag-icon-ca"><a href="http://canada.topbinarybrokersonline.com">Canada</a></span>
               <!-- <span class="flag-icon flag-icon-fr"><a href="http://france.topbinarybrokersonline.com">France</a></span>
               <span class="flag-icon flag-icon-it"><a href="http://italy.topbinarybrokersonline.com">Italy</a></span>
               <span class="flag-icon flag-icon-ru"><a href="http://russia.topbinarybrokersonline.com">Russia</a></span> -->
               <span class="flag-icon flag-icon-gb"><a href="http://topbinaryoptionsites.co.uk">UK</a></span>




             </div>
         </div>
     </header>

     <script src='/wp-content/themes/<?php echo get_stylesheet() ?>/js/header.js'></script>
