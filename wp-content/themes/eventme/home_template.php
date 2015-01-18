<?php 
/** Template Name: Home Template  */

get_header();
	while(have_posts()): the_post();           
		$content= get_the_content();
		echo ova_do_shortcode($content);           	
    endwhile;
get_footer();