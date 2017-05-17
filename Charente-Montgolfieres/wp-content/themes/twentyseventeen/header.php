<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php //language_attributes(); 
// Détection des Pages en anglais.. utilisée aussi pour les menus
$adresse = get_permalink(); 
$langue="fr";
if(!(strpos($adresse, "/en/")===false)) {$langue="en"; echo " lang=\"uk\" ";} else {language_attributes();}
?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentyseventeen' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<?php 
		// echo "<h1>.<br>...</h1>";
		// if (twentyseventeen_is_frontpage()) {echo "<h1><br>twentyseventeen_is_frontpage</h1>";}
		// if (is_front_page()) {echo "<h1>is_front_page</h1>";}
		// if (is_home()) {echo "<h1>is_home</h1>";}
		// if (is_page()) {echo "<h1>is_page</h1>";}
		// if (is_single()) {echo "<h1>is_single</h1>";}
		
		// Détection de home as front-page
		if ( is_page() && is_front_page() ) :
		// get_template_part( 'template-parts/header/header', 'image' ); 
		endif; ?>
		
		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
				<div class="wrap">
					<?php // get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
					
					<nav id="site-navigation" class="main-navigation <?php  echo ($langue=="en"?$langue:""); ?>" role="navigation" aria-label="<?php _e( 'Top Menu', 'twentyseventeen' ); ?>">
					<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false"><?php echo twentyseventeen_get_svg( array( 'icon' => 'bars' ) ); echo twentyseventeen_get_svg( array( 'icon' => 'close' ) ); // _e( 'Menu', 'twentyseventeen' ); ?></button>
					<?php 
					$topMenu = ($langue=="en"?"en":"top");
					wp_nav_menu( array(
					
					// utiliser register_nav_menu pour enregistrer le menu EN
					// puis dans theme_location : faire le switch en fonction de la langue
						// 'theme_location' =>  'top',
						'theme_location' =>  $topMenu,
						'menu_id'        => 'top-menu',
					) ); ?>
					

					<?php /* DC 8 mars 2017 - génére code html Menu Action pour vue Mobile  et classe EN*/
						if ( has_nav_menu( 'action' ) ) : ?>
						<div class="action-navigation <?php  echo ($langue=="en"?$langue:""); ?>" role="navigation">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'action', /* identifiant du menu pour WP */
								'menu_class' => 'menu-action',   /* classe css */
								'container' => 'div',            /* élément HTML conteneur */
								'link_before' => '<span>',     /* élément HTML avant le lien */
								'link_after' => '</span>'      /* élément HTML après le lien */
							)
						);
					?></div><!-- .action-navigation -->
					<?php endif; ?>
					
					
					<?php  /* DC 8 mars 2017 - génére code html Menu Social et classe EN */
		
					if ( has_nav_menu( 'social' ) ) : ?>
						<nav class="social-navigation <?php  echo ($langue=="en"?$langue:""); ?>" role="navigation" aria-label="<?php _e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
							<?php
								$socialMenu = ($langue=="en"?"en-social":"social");
								wp_nav_menu( array(
									// 'theme_location' => 'social',
									'theme_location' => $socialMenu,
									'menu_class'     => 'social-links-menu',
									// 'depth'          => 1,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>' . twentyseventeen_get_svg( array( 'icon' => 'chain' ) ),
								) );
							?>
						</nav><!-- .social-navigation -->
					<?php endif; ?>
				
					
					</nav>
				</div><!-- .wrap -->
			</div><!-- .navigation-top -->
		<?php endif; ?>
		<?php
		/* Ajout du custom logo dans navbar principal 
		 * DC 8 mars 2017
		 */
		$custLogo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' );
		echo "<a href='".esc_url(get_home_url())."' title='". get_bloginfo( 'name' ) ."'>".'<img src="'.$custLogo[0].'" class="logo-in-nav"></a>';
		// esc_url( get_permalink( get_the_ID() ) )
		// get_home_url()
		?>

		<?php  /* DC 8 mars 2017 - génére code html Menu Social et classe EN */
		
		if ( has_nav_menu( 'social' ) ) : ?>
			<nav class="social-navigation <?php  echo ($langue=="en"?$langue:""); ?>" role="navigation" aria-label="<?php _e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
				<?php
					$socialMenu = ($langue=="en"?"en-social":"social");
					wp_nav_menu( array(
						// 'theme_location' => 'social',
						'theme_location' => $socialMenu,
						'menu_class'     => 'social-links-menu',
						// 'depth'          => 1,
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>' . twentyseventeen_get_svg( array( 'icon' => 'chain' ) ),
					) );
				?>
			</nav><!-- .social-navigation -->
		<?php endif; ?>
		
		<div id="tels" style="display: none"><div>
			<?php  echo twentyseventeen_get_svg( array( 'icon' => 'mobile' )); ?>
			<span class="tel">Bureau :</span> 05.45.67.01.45<br>
			<span class="tel">Didier :</span> 06.09.93.57.14<br>
			<span class="tel">Patrick :</span> 06.13.29.80.32<br>
		</div></div>
		

	</header><!-- #masthead -->

	<?php
	// If a regular post or page, and not the front page, show the featured image.
	// if ( has_post_thumbnail() && ( is_single() || ( is_page() && ! twentyseventeen_is_frontpage() ) ) ) :
	
// DC 14 mars 2017 - l'image à la une n'est pas affichée sur les pages mais seulement en front-page..
	if ( is_page() && is_front_page() ) :
		echo '<div class="single-featured-image-header">';
		the_post_thumbnail( 'twentyseventeen-featured-image' );
		echo '</div><!-- .single-featured-image-header -->';
	endif;
	?>

	<div class="site-content-contain">
		<div id="content" class="site-content">
