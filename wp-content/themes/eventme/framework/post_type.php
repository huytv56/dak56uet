<?php

// Slideshow //////////////////////////////////////////////////////////
add_action( 'init', 'slideshow_init' );
function slideshow_init() { 
    
    $labels = array(
        'name'               => __( 'Slideshows', 'post type general name', TEXT_DOMAIN ),
        'singular_name'      => __( 'Slide', 'post type singular name', TEXT_DOMAIN ),
        'menu_name'          => __( 'Slideshows', 'admin menu', TEXT_DOMAIN ),
        'name_admin_bar'     => __( 'Slide', 'add new on admin bar', TEXT_DOMAIN ),
        'add_new'            => __( 'Add New slide', 'Slide', TEXT_DOMAIN ),
        'add_new_item'       => __( 'Add New Slide', TEXT_DOMAIN ),
        'new_item'           => __( 'New Slide', TEXT_DOMAIN ),
        'edit_item'          => __( 'Edit Slide', TEXT_DOMAIN ),
        'view_item'          => __( 'View Slide', TEXT_DOMAIN ),
        'all_items'          => __( 'All Slides', TEXT_DOMAIN ),
        'search_items'       => __( 'Search Slides', TEXT_DOMAIN ),
        'parent_item_colon'  => __( 'Parent Slides:', TEXT_DOMAIN ),
        'not_found'          => __( 'No Slides found.', TEXT_DOMAIN ),
        'not_found_in_trash' => __( 'No Slides found in Trash.', TEXT_DOMAIN ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-format-gallery',
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'slideshow' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail','comments')
    );

    register_post_type( 'slideshow', $args );
}


// Event Register List //////////////////////////////////////////////////////////
add_action( 'init', 'registerlist_init' );
function registerlist_init() { 
    
    $labels = array(
        'name'               => __( 'Event Register List', 'post type general name', TEXT_DOMAIN ),
        'singular_name'      => __( 'Event Register List', 'post type singular name', TEXT_DOMAIN ),
        'menu_name'          => __( 'Event Register List', 'admin menu', TEXT_DOMAIN ),
        'name_admin_bar'     => __( 'Event Register List', 'add new on admin bar', TEXT_DOMAIN ),
        'add_new'            => __( 'Add New Register', 'Register', TEXT_DOMAIN ),
        'add_new_item'       => __( 'Add New Register', TEXT_DOMAIN ),
        'new_item'           => __( 'New Register', TEXT_DOMAIN ),
        'edit_item'          => __( 'Edit Register', TEXT_DOMAIN ),
        'view_item'          => __( 'View Register', TEXT_DOMAIN ),
        'all_items'          => __( 'All Registers', TEXT_DOMAIN ),
        'search_items'       => __( 'Search Registers', TEXT_DOMAIN ),
        'parent_item_colon'  => __( 'Parent Registers:', TEXT_DOMAIN ),
        'not_found'          => __( 'No Registers found.', TEXT_DOMAIN ),
        'not_found_in_trash' => __( 'No Registers found in Trash.', TEXT_DOMAIN ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-groups',
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'register-list' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author')
    );

    register_post_type( 'registerlist', $args );
}


// Schedule /////////////////////////////////////////////////////////
add_action( 'init', 'schedule_post_type', 0 );
function schedule_post_type() {

    $labels = array(
        'name'                => __( 'Schedule', 'Post Type General Name', TEXT_DOMAIN ),
        'singular_name'       => __( 'Schedule', 'Post Type Singular Name', TEXT_DOMAIN ),
        'menu_name'           => __( 'Schedule', TEXT_DOMAIN ),
        'parent_item_colon'   => __( 'Parent Schedule:', TEXT_DOMAIN ),
        'all_items'           => __( 'All Schedules', TEXT_DOMAIN ),
        'view_item'           => __( 'View Schedule', TEXT_DOMAIN ),
        'add_new_item'        => __( 'Add New Schedule', TEXT_DOMAIN ),
        'add_new'             => __( 'Add New Schedule', TEXT_DOMAIN ),
        'edit_item'           => __( 'Edit Schedule', TEXT_DOMAIN ),
        'update_item'         => __( 'Update Schedule', TEXT_DOMAIN ),
        'search_items'        => __( 'Search Schedules', TEXT_DOMAIN ),
        'not_found'           => __( 'No Schedules found', TEXT_DOMAIN ),
        'not_found_in_trash'  => __( 'No Schedules found in Trash', TEXT_DOMAIN ),
    );
    $args = array(
        'label'               => __( 'schedule', TEXT_DOMAIN ),
        'description'         => __( 'Schedule information pages', TEXT_DOMAIN ),
        'labels'              => $labels,
        'supports'            => array( 'thumbnail', 'editor', 'title', 'comments', 'post-formats' ),
        'taxonomies'          => array( 'categories','skill', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'menu_icon'          => 'dashicons-calendar',
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => null,        
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'schedule', $args );
}

add_action( 'init', 'create_schedule_taxonomies', 0 );
// create skin taxonomy
function create_schedule_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => __( 'Skill', 'taxonomy general name' , TEXT_DOMAIN),
        'singular_name'     => __( 'Skill', 'taxonomy singular name' , TEXT_DOMAIN),
        'search_items'      => __( 'Search Skills', TEXT_DOMAIN),
        'all_items'         => __( 'All Skills', TEXT_DOMAIN ),
        'parent_item'       => __( 'Parent Skill', TEXT_DOMAIN ),
        'parent_item_colon' => __( 'Parent Skill:' , TEXT_DOMAIN),
        'edit_item'         => __( 'Edit Skill' , TEXT_DOMAIN),
        'update_item'       => __( 'Update Skill' , TEXT_DOMAIN),
        'add_new_item'      => __( 'Add New Skill' , TEXT_DOMAIN),
        'new_item_name'     => __( 'New Skill Name' , TEXT_DOMAIN),
        'menu_name'         => __( 'Skill' , TEXT_DOMAIN),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'schedule' ),
    );

    register_taxonomy( 'skill', array('schedule'), $args );
}




