<?php
/** Template Name: Blog */
global $theme_option;

get_header(); 

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'paged' => $paged,
);
$a = new WP_Query($args);

?>        
        <?php if($theme_option['blog_heading']){ ?>
	        <section class="page-section image blog-head">
	            <div class="container text-center">
	                <h1 class="section-title">
	                	<?php echo $theme_option['blog_heading']; ?>
	                </h1>
	            </div>
	        </section>
        <?php }else{ ?>
            <section class="page-section image blog-head">
                <div class="container text-center">
                    <h1 class="section-title">
                        <?php echo __('Blog Heading', TEXT_DOMAIN); ?>
                    </h1>
                </div>
            </section>
        <?php } ?>
        

        <!-- Page Blog -->
        <section class="page-section with-sidebar sidebar-right">
            <div class="container">
                <div class="row">

                    <!-- Content -->
                    <section id="content" class="content col-sm-8 col-md-9">

                    	<?php 
							$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	                        $args = array(    
	                            'paged' => $paged,
	                            'post_type' => 'post',
	                        );
	                        $a = new WP_Query($args);
			 			?>
			 			<?php if ( $a->have_posts() ) : while ( $a->have_posts() ) : $a->the_post(); ?>
			 				<article class="post-wrap thumbnail">
	                            <div class="post-media">	                            	
	                                <div class="thumbnail no-border <?php if(!has_post_format('gallery')) echo 'do-hover'; ?>">

                                        <?php if(has_post_format('image')){ ?>
                                            <?php $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id()); ?>
                                            <img class="img-responsive" src="<?php  echo $thumbnail_url; ?>" alt="">
                                        <?php } else if(has_post_format('audio')){ ?>
                                            <div class="js-video postformat_audio">
                                                <?php echo wp_oembed_get(get_post_meta(get_the_id(), "_cmb_embed_media", true)); ?>
                                                <div style="clear:both;"></div>
                                            </div>
                                        <?php } else if(has_post_format('video')){ ?>
                                            <div class="js-video postformat_video">
                                                <?php echo wp_oembed_get(get_post_meta(get_the_id(), "_cmb_embed_media", true)); ?>
                                            </div>
                                        <?php } else if(has_post_format('link')){ ?>
                                                <?php the_content(); ?>
                                        <?php } else if(has_post_format('gallery')){
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
                                        } else{ ?>
											<?php $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id()); ?>
												<img class="img-responsive" src="<?php  echo $thumbnail_url; ?>" alt="">
										<?php } ?>
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
                                                <?php comments_popup_link(__(' 0 comment', TEXT_DOMAIN), __(' 1 comment', TEXT_DOMAIN), ' % comments'.__('', TEXT_DOMAIN)); ?>
                                            </a>
	                                        <a href="<?php the_permalink();?>"><i class="fa fa-eye"></i>
                                                <?php echo wpb_get_post_views(get_the_id()); ?></a>
	                                    </span>
	                                </div>
	                            </div>

	                            <div class="post-header">
	                                <h4 class="post-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo the_title( ); ?>
                                        </a>
                                    </h4>
	                                <span class="post-author"><?php _e('by', TEXT_DOMAIN); ?>
                                            <?php echo get_the_author( ); ?>
                                    </span>
	                            </div>
	                            <div class="post-body">
	                                <div class="post-excerpt">
	                                	<?php  the_excerpt(); ?>
	                                </div>
	                            </div>
	                        </article>

			 			<?php endwhile; else: ?>
							<p><?php _e('Sorry, no posts matched your criteria.', TEXT_DOMAIN); ?></p>
						<?php endif; ?>

                        <!-- Pagination -->
                        <div class="pagination-wrapper">                           
                            <?php ova_numeric_posts_nav(); ?>
							

                        </div>
                        <!-- /Pagination -->

                    </section>
                    <!-- Content -->

                    <hr class="page-divider transparent visible-xs"/>

                    <!-- Sidebar -->
                    <aside id="sidebar" class="sidebar col-sm-4 col-md-3">

                        <?php dynamic_sidebar('sidebar-right' ); ?>

                    </aside>
                    <!-- Sidebar -->

                </div>
            </div>
        </section>
        <!-- /Page Blog -->

    
   
<?php get_footer(); ?>