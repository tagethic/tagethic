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
		<?php //the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php //twentyseventeen_edit_link( get_the_ID() ); ?>
	</header><!-- .entry-header -->
	<div class="entry-content"> 
		<?php
			/*
			 * DC 24 avril 2017 - extraction du contenu JSON d'un Post de type "grilleaccueil"
			 */
			$args = array(
				'post_type' => 'grilleaccueil',
				'name' => "grid-accueil",
				'post_status' => 'publish'
			);
			$PostsG = new WP_Query($args);

			$PostsG->the_post();
			$data = get_the_content();

			$data = str_replace(
				array("&laquo;&nbsp;", "&nbsp;&raquo;","<p>","</p>","<br />"),
				array('"', '"',"","",""),
				$data
				);
			$json = json_decode($data, true);
			// echo 'Dernière erreur : ', $json_errors[json_last_error()], PHP_EOL, PHP_EOL;
			
			// Extraction du Nombre de Tuiles
			if($json["nombre"] AND is_numeric($json["nombre"])) {$nombre =  $json["nombre"];}	else { $nombre=0;}
			
			// Extraction du nom du lieu (exemple : Blanzac Porcheresse (16)
			if($json["lieu"] AND $json["lieu"]!=="") {$lieu =  $json["lieu"];}	else { $lieu="";}
			
			// Extraction de la liste ordonnées des Categories
			if($json["categories"] AND is_array($json["categories"])) {
				$catg = $json["categories"];
				
				// Lien pour modifier le JSON
				twentyseventeen_edit_link( get_the_ID() );
				
				// Calcul de l'affichage de la GRille
				getPostsAsAGrid("grid-accueil", $catg, $nombre, $lieu);
				
			}

		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

<?php

/*
 * @mainCatg : categorie racine "grid-accueil"
 * @catArray : liste ordonnée de categories issues du json 
 *   - si une valeur est vide, cela correspond à un affichage par défaut du post en question
 * @nombre : permet d'indiquer le nombre de tuile à utiliser par rapport à la liste (définir les bornes/limites)
 *
*/
function getPostsAsAGrid($mainCatg, $catArray, $nombre, $lieu) {
	// Construction de la requête sur les Posts du type "grilleaccueil"
	// $PostsP = new WP_Query();
	
	$args = array(
		'post_type' => 'grilleaccueil',  
		'post_status' => 'publish'
	);
	$PostsP = new WP_Query($args);
			
	// Liste des Posts 
	// Array avec index unique
	$Tuile = Array();  

	if($PostsP->have_posts())  {
	while ($PostsP->have_posts()) : 
		$PostsP->the_post();
		
		/* DC 28 avril 2017 : on exclut les title commençant par un tiret */
		$p = get_the_title();
		if($p[0]!=="-") {
	
			// Retrouver la première catégorie (concernant le post type : bloc)
			$termes = get_the_terms( get_the_ID(), 'bloc' );
			if ( ! empty( $termes ) ) {
				$catgSec =  esc_html( $termes[0]->name );   
			}
	
			// Calcul du bon index "k"
			$k = array_search($catgSec, $catArray);
			if ( $k === false ) {  // === important pour analyser le resultat de search_array()
				// on recherche alors la première place vide pour y loger un article par [défaut]				
				// Si un bloc est trouvé mais n'est pas dans Définition, alors on passe au suivant
			} else {
			
				$large_image_url = "";
				// test image à la une
				if ( has_post_thumbnail() ) {
					$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
				}
				
				// Le tableau $Tuile[] sert à ordonner les résultats à afficher
				if ( empty( $Tuile[ $k ] ) ) {
					$Tuile[ $k ] = [ "id" => get_the_ID(), 
						"titre" => get_the_title(), 
						"contenu" => get_the_content_with_formatting(),  // get_the_content(), 
						"slug" => $catgSec,
						"extrait" => get_the_excerpt(),
						"lien" => get_the_permalink(),
						"image" => ( ! empty( $large_image_url[0] ) ? esc_url( $large_image_url[0] ) : "" )
						] ;
				}
				
			}
		}
		
	endwhile;
	}

	if(count($Tuile)>1) {
		
		// Test du nombre d'éléments manquant afin de compléter avec des Posts courants
		$pcourants = array();
		for($x=0; $x<$nombre; $x++) {
			if( ! array_key_exists($x, $Tuile) ) array_push($pcourants, $x);
		}
		if(count($pcourants )>0) {
			$a = array(
				'post_type' => 'post',  
				'post_status' => 'publish',
				'posts_per_page' => count($pcourants),
				'category__not_in' => array(-31, -38)   // On exclut Archive
			);
			$post = new WP_Query($a);
			if($post->have_posts())  {
			while ($post->have_posts()) {
				$post->the_post();
				$k = $pcourants[0];
				array_shift($pcourants);
				
				// test image à la une
				$large_image_url = "";
				if ( has_post_thumbnail() ) {
					$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
				}
				// Recherche de la première catégorie (post standard)
				$catgSec = "";
				$catgTri = "";
				$termes = get_the_category( $post->ID() );
				if ( ! empty( $termes ) ) {
					$catgSec =  esc_html( $termes[0]->name );   
					$catgTri =  esc_html( $termes[1]->name );  
				}
				if ( empty( $Tuile[ $k ] ) ) {
					$Tuile[ $k ] = [ "id" => $post->ID, 
						"titre" => get_the_title(), 
						"contenu" => get_the_content_with_formatting(),  // get_the_content(), 
						"slug" => $catgSec,
						"slug3" => $catgTri,
						"extrait" => get_the_excerpt(),
						"lien" => get_the_permalink(),
						"image" => ( ! empty( $large_image_url[0] ) ? esc_url( $large_image_url[0] ) : "" )
						] ;
					}
				}
			}
		}
		ksort($Tuile);  // suivant la clé (venant elle-même du json initial)	
		
		// Affichage des résultats dans l'ordre $Tuile
		echo "<div class=\"grid-accueil-box\">";
		$i = 0;
		foreach($Tuile as  $v) {
			if ($i < $nombre) {
				$i+=1;
				switch ($v["slug"]) {
					case "bloc-dgac" : echo  "<div class=\"".$mainCatg." ".$v["slug"] . "\"><div>". $v["contenu"] ."</div></div>\n";
					break;
					
					case "bloc-meteo" : echo  "<div class=\"".$mainCatg." ".$v["slug"] . "\"><div>". afficheMeteo($lieu)."</div></div>\n";
					break;
					
					case "affiche" :
					case "Affiche" : echo  "<div class=\"".$mainCatg." ".$v["slug"] . "\"><div "
					. ($v["image"]!=="" ? "style=\"background:url(".$v["image"].")\"":"")
					. "><div class=\"filtre\">"
					. ($v["slug3"]!=="" && $v["slug3"]!=="non-classe" ? "<div><span>".$v["slug3"]."</span></div>" : "")
					. "<h3>".$v["titre"]."</h3>". $v["extrait"] ." <br><a href=\"".$v["lien"]."\">Lire la suite</a></div></div></div>\n";
					break;
					
					case "bloc-decouverte" :
					case "bloc-formule" :
					case "bloc-service" :
					case "bloc-qui-sommes-nous" : echo  "<div class=\"".$mainCatg." ".$v["slug"] . "\"><div "
					. ($v["image"]!=="" ? "style=\"background:url(".$v["image"].")\"":"")
					."><p>". $v["contenu"] ."</p></div></div>\n";
					break;
					
					case "bloc-terrains" :  echo  "<div class=\"".$mainCatg." ".$v["slug"] . "\"><div>"
					. ($v["image"]!=="" ? "<img src=\"".$v["image"]."\">":"")
					."<div class=\"gtext\">". $v["contenu"] ."</div></div></div>\n";
					break;
					
					case "bloc-paiements" :  echo  "<div class=\"".$mainCatg." ".$v["slug"] . "\"><div>"
					."<div class=\"gtext\">". $v["contenu"] ."</div></div></div>\n";
					break;
					
					// On utilise ici : titre, image à la une, Extrait, [autre Catégorie] et lien vers Post
					// On n'utilise pas Extrait pour les cas précédents
					default : echo  "<div class=\"".$mainCatg." defaut\"><div>"
					// . ($v["image"]!=="" ? "<img src=\"".$v["image"]."\" >":"")
					. ($v["image"]!=="" ? "<div class=\"thumb\" style=\"background:url(".$v["image"].")\"></div>":"")
					. "<div class=\"gtext\">"
					. ($v["slug"]!=="" && $v["slug"]!=="non-classe" ? "<div><span>".$v["slug"]."</span></div>" : "")
					. "<h3>".$v["titre"]."</h3>". $v["extrait"] ." <br><a href=\"".$v["lien"]."\">Lire la suite</a></div></div></div>\n";
					break;
				}
			}
		}
		echo "</div>";
	
	}
}

