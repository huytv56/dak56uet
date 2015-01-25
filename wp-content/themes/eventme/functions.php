<?php

define('TEXT_DOMAIN','eventme');


// Load the theme of translated strings
$lang = get_template_directory() . '/languages';
load_theme_textdomain(TEXT_DOMAIN, $lang);

// Require generate shortcode
require_once get_template_directory().'/mce/mce_ova.php';

// Require theme option
require_once get_template_directory() . '/framework/redux/sample-config.php';
global $theme_option;



//Custom fields
include dirname( __FILE__ ) . '/framework/Custom-Metaboxes/metabox-functions.php';

// Post Type
require_once dirname( __FILE__ ) . '/framework/post_type.php';

// Shortcode
require get_template_directory() . '/framework/shortcode.php';
require get_template_directory() . '/framework/shortcode_slideshow.php';


// Create sidebar right
$args = array(
    'name' => sprintf( __( 'Sidebar right', TEXT_DOMAIN) ),
    'id' => "sidebar-right",
    'description' => __( 'Sidebar right', TEXT_DOMAIN ),
    'class' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => "</h3>",
);
register_sidebar( $args );

function ova_theme_setup(){
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    if ( ! isset( $content_width ) ) $content_width = 900;

    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    // Switches default core markup for search form, comment form, and comments    
    // to output valid HTML5.
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

    /*
     * This theme supports all available post formats by default.
     * See http://codex.wordpress.org/Post_Formats
     */
     add_theme_support( 'post-formats', array(
         'audio', 'gallery', 'image', 'link', 'video'
     ) );

    add_theme_support( 'post-thumbnails' );

    add_shortcode('gallery', '__return_false');

    add_theme_support( 'custom-header' );
    add_theme_support( 'custom-background');

    if ( function_exists( 'add_theme_support' ) ) {
        add_theme_support( 'post-home-thumbnails' );
        set_post_thumbnail_size( 318, 250,true );
    }

}
add_action( 'after_setup_theme', 'ova_theme_setup' );


function ova_register_menus() {
  register_nav_menus( array(
    'primary'   => __( 'Subpage Menu', TEXT_DOMAIN ),
    'one_page'   => __( 'One Page Menu', TEXT_DOMAIN ),
  ) );
}
add_action( 'init', 'ova_register_menus' );