// Speaker //////////////////////////////////////////////////////////
add_action( 'init', 'speaker_init' );
function speaker_init() { 
    
    $labels = array(
        'name'               => __( 'Speakers', 'post type general name', TEXT_DOMAIN ),
        'singular_name'      => __( 'Speaker', 'post type singular name', TEXT_DOMAIN ),
        'menu_name'          => __( 'Speakers', 'admin menu', TEXT_DOMAIN ),
        'name_admin_bar'     => __( 'Speaker', 'add new on admin bar', TEXT_DOMAIN ),
        'add_new'            => __( 'Add New Speaker', 'Speaker', TEXT_DOMAIN ),
        'add_new_item'       => __( 'Add New Speaker', TEXT_DOMAIN ),
        'new_item'           => __( 'New Speaker', TEXT_DOMAIN ),
        'edit_item'          => __( 'Edit Speaker', TEXT_DOMAIN ),
        'view_item'          => __( 'View Speaker', TEXT_DOMAIN ),
        'all_items'          => __( 'All Speakers', TEXT_DOMAIN ),
        'search_items'       => __( 'Search Speakers', TEXT_DOMAIN ),
        'parent_item_colon'  => __( 'Parent Speakers:', TEXT_DOMAIN ),
        'not_found'          => __( 'No Speakers found.', TEXT_DOMAIN ),
        'not_found_in_trash' => __( 'No Speakers found in Trash.', TEXT_DOMAIN ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-megaphone',
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'speaker' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail','comments'),
        'taxonomies'         => array('post_tag')
    );

    register_post_type( 'speaker', $args );
}


// Speaker //////////////////////////////////////////////////////////
add_action( 'init', 'testimonials_init' );
function testimonials_init() { 
    
    $labels = array(
        'name'               => __( 'Testimonials', 'post type general name', TEXT_DOMAIN ),
        'singular_name'      => __( 'Testimonial', 'post type singular name', TEXT_DOMAIN ),
        'menu_name'          => __( 'Testimonials', 'admin menu', TEXT_DOMAIN ),
        'name_admin_bar'     => __( 'Testimonial', 'add new on admin bar', TEXT_DOMAIN ),
        'add_new'            => __( 'Add New Testimonial', 'Testimonial', TEXT_DOMAIN ),
        'add_new_item'       => __( 'Add New Testimonial', TEXT_DOMAIN ),
        'new_item'           => __( 'New Testimonial', TEXT_DOMAIN ),
        'edit_item'          => __( 'Edit Testimonial', TEXT_DOMAIN ),
        'view_item'          => __( 'View Testimonial', TEXT_DOMAIN ),
        'all_items'          => __( 'All Testimonials', TEXT_DOMAIN ),
        'search_items'       => __( 'Search Testimonials', TEXT_DOMAIN ),
        'parent_item_colon'  => __( 'Parent Testimonials:', TEXT_DOMAIN ),
        'not_found'          => __( 'No Testimonials found.', TEXT_DOMAIN ),
        'not_found_in_trash' => __( 'No Testimonials found in Trash.', TEXT_DOMAIN ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-format-status',
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'testimonial' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail','comments')
    );

    register_post_type( 'testimonial', $args );
}


