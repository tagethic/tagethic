<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php twentyseventeen_edit_link( get_the_ID() ); ?>
	</header><!-- .entry-header -->
	<div class="entry-content"> 
		<?php
			// Affichage du contenu de la Page avant les Galeries
			echo get_the_content_with_formatting();
			/*
			 * DC 6 mai 2017 - affichage de toutes les galeries FOO
			 */
			$args = array(
				'post_type' => 'foogallery',
				'post_status' => 'publish',
				'orderby' => 'ID',
				'order'   => 'DESC'
			);
			$PostsG = new WP_Query($args);
				
				// Calcul de l'affichage de 
			if($PostsG->have_posts())  {
				while ($PostsG->have_posts()) {
					$PostsG->the_post();
					$t = get_the_title();
					if($t[0] !== "&" AND $t[1] !== "#") {
						// On ignore les Galeries dont le nom commence par "-"  ( &#8211 - en dash)
						echo "<h2>".get_the_title()."</h2>";
						echo do_shortcode( "[foogallery id=\"".get_the_ID()."\"]" );
					}
				}
			}

		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->


