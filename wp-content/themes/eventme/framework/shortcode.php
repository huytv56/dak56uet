<?php

// Create Section
add_shortcode('section', 'shortcode_section');
function shortcode_section($atts, $content = null) {
    $atts = shortcode_atts(
    array(
    'class'         => '',
    'id'            => '',
    'rowvisible'    => '1',
    'parallax_bg'   => '',
    ), $atts);
    $hand_sec = rand();
    $class_parallax = '';
    if($atts['parallax_bg']!= ""){
        $class_parallax = 'parallax';
    }
    $html = "";
    $html .='<section class=" page-section '.$atts['class'].' '.$class_parallax.'" id="'.$atts['id'].'">
            <div class="container">';

            if($atts['parallax_bg']!= ""){
                $html .= '<div class="parallax-bg bg'.$hand_sec.'" data-stellar-background-ratio="0.5" style="background-image: url('.$atts['parallax_bg'].')">
                </div>
                <div class="parallax-overlay"></div>
                <div class="parallax-inner text-center">';
            }

            if($atts['rowvisible']){
                $html .= '<div class="row">';
            }

        $html .= do_shortcode($content);

            if($atts['rowvisible']){
                $html .='</div>';
            }

            if($atts['parallax_bg']!= ""){
                $html .= '</div>';    
            }

    $html .='</div></section>';
    return $html;
}

// one_fourth column
add_shortcode('one_fourth', 'shortcode_one_fourth');
function shortcode_one_fourth($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => '',
    ), $atts);
    $html ='';
    $html .= '<div class="col-md-3 col-sm-6 '. $atts['class'].'">
    '.do_shortcode($content).'
    </div>';
    return $html;
}

// one_third column
add_shortcode('one_third', 'shortcode_one_third');
function shortcode_one_third($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => '',
    ), $atts);
    $html ='';
    $html .= '<div class="col-md-4  col-sm-12'. $atts['class'].'">
    '.do_shortcode($content).'
    </div>';
    return $html;
}

// one_half column
add_shortcode('one_half', 'shortcode_one_half');
function shortcode_one_half($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => '',
    ), $atts);
    $html ='';
    $html .= '<div class="col-md-6 col-sm-6'. $atts['class'].'">
    '.do_shortcode($content).'
    </div>';
    return $html;
}

// one_half column
add_shortcode('one_half_inside', 'shortcode_one_half_inside');
function shortcode_one_half_inside($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => '',
    ), $atts);
    $html ='';
    $html .= '<div class="col-md-6 col-sm-6'. $atts['class'].'">
    '.do_shortcode($content).'
    </div>';
    return $html;
}

// one_full column
add_shortcode('one_full', 'shortcode_one_full');
function shortcode_one_full($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => '',
    ), $atts);
    $html ='';
    $html .= '<div class="col-md-12 '. $atts['class'].'">
    '.do_shortcode($content).'
    </div>';
    return $html;
}

// two_third column
add_shortcode('two_third', 'shortcode_two_third');
function shortcode_two_third($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'class' => '',
    ), $atts);
    $html ='';
    $html .= '<div class="col-md-8 col-sm-8'. $atts['class'].'">
    '.do_shortcode($content).'
    </div>';
    return $html;
}

// Group button
add_shortcode('groupbutton', 'shortcode_groupbutton');
function shortcode_groupbutton($atts, $content = null) {
    $html ='<div class="group-button"><div class="btn-theme-group">'.do_shortcode($content).'</div></div>';
    return $html;
}

if(function_exists('vc_map')){

vc_map( array(
   "name" => __("Groupbutton", TEXT_DOMAIN),
   "base" => "groupbutton",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",   
   "params" => array(
    array(
         "type" => "textarea",
         "holder" => "div",
         "class" => "",
         "heading" => __("Content",TEXT_DOMAIN),
         "param_name" => "content",
         "value" => "",
         "description" => ''
      )
   )
) );

}


// Button
add_shortcode('button', 'shortcode_button');
function shortcode_button($atts, $content = null) {
    $atts = shortcode_atts(
        array(
        'position' => 'center',
        'href'  => '#',        
        'class' => '',        
    ), $atts);
    $html ='';
    $position = '';
    if($atts['position'] == 'left') $position = 'pull-left';
    if($atts['position'] == 'right') $position = 'pull-right';
    if($atts['position'] == 'center') $position = 'text-center';

    $html .= '<div class="'.$position.'"><a class="btn btn-theme '.$atts['class'].'" href="'.$atts['href'].'">'.do_shortcode($content).'</a></div>';
    return $html;
}

