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
			// the_content();
			// DC 18 mars 2017
			$content = get_the_content_with_formatting();

			// Détection et Affichage de la Grille de Sélection des Actitivités Oeno sur page Réservation
			if (! (strpos($content, "{selection}") === false ) ) {
				// Traitement des Activités
				// basé sur template FicheOeno et contentOeono 
				$out = getGrilleSelection();
				$content = str_replace("{selection}", $out, $content);
			}
			echo $content;

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

<?php

function getGrilleSelection() {
	// $json = "";   // important : au format utf8 
	/*
	 * DC 7 mai 2017 - extraction du contenu JSON d'un Post de type "chateau"
	 */
	 
	$args = array(
		'post_type' => 'chateau',
		'post_status' => 'publish',
		'orderby' => 'ID',
		'order' => 'desc',
		'posts_per_page ' => 1,
		'tax_query' => array(
		array (
			'taxonomy' => 'bloc',
			'field' => 'slug',
			'terms' => 'oenotourisme',
			)
		),
	);
	$PostsG = new WP_Query($args);
	
	if($PostsG->have_posts())  {

		$PostsG->the_post();
		$data = get_the_content();

		$data = str_replace(
			array("&laquo;&nbsp;", "&nbsp;&raquo;","<p>","</p>","<br />"),
			array('"', '"',"","",""),
			$data
			);
		$json = json_decode($data, true);
	
		// echo 'Dernière erreur : ', $json_errors[json_last_error()], PHP_EOL, PHP_EOL;
		$modlH3 = "<h3>{tit}</h3>";
		$modlH3b = "<p class=\"h3b\">{tit}</p>";

		// Affichage de la GRille de sélection des Actitivités Oeno ..
		// @params : nb_person, date_souhaitée, EN|FR
		//
		// Prévoir une requête SQL à terme basée sur un champ personnalisé.
		//
		$out = "<div class='oeno-selection'>";
		$c = 0;
		foreach($json as $cle => $val)  {
			if ($cle !== "_info_") {
				$out .= "<div>";
				$out .= str_replace("{tit}",$val[0], $modlH3);
				$out .= str_replace("{tit}",$val[1], $modlH3b);
				//
				$out .= "Nombre de personnes : <input type='text' name='qte' data-c='".$c."' data-oeno='".$val[0]."'> "
					. "<br>Date souhaitée : <input type='text' name='date' data-c='".$c."'>" 
					. "<br>Langue : <input type='radio' name='langue".$c."'  data-c='".$c."' checked value='FR' id='lfr".$c."'><label for='lfr".$c."'> Français</label><input type='radio' name='langue".$c."'  data-c='".$c."' value='EN' id='len".$c."'><label for='len".$c."'> English</label> "
					. "</div>";
				$c++;
			}
		}
	return $out ."</div>\n";
	} // have_posts
}
