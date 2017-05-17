<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
// Test si c'est .. pour ne pas envoyer header/footer :
// - un appel en méthode Post
// - un post_type "event"
$posttype = get_post_type( $postid );
$contentOnly = false;
if ($posttype=="event") {$contentOnly = true;}
if ($_POST) {$contentOnly = true;}


if (! $contentOnly ) {get_header();} // test pour affichage simplifié en ModalWindow 
// if ( is_home() ) {get_header();} ?>


<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php 
if (! $contentOnly ) {get_footer(); }
// if ( is_home() ) {get_footer();}