if(function_exists('vc_map')){

vc_map( array(
   "name" => __("button", TEXT_DOMAIN),
   "base" => "button",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",   
   "params" => array(
    array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => __("Position",TEXT_DOMAIN),
         "param_name" => "position",
         "value" => array(   
                __('center', TEXT_DOMAIN) => 'center',
                __('left', TEXT_DOMAIN) => 'left',
                __('right', TEXT_DOMAIN) => 'right',
                ),
         "description" => ''
    ),
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Href",TEXT_DOMAIN),
         "param_name" => "href",
         "value" => "#",
         "description" => ''
    ),
     array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Class",TEXT_DOMAIN),
         "param_name" => "class",
         "value" => "",
         "description" => ''
    ),
    array(
         "type" => "textarea",
         "holder" => "div",
         "class" => "",
         "heading" => __("Content",TEXT_DOMAIN),
         "param_name" => "content",
         "value" => "",
         "description" => ''
    )

   )
) );

}


// Heading Title
add_shortcode('heading', 'shortcode_heading');
function shortcode_heading($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'title' => 'Sample Data',        
        'class' => '',
    ), $atts);
    $html ='';
    $html .= '<div style="clear:both;"></div><h3 class="section-title text-center '.$atts['class'].'" data-animation="fadeInUp" data-animation-delay="0">'.$atts['title'].'<small>'.do_shortcode($content).'</small></h3>';
    return $html;
}


if(function_exists('vc_map')){

vc_map( array(
   "name" => __("Heading", TEXT_DOMAIN),
   "base" => "heading",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",
   "params" => array(
     array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title",TEXT_DOMAIN),
         "param_name" => "title",
         "value" => "",
         "description" => 'The title'
      ),   
     array(
         "type" => "textarea",
         "holder" => "div",
         "class" => "",
         "heading" => __("Content",TEXT_DOMAIN),
         "param_name" => "content",
         "value" => "",
         "description" => ''
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("class",TEXT_DOMAIN),
         "param_name" => "Class",
         "value" => "",
         "description" => ''
      )
   
     
   )
) );

}

// divide Shortcode
add_shortcode('hr', 'shortcode_hr');
function shortcode_hr($atts, $content=null){
    $html ='<hr class="page-divider half hidden-md"/>';
    return $html;
}


// List Shortcode
add_shortcode('list', 'shortcode_list');
function shortcode_list($atts, $content=null){
    $atts = shortcode_atts(
        array(        
        'class' => 'text-md'
    ), $atts);
    $html ='';
    $html .= '<ul class="list-ul '.$atts['class'].'">'.do_shortcode($content).'</ul>';
    return $html;
}





// List Item Shortcode
add_shortcode('list_item', 'shortcode_list_item');
function shortcode_list_item($atts, $content=null){
    $atts = shortcode_atts(
        array(        
        'type' => 'fa-stop'
    ), $atts);
    $html ='';
    $html .= '<li><i class="fa '.$atts['type'].'"></i>'.do_shortcode($content).'</li>';
    return $html;
}


// Thumbnail Title
add_shortcode('thumbnail', 'shortcode_thumbnail');
function shortcode_thumbnail($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'img_thumb_url' => '',
        'img_big_url'   => '',
        'href' => '',        
        'class' => '',
    ), $atts);
    $html ='';
    $html .= '<div class="thumbnail do-hover no-border '.$atts['class'].'">
                <img src="'.$atts['img_thumb_url'].'" class="img-responsive" alt="">
                <div class="caption">
                    <div class="caption-wrapper div-table">
                        <div class="caption-inner div-cell">
                            <p class="caption-buttons">';
                                if($atts['href']){
                                    $html .='<a href="'.$atts['href'].'" class="btn caption-links">
                                    <i class="fa fa-heart"></i></a>';
                                }
                                if($atts['img_big_url']){
                                    $html .='<a data-gal="prettyPhoto" href="'.$atts['img_big_url'].'" class="btn caption-links"><i class="fa fa-eye"></i></a>';
                                }
                            $html .='   
                            </p>
                        </div>
                    </div>
                </div>
            </div>';
    return $html;
}


if(function_exists('vc_map')){

vc_map( array(
   "name" => __("thumbnail", TEXT_DOMAIN),
   "base" => "thumbnail",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",
   "params" => array(
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Thumbnail image path ",TEXT_DOMAIN),
         "param_name" => "img_thumb_url",
         "value" => "",
         "description" => ''
      ),
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Big image path ",TEXT_DOMAIN),
         "param_name" => "img_big_url",
         "value" => "",
         "description" => ''
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Href",TEXT_DOMAIN),
         "param_name" => "href",
         "value" => "",
         "description" => ''
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Class",TEXT_DOMAIN),
         "param_name" => "class",
         "value" => "",
         "description" => ''
      )
   
     
   )
) );

}


