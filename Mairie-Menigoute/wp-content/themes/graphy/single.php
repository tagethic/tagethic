<?php
/**
 * The template for displaying all single posts.
 *
 * @package Graphy
 */

// Test si c'est .. pour ne pas envoyer header/footer :
// - un appel en méthode Post
// - un post_type "event"
$posttype = get_post_type( $postid );
$contentOnly = false;
if ($posttype=="event") {$contentOnly = true;}
if ($_POST) {$contentOnly = true;}


if (! $contentOnly ) {get_header();} // test pour affichage simplifié en ModalWindow ?>



	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>
			
			<?php if (! $contentOnly) { graphy_post_nav(); } ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					// comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar();  ?>
<?php if (! $contentOnly) { get_footer();}  ?>