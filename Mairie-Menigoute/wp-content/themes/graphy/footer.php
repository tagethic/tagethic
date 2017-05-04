<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Graphy
 */
?>

	</div><!-- #content -->
	
</div><!-- #page -->

	<footer id="colophon" class="site-footer">

		<?php get_sidebar( 'footer' ); ?>

			<div class="footer-boxes">
				
					<?php
// Recherche du Post dont le titre vaut "-footer-" et affichage de son contenu
// Il doit contenir des .footer-box
$found_post = null;
if ( $posts = get_posts( array( 
    'name' => '-footer-', 
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 1
) ) ) $found_post = $posts[0];
if ( ! is_null( $found_post ) ){
    $contenu = $found_post->post_content;
	 $contenu = apply_filters('the_content', $contenu);
	 $contenu = str_replace(']]>', ']]&gt;', $contenu);
	 
	 echo $contenu;
}
					?>
			</div>		
		
		<div class="site-bottom">
			<div class="site-info">
				<div class="site-copyright">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?> </a> &copy; <?php echo date( 'Y' ); ?> &ndash; <a href="<?php echo esc_url( home_url( '/mentions-legales' ) ); ?>">Mentions légales</a> &ndash; <a href="<?php echo esc_url( home_url( '/plan-du-site' ) ); ?>">Plan du site</a>
				</div><!-- .site-copyright -->
			</div><!-- .site-info -->

		</div><!-- .site-bottom -->

	</footer><!-- #colophon -->


<?php wp_footer(); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-88133268-1', 'auto');
  ga('send', 'pageview');

</script>


</body>
</html>
