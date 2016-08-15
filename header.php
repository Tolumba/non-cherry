<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes();?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes();?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes();?>> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" <?php language_attributes();?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes();?>> <!--<![endif]-->
<head>
	<title><?php wp_title(); ?></title>
	<meta name="description" content="<?php echo get_bloginfo().' | '.get_bloginfo( 'description' ); ?>" />
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />

	<!--[if lt IE 9]>
	<html class="lt-ie9">
	<div id="ie6-alert" style="width: 100%; text-align:center; background: #232323;">
	    <img src="http://beatie6.frontcube.com/images/ie6.jpg" alt="Upgrade IE 6" width="640" height="344" border="0"
	         usemap="#Map" longdesc="http://die6.frontcube.com"/>
	    <map name="Map" id="Map">
	        <area shape="rect" coords="496,201,604,329"
	              href="http://www.microsoft.com/windows/internet-explorer/default.aspx" target="_blank"
	              alt="Download Interent Explorer"/>
	        <area shape="rect" coords="380,201,488,329" href="http://www.apple.com/safari/download/" target="_blank"
	              alt="Download Apple Safari"/>
	        <area shape="rect" coords="268,202,376,330" href="http://www.opera.com/download/" target="_blank"
	              alt="Download Opera"/>
	        <area shape="rect" coords="155,202,263,330" href="http://www.mozilla.com/" target="_blank"
	              alt="Download Firefox"/>
	        <area shape="rect" coords="35,201,143,329" href="http://www.google.com/chrome" target="_blank"
	              alt="Download Google Chrome"/>
	    </map>
	</div>

	<script src="<?php echo get_stylesheet_directory(); ?>/js/html5shiv.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory(); ?>/css/ie.css">
	<![endif]-->

    <?php
		/* Always have wp_head() just before the closing </head>
		 * tag of your theme, or you will break many plugins, which
		 * generally use this hook to add elements to <head> such
		 * as styles, scripts, and meta tags.
		 */
		wp_head();
	?>
</head>
<body <?php body_class(); ?>>

	<section id="main" class="site-main">
		
		<?php do_action('before_header'); ?>

			<?php get_template_part('template-parts/header-logo') ?>
			<?php get_template_part('template-parts/nav-menu-primary') ?>
			<?php get_template_part('template-parts/search') ?>
						
		<?php do_action('after_header'); ?>