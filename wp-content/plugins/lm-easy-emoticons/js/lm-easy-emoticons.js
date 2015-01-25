//LM Easy Emoticons plugin

//------------------------------
//     init LMEE 
//------------------------------
var LMEE = LMEE || {};


jQuery(document).ready(function($)
{

    //vars 
    var pop_width = 20 +(110*5);
    var container_height = (110) *3; 
   
    var $popup , $emoticon_holder_super_parent ,$emoticon_pages_parent , $emoticon_child_container , $emoticons_tabs ,$tabs_ul, $box_arrow ,$addEmoPopup;
    var isShow = false
    var addEmoPopupIsShow=false
    //Function

    function trace(){
        var debug = true
        if(console && debug) console.log.apply(console , arguments);
    }

    function createPopupBase(){
        $popup = $("<div>")
                    .attr( "id" ,"lmee_popup" )
                    .addClass( "lmee_popup" )
                    .css("width" , pop_width);
                      
        $emoticon_child_container = $('<div>')
                                            .attr( "id" ,"emoticon_child_container" )
                                            .css({  
                                                    height:container_height,                                                                                           
                                                    overflow: 'auto'
                                                    // overflowX: 'scroll'
                                                });
        $emoticon_pages_parent = $('<div>').attr( "id" ,"emoticon_pages_parent" )
                                            .append($emoticon_child_container);
        $emoticon_holder_super_parent = $('<div>').attr( "id" ,"emoticon_holder_super_parent" )
                                        .append($emoticon_pages_parent).css({  
                                                    height:container_height
                                                });;
        
        //Tabs                                
        $emoticons_tabs = $("<div>").attr( "id" ,"emoticons_tabs" );
        //add Ctrl btn
        $emoticons_tabs.append('<a href="javascript:void(0)" class="bn_close"></a>');
        $emoticons_tabs.append('<a id="emo_emotiland_button" title="新增..." style="background-image: url('+LMEESettings.url+'css/images/add_btn.png); display:none;"></a>');
        $emoticons_tabs.append('<a id="emptyUsed_button" title="清空記錄..." style="background-image: url('+LMEESettings.url+'css/images/clear_btn.png); display:none;"></a>');

        $tabs_ul = $("<ul>")
        $tabs_ul.append('<li id="emo_basic" class="current"><a href="javascript:void(0)"><img src="'+LMEESettings.url+'css/images/tab_emo.png" title="常用表情" style="border: none;"></a></li>')
        $tabs_ul.append('<li id="emo_history" class=""><a href="javascript:void(0)"><img src="'+LMEESettings.url+'css/images/tab_histroy.png" title="歷史紀錄"></a></li>')

        $emoticons_tabs.append($tabs_ul);
        

        $box_arrow = $('<div class="box_arrow"></div>');

        $popup.append($emoticon_holder_super_parent)
              .append($emoticons_tabs);



        // $popup.append($box_arrow);

                   

        $('#wpcontent #poststuff #post-body').append($popup);
    }

    function createAddPop(){
        //trace("createAddPop")
        $addEmoPopup = $("<div>").attr("id" , "LMEEmoAddPopup")
        $addEmoPopup.hide();
        addEmoPopupIsShow =false

        $addEmoPopup.load( ajaxurl,{action: 'addEmoPopupTPL'}, function() {
          //alert( "Load was performed." );
          var $form = $addEmoPopup.find("#emo-file-form")
                            .attr("action", ajaxurl)
                            .attr("method", "post");
            $form.find("#emo-file-form").val("addEmoFromFile");
          
          $("#LMEEmoAddPopup #emo-upload-iframe").load(function () {
                $("#LMEEmoAddPopup #emo-file-indicator").hide();
                // var iframeContents = this.contentWindow.document.body.innerHTML;
                var data = $.parseJSON($("#LMEEmoAddPopup #emo-upload-iframe").contents().text());
                $error = $("#LMEEmoAddPopup #emo-file-error").text("").hide();

                if(data.status === undefined){
                    alert("Error")
                }else if(data.status === true){
                    $emoticon_child_container.empty();
                    addEmo(null , data);
                    closeEmotiland();
                }else if(data.status === false){

                    $error.show();
                    $error.text('('+ data.error_code +') ' + data.error);

                }


            });

        } );


        $('body').append($addEmoPopup);
        
    }


    

    //相減 a-b 物件必須含有TOP & LEFT
    function substract(a, b){

        var _defaults = {top:0,left:0}
        var _a = $.extend(false, _defaults , a );
        var _b = $.extend(false, _defaults , b );
        var _r = $.extend(false, _defaults , {} );
        _r.top = _a.top - _b.top
        _r.left = _a.left - _b.left
        return _r
    }

    function setPOPPos(){
        var btnPG = $(".mce-btnLMEEmo").offset()
        // var popPG = $popup.offset()
        // var nPos = substract(btnPG , popPG)
        btnPG.left -=  pop_width/2 
        btnPG.top += 35

        if(btnPG.left - pop_width/2 < 5){
            btnPG.left = 5
        }

        var _dw = $(document).width();

        var max_left = _dw - pop_width -10
        if( btnPG.left  > max_left ){
            btnPG.left = max_left
        }

        $popup.offset(btnPG)

        
    }
    function addEmo(error,data){
        if(error){
            return
        }
        var emo_group = data.emo
        var root_url = LMEESettings.url


        if(emo_group.length > 0){

            for(var i=0 ; i<emo_group.length ; i++){
                var emo = emo_group[i]
                var path = emo


                var div = $('<div class="EmoItem">');
                var img = $('<img class="EmoItemImg">');
                img.attr('src', path);

                var a = $('<a>');
                a.attr('href', "javascript://");
                a.click(emoClickHandle)


                
                img.appendTo(div);
                div.appendTo(a);
                // img.appendTo(a);
                a.appendTo($emoticon_child_container);
            }


        }else{
            addEmptyIMG()
        }

        
    }

    function addEmptyIMG(){
        var emptyIMG = $('<div class="empty-emo"><img src="'+LMEESettings.url+'css/images/empty.png" border="0" /><br/><span>No Item</span></div>');
            emptyIMG.appendTo($emoticon_child_container);

    }

    function emoClickHandle(){
        var $img = $(this).find("img") 
        var path = $img.attr('src')
        insert_image(path)
        setUsedEmo(path)
        hidePop()
    }


    //------------------------------
    //     UI Interactive 
    //------------------------------

    function showPop(){
        isShow = true
        $popup.css('visibility', 'visible');
    }
    function hidePop(){
        isShow = false
        $popup.css('visibility', 'hidden');
    }
    //Tabs Act
    function tagsBtnHandle(){
       //
        var act =null
        if( $(this).hasClass("current")) return

        $(this).addClass("current").siblings().removeClass("current")

        $emoticons_tabs.find("#emo_emotiland_button,#emptyUsed_button").hide();
        

        switch($(this).attr("id")){
            case "emo_basic":
                $emoticon_child_container.empty()
                getEmo()
                 $emoticons_tabs.find("#emo_emotiland_button").show();
            break
            case "emo_history":
                $emoticon_child_container.empty()
                getUsedEmo()
                $emoticons_tabs.find("#emptyUsed_button").show();

            break
        }

    }

    function emotyUsedClickHandle(){
        if(confirm("Are u  sure Empty Used Histroy ?"))
        {
            emptyUsedEmo()
        }
    }

    function resetAddEmoForm()
    {
        var $error = $("#LMEEmoAddPopup #emo-url-error");
            $error.hide();
            $error.text("");

        $error = $("#LMEEmoAddPopup #emo-file-error").text("").hide();

        target_url = $("#LMEEmoAddPopup #emo-url").val("")

        var form = $addEmoPopup.find("form").get(0)
        if(form){
             form.reset()
        }
    }

    function emotilandClickHandle(){        
        if(addEmoPopupIsShow==false){
            $addEmoPopup.show();

            resetAddEmoForm()

            addEmoPopupIsShow =true
        }
        
    }
    function closeEmotiland()
    {
        if(addEmoPopupIsShow==true){
            $addEmoPopup.hide();
            addEmoPopupIsShow =false
        }

    }

    //新增表情符號 FROM URL Handle
    function onaddEmoFromURLData(error,data){
        var $error = $("#LMEEmoAddPopup #emo-url-error");
        $error.hide();
        $error.text("");

        if(error){
            $error.show();
            $error.text(error);
            return
        }

        if(data){
            if(data.status ===true){
                $emoticon_child_container.empty();
                addEmo(null , data);
                closeEmotiland();
            }else{
                $error.show();
                $error.text('('+ data.error_code +') ' + data.error);
            }
        }
    }

    function addEmoFromURLBtnClickHandle(){
        if(addjqXHR !=null )return;

        var $indicator = $("#LMEEmoAddPopup #emo-url-indicator");
        var $error = $("#LMEEmoAddPopup #emo-url-error");
        $error.hide();
        $error.text("");


         var target_url = $("#LMEEmoAddPopup #emo-url").val().trim();
         //trace(target_url)
         if(target_url.length == 0){
            $error.show();
            $error.text("輸入的網址不能為空!");
            return;
         }else{
            var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;  
            var isURL = regexp.test(target_url);
            //trace(isURL)
            if(!isURL){
                $error.show();
                $error.text("輸入的網址錯誤!");
                return
            }

         }
                 
         $indicator.show()

         var data = {
              action: 'addEmoFromURL',
              target_url:target_url
            };

        addjqXHR = $.post( ajaxurl , data , function( data ) {
          //trace(data.sataus)
        }, "json")
            .done(function( json ) {
            onaddEmoFromURLData(null,json)
          })
          .fail(function( jqxhr, textStatus, error ) {
            onaddEmoFromURLData(error,null)
        })
          .always(function() {
            addjqXHR =null
            $indicator.hide()
          });
          
    }

     function addEmoFromFileBtnClickHandle(){
        $file = $("#LMEEmoAddPopup #emo-file");
        $error = $("#LMEEmoAddPopup #emo-file-error").val("").hide();

        if( $file.val() == "" || $file.val().length == 0){

            $error.show();
            $error.text("尚未選擇檔案");

            return false
        }else{
            $("#LMEEmoAddPopup #emo-file-indicator").show();            
            return true
        }

        
    }


    //-----------------------------
    //      DATA
    //------------------------------
    var jqXHR = null
    var addjqXHR = null

    function checkAbort(){
        if(jqXHR){
            jqXHR.abort();
            jqXHR = null
        }
    }
    function getEmo(){
        var data = {
              action: 'getEmo',
            };
        checkAbort()
        jqXHR = $.getJSON( ajaxurl, data)
          .done(function( json ) {
            addEmo(null,json)
          })
          .fail(function( jqxhr, textStatus, error ) {
            addEmo(error,null)
        });

    }
    function setUsedEmo (target_url){
        var data = {
              action: 'setUsedEmo',
              arg1: target_url,
            };
        checkAbort()
        jqXHR = $.post( ajaxurl , data , function( data ) {
          //trace(data.sataus)
        }, "json");

    }
    function getUsedEmo (){
        var data = {
              action: 'getUsedEmo'
            };
        checkAbort()
        jqXHR = $.getJSON( ajaxurl, data)
          .done(function( json ) {
            addEmo(null,json)
          })
          .fail(function( jqxhr, textStatus, error ) {
            addEmo(error,null)
        });

    }
    function emptyUsedEmo(){

        var data = {
              action: 'emptyUsedEmo'
            };
        
        checkAbort()
        jqXHR = $.getJSON( ajaxurl, data)
          .done(function( json ) {
            if(json.status){
                if($('#emo_history').hasClass("current"))
                {
                    $emoticon_child_container.empty()
                    addEmptyIMG()
                }
                
            }
          })
          .fail(function( jqxhr, textStatus, error ) {
            alert(error)
        });

        
    }

    

    //-----------------------------
    //      WP 控制
    //------------------------------
    function insert_image(src, title) {

         //var size = document.getElementById('img_size').value;
         title = title || ""
         var img = '<img src="' + src + '" alt="' + title + '" hspace="5" border="0" />';
         send_wp_editor(img);

    }
    // function insert_link(html_link)
    // {
    //     if ((typeof tinyMCE != "undefined") )
    //     {
    //         var edt = tinyMCE.activeEditor
    //         if ((edt != null) && (edt.isHidden() != false)) {
    //             var sel = edt.selection.getSel();
    //             if (sel){
    //                 var link = '<a href="' + html_link + '" >' + sel + '</a>';
    //                 send_wp_editor(link);
    //             }
    //         }
    //     }
    // }
    // send html to the editor
    function send_wp_editor(html)
    {
        // trace(html)
        // var win = window.dialogArguments || opener || parent || top;
        send_to_editor(html);
        // alternatively direct tinyMCE command for insert
        // tinyMCE.execCommand("mceInsertContent", false, html);
    }

    //-----------------------------
    //      INIT
    //------------------------------
    var init = function(){
        createPopupBase()
        createAddPop()
        getEmo()

        hidePop()

        
        $( window ).resize(function() {
            setPOPPos()
        });

        $(document).click(function(e){ 
         e = window.event || e; // 兼容IE7
         var obj = $(e.srcElement || e.target);

         var isEmoPop = $(obj).is("#lmee_popup,#lmee_popup *,.mce-btnLMEEmo,.mce-btnLMEEmo *")
         var isAddEmoPop = $(obj).is("#LMEEmoAddPopup .modal-dialog,#LMEEmoAddPopup *")
         
            if ( isEmoPop ) { 
           } else {
            // 目標以外都關閉視窗
            if(isShow && !addEmoPopupIsShow){
                hidePop()
            }
            //當新增視窗打開時
            if(addEmoPopupIsShow){
                    //不是 ADD POP 或關閉按鈕就關閉視窗
                    if( $(obj).is("#LMEEmoAddPopup .btn-close ,#LMEEmoAddPopup .modal ")   ){
                        closeEmotiland()
                    }
            }


         } 
        });

        $(document).on("click", ".lmee_popup",function(e){ 
            //trace("ccc")
            //e.preventDefault();
        })
        $emoticons_tabs.find('#emptyUsed_button').click(emotyUsedClickHandle)
        $emoticons_tabs.find('#emo_emotiland_button').click(emotilandClickHandle)
        

        $tabs_ul.find("li").click(tagsBtnHandle)

        $(".mce-btnLMEEmo").live("click",function(){
            if(isShow){
                hidePop()
            }else{
                setPOPPos()
                showPop()
            }
            
        })
        $("#lmee_popup .bn_close").live("click",function(){
            if(isShow){
                hidePop()
            }        
        })

        //
        $("#LMEEmoAddPopup #emo-add-url-btn").live("click",addEmoFromURLBtnClickHandle)

        $("#LMEEmoAddPopup #emo-add-file-btn").live("click",addEmoFromFileBtnClickHandle)



        $emoticons_tabs.find("#emo_emotiland_button").show();


    }
    init()



})



