//LM Easy Emoticons plugin
 (function()
 {
  
 tinyMCE.create('tinymce.plugins.LMEasyEmoticons',
     {
         init : function(ed, url)
         {

         // Register a button
         ed.addButton('btnLMEEmo',
         {
           title : 'LM Easy Emoticons',
           //cmd : 'LMEEmo',
           image : url + '/button_l.png',
            classes: 'widget btn btnLMEEmo',
           onclick : function() {

           }
         });
     },
     // Returns information about the plugin as a name/value array.
     getInfo : function()
      {
         return {
            longname : "LM Easy Emoticons",
            author : '羊小咩 Lamb-Mei',
            authorurl : 'http://lamb-mei.com/',
            infourl : 'http://lamb-mei.com/',
            version : "1.0"
         };
      }
   });
   // Register plugin
   tinyMCE.PluginManager.add('lmeemo', tinyMCE.plugins.LMEasyEmoticons);
 })();
