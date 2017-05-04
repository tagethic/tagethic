<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Graphy
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="pingback" href="<?php //bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
<link rel="icon" href="http://ville-menigoute.fr/wp-content/uploads/2016/11/favicon1.png" sizes="32x32" />
<link rel="icon" href="http://ville-menigoute.fr/wp-content/uploads/2016/11/favicon1.png" sizes="192x192" />
<link rel="apple-touch-icon-precomposed" href="http://ville-menigoute.fr/wp-content/uploads/2016/11/favicon1.png" />
<meta name="msapplication-TileImage" content="http://ville-menigoute.fr/wp-content/uploads/2016/11/favicon1.png" />
</head>

<body <?php body_class(); ?>>

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'graphy' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-header-container">
		<div class="site-branding">
		<?php //graphy_logo(); ?>
		<div class="site-logo">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img alt="" class="normal" src="<?php echo esc_url( get_theme_mod( 'graphy_logo' ) ); ?>" /><img alt="" class="medium" src="<?php echo str_replace(".jpg","-transp.png", esc_url( get_theme_mod( 'graphy_logo' ) )); ?>" />
		</a>
		</div>
		<?php graphy_site_title(); ?>
		<?php if ( ! get_theme_mod( 'graphy_hide_blogdescription' ) ) : ?>
			<div class="site-description"><?php bloginfo( 'description' ); ?></div>
		<?php endif; ?>
		<?php if ( has_nav_menu( 'header-social' ) ) : ?>
			<nav id="header-social-link" class="header-social-link social-link">
				<?php wp_nav_menu( array( 'theme_location' => 'header-social', 'depth' => 1, 'link_before'  => '<span class="screen-reader-text">', 'link_after'  => '</span>' ) ); ?>
			</nav><!-- #header-social-link -->
		<?php endif; ?>
		</div><!-- .site-branding -->

		<?php if ( ! get_theme_mod( 'graphy_hide_navigation' ) ) : ?>
		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle"><span class="menu-text"><?php esc_html_e( 'Menu', 'graphy' ); ?></span></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			<?php if ( ! get_theme_mod( 'graphy_hide_search' ) ) : ?>
			<?php get_search_form(); ?>
			<?php endif; ?>
			<div class="astucefav">Pour ajouter un raccourci vers ce site sur votre écran d'accueil, utilisez le menu de votre navigateur &gt; <b>Ajouter à l'écran d'accueil</b>.</div>
		</nav><!-- #site-navigation -->
		<?php endif; ?>
		</div>
		<?php if ( is_home() && get_header_image() ) : ?>
		<div id="header-image" class="header-image">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
		</div><!-- #header-image -->
		<?php elseif ( is_page() && has_post_thumbnail() ) : ?>
		<div id="header-image" class="header-image">
			<?php the_post_thumbnail( 'graphy-page-thumbnail' ); ?>
		</div><!-- #header-image -->
		<?php endif; ?>

	</header><!-- #masthead -->

<div id="page" class="hfeed site">
	<div id="content" class="site-content">
