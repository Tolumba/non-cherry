<div id="footer-text" class="info privacy-block">
<?php ob_start(); ?>
	<?php _e( 'Copyright', 'non-cherry' ); ?> &copy; <?php echo date('Y'); ?> | <a href="<?php echo esc_url( home_url() ); ?>/privacy-policy/"><?php _e( 'Privacy policy', 'non-cherry'); ?></a>
<?php $default_footer = ob_get_clean(); ?>
<?php echo of_get_option('footer_text', $default_footer); ?>
</div>