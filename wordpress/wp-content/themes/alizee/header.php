<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Alizee
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php if ( get_theme_mod('site_favicon') ) : ?>
	<link rel="shortcut icon" href="<?php echo esc_url(get_theme_mod('site_favicon')); ?>" />
<?php endif; ?>

<?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'alizee' ); ?></a>

<?php if ( get_header_image() ) :?>
	<header id="masthead" class="site-header has-banner" role="banner">
<?php else : ?>
	<header id="masthead" class="site-header" role="banner">
<?php endif; ?>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<div class="container">
				<button class="menu-toggle btn"><i class="fa fa-bars"></i></button>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</div>	
		</nav><!-- #site-navigation -->
		<div class="container">
			<div class="site-branding">
				<?php if ( get_theme_mod('site_logo') ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php echo esc_url(get_theme_mod('site_logo')); ?>" alt="<?php bloginfo('name'); ?>" /></a>
				<?php else : ?>
					<?php if ( display_header_text() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	<?php if ( is_home() ) : ?>
		<div class="sidebar-toggle"><i class="fa fa-plus"></i></div>
	<?php endif; ?>
	<?php if ( has_nav_menu( 'social' ) ) : ?>
		<nav class="social-navigation clearfix">
			<?php wp_nav_menu( array( 'theme_location' => 'social', 'link_before' => '<span class="screen-reader-text">', 'link_after' => '</span>', 'container_class' => 'container', 'menu_class' => 'menu clearfix', 'fallback_cb' => false ) ); ?>
		</nav>
		<div class="social-toggle"><i class="fa fa-facebook"></i></div>
	<?php endif; ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content container">