// About shortocde
add_shortcode('about', 'shortcode_about');
function shortcode_about($atts, $content=null){
    $atts = shortcode_atts(
        array(
        'iconfont'  => 'fa-calendar',
        'title'     => 'The title',        
        'animation' => 'fadeInUp',
        'timedelay' => '100',
        'class'     => '',
    ), $atts);
    $html ='';
    $html .= '<div class="feature '.$atts['class'].'"><div class="media" data-animation="'.$atts['animation'].'" data-animation-delay="'.$atts['timedelay'].'">
                            <div class="media-object fa '.$atts['iconfont'].'"></div>
                            <div class="media-body">
                                <h4 class="media-heading">'.$atts['title'].'</h4>
                                '.do_shortcode($content).'
                            </div>
                        </div></div>';
    return $html;                        
}

if(function_exists('vc_map')){

vc_map( array(
   "name" => __("About", TEXT_DOMAIN),
   "base" => "about",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",
   "params" => array(
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title",TEXT_DOMAIN),
         "param_name" => "title",
         "value" => "The title",
         "description" => ''
      ),
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Iconfont",TEXT_DOMAIN),
         "param_name" => "iconfont",
         "value" => "fa-calendar",
         "description" => 'Insert fontawesome.'
      ),        
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Animation",TEXT_DOMAIN),
         "param_name" => "animation",
         "value" => "fadeInUp",
         "description" => ''
      ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("timedelay",TEXT_DOMAIN),
         "param_name" => "timedelay",
         "value" => "100",
         "description" => ''
      ),  
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Class",TEXT_DOMAIN),
         "param_name" => "class",
         "value" => "",
         "description" => ''
      ),
      array(
         "type" => "textarea",
         "holder" => "div",
         "class" => "",
         "heading" => __("Content",TEXT_DOMAIN),
         "param_name" => "content",
         "value" => "",
         "description" => ''
      )
     
   )
) );

}

