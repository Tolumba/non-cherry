<div class="no-results content-wrap">
	<p><strong><?php _e('There has been an error.', 'non-cherry'); ?></strong></p>
	<p><?php _e('We apologize for any inconvenience, please', 'non-cherry'); ?> <a href="<?php echo esc_url( home_url() ); ?>/" title="<?php bloginfo('description'); ?>"><?php _e('return to the home page', 'non-cherry'); ?></a> <?php _e('or use the search form below.', 'non-cherry'); ?></p>
	<?php get_search_form(); ?>
</div>