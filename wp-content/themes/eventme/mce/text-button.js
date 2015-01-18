(function() {
    tinymce.PluginManager.add('ova_tc_button', function( editor, url ) {
        editor.addButton( 'ova_tc_button', {
            title: 'Generate Shortcode',
            type: 'menubutton',
            icon: 'mce-ico mce-i-wp_code',
            menu: [
                {
                    text: 'Section',
                    onclick: function() {
                    	editor.insertContent( '[section id="Sample Content" class="" rowvisible="0" parallax_bg=""]The content here[/section]');
                    }
                },
                {
                    text: 'Column',
                    menu: [
                    	{
                    		text: 'One Fourth',
                    		onclick: function() {
                    			editor.insertContent( '[one_fourth class=""]The content here[/one_fourth]');
                    		}
                    	},
                    	{
                    		text: 'One Third',
                    		onclick: function() {
                    			editor.insertContent( '[one_third class=""]The content here[/one_third]');
                    		}
                    	},
                    	{
                    		text: 'One Half',
                    		onclick: function() {
                    			editor.insertContent( '[one_half class=""]The content here[/one_half]');
                    		}
                    	},
                    	{
                    		text: 'One half inside',
                    		onclick: function() {
                    			editor.insertContent( '[one_half_inside class=""]The content here[/one_half_inside]');
                    		}
                    	},
                    	{
                    		text: 'One Full',
                    		onclick: function() {
                    			editor.insertContent( '[one_full class=""]The content here[/one_full]');
                    		}
                    	},
                    	{
                    		text: 'Two Third',
                    		onclick: function() {
                    			editor.insertContent( '[two_third class=""]The content here[/two_third]');
                    		}
                    	}
                    ]
                },
                {
                	text: 'Elements',
                	menu:[
                		{
                			text: 'slideshow',
                    		onclick: function() {
                    			editor.insertContent( '[slideshow id="" class=""][/slideshow]');
                    		}
                		},
                		{
                			text: 'about',
                    		onclick: function() {
                    			editor.insertContent( '[about iconfont="fa-calendar" title="The title" animation="fadeInUp" timedelay="100" class=""]The content here[/about]');
                    		}
                		},
                		{
                			text: 'schedule',
                    		onclick: function() {
                    			editor.insertContent( '[schedule class=""][/schedule]');
                    		}
                		},
                		{
                			text: 'speakers',
                    		onclick: function() {
                    			editor.insertContent( '[speakers class=""][/speakers]');
                    		}
                		},
                		{
                			text: 'testimonial',
                    		onclick: function() {
                    			editor.insertContent( '[testimonial class=""][/testimonial]');
                    		}
                		},
                        {
                            text: 'Subscribe',
                            onclick: function() {
                                editor.insertContent( '<div class="subscribe_ova">[mc4wp_form]</div>');
                            }

                        },
                		{
                			text: 'recentpost',
                    		onclick: function() {
                    			editor.insertContent( '[recentpost class=""][/recentpost]');
                    		}
                		},
                		{
                			text: 'sponsors',
                    		onclick: function() {
                    			editor.insertContent( '[sponsors animation="fadeInUp" slidecount="4" playdelay="5000"]Insert sponsor_item shortcode here [/sponsors]');
                    		}
                		},
                		{
                			text: 'sponsor_item',
                    		onclick: function() {
                    			editor.insertContent( '[sponsor_item href="" img_url="" class=""][/sponsor_item]');
                    		}
                		},
                		{
                			text: 'twitter',
                    		onclick: function() {
                    			editor.insertContent( '[twitter][/twitter]');
                    		}
                		},
                		{
                			text: 'pricing',
                    		onclick: function() {
                    			editor.insertContent( '[pricing title="The Title" currency="$" value="20" time="/ month" subtitle="The subtitle" link="#" class="" ]Insert pricing_row_content shortcode here[/pricing]');
                    		}
                		},
                        {
                            text: 'pricing_row_content',
                            onclick: function() {
                                editor.insertContent( '[pricing_row_content]The content here[/pricing_row_content]');
                            }
                        },
                		{
                			text: 'location',
                    		onclick: function() {
                    			editor.insertContent( '[location fontimage="fa-map-marker" link_directions="#"]The content here[/location]');
                    		}
                		},
                		{
                			text: 'contact-form-7',
                    		onclick: function() {
                    			editor.insertContent( '[contact-form-7 id="ID Number" title="SampleData"]');
                    		}
                		}
                	]
                },
                {
                	text: 'Other',
                	menu: [
                		{
            				text: 'groupbutton',
                    		onclick: function() {
                    			editor.insertContent( '[groupbutton]Insert button shortcodes here[/groupbutton]');
                    		}
                		},
                		{
                			text: 'button',
                    		onclick: function() {
                    			editor.insertContent( '[button position="center" href="#" class=""]The content here[/button]');
                    		}
                		},
                		{
                			text: 'heading',
                    		onclick: function() {
                    			editor.insertContent( '[heading title="Sample Data" class=""]The content here[/heading]');
                    		}
                		},
                		{
                			text: 'hr',
                    		onclick: function() {
                    			editor.insertContent( '[hr][/hr]');
                    		}
                		},
                		{
                			text: 'thumbnail',
                    		onclick: function() {
                    			editor.insertContent( '[thumbnail img_thumb_url="" img_big_url="" href="#" class=""][/thumbnail]');
                    		}
                		},
                		{
                			text: 'list',
                    		onclick: function() {
                    			editor.insertContent( '[list class="text-md"]Insert list_item shortocde here[/list]');
                    		}
                		},
                		{
                			text: 'list_item',
                    		onclick: function() {
                    			editor.insertContent( '[list_item type="fa-stop"]The content here[/list_item]');
                    		}
                		},
                	]
                },
                
           ]
        });
    });
})();