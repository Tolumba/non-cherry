<div class="site-logo">
	<h1 class="logo">
		<?php if(of_get_option('logo_type') == 'text_logo'){?>
			<a href="<?php echo esc_url( home_url("/") ); ?>" title="<?php bloginfo('description'); ?>"><span class="main"><?php bloginfo('name'); ?></span><br/><span class="secondary"><?php bloginfo('description'); ?></span></a>
		<?php } else {
				$logo_src = wp_get_attachment_url( (int) of_get_option( 'logo_url' ) );
				$logo_src = $logo_src ?: CHILD_URL."/images/logo.png";
			?>
			<a href="<?php echo esc_url( home_url() ); ?>/" id="logo"><img src="<?php echo $logo_src; ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('description'); ?>"></a>
		<?php }?>
	</h1>
</div>
