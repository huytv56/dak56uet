<?php
$root = dirname(dirname(dirname(dirname(__FILE__))));
if ( file_exists( $root.'/wp-load.php' ) ) {
    require_once( $root.'/wp-load.php' );
} elseif ( file_exists( $root.'/wp-config.php' ) ) {
    require_once( $root.'/wp-config.php' );
}

header("Content-type: text/css; charset=utf-8");

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return $rgb; // returns an array with the rgb values
}

global $theme_option;

$page_boxed_pattern = $theme_option['page_boxed_pattern']['url'];


$main_color= $theme_option['theme_color'];
$menu_color = $theme_option['menu_color'];

$parallax_overlay = hex2rgb($theme_option['parallax_overlay']['color']);
$header_sticky_color = hex2rgb($theme_option['header_sticky_color']['color']);

$social_bg_color = $theme_option['social_bg_color'];


?>

// Theme Color

body{
    background-color: <?php echo $main_color; ?>;
}

body.boxed {
    background:  url(<?php echo $page_boxed_pattern; ?>) 50% 0 repeat fixed <?php echo $main_color; ?>;
}

.page-section.overcolor .parallax-overlay,
.overcolor .parallax-overlay {
    background-color: rgba(<?php echo $parallax_overlay[0]; ?>,<?php echo $parallax_overlay[1]; ?>, <?php echo $parallax_overlay[2]; ?>, 0.5);
}

.owl-theme .owl-controls .owl-page.active span {
    background-color: <?php echo $main_color; ?>;
}

h1 .fa,
h2 .fa,
h3 .fa,
h4 .fa,
h5 .fa,
h6 .fa {
    color: <?php echo $main_color; ?>;
}

.section-title small:before,
.bloglist small:before{
    background-color: <?php echo $main_color; ?>;
}



a,
a:hover,
a:active,
a:focus {
    color: <?php echo $main_color; ?>;
}



.sf-menu li > a {
    color: <?php echo $menu_color; ?>;
}

.do-up:hover .caption-category a {
    color: <?php echo $menu_color; ?>;
}

.sf-menu > li > a.active-off:after,
.sf-menu > li.active > a:after,
.sf-menu > li:hover > a:after,
.sf-menu > li.sfHover-off > a:after {
    background-color: <?php echo $menu_color; ?> !important;
}

.list-ul .fa {
    color: <?php echo $main_color; ?>;
}

.btn-theme-primary {
    background-color: <?php echo $main_color; ?>;
    border-color: <?php echo $main_color; ?>;
}

.btn-theme-primary:focus,
.btn-theme-primary:active,
.btn-theme-primary:hover {
    background-color: <?php echo $main_color; ?>;
    border-color: <?php echo $main_color; ?>;
}

.btn-theme-white:hover {
    background-color: <?php echo $main_color; ?>;
}

.form-control:focus {
    border-color: <?php echo $main_color; ?>;
}

.price-table-header {
    background-color: <?php echo $main_color; ?>;
}

.wide .header.sticky-header,
.boxed .header.sticky-header > .container {
    background-color: rgba(<?php echo $header_sticky_color[0]; ?>, <?php echo $header_sticky_color[1]; ?>,<?php echo $header_sticky_color[2]; ?>, 0.9)
}

.wide .header,
.boxed .header > .container {
    background-color: <?php echo $main_color; ?>;
}

.sub-menu a:hover {
    color: <?php echo $main_color; ?> !important;
}

.post-author a:hover {
    color: <?php echo $main_color; ?>;
}

.post-meta a:hover {
    color: <?php echo $main_color; ?>;
}

.post-media .media-link {
    background-color: <?php echo $main_color; ?>;
}

.post-title a:hover {
    color: <?php echo $main_color; ?>;
}

.timeline .item-left .dot,
.timeline .item-right .dot {
    background-color: <?php echo $main_color; ?>;
}

.nav-tabs > li > a {
    color: <?php echo $main_color; ?>;
}

.do-up:hover .caption {
    background-color: <?php echo $main_color; ?>;
}

.do-up .caption-category a {
    color: <?php echo $main_color; ?>;
}

.do-up .caption-social {
    background-color: <?php echo $social_bg_color; ?>
}

.do-hover .caption {
    background-color: rgba(<?php echo $parallax_overlay[0]; ?>,<?php echo $parallax_overlay[1]; ?>, <?php echo $parallax_overlay[2]; ?>, 0.5);    
}

.feature:hover .media-object,
.feature.hover .media-object {
    color: <?php echo $main_color; ?>;
}

.last-tweet .twitter-icon .fa {
    color: <?php echo $main_color; ?>;
}

.last-tweet a {
    color: <?php echo $main_color; ?>;
}

.media .post-date {
    color: <?php echo $main_color; ?>;
}

.totop {
    background-color: <?php echo $main_color; ?>;
}

.totop:hover {
    background-color: rgba(<?php echo $parallax_overlay[0]; ?>,<?php echo $parallax_overlay[1]; ?>, <?php echo $parallax_overlay[2]; ?>, 0.5);
}

.gallery_schedule .owl-prev,
.gallery_schedule .owl-next{
  color: <?php echo $main_color; ?>!important;
}


.pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus{
  
  background-color: <?php echo $main_color; ?>;
  border-color:<?php echo $main_color; ?>;
}

.pagination>li>a, .pagination>li>span{
  color:<?php echo $main_color; ?>;
}
.pagination span.current{
  background-color: <?php echo $main_color; ?>;
  border-color:<?php echo $main_color; ?>;
  color: #fff; 
}

.widget_tag_cloud .tagcloud a:hover{
  background-color: <?php echo $main_color; ?>;
  cursor: pointer:
}