<?php
/*

Template Name: Carte-Terrains

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

				// get_template_part( 'template-parts/page/content', 'page' );
				get_template_part( 'template-parts/page/content', 'terrains' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					// comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		<div class="carte">
			<div id="map"></div>
			<div id="capture"></div>
		</div>
			<script>
					
				  var map;
			  
					function initMap() {
						
						// var blanzac = { lat: 45.477259, lng: 0.033254 };
						var centre = { lat: 45.50, lng: 0.24 }; 
						map = new google.maps.Map(document.getElementById('map'), {
							  zoom: 8,
							  mapTypeId: 'terrain',
							  center: centre
							});
						
						if(markers.length > 0) {
							for(i=0; i<markers.length; i++) {
								var path = "<?php echo get_template_directory_uri() . '/_cd53/'; ?>";
								var icone = (markers[i][2] == "homologue"?"verte-w32.png":"orange-w32.png");
								// var icone = (markers[i][2] == "homologue"?"verte-w32.png":"cmtg-vert-m.svg");
								var marker = new google.maps.Marker({
								  position: markers[i][0],
								  map: map,
								  title: markers[i][1],
								  // title: markers[i][1] + "\nCliquez pour plus d'infos...",
								  icon: path + icone,
								  // size: new google.maps.Size(31, 42),
								  // scaledSize: new google.maps.Size(5, 10),
								  // scaledSize: [5, 10],
								  // scale: 0.3,
								  optimized: false
								});
								var infowindow = new google.maps.InfoWindow({
									content: "--"
								});
								//
								google.maps.event.addListener(marker, 'click', function() {
									infowindow.setContent( this.title );
									infowindow.open(map, this);  
									afficheDetails(this.title);
								});
							}
						}
					}  // fin initMap
							
					function afficheDetails( t ) {
						var c = document.getElementById('capture'),
							title = t,
							o = "";
						if(markers.length > 0) {
							for(i=0; i<markers.length; i++) {
								if ( markers[i][1] == title ) {
									o += markers[i][4]
									   + "<h3>"+title+"</h3>"
									   + markers[i][3];
								}
							}
						}								
						c.innerHTML =  o;
						c.style.right = "0px";
						c.onclick = function () {
							c.style.right = "-300px";
						}
					}

			</script>
			<script async defer
				src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUbmmVHKF65cEim8JaoHgLcKjVspQbtRQ&callback=initMap">
			</script>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php 
get_footer();
// if ( is_home() ) {get_footer();}
