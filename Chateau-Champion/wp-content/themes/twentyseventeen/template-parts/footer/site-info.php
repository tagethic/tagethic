<?php
/**
 * Displays footer site info
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<div class="site-info">
	
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?> </a> &copy; <?php echo date( 'Y' ); ?> &ndash; <a href="<?php echo esc_url( home_url( '/mentions-legales' ) ); ?>">Mentions légales</a> &ndash; <a href="<?php echo esc_url( home_url( '/plan-du-site' ) ); ?>">Plan du site</a>
	
</div><!-- .site-info -->