/**
 * Enqueues scripts and styles for front end.
 *
 */
 function ova_theme_scripts_styles() {

    global $theme_option;

    // Adds JavaScript to pages with the comment form to support sites with
    wp_enqueue_script("jquery");
    wp_enqueue_script("jquery-migrate", get_template_directory_uri()."/assets/plugins/jquery-migrate.min.js",array(),false,true);
    wp_enqueue_script("bootstrap-min", get_template_directory_uri()."/assets/plugins/bootstrap/js/bootstrap.min.js",array(),false,true);
    wp_enqueue_script("modernizr-custom", get_template_directory_uri()."/assets/plugins/modernizr.custom.js",array(),false,true);    
    wp_enqueue_script("superfish", get_template_directory_uri()."/assets/plugins/superfish/js/superfish.js",array(),false,true);
    wp_enqueue_script("prettyPhoto", get_template_directory_uri()."/assets/plugins/prettyPhoto/js/jquery.prettyPhoto.js",array(),false,true);
    wp_enqueue_script("placeholdem", get_template_directory_uri()."/assets/plugins/placeholdem.min.js",array(),false,true);
    

    wp_enqueue_script("jquery-plugin", get_template_directory_uri()."/assets/plugins/countdown/jquery.plugin.min.js",array(),false,true);
    wp_enqueue_script("jquery-countdown", get_template_directory_uri()."/assets/plugins/countdown/jquery.countdown.min.js",array(),false,true);
    wp_enqueue_script("jquery-isotope", get_template_directory_uri()."/assets/plugins/isotope/jquery.isotope.min.js",array(),false,true);

    if(is_rtl()){
      wp_enqueue_script("owl-carousel-rtl", get_template_directory_uri()."/assets/plugins/owl-carousel/owl.carousel-rtl.js",array(),false,true);  
      wp_enqueue_script("gallery-rtl", get_template_directory_uri()."/assets/plugins/owl-carousel/gallery-rtl.js",array(),false,true);  
    }else{
      wp_enqueue_script("owl-carousel-min", get_template_directory_uri()."/assets/plugins/owl-carousel/owl.carousel.min.js",array(),false,true);
      wp_enqueue_script("gallery-ltr", get_template_directory_uri()."/assets/plugins/owl-carousel/gallery-ltr.js",array(),false,true);  
    }    


    wp_enqueue_script("waypoints", get_template_directory_uri()."/assets/plugins/waypoints.min.js",array(),false,true);
    wp_enqueue_script("easing", get_template_directory_uri()."/assets/plugins/jquery.easing.min.js",array(),false,true);
    wp_enqueue_script("smoothscroll", get_template_directory_uri()."/assets/plugins/jquery.smoothscroll.min.js",array(),false,true);
    wp_enqueue_script("stellar", get_template_directory_uri()."/assets/plugins/jquery.stellar.min.js",array(),false,true);
    // wp_enqueue_script("ajaxchimp", get_template_directory_uri()."/assets/plugins/jquery.ajaxchimp.js",array(),false,true);
    // wp_enqueue_script("ajaxchimp-langs", get_template_directory_uri()."/assets/plugins/jquery.ajaxchimp.langs.min.js",array(),false,true);

    

    wp_enqueue_script("theme", get_template_directory_uri()."/assets/js/theme.js",array(),false,true);
    wp_enqueue_script("init_theme", get_template_directory_uri()."/assets/js/init_theme.js",array(),false,true);
    

    // Loads our main stylesheet.   
    wp_enqueue_style( 'bootstrap_min', get_template_directory_uri().'/assets/plugins/bootstrap/css/bootstrap.min.css');
    wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/assets/plugins/font-awesome/css/font-awesome.min.css');
    wp_enqueue_style( 'superfish', get_template_directory_uri().'/assets/plugins/superfish/css/superfish.css');
    wp_enqueue_style( 'prettyPhoto', get_template_directory_uri().'/assets/plugins/prettyPhoto/css/prettyPhoto.css');
    wp_enqueue_style( 'animate', get_template_directory_uri().'/assets/plugins/animate.css');
    wp_enqueue_style( 'jquery_countdown', get_template_directory_uri().'/assets/plugins/countdown/jquery.countdown.css');
    wp_enqueue_style( 'jquery_isotope', get_template_directory_uri().'/assets/plugins/isotope/jquery.isotope.css');

    if(is_rtl()){
      wp_enqueue_style( 'owl_carousel_rtl', get_template_directory_uri().'/assets/plugins/owl-carousel/owl.carousel-rtl.css');  
    }else{
      wp_enqueue_style( 'owl_carousel', get_template_directory_uri().'/assets/plugins/owl-carousel/owl.carousel.css');
    }
    

    wp_enqueue_style( 'owl_theme', get_template_directory_uri().'/assets/plugins/owl-carousel/owl.theme.css');   

    wp_enqueue_style( 'theme-style', get_stylesheet_uri(), array(), '2014-04-05' );    
    wp_enqueue_style( 'style-css', get_template_directory_uri().'/style.php');
}
add_action( 'wp_enqueue_scripts', 'ova_theme_scripts_styles' );

//For IE
function ova_cams_script_ie() {
    echo '
   	<!--[if (gte IE 9)|!(IE)]><!-->
	<!--script src="'.get_template_directory_uri().'/assets/plugins/jquery.cookie.js"></script>
	<script src="'.get_template_directory_uri().'/assets/plugins/style-switcher/style.switcher.js"></script-->
	<!--<![endif]-->
  ';
}
add_action( 'wp_head', 'ova_cams_script_ie' );

function eventme_do_shortcode($content) {
    global $shortcode_tags;
    if (empty($shortcode_tags) || !is_array($shortcode_tags))
        return $content;
    $pattern = get_shortcode_regex();
    return preg_replace_callback( "/$pattern/s", 'do_shortcode_tag', $content );
}




// Start Display View Count of Post without Plugin
function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}



function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

// End Display View Count of Post without Plugin

add_filter( 'excerpt_length', 'ova_custom_excerpt_length', 999 );
function ova_custom_excerpt_length( $length ) {
    return 42;
}

