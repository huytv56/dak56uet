<?php
/*
Plugin Name: LM-Easy-Emoticons
Version: 1.0
Author: 羊小咩 Lamb-Mei
Author: http://lamb-mei.com/
Description: Easy way to use Emoticons
*/
 
//wp 版本
global $wp_version;


/**
 +----------------------------------------------------------
 * 版本檢查
 +----------------------------------------------------------
 */
$exit_msg='LMEasy Emoticons requires WordPress 3.0 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';
if (version_compare($wp_version,"3.0","<"))
{
 exit ($exit_msg);
}



/**
 +----------------------------------------------------------
 * 註冊class.
 +----------------------------------------------------------
 */
if ( !class_exists('LMEasy_Emoticons') ) :
class LMEasy_Emoticons
{
    const KEY_USE_HISTORY   = 'key_use_history';
    const KEY_CUSTOM_EMO    = 'key_custom_emo';
    const PLUGIN_NAME       = 'lm-easy-emoticons';
    // the plugin URL
    var $plugin_url;

    //圖片限制
    var $k_allow_min_size = 300;

    var $allow_max_W = 500;
    var $allow_max_H = 500;
    var $allow_min_W = 5;
    var $allow_min_H = 5;


    var $lm_emoticons_dir;
    var $uploads;
    // Initialize WordPress hooks
    function LMEasy_Emoticons()
    {
        //Init vars
        $this->plugin_url = trailingslashit( WP_PLUGIN_URL.'/'.dirname( plugin_basename(__FILE__) ));

        // $upload_dir = trailingslashit( WP_CONTENT_DIR ) . 'custom_uploads_name';
        //trailingslashit( WP_CONTENT_DIR )
        $this->uploads = wp_upload_dir();

        $this->lm_emoticons_dir = sprintf("%s/%s" , $this->uploads["basedir"] , self::PLUGIN_NAME );

        //檢查儲存資料夾存在
        $this->checkLMEmoticonsDirExist();


        // print scripts action
        add_action('admin_print_scripts-post.php',  array(&$this,'scripts_action'));
        add_action('admin_print_scripts-page.php',  array(&$this,'scripts_action'));
        add_action('admin_print_scripts-post-new.php',  array(&$this,'scripts_action'));
        add_action('admin_print_scripts-page-new.php',  array(&$this,'scripts_action'));


        // add LMEE handlig
        add_action( 'init', array( &$this, 'add_LMEE' ));
        
        //AJAX
        //記得加上前綴字wp_ajax_
        
        add_action('wp_ajax_getEmo', array(&$this,'getEmo_callback'));
        add_action('wp_ajax_setUsedEmo', array(&$this,'setUsedEmo_callback'));
        add_action('wp_ajax_getUsedEmo', array(&$this,'getUsedEmo_callback'));
        add_action('wp_ajax_emptyUsedEmo', array(&$this,'emptyUsedEmo_callback'));

        add_action('wp_ajax_addEmoFromURL', array(&$this,'addEmoFromURL_callback'));
        add_action('wp_ajax_addEmoFromFile', array(&$this,'addEmoFromFile_callback'));

        add_action('wp_ajax_addEmoPopupTPL', array(&$this,'addEmoPopupTPL_callback'));
        
        add_action('wp_ajax_test', array(&$this,'test_callback'));
    }
    function test_callback(){
                $uploads = wp_upload_dir();
                $dir = $uploads['basedir'];
         // trailingslashit( WP_CONTENT_DIR ), '', untrailingslashit( UPLOADS )

         // $upload_dir = trailingslashit( WP_CONTENT_DIR ) . 'custom_uploads_name';
        //trailingslashit( WP_CONTENT_DIR )
        // $uploads = wp_upload_dir();
                var_dump($uploads);
        // $this->lm_emoticons_dir = sprintf("%s/%s" , $upload_dir["basedir"] , self::PLUGIN_NAME );

                 die();
    }

    //add Lambmei Easy Emoticons 功能
    function add_LMEE()
    {

        wp_register_script( 'lmeemo', $this->plugin_url.'js/lm-easy-emoticons.js' );
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
        return;

        if ( get_user_option('rich_editing') == 'true' ) //使否為編輯模式
        {
            //按鈕
            add_filter( 'mce_external_plugins', array( &$this,'add_lmee_mce_plugin' ) );
            add_filter( 'mce_buttons', array( &$this,'add_lmee_mce_button' ));
        }
    }