/* En test - ! */ 
function recupereEmbedAHref( $s ) {
	$z = preg_match_all("/<a href=\"([^\"]*)/", $s, $matches, PREG_SET_ORDER);		
	//
	if ($z) {
		foreach ($matches as $val) {
			$href = $val[1];  
			return $href;
		}
	}
}


function afficheMeteo($lieu) {
	
// traitement fichier json pour prévisions météo
// source : http://www.prevision-meteo.ch/services

$jsonFile = "http://www.prevision-meteo.ch/services/json/".str_replace(array(" ","(",")"), array("-","",""),$lieu);
$json = file_get_contents( $jsonFile );
$json = json_decode($json);

	$modl = "<div  class='mto-fcst' title='{title}'><img src='{icon}'><span class='jour'>{jour}</span><span class='tmin'>{tmin}°</span><span class='tmax'>{tmax}°</span></div>\n";
	$m0 = array("janvier", "février", "mars", "avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre");
	$d = $json->current_condition->date;
	$m1 = explode('.', $d );
	$m2 = $m1[1];
	$mois = $m0[ (ltrim($m2, 0) -1) ];
	$mois = $mois;
	
	return ""
	. str_replace(array("{jour}", "{icon}","{tmin}","{tmax}","{title}"), array($json->fcst_day_0->day_long." ".substr($json->current_condition->date, 0, strpos($json->current_condition->date,'.')). " ".$mois, $json->fcst_day_0->icon_big, "", $json->current_condition->tmp, $json->fcst_day_0->day_short), $modl)

	. str_replace(array("{jour}", "{icon}","{tmin}","{tmax}","{title}"), array($json->fcst_day_1->day_long, $json->fcst_day_1->icon, $json->fcst_day_1->tmin, $json->fcst_day_1->tmax, $json->fcst_day_1->day_short), $modl) 

	. str_replace(array("{jour}", "{icon}","{tmin}","{tmax}","{title}"), array($json->fcst_day_2->day_long, $json->fcst_day_2->icon, $json->fcst_day_2->tmin, $json->fcst_day_2->tmax, $json->fcst_day_2->day_short), $modl)
	. "\n"
	
	// Location
	. "<div class='lieu'>".twentyseventeen_get_svg( array("icon"=>"location") )." ". $lieu."</div>"
	;
	
	

}
