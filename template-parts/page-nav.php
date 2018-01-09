<div class="clear"></div>
<div class="row">
	<div class="col-sm-12">
		<?php if( function_exists('pagination') ) :
			pagination();
		else : ?>
			<nav class="oldernewer">
				<div class="older">
					<?php next_posts_link( __('&laquo; Older Entries', 'non-cherry') ) ?>
				</div>
				<div class="newer">
					<?php previous_posts_link( __('Newer Entries &raquo;', 'non-cherry') ) ?>
				</div>
			</nav>
		<?php endif; ?>
	</div>
</div>
