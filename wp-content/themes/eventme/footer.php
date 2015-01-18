<!-- Footer -->
	<?php global $theme_option; ?>
	
	<?php if(isset($theme_option['footer']) && $theme_option['footer'] != '' ){ ?>
	    <footer class="footer">
	        <div class="container">
	            	<?php echo $theme_option['footer']; ?>
	        </div>
	    </footer>
    <?php } else{ ?>
		<footer class="footer">
	        <div class="container">
				<div class="row">
					<div class="col-sm-12 text-center social-icons">
						<a class="social-icon" href="#"><i class="fa fa-facebook"></i></a>
						<a class="social-icon" href="#"><i class="fa fa-twitter"></i></a>
						<a class="social-icon" href="#"><i class="fa fa-linkedin"></i></a>
					</div>
					<div class="col-sm-12 text-center">@ 2014 EventME - An One Page Event Manager Theme | Developed by <a href="http://jakjim.com">jThemes Studio</a></div>
				</div>
			</div>
	    </footer>	 
		
	<?php }?>



	</div><!-- /Content area -->
</div><!-- /wrapper -->

<?php wp_footer();?>
</body></html>