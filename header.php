<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package jbaths
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php custom_data_layer(); ?>
	
	<?php google_tag_manager(); ?>

<div id="page">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'jbaths' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" id="logo"><?php bloginfo( 'name' ); ?></a>
		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle"><?php _e( 'Menu', 'jbaths' ); ?></button>
			<?php echo custom_search_form(); ?>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<!--[if lte IE 9]>
	<div id="lteIE8"><p>We see you are using an older version of Internet Explorer. For the best experience, we recommend upgrading to the latest browser version.<br />We recommend <a href="https://www.google.com/intl/en-US/chrome/browser/">Google Chrome</a> or <a href="http://www.mozilla.org/en-US/firefox/new/">Firefox</a>. Or get the latest <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">Internet Explorer</a>.</p></div>
	<![endif]-->

	<div id="content" class="site-content" role="main">
