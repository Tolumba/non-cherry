<?php get_header(); ?>

	<?php do_action('before_loop') ?>

	<?php if( isset($_GET['author_name']) ) :

		$curauth = get_userdatabylogin($author_name);

	else :

		$curauth = get_userdata( intval($author) );

	endif; ?>

	<div class="author-info">

		<h2><?php _e('About:', 'non-cherry'); ?> <?php echo $curauth->display_name; ?></h2>

		<figure class="avatar">
			<?php if(function_exists('get_avatar')) { echo get_avatar( $curauth->user_email, $size = '120' ); }
			/* Displays the Gravatar based on the author's email address. Visit Gravatar.com for info on Gravatars */ ?>
		</figure>

		<?php if( $curauth->description != "" ) { /* Displays the author's description from their Wordpress profile */ ?>

			<section class="author-description"><?php echo $curauth->description; ?></section>

		<?php } ?>

	</div>

	<div id="recent-author-posts">

		<h2><?php _e('Recent Posts by', 'non-cherry'); ?> <?php echo $curauth->display_name; ?></h2>
		
		<?php get_template_part('template-parts/loops/loop-author'); ?>

	</div>

	<?php get_template_part('template-parts/page-nav'); ?>

	<div id="recent-author-comments">

		<h2><?php _e('Recent Comments by', 'non-cherry'); ?> <?php echo $curauth->display_name; ?></h2>

		<?php
			global $wpdb;

			$number = 5; // number of recent comments to display
			$comments = $wpdb->get_results( "SELECT * FROM $wpdb->comments WHERE comment_approved = '1' and comment_author_email='$curauth->user_email' ORDER BY comment_date_gmt DESC LIMIT $number" ); ?>
		<ul>
			<?php if ( $comments ) : foreach ( (array) $comments as $comment) :
				echo  '<li class="recentcomments">' . sprintf(__('%1$s on %2$s', 'non-cherry'), get_comment_date(), '<a href="'. get_comment_link($comment->comment_ID) . '">' . get_the_title($comment->comment_post_ID) . '</a>') . '</li>';
			endforeach; else: ?>
				<p>
					<?php _e('No comments by', 'non-cherry'); ?> <?php echo $curauth->display_name; ?> <?php _e('yet.', 'non-cherry'); ?>
				</p>
			<?php endif; ?>
		</ul>
	</div>

	<?php do_action('after_loop') ?>

<?php get_footer(); ?>