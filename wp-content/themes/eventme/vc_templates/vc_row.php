<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $el_id = $div_wrapper = '';
extract(shortcode_atts(array(
    'el_class'        => '',
    'el_id'        => '',
    'bg_image_custom'  => '',
    'div_wrapper'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'font_color'      => '',
    'padding'         => '',
    'fullwidth'         => 'no',
    'margin_bottom'   => '',
    'css' => ''
), $atts));

    wp_enqueue_style( 'js_composer_front' );
    wp_enqueue_script( 'wpb_composer_front_js' );
    wp_enqueue_style('js_composer_custom_css');
    

    $hand_sec = rand();

    $el_id =  $el_id?$el_id:'id'.$hand_sec;

    $class_parallax = '';
    

    if( (int)$bg_image_custom > 0 && wp_get_attachment_url( $bg_image_custom, 'large' ) !== false ){
        $class_parallax = 'parallax';
    }
    

    $el_class = $this->getExtraClass($el_class);

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row ' . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
    $bg_image_vc = 0;
    $style = $this->buildStyle($bg_image_vc, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);

$output .='<section class="'.$el_class.' '.$class_parallax.' '.$css_class.' '.$style.'" id="'.$el_id.'"><div class="row">';

            if( (int)$bg_image_custom > 0 && wp_get_attachment_url( $bg_image_custom, 'large' ) !== false ){
                $output .= '<div class="parallax-bg bg'.$hand_sec.'" data-stellar-background-ratio="0.5" style="background-image: url('.wp_get_attachment_url( $bg_image_custom, 'large' ).')">
                </div>
                <div class="parallax-overlay"></div>
                <div class="parallax-inner text-center">';
            }

            if($fullwidth == 'no'){
                $output .= '<div class="container">';
            }

            $output .= wpb_js_remove_wpautop($content);

            if($fullwidth == 'no'){
                $output .='</div>';
            }

            if( (int)$bg_image_custom > 0 && wp_get_attachment_url( $bg_image_custom, 'large' ) !== false ){
                $output .= '</div>';    
            }

    $output .='</div></section>'.$this->endBlockComment('row');



echo $output;