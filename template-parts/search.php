<?php if(of_get_option('g_search_box_id')=='yes'): ?>
<?php $form_id = 'search-'.uniqid(); ?>
<div class="search-form-wrapp">
	<form class="search-form" method="get" id="<?php echo $form_id; ?>" action="<?php echo esc_url( home_url() ); ?>">
		<input type="text" class="searching" value="<?php the_search_query(); ?>" name="s" id="s" />
		<a class="btn btn-default" onclick="document.getElementById('<?php echo $form_id; ?>').submit()"><?php __( 'search', 'non-cherry' ); ?>search</a>
	</form>
</div>
<?php endif; ?>
