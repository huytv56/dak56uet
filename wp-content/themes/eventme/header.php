<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<?php 
	global $theme_option; 
	global $wp_query;

	$seo_title = get_post_meta($wp_query->get_queried_object_id(), "_cmb_seo_title", true);
    $seo_description = get_post_meta($wp_query->get_queried_object_id(), "_cmb_seo_description", true);
    $seo_keywords = get_post_meta($wp_query->get_queried_object_id(), "_cmb_seo_keywords", true);

    $page_layout = $theme_option['page_layout']?$theme_option['page_layout']:'wide';
    if(is_rtl()){
        $page_text_direction = 'rtl';
    }else{
        $page_text_direction = 'ltr';
    }
    //$page_text_direction = $theme_option['page_text_direction'];
    
    $template_blog = '';
    $single_class = '';

    
    if(is_page_template('home_template.php' ) == false){
        $single_class = 'blog';
    }
        
    


    $class_extra = $page_layout.' '. $template_blog.' '.$page_text_direction. ' '.$single_class;

    
?>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title><?php if($seo_title!="") { ?><?php bloginfo('name'); ?> | <?php echo $seo_title; ?><?php } else {?><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?><?php } ?></title>
    <meta name="author" content="ovatheme_">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- For SEO -->
    <?php if($seo_description!="") { ?>
        <meta name="description" content="<?php echo $seo_description; ?>">
    <?php }elseif(isset($theme_option['seo_des'])){ ?>
        <meta name="description" content="<?php echo $theme_option['seo_des']; ?>">
    <?php } ?>
    <?php if($seo_keywords!="") { ?>
        <meta name="keywords" content="<?php echo $seo_keywords; ?>">
    <?php }elseif(isset($theme_option['seo_keywords'])){ ?>
        <meta name="keywords" content="<?php echo $theme_option['seo_keywords']; ?>">
    <?php } ?>
    <!-- End SEO-->

    <link rel="shortcut icon" href="<?php if(isset($theme_option['favicon']['url'])) echo $theme_option['favicon']['url']; ?>">
    <link rel="apple-touch-icon" href="<?php if(isset($theme_option['app_icon']['url'])) echo $theme_option['app_icon']['url']; ?>">

    <style>
        .page-section.subscribe .parallax-bg {
            background-image: url(<?php echo $theme_option['subscribe_background']['url'];  ?>);
        }
        .page-section.directions .parallax-bg {
        background-image: url(<?php echo $theme_option['location_background']['url'];  ?>);
        }
    </style>

     <style type="text/css" media="screen">
        .wide .page-section.image{
            background-image: url(<?php echo $theme_option["background_blog_heading"]["url"]?$theme_option["background_blog_heading"]["url"]:get_template_directory_uri().'/assets/img/preview/bg-mainslider-1.jpg'; ?>);
        }
        .wide .page-section.image:before {        
            background: url(<?php echo $theme_option["background_blog_overlay"]["url"]?$theme_option["background_blog_overlay"]["url"]:get_template_directory_uri().'/assets/img/main-slider-overlay.png'; ?>)
            
        }
        
    </style>
    <?php if($theme_option['custom_css']){ ?>
        <style>
            <?php echo $theme_option['custom_css']; ?>
        </style>
    <?php } ?>

    <?php if($theme_option['custom_js']){ ?>
    <script>
        jQuery(document).ready(function($){
            <?php echo $theme_option['custom_js']; ?>
        });
    </script>
    <?php } ?>

    <?php wp_head(); ?>

</head>

<body <?php body_class($class_extra); ?>>

<!-- Google Analytics start -->
<?php if (isset($theme_option['google_analytics'])){
    if($theme_option['google_analytics'] != "") { ?>
        <script>
            <?php echo $theme_option['google_analytics']; ?>
        </script>
    <?php }
}
?>
<!-- Google Analytics end -->

<!-- Preloader -->
<?php if($theme_option['display_reload'] != 0){ ?>

    <?php if($theme_option['display_reload'] == 1){ ?>
        <div id="preloader">
            <div id="status"><i class="fa <?php echo $theme_option['reload_icon']; ?>"></i></div>
        </div>
    <?php } else if($theme_option['display_reload'] == 2){ ?>
        <div id="preloader">
            <div id="status">
                <img src="<?php echo $theme_option['reload_image']['url']; ?>" alt="spin">
            </div>
        </div>
    <?php } ?>
<?php } ?>

<!-- Wrap all content -->
<div class="wrapper">


     <!-- Header -->
    <header class="header">
        <div class="container">

            <!-- Logo -->
            <div class="logo">			
                <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>" class="scroll-to">
				<?php if($theme_option['logo_image']['url']){ ?>
                    <img src="<?php echo $theme_option['logo_image']['url']; ?>" alt="<?php echo bloginfo('name'); ?>"/>
				<?php } else { ?>	
					<h3><?php echo __('Event Me', TEXT_DOMAIN); ?></h3>
				<?php } ?>
                </a>
            </div>
            <!-- /Logo -->

            <!-- Navigation -->
            <div id="mobile-menu"></div>
            <nav class="navigation clearfix">
                <?php 
                    
                    $menu_style = 'primary';
                    if(is_page_template('home_template.php') || !has_nav_menu('primary')){
                        $menu_style = 'one_page';
                    }
                    
                ?>
                <?php wp_nav_menu(
                    array(
                            'theme_location'  => $menu_style,
                            'menu'            => '',
                            'container'       => 'container',
                            'container_class' => 'container_class',
                            'container_id'    => '',
                            'menu_class'      => 'sf-menu nav',
                            'menu_id'         => '',
                            'echo'            => true,
                            'fallback_cb'     => 'wp_page_menu',
                            'before'          => '',
                            'after'           => '',
                            'link_before'     => '',
                            'link_after'      => '',
                            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'depth'           => 0,
                            'walker'          => ''
                        )
                ); ?>
            </nav>
            <!-- /Navigation -->

        </div>
    </header>
    <!-- /Header -->

    <!-- Content area-->
    <div class="content-area content">