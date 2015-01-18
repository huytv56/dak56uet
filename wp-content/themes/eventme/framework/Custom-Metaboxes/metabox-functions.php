<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cmb_';

	$meta_boxes[] = array(
        'id'         => 'Post_Options',
        'title'      => 'Post Options',
        'pages'      => array('post','schedule'), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => __('oEmbed Post format media', TEXT_DOMAIN),
                'desc' => __('Enter a audio, youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', TEXT_DOMAIN),
                'id'   => $prefix . 'embed_media',
                'type' => 'oembed',
            ),
        ),
    );

	$meta_boxes[] = array(
		'id'         => 'schedule_fields',
		'title'      => __('Schedule Field', TEXT_DOMAIN),
		'pages'      => array( 'schedule'), // Post type
		'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
		//'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
		'fields' => array(
			array(
                'name' => __('Time', TEXT_DOMAIN),
				'desc' => __('Time', TEXT_DOMAIN),
				'id'   => $prefix . 'schedule_time',
				'type' => 'text',
            ),           
            array(
                'name' => __('Address', TEXT_DOMAIN),
				'desc' => __('Address', TEXT_DOMAIN),
				'id'   => $prefix . 'schedule_address',
				'type' => 'text',
            ),
          
		)
	);

	$meta_boxes[] = array(
		'id'         => 'speaker_fields',
		'title'      => __('Speaker Field', TEXT_DOMAIN),
		'pages'      => array( 'speaker'), // Post type
		'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
		//'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
		'fields' => array(
			array(
                'name' => __('Job', TEXT_DOMAIN),
				'desc' => __('Job', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_job',
				'type' => 'text',
				'default'	=> 'Speaker name here'
            ),
            array(
                'name' => __('Mail Adress', TEXT_DOMAIN),
				'desc' => __('Mail Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_mail_address',
				'type' => 'text',
				'default'=> 'mail@sitename.com'
            ),
            array(
                'name' => __('Facebook Adress', TEXT_DOMAIN),
				'desc' => __('Facebook Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_facebook_address',
				'type' => 'text',
				'default'=> 'https://facebook.com'
            ),
            array(
                'name' => __('Twitter Adress', TEXT_DOMAIN),
				'desc' => __('Twitter Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_twitter_address',
				'type' => 'text',
				'default'=> 'https://twitter.com/'
            ),
            array(
                'name' => __('Linkedin Adress', TEXT_DOMAIN),
				'desc' => __('Linkedin Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_linkedin_address',
				'type' => 'text',
				'default'=> 'https://www.linkedin.com/'
            ),
            array(
                'name' => __('Pinterest Adress', TEXT_DOMAIN),
				'desc' => __('Pinterest Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_pinterest_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Google Plus Adress', TEXT_DOMAIN),
				'desc' => __('Google Plus Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_googleplus_address',
				'type' => 'text'				
            ),            
            array(
                'name' => __('Tumblr Adress', TEXT_DOMAIN),
				'desc' => __('Tumblr Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_tumblr_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Instagram Adress', TEXT_DOMAIN),
				'desc' => __('Instagram Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_instagram_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('VK Adress', TEXT_DOMAIN),
				'desc' => __('VK Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_vk_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Flickr Adress', TEXT_DOMAIN),
				'desc' => __('Flickr Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_flickr_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('MySpace Adress', TEXT_DOMAIN),
				'desc' => __('MySpace Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_mySpace_address',
				'type' => 'text'				
            ),
            array(
                'name' => __('Youtube Adress', TEXT_DOMAIN),
				'desc' => __('Youtube Adress', TEXT_DOMAIN),
				'id'   => $prefix . 'speaker_youtube_address',
				'type' => 'text'				
            ),
                       
           
            
          
		)
	);

	$meta_boxes[] = array(
		'id'         => 'seo_fields',
		'title'      => __('SEO Fields', TEXT_DOMAIN),
		'pages'      => array( 'page', 'post','schedule', 'speaker'), // Post type
		'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
		//'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
		'fields' => array(
			array(
				'name' => __('SEO title', TEXT_DOMAIN),
				'desc' => __('Title for SEO (optional)', TEXT_DOMAIN),
				'id'   => $prefix . 'seo_title',
				'type' => 'text',
			),
            array(
                'name' => __('SEO Keywords', TEXT_DOMAIN),
                'desc' => __('SEO keywords (optional)', TEXT_DOMAIN),
                'id'   => $prefix . 'seo_keywords',
                'type' => 'text',
            ),
            array(
                'name' => __('SEO Description', TEXT_DOMAIN),
                'desc' => __('SEO description (optional)', TEXT_DOMAIN),
                'id'   => $prefix . 'seo_description',
                'type' => 'text',
            ),
		)
	);

	$meta_boxes[] = array(
		'id'         => 'slideshow_fields',
		'title'      => __('Slideshow Field', TEXT_DOMAIN),
		'pages'      => array( 'slideshow'), // Post type
		'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
		//'show_on'    => array( 'key' => 'id', 'value' => array( 2, ), ), // Specific post IDs to display this metabox
		'fields' => array(			
            array(
                'name' => __('End Date', TEXT_DOMAIN),
				'desc' => __('End Date', TEXT_DOMAIN),
				'id'   => $prefix . 'end_date',
				'type' => 'text_date_timestamp',
            ),
            array(
                'name' => __('Button Register Link (W,P,L,O,C,K,E,R,.,C,O,M', TEXT_DOMAIN),
                'desc' => __('You can insert a your link else use popup default register', TEXT_DOMAIN),
                'id'   => $prefix . 'register_link',
                'type' => 'text',
            ),
            array(
                'name' => __('Template', TEXT_DOMAIN),
                'desc' => __('Select an option', TEXT_DOMAIN),
                'id'   => $prefix . 'template',
                'type' => 'select',
                'options' => array(
		        'slide1' => __( 'Template 1', TEXT_DOMAIN ),
		        'slide2'   => __( 'Template 2', TEXT_DOMAIN ),		        
		    ),
		    'default' => 'slide1',
            ),
		)
	);

	

	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}
