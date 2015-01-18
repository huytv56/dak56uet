<?php 
// Integrate with editor
add_action('admin_head', 'ova_add_my_tc_button');
function ova_add_my_tc_button() {
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
    return;
    }
    // verify the post type
    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return;
    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "ova_add_tinymce_plugin");
        add_filter('mce_buttons', 'ova_register_my_tc_button');
    }
}

function ova_add_tinymce_plugin($plugin_array) {
    $plugin_array['ova_tc_button'] = get_template_directory_uri().'/mce/text-button.js'; 
    return $plugin_array;
}
function ova_register_my_tc_button($buttons) {
   array_push($buttons, "ova_tc_button");
   return $buttons;
}
 ?>