    function add_lmee_mce_plugin( $plugin_array )
    {
        $plugin_array['lmeemo'] = $this->plugin_url.'js/lmeemo-mceplugin.js';
        return $plugin_array;
    }

    function add_lmee_mce_button( $buttons )
    {
        array_push( $buttons, "separator", 'btnLMEEmo' );
        return $buttons;
    }


    // Set up everything
    function install()
    {

    }


    // prints the scripts 定義
    function scripts_action($hook)
    {

        $nonce=wp_create_nonce('lmeemo-nonce');
        wp_enqueue_script('jquery');


        wp_register_style( 'lmeemo-basic-style', plugins_url('css/lambmei-easyemo.css', __FILE__) );
        



        wp_enqueue_style( 'lmeemo-basic-style' );

        wp_enqueue_script('lmeemo', $this->plugin_url.'js/lm-easy-emoticons.js', array('jquery'));
        wp_localize_script('lmeemo', 'LMEESettings',array(
                                                    'url' => $this->plugin_url
                                                    )
        );
    }

    //DATA
    function getEmo_callback(){

        $_emo = $this->getCustomEmoByData();

        header( "Content-Type: application/json" );
        echo json_encode(array("emo"=>$_emo));
        die(); // this is required to return a proper result
    }

    function getCustomEmoByData(){
        /* 更改直接取得資料夾 以便移轉
        $_custom_emo = get_option(LMEasy_Emoticons::KEY_CUSTOM_EMO);

        if($_custom_emo === false || !is_array($_custom_emo) || (count($_custom_emo) == 0))
        {
            //init data
            // $this->plugin_url

            $plugin_dir = plugin_dir_path( __FILE__ );

            $_custom_emo = $this->dir_list($plugin_dir .'images/emoticons-lamb', "gif|jpg|jpeg|png");
            if(count($_custom_emo) > 0){
                $_custom_emo = array_map(array( &$this,'fix_path_root' ),$_custom_emo);
            }
            add_option(LMEasy_Emoticons::KEY_CUSTOM_EMO, $_custom_emo);
        }
        */

        
        $_custom_emo = array();        

        $target_dir = array('emoticons-lamb' , 'emoticons-custom');

        $this->checkDefaultCustomFolder();
        
        // $plugin_dir = plugin_dir_path( __FILE__ ); 不符合WordPress 儲存資料不可放在plugin 本身內
        $upload_dir = $this->lm_emoticons_dir;

        foreach($target_dir as $key => $value)
        {

            $_tmp_emo = $this->dir_list( $upload_dir ."/" .$value, "gif|jpg|jpeg|png");
            if(count($_tmp_emo) > 0){
                $_custom_emo = array_merge($_custom_emo , array_map(array( &$this,'fix_path_root' ),$_tmp_emo));
            }

        }

        return $_custom_emo;
    }


    //記錄 更改為直接讀取目錄所以不需要儲存
    /* 
    function setEmoToData($dir , $file)
    {
        $plugin_url = plugin_dir_url( __FILE__ );
        $_custom_emo = $this->getCustomEmoByData();
        
        $path = sprintf("%s%s%s" , $plugin_url  , $dir  , $file);
        // array_unshift($_custom_emo , $path) ;
        $_custom_emo[] = $path;

        $save_array = array_unique($_custom_emo);

        update_option(LMEasy_Emoticons::KEY_CUSTOM_EMO, $save_array );


        return $save_array;
    }
    */

    function fix_path_root($path){
        // $plugin_dir = $this->dir_path( plugin_dir_path( __FILE__ ) );
        // $plugin_url = plugin_dir_url( __FILE__ );
        // $path = str_replace($plugin_dir, $plugin_url,$path); 

        // var_dump($plugin_dir);

        $basedir = str_replace('\\', '/', $this->uploads['basedir']);     
        $path = str_replace('\\', '/', $path);


        $path = str_replace($basedir , $this->uploads['baseurl'] ,$path); 

        return $path;
    }

    //---------



    function setUsedEmo_callback() {
      // 讀取POST資料
      $arg1 = $_POST['arg1'];
     
      global $wpdb; //可以拿POST來的資料作為條件，撈DB的資料來作顯示

      $_use_history = $this->getUseHistroyByData();

      array_unshift($_use_history , $arg1) ;

      $save_array = array_unique($_use_history);

      $array_max_num = 15;
      if(count($save_array) > $array_max_num)
      {
        $save_array = array_slice($save_array, 0 ,$array_max_num );
      }

      //記錄不重覆array
      update_option(LMEasy_Emoticons::KEY_USE_HISTORY, $save_array );

      header( "Content-Type: application/json" );
      $dataInfo = array("status" => true );
      // $dataInfo["histroy"] = $_use_history
        
      echo json_encode($dataInfo);
      die(); // this is required to return a proper result
    }


