<?php

// Slideshow
add_shortcode('slideshow', 'shortcode_slideshow');
function shortcode_slideshow($atts, $content = null) {
	
        global $theme_option;

        $atts = shortcode_atts(
        array(
            'class' => '',
            'id' => '',
        ), $atts);

        $args	= array('post_type'	=> 'slideshow', 'posts_per_page'=> $theme_option['slideshow_item_count']);
        $html = "";
        $html .='<section class="page-section slider '.$atts['class'].'" id="'.$atts['id'].'">
            <div class="container">
                <div class="main-slider">
                    <div id="event-slider" class="clearfix">';
        $link_re = array();
        $the_query = new WP_Query($args);
        if($the_query->have_posts()){
        	while($the_query->have_posts()){
        		global $post;
                
        		$the_query->the_post();        		
        		$template = get_post_meta($post->ID, "_cmb_template", true);
        		$link_regis = get_post_meta($post->ID, "_cmb_register_link", true);
        		$thumbnail_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
                $end_date_d = date('d',get_post_meta($post->ID, "_cmb_end_date", true));
                $end_date_m = date('m',get_post_meta($post->ID, "_cmb_end_date", true))-1;
                $end_date_y = date('Y',get_post_meta($post->ID, "_cmb_end_date", true));
                $timezone = $theme_option['slideshow_timezone']?$theme_option['slideshow_timezone']:0;
                $display_format = $theme_option['display_format'];
                $display_navigation = $theme_option['display_navigation'];
                $display_register_button = $theme_option['display_register_button'];
                
               
        		if($template == 'slide1'){
        			$html .= '<div class="item slide '.$template.' full-width-slide div-table">
                            <div class="slide-image" style="background:url('.$thumbnail_large['0'].') 50% 50% transparent;"></div>
                            <div class="slide-caption div-cell">
                                <div class="slide-caption-inner">
                                    '.get_the_content().'
                                    <div class="countdown-wrapper">
                                        <div id="defaultCountdown'.$post->ID.'" class="defaultCountdown clearfix"></div>
                                    </div>
                                    <script>
                                    jQuery(document).ready(function($){
                                         var austDay = new Date();
                                    austDay = new Date('.$end_date_y.', '.$end_date_m.', '.$end_date_d.');
                                       $("#defaultCountdown'.$post->ID.'").countdown({
                                            labels: ["'.__('Years', TEXT_DOMAIN).'","'.__('Months', TEXT_DOMAIN).'","'.__('Weeks', TEXT_DOMAIN).'","'.__('Days', TEXT_DOMAIN).'","'. __('Hours', TEXT_DOMAIN).'","'.__('Minutes', TEXT_DOMAIN).'","'.__('Seconds', TEXT_DOMAIN).'"], 
                                            labels1: ["'.__('Year', TEXT_DOMAIN).'","'.__('Month', TEXT_DOMAIN).'","'.__('Week', TEXT_DOMAIN).'","'.__('Day', TEXT_DOMAIN).'","'. __('Hour', TEXT_DOMAIN).'","'.__('Minute', TEXT_DOMAIN).'","'.__('Second', TEXT_DOMAIN).'"], 
                                            until: austDay, 
                                            timezone: "'.$timezone.'", 
                                            format: "'.$display_format.'"
                                        });
                                    });                                    
                                    </script>';
                    if($display_register_button){
                        if($link_regis){
                        $html .= '<a class="btn btn-theme btn-theme-primary slide-btn" href="'.$link_regis.'">'.__('Register Now', TEXT_DOMAIN).'</a>';
                        }else{

                            $html .= '<a data-toggle="modal" data-target="#myModal'.$post->ID.'" class="btn btn-theme btn-theme-primary slide-btn" href="">'.__('Register Now', TEXT_DOMAIN).'</a>';
                            $link_re[$post->ID] = get_the_title();
                        }
                    }
	                
	                $html .= '</div>
	                            </div>
	                        </div>';
                }else{
                	$html .= '<div class="item slide slide2 alternate div-table">
                            <div class="slide-image" style="background:url('.$thumbnail_large['0'].') 50% 50% transparent;"></div>
                            <div class="slide-caption div-cell">
                                <div class="container">
                                    <div class="slide-caption-inner">
                                        '.get_the_content().'
                                        <div class="countdown-wrapper">
                                        <div id="defaultCountdown'.$post->ID.'" class="defaultCountdown clearfix"></div>
                                    </div>
                                    <script>
                                    jQuery(document).ready(function($){
                                         var austDaynew = new Date();
                                    austDaynew = new Date('.$end_date_y.', '.$end_date_m.', '.$end_date_d.');
                                        $("#defaultCountdown'.$post->ID.'").countdown({
                                            labels: ["'.__('Years', TEXT_DOMAIN).'","'.__('Months', TEXT_DOMAIN).'","'.__('Weeks', TEXT_DOMAIN).'","'.__('Days', TEXT_DOMAIN).'","'. __('Hours', TEXT_DOMAIN).'","'.__('Minutes', TEXT_DOMAIN).'","'.__('Seconds', TEXT_DOMAIN).'"], 
                                            labels1: ["'.__('Year', TEXT_DOMAIN).'","'.__('Month', TEXT_DOMAIN).'","'.__('Week', TEXT_DOMAIN).'","'.__('Day', TEXT_DOMAIN).'","'. __('Hour', TEXT_DOMAIN).'","'.__('Minute', TEXT_DOMAIN).'","'.__('Second', TEXT_DOMAIN).'"],
                                            until: austDaynew, 
                                            timezone: "'.$timezone.'", 
                                            format: "'.$display_format.'"
                                        }); 
                                    });                                    
                                    </script>';
                    if($display_register_button){
                        if($link_regis){
                        $html .= '<a class="btn btn-theme btn-theme-primary slide-btn" href="'.$link_regis.'">'.__('Register Now', TEXT_DOMAIN).'</a>';
                        }else{
                            $html .= '<a data-toggle="modal" data-target="#myModal'.$post->ID.'" class="btn btn-theme btn-theme-primary slide-btn" href="">'.__('Register Now', TEXT_DOMAIN).'</a>';
                            $link_re[$post->ID] = get_the_title();
                        }
                    }

	                $html .='</div>
                                </div>
                            </div>
                        </div>';
                }

        	}
        }else{}

        $html .= '</div>
                </div>
            </div>           
        </section>';

         if(!$display_navigation){
            $html .= 'jQuery("#event-slider .owl-controls").css("display","none!important")';
        }
        foreach($link_re as $key=>$value){

                $html .= '
                    <div class="modal fade event_register_pop" id="myModal'.$key.'" tabindex="-1" role="dialog" >
                        <div class="modal-dialog">
                            <div class="modal-content">                                
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" >&times;</button>
                                    <h4 class="modal-title" >'.__('Register', TEXT_DOMAIN).'</h4>
                                </div>
                                <div class="modal-body">
                                    <h5 class="reg_event">'.$value.'</h5>
                                    <form name="regitration" method="post"  class="af-form af-form'.$key.'"  >

                                        <div class="event_loading hide"><img src="'.get_template_directory_uri()."/assets/img/preloader.gif".'" alt="'.__('registing', TEXT_DOMAIN).'"></div>

                                        <div class="af-outer af-required">
                                            <div class="form-group af-inner">
                                                <input type="text" name="name"  size="30" value="" placeholder="'.__('Name *', TEXT_DOMAIN).'" class="form-control name-rf placeholder" />
                                                <label class="name_error_rf error"  >'.__('Name is required', TEXT_DOMAIN).'.</label>
                                            </div>
                                        </div>

                                        <div class="af-outer af-required">
                                            <div class="form-group af-inner">
                                                <input type="text" name="email"  size="30" value="" placeholder="'.__('Email *', TEXT_DOMAIN).'" class="form-control email-rf placeholder" />
                                                <label class="email_error_rf error"  >'.__('Email is required.', TEXT_DOMAIN).'</label>
                                            </div>
                                        </div>

                                        <div class="af-outer af-required">
                                            <div class="form-group af-inner">
                                                <input type="text" name="phone"  size="30" value="" placeholder="'.__('Phone', TEXT_DOMAIN).'" class="form-control phone-rf placeholder" />
                                                <label class="phone_error_rf error"  >'.__('Phone is required.', TEXT_DOMAIN).'</label>
                                            </div>
                                        </div>

                                        <div class="af-outer af-required">
                                            <div class="form-group af-inner">
                                                <textarea name="message"  cols="30" placeholder="'.__('Message *', TEXT_DOMAIN).'" class="form-control message-rf placeholder"></textarea>
                                                <label class="message_error_rf error"  >'.__('Message is required.', TEXT_DOMAIN).'</label>
                                            </div>
                                        </div>
                                        <input type="hidden" class="registraton" name="registraton" value="'.get_template_directory_uri()."/template-insert-posts.php".'">

                                        <input type="hidden" class="mes_success" name="registraton" value="'.__('Your request send! We will be in touch soon.',TEXT_DOMAIN).'">
                                        <input type="hidden" class="mes_error" name="registraton" value="'.__('Error',TEXT_DOMAIN).'">

                                        <input type="hidden" class="event_title" name="event_title" value="'.$value.'">

                                        

                                    </form>

                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-theme-sm btn-theme" data-dismiss="modal">'.__('Close', TEXT_DOMAIN).'</button>
                                    <button type="button" class="btn btn-theme-sm btn-theme btn-theme-primary button_register" data-idslide="'.$key.'" >'.__('Register', TEXT_DOMAIN).'</button>
                                </div>  

                                </div>
                                                              
                            </div>
                        </div>
                    </div>
                ';
            }
        

        return $html;
 }


if(function_exists('vc_map')){

vc_map( array(
   "name" => __("Slideshow", TEXT_DOMAIN),
   "base" => "slideshow",
   "class" => "",
   "category" => __("My shortcode", TEXT_DOMAIN),
   "icon" => "icon-qk",
   "params" => array(
    array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => __("ID",TEXT_DOMAIN),
         "param_name" => "id",
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
      ),      
   )
) );

}