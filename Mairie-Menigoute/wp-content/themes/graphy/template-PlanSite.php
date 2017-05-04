<?php
/*
Template Name: Sitemap
*/
?>

<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<article class="page type-page status-publish hentry">
			<header class="entry-header">
				<h1 class="entry-title"><?php echo $wp_query->post->post_title; ?></h1>
			</header>
		<div id="content" class="entry-content">
			<div class="planPages">
				<h2><?php _e('Pages', 'textdomain'); ?></h2>
				<ul><?php wp_list_pages(array(
					'title_li' => '',
					'exclude' => 2   // DC : inhibition de la page de test
					)); ?></ul>
			 </div>
			 <div class="planPosts">
				<!--
				<h2><?php //_e('Catégories', 'textdomain'); ?></h2>
				<ul><?php  
				/* wp_list_categories( array(
					'title_li'    => '',
					'orderby'    => 'name',
					'show_count' => true,
					'exclude'    => array( 1, 17 )
					) );
					*/
				?></ul>
				-->

				<h2><?php _e('Articles', 'textdomain'); ?></h2>
				<ul><?php $archive_query = new WP_Query('showposts=1000'); while ($archive_query->have_posts()) : $archive_query->the_post(); 
				/* DC 3 dec 2016 : on exclut les title commençant par un tiret */
				$p = get_the_title();
				if($p[0]!=="-") {
				?>
				<li>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a> <?php $categories = get_the_category();
				if ( ! empty( $categories ) ) {
					echo "<span class='tag-catg'>".esc_html( $categories[0]->name )."</span>";   
				} ?>
				</li>
				<?php } endwhile; ?>
				</ul>
			</div>
		</div>
		</article>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>