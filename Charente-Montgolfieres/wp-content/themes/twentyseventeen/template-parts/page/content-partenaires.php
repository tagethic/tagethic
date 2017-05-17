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
			 
			 $z = preg_match_all("/\{partenaire:([^\}]*)}/", $content, $matches, PREG_SET_ORDER);
			if ($z) {
				foreach ($matches as $val) {
					$chaine = $val[0];  
					$type = $val[1];  
					$out = recuperePartenaires( $type );
					$content = str_replace($chaine, $out, $content);
				}
			}
			 
			 // if (! (strpos($content, "{partenaire:non-classe}") === false ) ) {
				 
				// $out = recuperePartenaires("non-classe");
				// $content = str_replace("{partenaire:non-classe}", $out, $content);
			 // }
			 
			echo $content;
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->


<?php
function recuperePartenaires( $p ) {
	
	$modl = "<div class='partenaire'>\n{img}\n<h4>{titre}</h4>\n<p>{desc}</p>\n</div>\n"; 
			 
	$args = array(
		'post_type' => 'partenaires',
		'post_status' => 'publish',
		'orderby' => 'post_name',
		'order' => 'asc',
		'tax_query' => array(
		array (
			'taxonomy' => 'partenaire',
			'field' => 'slug',
			'terms' => $p,
			)
		),
	);
	$PostsG = new WP_Query($args);
		
	// Calcul de l'affichage de la série
	$out = "";
	if($PostsG->have_posts())  {
		while ($PostsG->have_posts()) {
			$PostsG->the_post();
			$t = get_the_title();
	
			// 
			$contenu = get_the_content_with_formatting();
			
			// Thumbnail
			$image = "";
			// test image à la une
			if ( has_post_thumbnail() ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
			}
			$thumb = ( ! empty( $image[0] ) ? "<img src=\"". esc_url( $image[0] ) . "\">" : "" );
			
			$out .= str_replace( array("{img}", "{titre}", "{desc}"),
				array( $thumb, $t, $contenu ),
				$modl );

		}
	}
	return $out;
}
?>