    function getUsedEmo_callback() {
      // 讀取POST資料
      $_use_history = $this->getUseHistroyByData();

      global $wpdb; //可以拿POST來的資料作為條件，撈DB的資料來作顯示

      header( "Content-Type: application/json" );
      echo json_encode(array("emo"=>$_use_history));
      die(); // this is required to return a proper result
    }

    //清空使用記錄
    function emptyUsedEmo_callback(){
        header( "Content-Type: application/json" );
        $_use_history = $this->getUseHistroyByData();
        update_option(LMEasy_Emoticons::KEY_USE_HISTORY, array() );

        $dataInfo = array("status" => true );
        echo json_encode($dataInfo);
        die();
    }

    //取得使用記錄
    function getUseHistroyByData(){

        $_use_history = get_option(LMEasy_Emoticons::KEY_USE_HISTORY); //KEY_USE_HISTORY

        if($_use_history === false || !is_array($_use_history))
        {
            //init data
            $_use_history = array();
            add_option(LMEasy_Emoticons::KEY_USE_HISTORY, $_use_history);
        }
        return $_use_history;
    }



    //新增表情符號 From URL
    function addEmoFromURL_callback(){
        header( "Content-Type: application/json" );

        $target_url = $_POST['target_url'];

        $status = false;
        $error_code = 0;
        $error = null;
        $curl_error = null;

        $_emo = null;

        $ext = null;
        $fileName = null;
        $saveto = null;

        global $wpdb;

        
        // $user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
        $user_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36';


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($ch, CURLOPT_URL,$target_url);
        curl_setopt($ch, CURLOPT_TIMEOUT,        30);
        
        try{
            $result=curl_exec($ch);

            $info = curl_getinfo($ch);
            // $info2 = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            curl_close ($ch);
        } catch (Exception $e) {
            $curl_error = $e;
            // echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        //Check TYPE
        $content_type = $info['content_type'];
        $isTargetImageType = $content_type == 'image/jpeg' || $content_type == 'image/gif' || $content_type == 'image/png' ;
        
        if( $error_code >= 0 && $isTargetImageType == false)
        {
            $error_code = -100;
            $error = "Invalid file format.";
        }

        if($error_code >= 0 ){
            if( isset($info['download_content_length']) ){
                $content_lengthisset = (float) $info['download_content_length'];

                $k_size = $content_lengthisset/1024;

                
                if($k_size > $this->k_allow_min_size ){
                    $error_code = -201;
                    $error = sprintf("您要下載的圖檔 %.1f kb 大於限制的 %.1f kb" , $k_size , $this->k_allow_min_size );
                }

            }else{
                $error_code = -200;
                $error = "download_content_length 不正確！";
            }
            
        }
        


        
        //Chek Image W/H SIZE
        $isAllowSize = false;
        $_width = 0;
        $_height = 0;
        $imageInfo = array("width"=> &$_width , "height"=>&$_height);

        if( $error_code >= 0 )
        {
            $im = imagecreatefromstring($result);

            $_width = imagesx($im);
            $_height = imagesy($im); 



            if($_width> $this->allow_max_W || $_height > $this->allow_max_H){
                $error_code = -300;
                $error = "圖片寬或高超過允許的 {$this->allow_max_W} x {$this->allow_max_H}！";
            }
            if($_width <  $this->allow_min_W || $_height <  $this->allow_min_H ){
                $error_code = -301;
                $error = "圖片寬或高太小，必須大於 {$this->allow_min_W} x {$this->allow_min_H}！";
            }

        }
        
        $this->checkDefaultCustomFolder();

        if($error_code >= 0 ){
            //Save File
            $fileName = md5($result);
        
            switch ($content_type) {
                case 'image/jpeg':
                    $ext = 'jpg';
                    break;
                case 'image/gif':
                    $ext = 'gif';
                    break;
                case 'image/png':
                    $ext = 'png';
                    break;
            }

            
            // $plugin_dir = plugin_dir_path( __FILE__ );
            // $image_dir = $plugin_dir . "/images/emoticons-custom/";
            $upload_dir = $this->lm_emoticons_dir;
            $image_dir = $upload_dir . "/emoticons-custom/";

            $file = sprintf("%s.%s" , $fileName , $ext);
            $saveto =  sprintf("%s%s" , $image_dir ,$file );

            if(file_exists($saveto)){
                // unlink($saveto);
                $error_code = -400;
                $error = "此表情符號已經存在！";
            }else{

                $fp = fopen($saveto,'x');
                fwrite($fp, $result);
                fclose($fp);
                //SaveFile END

                //更改為直接讀取
                //$_emo = $this->setEmoToData("/images/emoticons-custom/" , $file );
                
                $_emo = $this->getCustomEmoByData();
            }
            
            


        }
        
        




        $output = array("status" => $error_code >= 0 ,                        
                       // "info"=>$info,
                       // "content_length"=>$content_length,
                       // "isTargetImageType" => $isTargetImageType,
                       // "saveto" => $saveto ,
                       // "img_info" =>$imageInfo,
                       "error_code"=> $error_code,
                       "error"=> $error
                        );

        if($_emo !=null)
        {
            $output["emo"] = $_emo ;
        }

        echo json_encode($output);
        die();

    }


    //From file
    function addEmoFromFile_callback(){

        header( "Content-Type: application/json" );
        $upfile_key = "image";

        try {
      
            // var_dump($_FILES[$upfile_key]);
            if (
                !isset($_FILES[$upfile_key]['error']) ||
                is_array($_FILES[$upfile_key]['error'])
            ) {
                throw new RuntimeException('Invalid parameters.',-1000);
            }

            // Check $_FILES[$upfile_key]['error'] value.
            switch ($_FILES[$upfile_key]['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.',-1001);
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.',-1002);
                default:
                    throw new RuntimeException('Unknown errors.',-1003);
            }

            //檢查類型
            if (false === $ext = array_search(
                $_FILES[$upfile_key]['type'],
                array(
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ),
                true
            )) {
                throw new RuntimeException('Invalid file format.',-1100);
            }

            //檢查檔案大小 
            $fileSize = $_FILES[$upfile_key]['size']/1024;
            if ( $fileSize > $this->k_allow_min_size) {
                $error_msg = sprintf("您上傳的圖檔 %.1f kb 大於限制的 %.1f kb" , $fileSize , $this->k_allow_min_size );
                throw new RuntimeException($error_msg,-1200);
            }

            // $finfo = new finfo(FILEINFO_MIME_TYPE);
            // if (false === $ext = array_search(
            //     $finfo->file($_FILES[$upfile_key]['tmp_name']),
            //     array(
            //         'jpg' => 'image/jpeg',
            //         'png' => 'image/png',
            //         'gif' => 'image/gif',
            //     ),
            //     true
            // )) {
            //     throw new RuntimeException('Invalid file format.');
            // }

            $raw = file_get_contents($_FILES[$upfile_key]['tmp_name']);

            $im = imagecreatefromstring($raw);

            $_width = imagesx($im);
            $_height = imagesy($im); 

            if($_width> $this->allow_max_W || $_height > $this->allow_max_H){
                $error_code = -1300;
                $error = "您上傳的圖片({$_width} * {$_height})寬或高超過允許的 {$this->allow_max_W} x {$this->allow_max_H}！";
                throw new RuntimeException($error,$error_code);
            }
            if($_width <  $this->allow_min_W || $_height <  $this->allow_min_H ){
                $error_code = -1301;
                $error = "您上傳圖片({$_width} * {$_height})寬或高太小，必須大於 {$this->allow_min_W} x {$this->allow_min_H}！";
                throw new RuntimeException($error,$error_code);
            }


            $this->checkDefaultCustomFolder();

            $fileName = md5($raw);
        
            
            // $plugin_dir = plugin_dir_path( __FILE__ );
            // $image_dir = $plugin_dir . "/images/emoticons-custom/";
            $upload_dir = $this->lm_emoticons_dir;
            $image_dir = $upload_dir . "/emoticons-custom/";

            $file = sprintf("%s.%s" , $fileName , $ext);
            $saveto =  sprintf("%s%s" , $image_dir ,$file );


            $_emo = null;
            if(file_exists($saveto)){
                // unlink($saveto);
                $error_code = -1400;
                $error = "此表情符號已經存在！";
                throw new RuntimeException($error,$error_code);
            }else{

                // $fp = fopen($saveto,'x');
                // fwrite($fp, $result);
                // fclose($fp);
                
                if (!move_uploaded_file( $_FILES[$upfile_key]['tmp_name'], $saveto ))
                {
                    throw new RuntimeException('Failed to move uploaded file.',-1500);
                }

                
                $_emo = $this->getcustomEmoByData();
            }


            $output = array("status"=>true );
            if($_emo !=null)
            {
                $output["emo"] = $_emo ;
            }

        } catch (RuntimeException $e) {
            $output = array("status"=>false ,"error"=>$e->getMessage() , "error_code"=>$e->getCode());
            
            // echo $e->getMessage();

        }
        echo json_encode($output);

        die();
    }




    //------FILE-----------
    function dir_path($path) { 
        $path = str_replace('\\', '/', $path); 
        if (substr($path, -1) != '/') $path = $path . '/'; 
        return $path; 
    } 
    /** 
    * 列出目录下的所有文件 
    * 
    * @param str $path 目录 
    * @param str $exts 后缀 
    * @param array $list 路径数组 
    * @return array 返回路径数组 
    */ 
    function dir_list($path, $exts = '', $list = array()) { 
        $path = $this->dir_path($path); 
        $files = glob($path . '*'); 
        usort($files, create_function('$a,$b', 'return filemtime($a) - filemtime($b);'));

        foreach($files as $v) { 
            if (!$exts || preg_match("/\.($exts)/i", $v)) { 
                $list[] = $v; 
                if (is_dir($v)) { 
                    $list = dir_list($v, $exts, $list); 
                } 
            } 
        } 
        return $list; 
    }



    /** 
    * Tpl
    */
    function addEmoPopupTPL_callback(){


echo <<< EOF
    <a href="javascript:void(0);" class="modal" id="modal-one" aria-hidden="true">
  </a>
  <div class="modal-dialog">
    <div class="modal-header">
      <h2>新增表情符號</h2>
      <a href="javascript:void(0);" class="btn-close" aria-hidden="true">x</a>
    </div>
    <div class="modal-body">

  <label for="emo-url">來自網址：</label><input id="emo-url" type="text" size="35"> 
  <input id="emo-add-url-btn" type="button" value="新增" class="btn"> 

  <img id="emo-url-indicator" src="$this->plugin_url/css/images/loading.gif" style="display: none;">
  <div id="emo-url-error" class="emo-error-msg" style="display: none;"></div>
  <div id="or">或 </div>

  <form id="emo-file-form" method="post" action="" target="emo-upload-iframe" enctype="multipart/form-data">
    <label for="emo-file">來自我的電腦：</label>
    <input id="emo-file" type="file" name="image" size="15" accept="image/*">
    <input id="emo-add-file-btn" type="submit" value="上傳" class="btn">
    <input id="emo-add-ajax-action" type="hidden" name="action" value="addEmoFromFile">
    <img id="emo-file-indicator" src="$this->plugin_url/css/images/loading.gif" style="display: none;">
    </form>

    <div id="emo-file-error" class="emo-error-msg" style="display: none;"> </div>
    <iframe name="emo-upload-iframe" id="emo-upload-iframe" style="display: none; width: 1px; height: 1px;"></iframe>

    <div class="emo-add-tip">圖片大小必須小於 {$this->k_allow_min_size}KB ，尺寸不能超過 {$this->allow_max_W} * {$this->allow_max_H}。<br>僅支援 JPG、GIF、PNG 格式。</div>

    </div>
    <!--
    <div class="modal-footer">
      <a href="javascript:void(0)" class="btn">Go</a>
    </div>
  -->
</div>

EOF;
}


    //Check Default Folder  "emoticons-custom"
    function checkDefaultCustomFolder(){
        // $plugin_dir = plugin_dir_path( __FILE__ );
        // $image_dir = $plugin_dir . "/images/emoticons-custom";
        $upload_dir = $this->lm_emoticons_dir;
        $image_dir = $upload_dir . "/emoticons-custom/";


        if (!file_exists($image_dir)) {
            mkdir($image_dir, 0777, true);
        }

    }


    function checkLMEmoticonsDirExist(){
        
        if (!file_exists($this->lm_emoticons_dir)) {
            mkdir($this->lm_emoticons_dir, 0777, true);
        }

    }




}



endif; // 註冊class end.





/**
 +----------------------------------------------------------
 * Wp PlugIn 執行區段
 +----------------------------------------------------------
 */

if ( class_exists('LMEasy_Emoticons') )
{

    $LMEasy_Emoticons = new LMEasy_Emoticons();
    if (isset($LMEasy_Emoticons))
    {
        register_activation_hook( __FILE__,array(&$LMEasy_Emoticons, 'install') );
    }

}

?>