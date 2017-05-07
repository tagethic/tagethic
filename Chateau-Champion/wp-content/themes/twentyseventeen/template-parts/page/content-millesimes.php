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
			
			// Détection et Affichage des Millésimes sur page Produit
			if (! (strpos($content, "{millesimes}") === false ) ) {
				// Traitement des Millésimes
				// basé sur template FicheVin et contentMillesimes 
				// Champ personnalisé : "vin"
				if ( $vin = get_post_meta( get_the_ID(), 'vin' ) ) {
						$out = getRecompenses( $vin[0] );
						$content = str_replace("{millesimes}", $out, $content);
					}
			}
			// Détection et Affichage de la Grille de Sélection des Millésimes sur page Commande
			if (! (strpos($content, "{selection}") === false ) ) {
				// Traitement des Millésimes
				// basé sur template FicheVin et contentMillesimes 
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
function getRecompenses($v) {
	// $url="http://chateau-champion.com/_wp/wp-content/themes/twentyseventeen/_cd53/liste-des-millesimes.js";
	// $url= esc_url(get_home_url()). "/wp-content/themes/twentyseventeen/_cd53/liste-des-millesimes.js";
	// $contents = file_get_contents($url); 
	// $json = json_decode($contents, true);   // important : au format utf8 
	
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
			'terms' => 'productions',
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
		$modl1 = "<div><p><u>{an}</u></p>\n<ul>\n";
		$modl2 = "<li class=\"{metal}\">{rec}</li>\n";
		$modl2x = "<li class=\"x\">{rec}</li>\n";
		$modl3 = "</ul></div>\n";
		$btnCmde = '<div><a href="'.esc_url(get_home_url()).'/nos-productions/passer-commande/"><button>Passer commande</button></a></div>';

		// Affichage des Récompenses ..
		$mill = $v; // "haute-terrasse", "grand-faurie", "champion", "excellence"

		if($json[$mill]) {
			$j = $json[$mill];
			$out = "<div class='chateau'><div class='millesimes'>";
			
			if($j["annee"]) {
				foreach($j["annee"] as $c => $v) {
					$out .= str_replace("{an}",$c, $modl1);
					if($v["recompenses"]) {
						foreach($v["recompenses"] as $c2 => $v2) {
							$out .= str_replace( array("{rec}","{metal}"), array($v2[1], $v2[0] ), $modl2);
						}
					}
					if($v["bouteille-ok"]) {
						if($v["bouteille-ok"] == "non") { $out .= str_replace("{rec}", "Bouteilles indisponibles.", $modl2x); }
						else if($v["bouteille-ok"] !== "" and $v["bouteille-ok"] !== "oui") { $out .= str_replace("{rec}",$v["bouteille-ok"], $modl2x); }
					} 
					if($v["magnum-ok"] AND $v["magnum-ok"] == "non") { $out .= str_replace("{rec}", "Magnum indisponible.", $modl2x); }
					$out .= $modl3;
				}
			}
			return $out.$btnCmde ."</div>\n". "</div>\n";
		}
	}  // have_posts
}

function getGrilleSelection() {
	// $url= esc_url(get_home_url()). "/wp-content/themes/twentyseventeen/_cd53/liste-des-millesimes.js";
	// $contents = file_get_contents($url); 
	// $json = json_decode($contents, true);   // important : au format utf8 
	
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
			'terms' => 'productions',
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
		$modlH3b = "<p class='h3b'>{tit}</p>";
		$modl2 = "<li class=\"{metal}\">{rec}</li>\n";
		$modl2x = "<li class=\"x\">{rec}</li>\n";

		// Affichage de la GRille de sélection des Récompenses ..
		$out = "<div class='chateau'><div class='millesimes selection'>";
		foreach($json as $cle => $val)  {
			if ($cle !== "_info_") {
				$out .= str_replace("{tit}",$val["nom"], $modlH3);
				$out .= str_replace("{tit}",$val["desc"], $modlH3b);
				//
				if($val["annee"]) {
					foreach($val["annee"] as $cAn => $vAn) {
						
						// Affichage : année   input  bouteille
						if ( $vAn["bouteille-ok"] && $vAn["bouteille-ok"]!=="non" && $vAn["bouteille-ok"]!=="") {  
						$out .= "<div>";
						
						
						$out .= " <div class='qte'>";
						if( $vAn["bouteille-ok"] && $vAn["bouteille-ok"]!=="" && $vAn["bouteille-ok"]!=="non" ) {
							$unit = "bouteille";
							$out .= "<div><label>". $cAn ."</label> <input type='number' min='0' data-aoc=\"". $cAn ." - ".$val["nom"] ."\" data-unit=\"".$unit."\""
							. ($vAn["bouteille-ok"]=="non"?" disabled":"") ."> ".$unit
							. ($vAn["bouteille-ok"]=="non"?" <span class='rouge'>indisponible</span>":"") 
							. ( in_array($vAn["bouteille-ok"], array("non","","oui")) ? "": " <span class='rouge'><br>". $vAn["bouteille-ok"]."</span>" )
							. "</div>";
						}
						// Affichage : année   input  magnum
						if( $vAn["magnum-ok"] && $vAn["magnum-ok"]!=="" ) {
							$unit = "magnum";
							$out .= "<div><label>". $cAn ."</label> <input type='number' min='0' data-aoc=\"". $cAn ." - ".$val["nom"] ."\" data-unit=\"".$unit."\""
							. ($vAn["magnum-ok"]=="oui"?"":" disabled") ."> ".$unit
							. ($vAn["magnum-ok"]=="oui"?"":" <span class='rouge'>indisponible</span>") ."</div>";
						}
						$out .= "</div>";
						
						$isRec=false;
						if($vAn["recompenses"] && $vAn["bouteille-ok"]!=="non" && $vAn["bouteille-ok"]!=="") {
							foreach($vAn["recompenses"] as $cRec => $vRec) {
								if($vRec[1] !=="") {
									// On affiche des Récompenses
									$out .= ($isRec?"":" <div class='rec'>");
									$isRec=true;
									$out .= str_replace( array("{rec}","{metal}"), array($vRec[1], $vRec[0]), $modl2);
								}
							}
						}
						$out .= ($isRec?"</div>":"");
						
						$out .= "</div>";
						}
						
						
						$out .= $modl3;
					}
				}
				
			}
			
		}
	} // have_posts
	return $out ."</div>\n". "</div>\n";
}