function custom_excerpt($limit) {
  $excerpt = explode(' ', get_the_content(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}




add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more( $more ) {
    return '';
}


// Remove Background and Header setting in Appearance
add_action( 'after_setup_theme','remove_theme_support_ova', 100 );
function remove_theme_support_ova() {
    remove_theme_support( 'custom-background' );
    remove_theme_support( 'custom-header' );
}


//Custom comment List:


function ova_theme_comment($comment, $args, $depth) {
    //echo 's';
   $GLOBALS['comment'] = $comment; ?>   
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
     <article class="comment_item" id="comment-<?php comment_ID(); ?>">
         <header class="comment-author">
         <?php echo get_avatar($comment,$size='85',$default='http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=70' ); ?>
         </header>
         <section class="comment-details">
             <div class="comment-meta commentmetadata clearfix media-body author-name">
                  <div class="author-name">
                    <?php printf(__('%s', TEXT_DOMAIN), get_comment_author_link()) ?>
                    <?php printf(get_comment_date()) ?>
                  </div> 
                  
              </div>

              <div class="comment-body clearfix comment-content">
                  <?php comment_text() ?>
                  <div class="pull-left">
                    <?php edit_comment_link(__('(Edit)', TEXT_DOMAIN),'  ','') ?>
                  <a href="" title=""> <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                  </div>
                  
                </div>
                
             
          </section>
          <?php if ($comment->comment_approved == '0') : ?>
             <em><?php _e('Your comment is awaiting moderation.', TEXT_DOMAIN) ?></em>
             <br />
          <?php endif; ?>
      
        
     </article>
<?php
        }

function ova_do_shortcode($content) {
    global $shortcode_tags;
    if (empty($shortcode_tags) || !is_array($shortcode_tags))
        return $content;
    $pattern = get_shortcode_regex();
    return preg_replace_callback( "/$pattern/s", 'do_shortcode_tag', $content );
}


function ova_numeric_posts_nav() {
   
    if( is_singular() )
        return;
 
    global $wp_query;
 
    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;
 
    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );
 
    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;
 
    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }
 
    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }
 
    echo '<ul class="pagination clearfix">' . "\n";
 
    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link('&laquo;') );
 
    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';
 
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
 
        if ( ! in_array( 2, $links ) )
            echo '<li>...</li>';
    }
 
    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }
 
    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>...</li>' . "\n";
 
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }
 
    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link('&raquo;') );
 
    echo '</ul>' . "\n";
 
}


/* Register Event */
function ova_enqueue_scripts_styles_init() {
  wp_enqueue_script( 'ajax-script', get_template_directory_uri().'/assets/plugins/register_event.js', array('jquery'), 1.0 );
  wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('init', 'ova_enqueue_scripts_styles_init');


function ajax_action_stuff() {
  $data     = $_POST['data'];
  $email    = $data['email'];
  $message  = $data['message'];
  $name     = $data['name'];
  $phone    = $data['phone'];
  $event_title = $data['event_title'];

  if(trim($email) == '' || trim($message) == '' || trim($name) == '' || trim($phone) == '' ){
    echo 'false';
    die;
  }

  $content = '<strong>'.__('Name').' :'.$name.'<br/>'.__('Phone: ').': '. $phone . '</strong><br/>'. $message;

  $post_information = array(
    'post_title' => wp_strip_all_tags( $event_title.' - '.$email ),
    'post_content' => $content,
    'post_type' => 'registerlist',    
    'post_status' => 'publish'
  );   

  if(wp_insert_post( $post_information )){
    echo 'true';
  }else{
    echo 'false';
  }
  die(); // stop executing script
}
add_action( 'wp_ajax_ajax_action', 'ajax_action_stuff' ); // ajax for logged in users
add_action( 'wp_ajax_nopriv_ajax_action', 'ajax_action_stuff' );


/*==========================================================================
Fix Youtube
==========================================================================*/
add_filter( 'oembed_result', 'pgl_framework_fix_oembeb' );
function pgl_framework_fix_oembeb( $url ){
    $array = array (
        'webkitallowfullscreen'     => '',
        'mozallowfullscreen'        => '',
        'frameborder="0"'           => '',
        '</iframe>)'        => '</iframe>'
    );
    $url = strtr( $url, $array );

    if ( strpos( $url, "<embed src=" ) !== false ){
        return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $url);
    }
    elseif ( strpos ( $url, 'feature=oembed' ) !== false ){
        return str_replace( 'feature=oembed', 'feature=oembed&amp;wmode=opaque', $url );
    }
    else{
        return $url;
    }
}

