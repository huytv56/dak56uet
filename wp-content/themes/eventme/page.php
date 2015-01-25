<?php
/** The main template file **/ 
global $theme_option;
global $wp_query;

get_header(); 

?>	
	<section class="page-section with-sidebar sidebar-right">
		<div class="container">

			<section id="page_content" class="content col-sm-8 col-md-9">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div class="post">
						<?php  
								$full_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
					 	?>
					 	<?php if($full_image_url){ ?>
						<div class="thumbnail">							
							 <img src="<?php echo $full_image_url[0] ?>" alt="" class="img-responsive">						
						</div>
						<?php } ?>
						<div class="title">
						    <h3>
						    	<a href="<?php the_permalink();?>" title="<?php the_title();?>">
						    		<?php the_title();?>
						    	</a>
						    </h3>
						</div><!-- end title -->
						
						<div class="content-blog">
							<?php 
								the_content();
								wp_link_pages();
							?>
						</div>
						
					</div>

				<?php endwhile; else: ?>
					<p><?php _e('Sorry, no pages matched your criteria.', TEXT_DOMAIN); ?></p>
				<?php endif; ?>
				
									
			</section>
			
			<hr class="page-divider transparent visible-xs"/>

			<aside id="sidebar" class="sidebar col-sm-4 col-md-3">
				<?php dynamic_sidebar('sidebar-right' ); ?>
			</aside>

		</div> <!-- container -->
	</div> <!-- page-section -->
	

<?php get_footer(); ?>
