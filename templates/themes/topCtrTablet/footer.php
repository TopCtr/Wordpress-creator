<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

function topctr_get_footer_menu() {
    $current_id = get_the_ID();
    $menu_list = '';
    $menu_name = 'Footer Menu';

    $menu = wp_get_nav_menu_object($menu_name);
    if (!$menu) return;
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

    return $menu_list;
}
?>

<footer id="site-footer" class="site-footer">
	<div id="footer-inside" class="page-width"><?php
echo topctr_get_footer_menu();
echo get_option('footer-text');
?></div>
</footer>

<?php wp_footer(); ?>
<script type="text/javascript">
var $=jQuery;
var lead_id = 0;
$(function() {
 $.post('/lead_manager.php', {'HTTP_REFERER': '<?php
   echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'NO REFERER';
   ?>', 'get_params': window.location.href
   }, function(result) {
   lead_id = result.lead_id;
 }, 'json');
});
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-39371751-19', 'auto');
  ga('send', 'pageview');
</script>
</body>
</html>