// Schedule shortocde
add_shortcode('schedule', 'shortcode_schedule');
function shortcode_schedule($atts, $content=null){
    global $theme_option;
    $rand_tab = rand();
    $atts = shortcode_atts(
        array(
        'class'     => '',
    ), $atts);
    $html ='';
    $html .= '<div class="row clearfix timeline-tabs '.$atts['class'].'" data-animation="fadeInUp" data-animation-delay="100">
                    <div class="col-sm-12 col-md-10 col-md-offset-1">
                        <ul id="tabs'.$rand_tab.'" class="nav tab_schedule nav-pills nav-justified">';
                        $filter_orderby = $theme_option['schedule_filter_order_by'];
                        $filter_order = $theme_option['schedule_filter_order'];

                        $args_term = array('orderby'=>$filter_orderby,'order'=>$filter_order);
                        $schedules_skills = get_terms('skill', $args_term);
    $i = 0;
    foreach($schedules_skills as $schedule_skills) {
        $schedule_active = '';
        if($i == 0){$schedule_active = 'active'; $i++;}
        $html .='<li class="'.$schedule_active .'">
                        <a href="#'.$schedule_skills->slug.'" data-toggle="tab">
                            '.$schedule_skills->name.'
                        </a>
                </li>';
    }
    $html .='</ul>
                    </div>
                </div>';
    $html .= '<div class="tab-content '.$atts['class'].'">';
    $d = 0;
    foreach($schedules_skills as $schedule_skills) {

        $schedule_active1 = '';
        $k = 0;
        if($d == 0){$schedule_active1 = 'active'; $d++;}

        $html .= '<div class="tab-pane fade in '.$schedule_active1.'" id="'.$schedule_skills->slug.'">                
                <div id="timeline'.$schedule_skills->slug.'" class="row timeline timeline'.$k.' no-transition">';
                if($k==4){ $k =0;}

                $schedule_schedule_order_by = $theme_option['schedule_schedule_order_by'];
                $schedule_schedule_order = $theme_option['schedule_schedule_order'];

                $args = array('post_type' => 'schedule','skill'=>$schedule_skills->slug, 'orderby'=>$schedule_schedule_order_by,'order'=>$schedule_schedule_order , 'posts_per_page' => $theme_option['schedule_tab_count_desc']);
                $schedule = new WP_QUery($args);
                global $post;

                if($schedule->have_posts()):
                    while($schedule->have_posts()): $schedule->the_post();

                    $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id());
                    $schedule_time = get_post_meta($post->ID, "_cmb_schedule_time", true);
                    $schedule_address = get_post_meta($post->ID, "_cmb_schedule_address", true);

                    
                    $schedule_display_time = $theme_option['schedule_display_time']?$theme_option['schedule_display_time']:0;                                        
                    $schedule_display_address = $theme_option['schedule_display_address']?$theme_option['schedule_display_address']:0;                    
                    $schedule_display_view = $theme_option['schedule_display_view']?$theme_option['schedule_display_view']:0;                    
                    $schedule_display_author = $theme_option['schedule_display_author']?$theme_option['schedule_display_author']:0;
                    $schedule_display_desc = $theme_option['schedule_display_desc']?$theme_option['schedule_display_desc']:0;
                    

        $html .= '<div class="item col-sm-6">
                    <span class="dot"></span>
                    <article class="post-wrap thumbnail">
                        <div class="post-media">
                            <div class="thumbnail no-border ">';

                            if(has_post_format('audio')){

                                $html .='<div class="js-video postformat_audio">'.
                                        wp_oembed_get(get_post_meta($post->ID, "_cmb_embed_media", true), array('width'=>400)).'
                                    </div>';
                            }else if(has_post_format('video')){
                                $html .='<div class="js-video postformat_video">'.
                                        wp_oembed_get(get_post_meta($post->ID, "_cmb_embed_media", true), array('width'=>500)).'
                                    </div>';
                            }else if(has_post_format('gallery')){

                                $gallery = get_post_gallery( $post->ID, false );

                                if(isset($gallery['ids'])){
                                    $gallery_ids = $gallery['ids'];
                                    $img_ids = explode(",",$gallery_ids);
                                    $i=1;
                                    $html .= '<div class="gallery_schedule gallery_schedule'.$post->ID.' owl-carousel" >';
                                    foreach( $img_ids AS $img_id ){
                                        $image_src = wp_get_attachment_image_src($img_id,'');
                                        $html .='<div><img class="img-responsive" src="'.$image_src[0].'" alt=""></div>';
                                        $i++;
                                    }
                                    $html .= '</div>';                                    
                                    
                                }
                            }else if(has_post_format('image')){
                                $html .= '<div class="do-hover"><img class="img-responsive" src="'.$thumbnail_url.'" alt="'.get_the_title().'"></div>';
                            }else if(has_post_format('link')){
                                $html .= '<div class="media-link">
                                <i class="fa fa-link"></i>'.get_the_content().'
                                </div>';
                                
                            }

                            $html .= '</div>';

                            if($schedule_display_time || $schedule_display_address || $schedule_display_view){
                            $html .= '<div class="post-meta clearfix">';                            
                            $html .= '<span class="pull-left">';
                            if($schedule_display_time){
                                if($schedule_time){
                                    $html .= '<span class="post-date">
                                                <i class="fa fa-clock-o"></i> 
                                                '.$schedule_time.'
                                            </span>';
                                        }
                                }
                            if($schedule_display_address){
                                if($schedule_address){    
                                    $html .= '  <span class="post-location">
                                                    <i class="fa fa-map-marker"></i> 
                                                    '.$schedule_address.'
                                                </span>';
                                    }
                                }
                            $html .= '</span>';
                            if($schedule_display_view){
                            $html .='<span class="pull-right"><i class="fa fa-eye"></i>&nbsp;'.wpb_get_post_views(get_the_ID()).'</span>';
                            }

                            $html .='</div>';
                            }

                        $html .= '</div>

                        <div class="post-header">
                            <h4 class="post-title">
                                <a href="'.get_permalink().'">'.get_the_title().'</a>
                            </h4>';

                        if($schedule_display_author){
                            $html .='<span class="post-author">'.__('by').' <a href="'.get_the_author_link().'">'.get_the_author().'</a></span>';
                        }

                        $html .= '</div>';

                        if($schedule_display_desc){
                            $html .= '<div class="post-body">
                                        <div class="post-excerpt">'
                                        .custom_excerpt($theme_option["schedule_count_word"]).
                                        '</div></div>';
                        }

                        $html .='
                    </article>
                </div>';

                endwhile;
                endif;

        $html .= '</div> <!-- end timeline -->
                </div> <!-- end tab-pane -->
                ';
    }    
    
    $html .= '<script>
        jQuery(document).ready(function($){
            $("#tabs'.$rand_tab.' a").click(function (e) {                
                var height_gallery = $(".gallery_schedule'.$post->ID.'").innerHeight();
                $(".gallery_schedule'.$post->ID.'").css("height",height_gallery);
                e.preventDefault();
                $(this).tab("show");

            });
            theme.initIsotope();
        });        
    </script>';
    $html .= '</div>';
    return $html;                        
}


