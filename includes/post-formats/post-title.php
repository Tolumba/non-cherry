<?php $title = get_the_title(); ?>
<?php $permalink = get_the_permalink(); ?>
<?php $title_before = __('Permalink to:', 'non-cherry'); ?>

<?php if( is_singular() ) : ?>

	<?php $format = '<h2 class="entry-title">%1$s</h2>'; ?>

<?php else :?>
	
	<?php $format = '<h4 class="entry-title"><a href="%3$s">%1$s</a></h4>'; ?>
	
<?php endif; ?>

<?php printf( $format, $title, $title_before, $permalink );