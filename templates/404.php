<?php get_header(); ?>
<section>
	<div class="container">
		<div class="row">
			<div id="error404">
				<div class="error404-num col-xs-12 col-sm-12 col-md-7 col-lg-7">
					404
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
					<?php echo '<h2 class="page-title">' . __('Sorry!', 'non-cherry') . '</h2>'; ?>
					<?php echo '<h3 class="page-heading">' . __('Page Not Found', 'non-cherry') . '</h3>'; ?>
					<?php echo '<p>' . __('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'non-cherry') . '</p>'; ?>
					<?php echo '<p>' . __('Please try using our search box below to look for information on the internet.', 'non-cherry') . '</p>'; ?>
					<?php get_template_part('template-parts/search-404'); ?>
				</div>
				<div class="clear"></div>
			</div><!--#error404 .post-->
		</div><!--#content-->
	</div><!--#content-->
</section>
<?php get_footer(); ?>