if(function_exists('vc_map')){

vc_map( array(
   "name" => __("Schedule", TEXT_DOMAIN),
   "base" => "schedule",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",
   "params" => array(
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Class",TEXT_DOMAIN),
         "param_name" => "class",
         "value" => "",
         "description" => ''
      )
     
   )
) );

}


// Speakers shortocde
add_shortcode('speakers', 'shortcode_speakers');
function shortcode_speakers($atts, $content=null){
    global $theme_option;
    $speakers_layout = $theme_option['speakers_layout'];
    
    $atts = shortcode_atts(
        array(        
        'class'  => '',
    ), $atts);
    $html ='';
    $html .= '<div class="speackers">';
    $html .='<div class="row '.$atts['class'].'">';
        $args = array('post_type' => 'speaker','posts_per_page'=> $theme_option['speakers_item_count']);
        $speakers = new WP_QUery($args);
        global $post; $i=0;
        if($speakers->have_posts()):
            while($speakers->have_posts()): $speakers->the_post();

            $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id());            
            $speaker_job = get_post_meta($post->ID, "_cmb_speaker_job", true);

            $speaker_mail_address = get_post_meta($post->ID, "_cmb_speaker_mail_address", true);
            $speaker_facebook_address = get_post_meta($post->ID, "_cmb_speaker_facebook_address", true);
            $speaker_twitter_address = get_post_meta($post->ID, "_cmb_speaker_twitter_address", true);
            $speaker_linkedin_address = get_post_meta($post->ID, "_cmb_speaker_linkedin_address", true);
            $speaker_pinterest_address = get_post_meta($post->ID, "_cmb_speaker_pinterest_address", true);
            $speaker_googleplus_address = get_post_meta($post->ID, "_cmb_speaker_googleplus_address", true);
            $speaker_tumblr_address = get_post_meta($post->ID, "_cmb_speaker_tumblr_address", true);
            $speaker_instagram_address = get_post_meta($post->ID, "_cmb_speaker_instagram_address", true);
            $speaker_vk_address = get_post_meta($post->ID, "_cmb_speaker_vk_address", true);
            $speaker_flickr_address = get_post_meta($post->ID, "_cmb_speaker_flickr_address", true);
            $speaker_mySpace_address = get_post_meta($post->ID, "_cmb_speaker_mySpace_address", true);
            $speaker_youtube_address = get_post_meta($post->ID, "_cmb_speaker_youtube_address", true);
            $speakers_layout_5 = '';    
            if($speakers_layout == 'col-md-2 col-sm-6 col-5' && ($i==0 || $i == 5)){
                    $speakers_layout_5 = 'col-lg-offset-1 col-md-offset-1';
            }
            if($i==5) $i=0; $i++;

                $html .= '<div class="'.$speakers_layout.' '.$speakers_layout_5.'" data-animation="fadeInUp" data-animation-delay="700">
                    <div class="thumbnail do-up no-border">
                        <img src="'.$thumbnail_url.'" class="img-responsive" alt="">
                        <div class="caption">
                            <div class="caption-wrapper div-table">
                                <div class="caption-inner div-cell">
                                    <h4 class="caption-title">'.get_the_title().'</h4>
                                    <p class="caption-category">';
                                    if($theme_option['speakers_speaker_link']){
                                    $html .='<a href="'.get_permalink().'">'.$speaker_job.'</a>';
                                    }else{
                                        $html .=$speaker_job;
                                    }
                                    $html .='</p>
                                    <p class="caption-text">'.custom_excerpt($theme_option['speakers_desc_count']).'</p>
                                    <p class="caption-buttons">';
                                    if($speaker_mail_address){
                                        $html .= '<a target="_blank" href="mailto:'.$speaker_mail_address.'" class="btn caption-social"><i class="fa fa-envelope"></i></a>';
                                    }
                                    if($speaker_facebook_address){
                                        $html .= '<a target="_blank" href="'.$speaker_facebook_address.'" class="btn caption-social"><i class="fa fa-facebook"></i></a>';
                                    }
                                    if($speaker_twitter_address){
                                        $html .= '<a target="_blank" href="'.$speaker_twitter_address.'" class="btn caption-social"><i class="fa fa-twitter"></i></a>';
                                    }
                                    if($speaker_linkedin_address){
                                        $html .= '<a target="_blank" href="'.$speaker_linkedin_address.'" class="btn caption-social"><i class="fa fa-linkedin"></i></a>';
                                    }
                                    if($speaker_pinterest_address){
                                        $html .= '<a target="_blank" href="'.$speaker_pinterest_address.'" class="btn caption-social"><i class="fa fa-pinterest"></i></a>';
                                    }
                                    if($speaker_googleplus_address){
                                        $html .= '<a target="_blank" href="'.$speaker_googleplus_address.'" class="btn caption-social"><i class="fa fa-google-plus"></i></a>';
                                    }
                                    if($speaker_tumblr_address){
                                        $html .= '<a target="_blank" href="'.$speaker_tumblr_address.'" class="btn caption-social"><i class="fa fa-tumblr"></i></a>';
                                    }
                                    if($speaker_instagram_address){
                                        $html .= '<a target="_blank" href="'.$speaker_instagram_address.'" class="btn caption-social"><i class="fa fa-instagram"></i></a>';
                                    }
                                    if($speaker_vk_address){
                                        $html .= '<a target="_blank" href="'.$speaker_vk_address.'" class="btn caption-social"><i class="fa fa-vk"></i></a>';
                                    }
                                    if($speaker_flickr_address){
                                        $html .= '<a target="_blank" href="'.$speaker_flickr_address.'" class="btn caption-social"><i class="fa fa-flickr"></i></a>';
                                    }
                                    if($speaker_mySpace_address){
                                        $html .= '<a target="_blank" href="'.$speaker_mySpace_address.'" class="btn caption-social"><i class="fa fa-users"></i></a>';
                                    }
                                    if($speaker_youtube_address){
                                        $html .= '<a target="_blank" href="'.$speaker_youtube_address.'" class="btn caption-social"><i class="fa fa-youtube"></i></a>';
                                    }

                                        $html .= '                                        
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';

            endwhile;
        endif;   

    $html .= '</div></div>';
    return $html;
}


