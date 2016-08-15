<?php 
	/**
	*
	*	Loop: Common Loop
	*
	*/
	?>
<?php if ( have_posts() ) :

		while ( have_posts() ) : the_post();

			if( get_post_type() != 'page'){

				$format = get_post_format()?: 'standard';
				get_template_part( 'includes/post-formats/'.$format );

			}elseif( is_search() ){

				get_template_part( 'template-parts/search-link' );

			}else{

				the_content();

			}

		endwhile;

	else: ?>

		<div class="no-results">
			<?php get_template_part( 'includes/post-formats/none' ); ?>
		</div>
	
<?php endif; ?>