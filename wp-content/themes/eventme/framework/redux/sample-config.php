<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'redux-framework-demo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'redux-framework-demo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'icon'      => 'el-icon-cogs',
                'title'     => __('General Settings', TEXT_DOMAIN),                
                'fields'    => array(
                    array(
                        'id'        => 'logo_image',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Logo Image', TEXT_DOMAIN),
                        'subtitle'  => __('Upload a logo image. The best logo 173x49px', TEXT_DOMAIN),
                        'default'   => array('url' => get_template_directory_uri().'/assets/img/logo-eventme.png')
                    ),                    
                    array(
                        'id'        => 'favicon',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Custom Favicon', TEXT_DOMAIN),
                        'subtitle'  => __('Upload your Favicon. The best size is 32x32 px', TEXT_DOMAIN),
                        'default'   => array('url' => get_template_directory_uri().'/assets/ico/favicon.ico')
                    ),
                    array(
                        'id'        => 'app_icon',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Apple touch icon', TEXT_DOMAIN),
                        'subtitle'  => __('Upload your Apple touch icon. The best size is 144x144 px', TEXT_DOMAIN),
                        'default'   => array('url' => get_template_directory_uri().'/assets/ico/apple-touch-icon-144-precomposed.png')
                    ),                    

                    array(
                        'id'        => 'google_analytics',
                        'type'      => 'textarea',                        
                        'title'     => __('Google Analytics Javascript', TEXT_DOMAIN),
                        'subtitle'  => __('Insert javascript of Google Analytics. You dont insert <script></script>', TEXT_DOMAIN)                        
                    ),

                    array(
                        'id'        => 'seo_des',
                        'type'      => 'textarea',                        
                        'title'     => __('SEO Description', TEXT_DOMAIN),
                        'subtitle'  => __('Paste your SEO Description. This will be added into the meta tag description in header', TEXT_DOMAIN),
                        'default'   => __('This is seo description', TEXT_DOMAIN)
                    ),
                    array(
                        'id'        => 'seo_keywords',
                        'type'      => 'textarea',                        
                        'title'     => __('SEO Keywords', TEXT_DOMAIN),
                        'subtitle'  => __('Paste your SEO Keywords. This will be added into the meta tag keywords in header', TEXT_DOMAIN),
                        'default'   => __('Seo Keywords', TEXT_DOMAIN)
                    ),
                    array(
                        'id'        => 'custom_css',
                        'type'      => 'textarea',                        
                        'title'     => __('Customize Css', TEXT_DOMAIN),
                        'subtitle'  => __('Please dont insert <style></style> here. For instance header{background:#ccc;}', TEXT_DOMAIN)                        
                    ),
                    array(
                        'id'        => 'custom_js',
                        'type'      => 'textarea',                        
                        'title'     => __('Customize Javascript', TEXT_DOMAIN),
                        'subtitle'  => __('Please do not insert <script></script> here. For instance jQuery(document).ready(function($){
<br/>// insert code here<br/>
});', TEXT_DOMAIN)                        
                    ),


                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-cogs',
                'title'     => __('Style Settings', TEXT_DOMAIN),                
                'fields'    => array(
                    array(
                        'id'        => 'display_reload',
                        'type'      => 'select',                        
                        'title'     => __('Reload Spin', TEXT_DOMAIN),
                        'subtitle'  => __('Choose icon or image for reload. You also can choose no reload', TEXT_DOMAIN),
                        'options'   => array('1'=>'Reload Icon','2'=>'Reload Image','0'=>'No Reload'),
                        'default'   => '2'
                    ),
                    array(
                        'id'        => 'reload_icon',
                        'type'      => 'text',                        
                        'title'     => __('Reload Icon', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'desc'      => __('You can insert FontAwesome here. Find icon font here: <a target="_blank" href="http://fontawesome.io/icons/">http://fontawesome.io/icons/</a>', TEXT_DOMAIN),
                        'default'   => 'fa-spinner'
                    ),                    
                    array(
                        'id'        => 'reload_image',
                        'type'      => 'media',
                        'url'       => true,                        
                        'title'     => __('Reload Image', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'desc'      => __('You can insert an image.', TEXT_DOMAIN),
                        'default'   => array('url' => get_template_directory_uri().'/assets/img/preloader.gif')
                    ),
                    array(
                        'id' => 'body-font',
                        'type' => 'typography',
                        'output' => array('body'),
                        'title' => __('Body Font', TEXT_DOMAIN),
                        'subtitle' => __('Select a primary font for site', TEXT_DOMAIN),                        
                        'google' => true,                        
                        'text-align'    => false,
                        'subsets'       => false,
                        'line-height' => false,                        
                        'font-style'    => false,
                        'default' => array(
                            'color' => '#787b80',
                            'font-size' => '16px',                            
                            'font-family' => "Source Sans Pro",                            
                            'font-weight'   => "300"
                        ),
                    ),
                     array(
                        'id' => 'heading-font',
                        'type' => 'typography',
                        'output' => array('h1','h2','h3','h4','h5','h6'),
                        'title' => __('Font Heading (Option)', TEXT_DOMAIN),                        
                        'desc'  => __('Select a google font heading: h1,h2,h3,h4,h5,h6. <br/> Note To use nexa_boldregular font, you have to hit Reset Section button.',TEXT_DOMAIN),                        
                        'google' => true,                        
                        'color' => false,
                        'font-size' => false,                        
                        'line-height' => false,
                        'font-weight'   => false,
                        'text-align'    => false,
                        'subsets'       => false,                        
                        'font-style'    => false,                        
                        'default' => array(                            
                            'font-family' => "Montserrat",
                        ),
                    ),                                                    
                    array(
                        'id'       => 'page_layout',
                        'type'     => 'select',
                        'title'    => __('Select layout for page', TEXT_DOMAIN),
                        'subtitle' => __('', TEXT_DOMAIN),
                        'desc'     => __('', TEXT_DOMAIN),
                        'options'  => array("wide" => "Wide","boxed" => "Boxed"),
                        'default'  => 'wide'
                    ),   
                    array(
                        'id'       => 'page_boxed_pattern',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => __('Select pattern for boxed layout', TEXT_DOMAIN),
                        'subtitle' => __('', TEXT_DOMAIN),
                        'desc'     => __('You should upload an image with format *.png', TEXT_DOMAIN),                        
                        'default'  => array('url' => get_template_directory_uri().'/assets/img/patterns/square_bg.png'),

                    ),
                    array(
                        'id'       => 'page_text_direction',
                        'type'     => 'select',
                        'title'    => __('Select text direction', TEXT_DOMAIN),
                        'subtitle' => __('', TEXT_DOMAIN),
                        'desc'     => __('', TEXT_DOMAIN),
                        'options'  => array("ltr" => "ltr","rtl" => "rtl"),
                        'default'  => 'ltr'
                    ),  
                    array(
                        'id'        => 'theme_color',
                        'type'      => 'color',                        
                        'title'     => __('Select theme color', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'desc'      => __('', TEXT_DOMAIN),
                        'default'   => '#1E90FF',
                    ),
                    array(
                        'id'        => 'menu_color',
                        'type'      => 'color',                        
                        'title'     => __('Select menu color', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'desc'      => __('', TEXT_DOMAIN),
                        'default'   => '#e0ffff',
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'header_sticky_color',
                        'type'     => 'color_rgba',
                        'title'    => __('Header Sticky Color', TEXT_DOMAIN),
                        'subtitle' => __('Gives you the RGBA color.', TEXT_DOMAIN),
                        'desc'     => __('', TEXT_DOMAIN),
                        'default'  => array(
                            'color' => '#6DB7FF', 
                            'alpha' => '1'
                        ),
                        
                    ),
                     array(
                        'id'       => 'social_bg_color',
                        'type'     => 'color',
                        'title'    => __('Social Background Color', TEXT_DOMAIN),
                        'subtitle' => __('Gives you the RGBA color.', TEXT_DOMAIN),
                        'desc'     => __('', TEXT_DOMAIN),
                        'default'  => '#6DB7FF',
                    ),
                    array(
                        'id'       => 'parallax_overlay',
                        'type'     => 'color_rgba',
                        'title'    => __('Parallax Overlay', TEXT_DOMAIN),
                        'subtitle' => __('Gives you the RGBA color.', TEXT_DOMAIN),
                        'desc'     => __('', TEXT_DOMAIN),
                        'default'  => array(
                            'color' => '#6DB7FF', 
                            'alpha' => '1'
                        ),
                        
                    ),

                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-book',
                'title'     => __('Blog & Footer Settings', TEXT_DOMAIN),                
                'fields'    => array(
                    array(
                        'id'        => 'blog_heading',
                        'type'      => 'text',
                        'title'     => __('Blog Heading', TEXT_DOMAIN),
                        'subtitle'  => __('Insert Blog Heading', TEXT_DOMAIN),
                        'default'   => 'Blog Heading'
                    ),
                    array(
                        'id'        => 'background_blog_heading',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Background Heading Blog ', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'default'   => array('url' => get_template_directory_uri().'/assets/img/preview/bg-mainslider-1.jpg')
                    ),
                    array(
                        'id'        => 'background_blog_overlay',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Overlay Content Heading Blog ', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'default'   => array('url' => get_template_directory_uri().'/assets/img/overlay.png')
                    ),
                    array(
                        'id'        => 'footer',
                        'type'      => 'textarea',
                        'url'       => true,                        
                        'title'     => __('Insert Footer', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'desc'      => __('', TEXT_DOMAIN),
                        'default'   => __(' <div class="row">
                            <div class="col-sm-12 text-center social-icons">
                                <a class="social-icon" href="#"><i class="fa fa-facebook"></i></a>
                                <a class="social-icon" href="#"><i class="fa fa-twitter"></i></a>
                                <a class="social-icon" href="#"><i class="fa fa-linkedin"></i></a>
                            </div>
                            <div class="col-sm-12 text-center">@ 2014 EventME - An One Page Event Manager Theme | Developed by <a href="http://jakjim.com">jThemes Studio</a></div>
                            </div>
                            '),
                    ),
                ),
            );        

            $this->sections[] = array(
                'icon'      => 'el-icon-photo',
                'title'     => __('Slideshow Settings', TEXT_DOMAIN),                
                'fields'    => array(
                    array(
                        'id'        => 'slideshow_timezone',
                        'type'      => 'text',
                        'title'     => __('Insert Timezone', TEXT_DOMAIN),
                        'desc'  => __('The timezone (hours or minutes from GMT) for the target times. <br/> For instance:<br/> If Timezone is UTC-9:00 you have to insert -9 <br/>If Timezone is UTC-9:30, you have to insert -9*60+30=-570. <br/>Read about UTC Time:  <a href="http://en.wikipedia.org/wiki/List_of_UTC_time_offsets" target="_blank"> http://en.wikipedia.org/wiki/List_of_UTC_time_offsets</a>', TEXT_DOMAIN),                        
                        'default'   => '0'
                    ),
                    array(
                        'id'        => 'display_format',
                        'type'      => 'text',
                        'title'     => __('Display Format', TEXT_DOMAIN),
                        'desc'  => __('Display Format: dHMS. <br/> d: Day <br/> H: Hour <br/> M: Month <br/> S: Second. <br/>You can insert HMS or dHM or dH. default dHMS', TEXT_DOMAIN),                        
                        'default'   => 'dHMS'
                    ),                    
                    array(
                        'id'        => 'display_navigation',
                        'type'      => 'select',                        
                        'title'     => __('Display Navigation', TEXT_DOMAIN),
                        'subtitle'  => __('Allow to display Navigation', TEXT_DOMAIN),
                        'options'   => array('1'=>'Yes','0'=>'No'),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'display_register_button',
                        'type'      => 'select',                        
                        'title'     => __('Display Register Button', TEXT_DOMAIN),
                        'subtitle'  => __('Allow to display Register Button', TEXT_DOMAIN),
                        'options'   => array('1'=>'Yes','0'=>'No'),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'slideshow_item_count',
                        'type'      => 'text',                        
                        'title'     => __('Slide Count', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),                        
                        'default'   => '10'
                    ),
                ),
            );
            
            $this->sections[] = array(
                'icon'      => 'el-icon-calendar',
                'title'     => __('Schedule Settings', TEXT_DOMAIN),                
                'fields'    => array(
                    array(
                        'id'        => 'schedule_filter_order_by',
                        'type'      => 'select',
                        'title'     => __('Filter Order By', TEXT_DOMAIN),
                        'subtitle'  => __('Display Filter Navigation Order By', TEXT_DOMAIN),
                        'options'   => array(
                            'name'=>'name',
                            'id'=>'ID',
                            'count'=>'count',                            
                            'slug'=>'slug',
                            'none'=>'none'                            
                        ),
                        'default'   => 'name'
                    ),
                    array(
                        'id'        => 'schedule_filter_order',
                        'type'      => 'select',
                        'title'     => __('Filter Order', TEXT_DOMAIN),
                        'subtitle'  => __('Display Filter Navigation  Order', TEXT_DOMAIN),
                        'options'   => array(
                            'ASC'=>'ASC',
                            'DESC'=>'DESC'                            
                        ),
                        'default'   => 'DESC'
                    ),                    

                    array(
                        'id'        => 'schedule_schedule_order_by',
                        'type'      => 'select',
                        'title'     => __('Schedule Order By', TEXT_DOMAIN),
                        'subtitle'  => __('Display Schedule Post Order By', TEXT_DOMAIN),
                        'options'   => array(
                            'id'=>'ID',
                            'author'=>'Author',
                            'title'=>'title',
                            'name'=>'Slug',
                            'date'=>'Order by date',
                            'modified'=>'Order by last modified date',
                            'parent'=>'Order by post/page parent id.',
                            'rand'=>'Random order',
                            'comment_count'=>'Order by number of comments',
                        ),
                        'default'   => 'id'
                    ),
                    array(
                        'id'        => 'schedule_schedule_order',
                        'type'      => 'select',
                        'title'     => __('Schedule Order', TEXT_DOMAIN),
                        'subtitle'  => __('Display Schedule Post Order', TEXT_DOMAIN),
                        'options'   => array(
                            'ASC'=>'ASC',
                            'DESC'=>'DESC'                            
                        ),
                        'default'   => 'DESC'
                    ),                      
                    array(
                        'id'        => 'schedule_display_time',
                        'type'      => 'select',                        
                        'title'     => __('Display Time', TEXT_DOMAIN),
                        'subtitle'  => __('Display Time', TEXT_DOMAIN),
                        'options'   => array('1'=>'Yes','0'=>'No'),
                        'default'   => '1'
                    ), 
                    array(
                        'id'        => 'schedule_display_address',
                        'type'      => 'select',                        
                        'title'     => __('Display Address', TEXT_DOMAIN),
                        'subtitle'  => __('Display Address', TEXT_DOMAIN),
                        'options'   => array('1'=>'Yes','0'=>'No'),
                        'default'   => '1'
                    ),                   
                    array(
                        'id'        => 'schedule_display_view',
                        'type'      => 'select',                        
                        'title'     => __('Display View', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'options'   => array('1'=>'Yes','0'=>'No'),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'schedule_display_author',
                        'type'      => 'select',                        
                        'title'     => __('Display Author', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'options'   => array('1'=>'Yes','0'=>'No'),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'schedule_count_word',
                        'type'      => 'text',                        
                        'title'     => __('Word Count dipplay in intro description', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),                        
                        'default'   => '30'
                    ),
                    array(
                        'id'        => 'schedule_display_desc',
                        'type'      => 'select',                        
                        'title'     => __('Display Description Intro', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'options'   => array('1'=>'Yes','0'=>'No'),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'schedule_tab_count_desc',
                        'type'      => 'text',                        
                        'title'     => __('Item count each tab', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),                        
                        'default'   => '20'
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-volume-up',
                'title'     => __('Speakers Settings', TEXT_DOMAIN),                
                'fields'    => array(
                    array(
                        'id'        => 'speakers_speaker_link',
                        'type'      => 'select',                        
                        'title'     => __('Display Link to detail Speaker', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'options'   => array('1'=>'Yes','0'=>'No'),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'speakers_desc_count',
                        'type'      => 'text',                        
                        'title'     => __('Character count display in description', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),                        
                        'default'   => '100'
                    ),
                    array(
                        'id'        => 'speakers_item_count',
                        'type'      => 'text',                        
                        'title'     => __('Item Count display', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),                        
                        'default'   => '20'
                    ),
                    array(
                        'id'        => 'speakers_layout',
                        'type'      => 'select',
                        'title'     => __('Select layout. Item Count in row', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'options'   => array(
                            'col-md-12 col-sm-12'=>'1 item in row',
                            'col-md-6 col-sm-6'=>'2 items in row',
                            'col-md-4 col-sm-4'=>'3 items in row',
                            'col-md-3 col-sm-6'=>'4 items in row',
                            'col-md-2 col-sm-6 col-5'=>'5 items in row',
                            'col-md-2 col-sm-6'=>'6 items in row',
                        ),
                        'default'   => 'col-md-3 col-sm-6'
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-arrow-right',
                'title'     => __('Subscribe Settings', TEXT_DOMAIN),                
                'fields'    => array(
                    array(
                        'id'        => 'subscribe_background',
                        'type'      => 'media',
                        'url'       => true,                        
                        'title'     => __('Select background image for subscribe section', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN)
                    )
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-time',
                'title'     => __('Recent Post Settings', TEXT_DOMAIN),                
                'fields'    => array(
                    array(
                        'id'        => 'recentpost_count',
                        'type'      => 'text',                        
                        'title'     => __('Item count display', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'default'   => '3'
                    ),
                    array(
                        'id'        => 'recentpost_des_count',
                        'type'      => 'text',                        
                        'title'     => __('Word count display in introtext', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'default'   => '30'
                    ),
                    array(
                        'id'        => 'recentpost_show_author',
                        'type'      => 'select',                        
                        'title'     => __('Show author', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'options'   => array('1'=>'Yes','0'=>'No'),
                        'default'   => '1'
                    ),                  
                  
                    array(
                        'id'        => 'recentpost_layout',
                        'type'      => 'select',
                        'title'     => __('Select layout. Item Count in row', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'options'   => array(
                            'col-md-12 col-sm-12'=>'1 item in row',
                            'col-md-6 col-sm-6'=>'2 items in row',
                            'col-md-4 col-sm-4'=>'3 items in row',
                            'col-md-3 col-sm-6'=>'4 items in row',
                            'col-md-2 col-sm-6 col-5'=>'5 items in row',
                            'col-md-2 col-sm-6'=>'6 items in row',
                        ),
                        'default'   => 'col-md-4 col-sm-4'
                    ),
                ),
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-twitter',
                'title'     => __('Twitter Settings', TEXT_DOMAIN),                
                'fields'    => array(                    
                    array(
                        'id'        => 'twitteruser',
                        'type'      => 'text',                        
                        'title'     => __('Show twitter User', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'default'   => 'ovatheme'
                    ),                    
                    array(
                        'id'        => 'consumerkey',
                        'type'      => 'text',                        
                        'title'     => __('Consumer key', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'default'   => 'tMkTTjTTUlc21SpRjbekGXzak'
                    ),
                    array(
                        'id'        => 'consumersecret',
                        'type'      => 'text',                        
                        'title'     => __('Consumer key secret', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'default'   => 'jLBIgMJb8D6psnqlD2mxfCqcD44I5U9RGAs2Bf6JsQB8lRCFLx'
                    ),
                    array(
                        'id'        => 'accesstoken',
                        'type'      => 'text',                        
                        'title'     => __('Access token', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'default'   => '2444841276-KuW7FFJuTMijF4AoWgdHKwO6oKvx2Ym1wB490E3'
                    ),
                    array(
                        'id'        => 'accesstokensecret',
                        'type'      => 'text',                        
                        'title'     => __('Access token secret', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'default'   => 'pvNMa8hEMph0jZjQUT4IRUVMi5yHFO7qMpZ5XJ3eFEqeP'
                    ),
                    array(
                        'id'        => 'twittercount',
                        'type'      => 'text',                        
                        'title'     => __('Show twitter Count', TEXT_DOMAIN),
                        'subtitle'  => __('', TEXT_DOMAIN),
                        'default'   => '5'
                    ),
                    array(
                        'id'        => 'twitter_autoplay',
                        'type'      => 'text',                        
                        'title'     => __('Auto Play', TEXT_DOMAIN),
                        'subtitle'  => __('Insert number time (ms) to deplay or false to not auto play', TEXT_DOMAIN),
                        'default'   => '5000'
                    ),
                ),
            );


            
           

            // Import Export
            $this->sections[] = array(
                'title'     => __('Import / Export', 'redux-framework-demo'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'redux-framework-demo'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );                     
                    
           
            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'redux-framework-demo'),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

            /*if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'redux-framework-demo'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }*/
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'theme_option',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', TEXT_DOMAIN),
                'page_title'        => __('Theme Options', TEXT_DOMAIN),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyCAHXGEaeiUlkHR8bnI-yUtM-xQ_gmfpHM', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => true,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo');
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