if(function_exists('vc_map')){

vc_map( array(
   "name" => __("speakers", TEXT_DOMAIN),
   "base" => "speakers",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",
   "params" => array(
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("class ",TEXT_DOMAIN),
         "param_name" => "class ",
         "value" => "",
         "description" => ''
      )   
     
   )
) );

}


// Testimonial shortocde
add_shortcode('testimonial', 'shortcode_testimonial');
function shortcode_testimonial($atts, $content=null){
    global $theme_option;
    $atts = shortcode_atts(
        array(        
        'class'     => '',
    ), $atts);
    $html ='';
    $html .= '<div class="owl-carousel testimonials_ova '.$atts['class'].'" data-animation="fadeInUp" data-animation-delay="300">';

    $args = array('post_type'=>'testimonial','posts_per_page'=> '100');
    $testimonial = new WP_Query($args);
    if($testimonial->have_posts()):
        while($testimonial->have_posts()):$testimonial->the_post();
        $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id());

                    $html .= '<div class="media testimonial">
                        <div class="media-body">
                            <p>'.get_the_excerpt().'</p>
                            <p class="media-heading"><strong>'.get_the_title().'</strong></p>
                        </div>
                        <div class="media-object-wrapper text-center">
                            <img class="media-object img-circle" src="'.$thumbnail_url.'" alt=""/>
                        </div>
                        </div>';
        endwhile;
    endif;
    $html .= '</div>';
    
    return $html;                        
}

if(function_exists('vc_map')){

vc_map( array(
   "name" => __("Testimonial", TEXT_DOMAIN),
   "base" => "testimonial",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",
   "params" => array(
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Class",TEXT_DOMAIN),
         "param_name" => "class",
         "value" => "",
         "description" => ''
      )
     
   )
) );

}


