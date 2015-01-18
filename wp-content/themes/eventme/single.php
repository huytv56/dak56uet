<?php
/** The main template file **/ 
global $theme_option;
global $wp_query;
get_header(); 

?>        
	<section class="page-section with-sidebar sidebar-right">
	    <div class="container">
	        <div class="row">

	            <!-- Content -->
	            <section id="content" class="content col-sm-8 col-md-9">
	            	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	                <article class="post-wrap thumbnail">
	                    <div class="post-media">
	                        <div class="thumbnail no-border <?php if(!has_post_format('gallery')) echo 'do-hover'; ?>">

	                            <?php if(has_post_format('image')){ ?>	                                
	                                <?php  
		                                if ( has_post_thumbnail() ) {
		                                	the_post_thumbnail('full'); 
		                            	}
	                                ?>
	                            <?php } ?>

	                            <?php if(has_post_format('audio')){ ?>
	                                <div class="js-video postformat_audio">
	                                    <?php echo wp_oembed_get(get_post_meta(get_the_id(), "_cmb_embed_media", true)); ?>
	                                    <div style="clear:both;"></div>
	                                </div>
	                            <?php } ?>

	                            <?php if(has_post_format('video')){ ?>
	                                <div class="js-video postformat_video">
	                                    <?php echo wp_oembed_get(get_post_meta(get_the_id(), "_cmb_embed_media", true)); ?>
	                                </div>
	                            <?php } ?>

	                            <?php if(has_post_format('link')){ ?>
	                                    <?php the_content(); ?>
	                            <?php } ?>

	                            <?php if(has_post_format('gallery')){
	                                $gallery = get_post_gallery( get_the_id(), false );

	                                if(isset($gallery['ids'])){
	                                    $gallery_ids = $gallery['ids'];
	                                    $img_ids = explode(",",$gallery_ids);
	                                    $i=1;
	                                    ?>
	                                    <div class="gallery_schedule owl-carousel">
	                                        <?php foreach( $img_ids AS $img_id ){
	                                                $image_src = wp_get_attachment_image_src($img_id,''); 
	                                        ?>                      
	                                            <div>
	                                                <img class="img-responsive" src="<?php echo $image_src[0]; ?>">
	                                            </div>
	                                        <?php
	                                            $i++;
	                                        }?>
	                                    </div>
	                                    <?php
	                                }
	                            } ?>	                                   
	                        </div>
	                        <div class="post-meta clearfix">
                                <span class="pull-left">
                                    <span class="post-date">
                                    	<i class="fa fa-calendar"></i>
                                    	<?php the_time('j F, Y');?>
                                    </span>
                                </span>
                                <span class="pull-right">
                                    <a href="<?php the_permalink();?>">
                                        <i class="fa fa-comment"></i>
                                        <?php comments_popup_link(__(' 0 bình luận', TEXT_DOMAIN), __(' 1 bình luận', TEXT_DOMAIN), ' % bình luận'.__('', TEXT_DOMAIN)); ?>
                                    </a>
                                    <a href="<?php the_permalink();?>"><i class="fa fa-eye"></i>
                                        <?php echo wpb_get_post_views(get_the_id()); ?></a>
                                </span>
                            </div>
	                    </div>
	                    <div class="post-header">
	                        <h4 class="post-title"><?php the_title( ); ?></h4>
	                    </div>
	                    <div class="post-body">
	                        <?php 
								the_content();
								wp_link_pages();
								wpb_set_post_views(get_the_ID());
							?>
	                    </div>

	                    <footer class="post-meta">
	                    	<?php if(has_tag()){ ?>
		                        <span class="post-tags"><i class="fa fa-tag"></i> 
		                        	<?php the_tags('',',',''); ?>
		                        </span> &nbsp;
	                        <?php } ?>
	                        <?php if(has_category( )){ ?>
		                        <span class="post-categories"><i class="fa fa-folder-open"></i> 
		                        	<?php the_category(','); ?>
		                        </span>
	                        <?php } ?>
	                    </footer>

	                </article>

	                <div class="post-wrap thumbnail">

	                    <!-- Comments -->
	                    <div class="comments">
	                    	<?php comments_template(); ?>
	                    </div>
	                    <!-- /Comments -->
	                </div>

	            </section>
	            <!-- Content -->
	            <?php endwhile; else: ?>
					<p><?php _e('Xin lỗi không tìm thấy bài bạn cần.', TEXT_DOMAIN); ?></p>
				<?php endif; ?>

	            <hr class="page-divider transparent visible-xs"/>

	            <!-- Sidebar -->
	            <aside id="sidebar" class="sidebar col-sm-4 col-md-3">
	                <?php dynamic_sidebar('sidebar-right' ); ?>	
	            </aside>
	            <!-- Sidebar -->

	        </div>
	    </div>
	</section>

<?php get_footer(); ?>
