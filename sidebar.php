<?php if(of_get_option('blog_sidebar_pos')!='none'): ?>
	<aside id="sidebar" class="<?php loop_sidebar_classes(); ?>">
		<?php if ( ! dynamic_sidebar( 'main-sidebar' )) : ?>
			<!-- No widgets so far :( -->
		<?php endif; ?>
	</aside><!--sidebar-->
<?php endif; ?>
