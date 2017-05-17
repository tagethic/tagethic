<?php
/*

Template Name: Sitemap

*/
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
get_header();
// if ( is_home() ) {get_header();} ?>


<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					// comments_template();
				endif;

			endwhile; // End of the loop.
			?>
			<div class="plan-site">
			
			<?php
			// Construction du Plan de site d'après Menu top 
			// DC 2_ avril 2017
			if ( has_nav_menu( 'top' ) )  {
				wp_nav_menu(
					array(
						'theme_location' => 'top', /* identifiant du menu pour WP */
						'menu_class' => 'plan-menu',   /* classe css */
						'container' => 'div'           /* élément HTML conteneur */
					)
				);
			}
			?>
			
			
				<div class="plan-articles">
					<h3><?php _e('Articles', 'textdomain'); ?></h3>
					<ul><?php $archive_query = new WP_Query('showposts=100'); while ($archive_query->have_posts()) : $archive_query->the_post(); 

					/* DC 3 dec 2016 : on exclut les title commençant par un tiret */
					$p = get_the_title();
					if($p[0]!=="-") {
					?>

					<li>
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a> <?php $categories = get_the_category();
					if ( ! empty( $categories ) ) {
						echo "<span class='tag-catg'>".esc_html( $categories[0]->name )
							. " &ndash; ";
						echo twentyseventeen_posted_on()
							."</span>";   
					} 	?>
					
					</li>

					<?php } endwhile; ?>
					</ul>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php 
get_footer();
// if ( is_home() ) {get_footer();}
