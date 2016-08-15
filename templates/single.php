<?php

	get_header();

		do_action('before_loop');

			if (have_posts()) : while (have_posts()) : the_post(); 
				
				// The following determines what the post format is and shows the correct file accordingly
				$format = get_post_format()?:'standard';
				get_template_part( 'includes/post-formats/'.$format );
				get_template_part( 'includes/post-formats/post-nav' );
				get_template_part( 'includes/post-formats/related-posts' );
				comments_template( '', true );

			endwhile; endif;

		do_action('after_loop');

	get_footer();

?>