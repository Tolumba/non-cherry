<?php if ( of_get_option('post_excerpt', false) ) : ?>

	<div class="post-excerpt">

		<?php if ( has_excerpt() ) :

			the_excerpt();

		else:

			$content = '';

			$content = strip_shortcodes( get_the_content() );

			$content = strip_tags( $content );

			$pattern_url = "#((http|https)://)(www.)*.+?\s#";

			$content = preg_replace( $pattern_url, '', $content);

			echo my_string_limit_words( $content, of_get_option( 'post_excerpt_length', 55 ) );

		endif; ?>

	</div>

<?php else: ?>

	<div class="post-content">

		<?php the_content(); ?>

	</div>

<?php endif; ?>

<!-- <a href="<?php the_permalink() ?>" class="btn btn-info"><?php _e('read more', 'non-cherry'); ?></a> -->