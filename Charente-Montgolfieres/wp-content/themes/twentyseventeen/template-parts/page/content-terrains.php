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
			$content =  get_the_content_with_formatting();
			/*
			 * DC 11 mai 2017 - affichage des post type : partenaires
			 */
			 
			$content .= afficheCarteTerrains();
			 
			echo $content;
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->


<?php
function afficheCarteTerrains(  ) {
				 
	$args = array(
		'post_type' => 'terrains',
		'post_status' => 'publish',
		'orderby' => 'post_name',
		'order' => 'asc',
		'posts_per_page'=>-1
		// 'tax_query' => array(
		// array (
			// 'taxonomy' => 'homologation',
			// 'field' => 'slug',
			// 'terms' => 'homologue'
			// )
		// ),
	);
	$PostsG = new WP_Query($args);
		
	// Calcul de l'affichage de la série
	$out = "";
	$outArray = "<script>var markers=[];\n";
	$cptr = 0;
	if($PostsG->have_posts())  {
		while ($PostsG->have_posts()) {
			$PostsG->the_post();
			$t = get_the_title();
			// coords gps
			$gps = get_the_excerpt();
			// 
			$contenu = get_the_content_with_formatting();
			//
			// Retrouver la première catégorie (concernant le post type : homologation)
			$catg = false;
			$termes = get_the_terms( get_the_ID(), 'homologation' );
			if ( ! empty( $termes ) ) {
				$catg =  esc_html( $termes[0]->slug );   // name
			}
			// Exclusion des terrains non-classés
			if($catg !== "non-classe") {
				// test image à la une
				$image = "";
				if ( has_post_thumbnail() ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );  // thumbnail
				}
				$thumb = ( ! empty( $image[0] ) ? "<img src=\"". esc_url( $image[0] ) . "\">" : "" );
				
				// Tableau des markers 
				$outArray .= "markers[".$cptr."]=[];\n" ;
				$outArray .= "markers[".$cptr."][0] = { lat: ". str_replace(",",", lng: ", $gps) . "};\n" ;
				$outArray .= "markers[".$cptr."][1] = \"".$t."\";\n" ;
				$outArray .= "markers[".$cptr."][2] = \"".($catg?$catg:"")."\";\n" ;
				$outArray .= "markers[".$cptr."][3] = \"". str_replace( array('"', "\n"), array("'", ""), $contenu) ."\";\n" ;
				$outArray .= "markers[".$cptr."][4] = \"". str_replace( array('"', "\n"), array("'", ""), $thumb) ."\";\n" ;
				
				$cptr++;
			}

		}
	}
	$outArray .= "</script>\n";
	return  $outArray. $out;
}
?>