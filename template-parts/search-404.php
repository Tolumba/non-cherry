<form class="search" method="get" id="search-404" action="<?php echo esc_url( home_url() ); ?>">
	<input type="text" class="searching" value="<?php the_search_query(); ?>" name="s" id="s" />
	<a class="btn btn-default" onclick="document.getElementById('search-404').submit()"><?php _e( 'Search', 'non-cherry' ); ?></a>
</form>