/* Visual Composer */
if(function_exists('vc_add_param')){

  vc_add_param('vc_row',array(
          "type" => "textfield",
          "heading" => __('Section ID', TEXT_DOMAIN),
          "param_name" => "el_id",
          "value" => "",
          "description" => __("Set ID section", TEXT_DOMAIN),   
    ));  
  vc_add_param('vc_row',array(
        "type" => "dropdown",
        "heading" => __('Fullwidth', TEXT_DOMAIN),
        "param_name" => "fullwidth",
        "value" => array(   
                __('No', TEXT_DOMAIN) => 'no',  
                __('Yes', TEXT_DOMAIN) => 'yes',                                                                                
                ),
        "description" => __("Select Fullwidth or not", TEXT_DOMAIN),      
      ) 
    );

  vc_add_param('vc_row',array(
        "type" => "attach_image",
        "heading" => __('Background Image', TEXT_DOMAIN),
        "param_name" => "bg_image_custom",
        "description" => __("Select Fullwidth or not", TEXT_DOMAIN),      
      ) 
    );

  

}


//Active Plugin: 
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package       TGM-Plugin-Activation
 * @subpackage Example
 * @version       2.3.6
 * @author       Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author       Gary Jones <gamajo@gamajo.com>
 * @copyright  Copyright (c) 2012, Thomas Griffin
 * @license       http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/framework/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function my_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        
      
        array(
            'name'                     => 'Contact Form 7',
            'slug'                     => 'contact-form-7',
            'required'                 => true,
        ),
        array(
            'name'                     => 'Redux Framework',
            'slug'                     => 'redux-framework',
            'required'                 => true,
        ),
        array(
            'name'                     => 'Twitter Shortcode',
            'slug'                     => 'twitter',
            'required'                 => true,
            'source'                   => get_template_directory() . '/framework/plugins/twitter.zip',
        ),
        array(
            'name'                     => 'Mailchimp for wp',
            'slug'                     => 'mailchimp-for-wp',
            'required'                 => true,
        ),
        array(
            'name'                     => 'WPBakery Visual Composer',
            'slug'                     => 'js_composer',
            'required'                 => true,
            'source'                   => get_template_directory() . '/framework/plugins/js_composer.zip',
        )
        
    );

    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = TEXT_DOMAIN;

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'               => TEXT_DOMAIN,             // Text domain - likely want to be the same as your theme.
        'default_path'         => '',                             // Default absolute path to pre-packaged plugins
        'parent_menu_slug'     => 'themes.php',                 // Default parent menu slug
        'parent_url_slug'     => 'themes.php',                 // Default parent URL slug
        'menu'                 => 'install-required-plugins',     // Menu slug
        'has_notices'          => true,                           // Show admin notices or not
        'is_automatic'        => false,                           // Automatically activate plugins after installation or not
        'message'             => '',                            // Message to output right before the plugins table
        'strings'              => array(
            'page_title'                                   => __( 'Install Required Plugins', TEXT_DOMAIN ),
            'menu_title'                                   => __( 'Install Plugins', TEXT_DOMAIN ),
            'installing'                                   => __( 'Installing Plugin: %s', TEXT_DOMAIN ), // %1$s = plugin name
            'oops'                                         => __( 'Something went wrong with the plugin API.', TEXT_DOMAIN ),
            'notice_can_install_required'                 => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'                      => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'                => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'            => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                     => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                         => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'                         => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                                   => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                               => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                                       => __( 'Return to Required Plugins Installer', TEXT_DOMAIN ),
            'plugin_activated'                             => __( 'Plugin activated successfully.', TEXT_DOMAIN ),
            'complete'                                     => __( 'All plugins installed and activated successfully. %s', TEXT_DOMAIN ), // %1$s = dashboard link
            'nag_type'                                    => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );

    tgmpa( $plugins, $config );

}        