<<<<<<< HEAD
	<footer id="footer" class="<?php footer_classes(); ?>">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 clearfix">
					<?php if ( ! dynamic_sidebar( 'footer-sidebar' ) ) : ?>
					<!-- No widgets so far -->
					<?php endif ?>
				</div>
			    <div class="col-xs-12">

			    	<?php get_template_part('template-parts/footer-logo') ?>
					<?php get_template_part('template-parts/footer-text') ?>
					
				</div>
			</div>
		</div>
		<?php if( is_front_page() ) { ?>
		<!-- {%FOOTER_LINK%} -->
		<?php } ?>
	</footer>
</section><!--#main-->

<?php wp_footer(); ?> <!-- this is used by many Wordpress features and for plugins to work properly -->

<?php if(of_get_option('ga_code')) : ?>
	<script type="text/javascript">
		<?php echo stripslashes(of_get_option('ga_code')); ?>
	</script>
<?php endif; ?>
</body>
=======
	<footer id="footer" class="<?php footer_classes(); ?>">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 clearfix">
					<?php if ( ! dynamic_sidebar( 'footer-sidebar' ) ) : ?>
					<!-- No widgets so far -->
					<?php endif ?>
				</div>
			    <div class="col-xs-12">

			    	<?php get_template_part('template-parts/footer-logo') ?>
					<?php get_template_part('template-parts/footer-text') ?>
					
				</div>
			</div>
		</div>
		<?php if( is_front_page() ) { ?>
		<!-- {%FOOTER_LINK%} -->
		<?php } ?>
	</footer>
</section><!--#main-->

<?php wp_footer(); ?> <!-- this is used by many Wordpress features and for plugins to work properly -->

<?php if(of_get_option('ga_code')) : ?>
	<script type="text/javascript">
		<?php echo stripslashes(of_get_option('ga_code')); ?>
	</script>
<?php endif; ?>
</body>
>>>>>>> origin/master
</html>