// Recent Post
add_shortcode('recentpost', 'shortcode_recentpost');
function shortcode_recentpost($atts, $content=null){
    global $theme_option;
    $i=0;
    $recentpost_layout = $theme_option['recentpost_layout'];
    $atts = shortcode_atts(
        array(
        'class'     => '',
    ), $atts);
    $html ='';
    $args = array('post_type'=>'post', 'posts_per_page'=> $theme_option['recentpost_count']);
    $recentpost = new Wp_Query($args);

    $html .= '<div class="row">';
    if($recentpost->have_posts()):
        while($recentpost->have_posts()): $recentpost->the_post();
        global $post;
        $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id(),'post-home-thumbnails');

        $recentpost_layout_5 = '';    
        if($recentpost_layout == 'col-md-2 col-sm-6 col-5' && ($i==0 || $i == 5)){
                $recentpost_layout_5 = 'col-lg-offset-1 col-md-offset-1';
        }
        if($i==5) $i=0; $i++;

    $html .= '<div class="recentpost '.$recentpost_layout.' '.$recentpost_layout_5.'">
                        <article class="post-wrap thumbnail">
                            <div class="post-media">                                
                                <div class="thumbnail no-border ">';

                                    if(has_post_format('audio')){
                                        $html .='<div class="js-video postformat_audio">'.
                                                wp_oembed_get(get_post_meta($post->ID, "_cmb_embed_media", true)).'
                                            </div>';
                                    }else if(has_post_format('video')){
                                        $html .='<div class="js-video postformat_video">'.
                                                wp_oembed_get(get_post_meta($post->ID, "_cmb_embed_media", true)).'
                                            </div>';
                                    }else if(has_post_format('gallery')){

                                        $gallery = get_post_gallery( $post->ID, false );

                                        if(isset($gallery['ids'])){
                                            $gallery_ids = $gallery['ids'];
                                            $img_ids = explode(",",$gallery_ids);
                                            $i=1;
                                            $html .= '<div class="gallery_schedule owl-carousel" >';
                                            foreach( $img_ids AS $img_id ){
                                                $image_src = wp_get_attachment_image_src($img_id,'');
                                                $html .='<div><img class="img-responsive" src="'.$image_src[0].'" alt=""></div>';
                                                $i++;
                                            }
                                            $html .= '</div>';                     
                                            
                                        }
                                    }else if(has_post_format('image')){
                                        $html .= '<div class="do-hover"><img class="img-responsive" src="'.$thumbnail_url.'" alt="'.get_the_title().'"></div>';
                                    }else if(has_post_format('link')){
                                        $html .= '<div class="media-link">
                                        <i class="fa fa-link"></i>'.get_the_content().'
                                        </div>';                                        
                                    }


                            $html .='</div>
                                <div class="post-meta clearfix">
                                    <span class="pull-left"><span class="post-date"><i class="fa fa-calendar"></i>&nbsp;'.get_the_date( ).'</span></span>
                                    <span class="pull-right">
                                        <a href="'.get_permalink( ).'"><i class="fa fa-comment"></i>
                                        '.get_comments_number(__("0", TEXT_DOMAIN), __("1", TEXT_DOMAIN), " %".__("", TEXT_DOMAIN)).'
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div class="post-header">
                                <h4 class="post-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
                            if($theme_option['recentpost_show_author']){
                                $html .= '<span class="post-author">'.__('by').'&nbsp;<a href="'.get_the_author_link().'">'.get_the_author().'</a></span>';
                            }
                            $html .='</div>
                            <div class="post-body">
                                <div class="post-excerpt">'.custom_excerpt($theme_option['recentpost_des_count']).'</div>
                            </div>';
                              
                        $html .= '</article>
                    </div>';
                endwhile;
                endif;    
            $html .='</div>';
            $html .= '<script>
                        jQuery(document).ready(function($){                            
                                var height_gallery = $(".gallery_schedule'.$post->ID.'").innerHeight();
                                $(".gallery_schedule'.$post->ID.'").css("height",height_gallery);
                        });        
                    </script>';

    return $html;
}


if(function_exists('vc_map')){

vc_map( array(
   "name" => __("Recentpost", TEXT_DOMAIN),
   "base" => "recentpost",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",
   "params" => array(
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Class",TEXT_DOMAIN),
         "param_name" => "class",
         "value" => "",
         "description" => ''
      )
     
   )
) );

}



// Sponsors Post
add_shortcode('sponsors', 'shortcode_sponsors');
function shortcode_sponsors($atts, $content=null){

    $atts = shortcode_atts(
        array(        
        'animation'     => 'fadeInUp',
        'slidecount'    => '4',
        'playdelay'     => '5000',        
    ), $atts);
    $html ='';

    $html ='';
    $html .='<div class="partners-carousel" data-animation="'.$atts['animation'].'" data-animation-delay="300"><div  class="owl-carousel partners_ova">'.do_shortcode( $content ).'</div></div><hr class="page-divider half"/>';
    $html .='<script>
            jQuery(document).ready(function($){
                $(".partners_ova").owlCarousel({
                    items: '.$atts['slidecount'].',
                    itemsDesktop: false,
                    itemsDesktopSmall: [991, 4],
                    itemsTablet: [768, 3],
                    itemsMobile: [479, 2],
                    autoPlay: '.$atts['playdelay'].',                    
                    pagination: false
                });
            });
        </script>';
    return $html;
}

