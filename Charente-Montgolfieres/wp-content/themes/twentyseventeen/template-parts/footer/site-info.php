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

<?php 
	/*
	 * DC 24 avril 2017 - pouvoir gérer le contenu du Footer depuis un Post spécifique
	 */
get_footer_info();
	
function get_footer_info() {
	$args = array(
		'post_type' => 'grilleaccueil',  // MàJ 28 avril 2017
		'name' => 'pied-de-page',  // and NOT post_name!
		// 'category_name' => 'site',
		'post_status' => 'publish'
	);
	$Post = new WP_Query($args);
	
	if ($Post->have_posts()) {
		$Post->the_post();
		echo str_replace( "{annee}", date('Y'), get_the_content() );
	}
}


	?>
	
</div><!-- .site-info -->