// Sponsor item post
add_shortcode('sponsor_item', 'shortcode_sponsor_item');
function shortcode_sponsor_item($atts, $content=null){
    
    $atts = shortcode_atts(
        array(
        'href'      =>'',
        'img_url'   =>'',
        'class'     =>'',
    ), $atts);
    $html ='';
    $html .='<div class="'.$atts['class'].'"><a href="'.$atts['href'].'"><img src="'.$atts['img_url'].'" alt=""/></a></div>';
    return $html;
}

// Pricing Shortcode
add_shortcode('pricing', 'shortcode_pricing');
function shortcode_pricing($atts, $content=null){
     $atts = shortcode_atts(
        array(
        'title'         =>'',
        'currency'      =>'',
        'value'         =>'',
        'time'          =>'',
        'subtitle'      => '',
        'link'          => '',
        'class'         =>'',
    ), $atts);

    $html ='';
    $html .='<div class="price-table '.$atts['class'].'">
                <div class="price-table-header">
                    <div class="price-label">
                        <h3 class="price-label-title">'.$atts['title'].'</h3>
                    </div>
                    <div class="price-value">
                        <span class="price-unit">'.$atts['currency'].'</span><span class="price-number">'.$atts['value'].'</span><span class="price-per">'.$atts['time'].'</span>
                        <small>'.$atts['subtitle'].'</small>
                    </div>
                </div>
                <div class="price-table-rows">'.do_shortcode($content).'
                    <div class="price-table-row-bottom">
                        <a class="btn btn-theme btn-theme-invert"  href="'.$atts['link'].'">'.__('Register', TEXT_DOMAIN).'</a>
                    </div>
                </div>

            </div>
        ';
    return $html;
}


if(function_exists('vc_map')){

vc_map( array(
   "name" => __("Pricing", TEXT_DOMAIN),
   "base" => "pricing",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",
   "params" => array(
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Title",TEXT_DOMAIN),
         "param_name" => "title",
         "value" => "The title",
         "description" => ''
      ),
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Currency",TEXT_DOMAIN),
         "param_name" => "currency",
         "value" => "$",
         "description" => ''
      ),        
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Value",TEXT_DOMAIN),
         "param_name" => "value",
         "value" => "",
         "description" => ''
      ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Time",TEXT_DOMAIN),
         "param_name" => "time",
         "value" => "",
         "description" => ''
      ),  
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Subtitle",TEXT_DOMAIN),
         "param_name" => "subtitle",
         "value" => "",
         "description" => ''
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Link",TEXT_DOMAIN),
         "param_name" => "link",
         "value" => "",
         "description" => ''
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Class",TEXT_DOMAIN),
         "param_name" => "class",
         "value" => "",
         "description" => ''
      )
      ,
      array(
         "type" => "textarea",
         "holder" => "div",
         "class" => "",
         "heading" => __("Content",TEXT_DOMAIN),
         "param_name" => "content",
         "value" => "",
         "description" => ''
      )
     
   )
) );

}



// Pricing row content
add_shortcode('pricing_row_content', 'shortcode_pricing_row_content');
function shortcode_pricing_row_content($atts, $content=null){
    $html = '<div class="price-table-row">'.do_shortcode( $content ).'</div>';
    return $html;
}


// Location Shortcode
add_shortcode('location', 'shortcode_location');
function shortcode_location($atts, $content=null){
     $atts = shortcode_atts(
        array(
        'fontimage'         =>'fa-map-marker',
        'link_directions'   =>'#'        
    ), $atts);

    $html = '';
    $html .='<div class="directions"><p class="directions-icon"><i class="fa '.$atts['fontimage'].'"></i></p>
                    '.do_shortcode($content).'
                    <p><a class="btn btn-theme btn-theme-white" href="'.$atts['link_directions'].'">'.__("get directions", TEXT_DOMAIN).'</a></p>
                </div>';
    return $html;
}


if(function_exists('vc_map')){

vc_map( array(
   "name" => __("Location", TEXT_DOMAIN),
   "base" => "location",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",
   "params" => array(
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("fontimage",TEXT_DOMAIN),
         "param_name" => "fontimage",
         "value" => "",
         "description" => 'Insert fontawesome'
    ),
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("Link Directions",TEXT_DOMAIN),
         "param_name" => "link_directions",
         "value" => "",
         "description" => ''
      ),
    array(
         "type" => "textarea",
         "holder" => "div",
         "class" => "",
         "heading" => __("Content",TEXT_DOMAIN),
         "param_name" => "content",
         "value" => "",
         "description" => ''
      )
     
   )
) );

}
