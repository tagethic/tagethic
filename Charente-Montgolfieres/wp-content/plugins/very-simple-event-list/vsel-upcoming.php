<?php

// disable direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// The shortcode
function vsel_shortcode( $vsel_atts ) {
	$vsel_atts = shortcode_atts( array( 
		'event_cat' => '', // include certain event categories
		'posts_per_page' => '', // set events per page
		'order' => 'asc', // order events
		'date_label' => __('Date: %s', 'very-simple-event-list'), // date label
		'start_label' => __('Start date: %s', 'very-simple-event-list'), // start date label
		'end_label' => __('End date: %s', 'very-simple-event-list'), // end date label
		'time_label' => __('Time: %s', 'very-simple-event-list'), // time label
		'location_label' => __('Location: %s', 'very-simple-event-list') // location label
	), $vsel_atts );

	$output = ""; 
	$output .= '<div id="vsel">'; 
	$titleEvents = false;

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; 
		$today = strtotime( 'today' );

		$vsel_meta_query = array( 
			'relation' => 'AND',
			array( 
				'key' => 'event-date', 
				'value' => $today, 
				'compare' => '>=', 
				'type' => 'NUMERIC'
			) 
		); 

		$vsel_query_args = array( 
			'post_type' => 'event', 
			'event_cat' => $vsel_atts['event_cat'],
			'post_status' => 'publish', 
			'ignore_sticky_posts' => true, 
			'meta_key' => 'event-date', 
			'orderby' => 'meta_value_num', 
			'order' => $vsel_atts['order'],
			'posts_per_page' => $vsel_atts['posts_per_page'],
 			'paged' => $paged, 
			'meta_query' => $vsel_meta_query
		); 

		$vsel_events = new WP_Query( $vsel_query_args );

		if ( $vsel_events->have_posts() ) : 
			while( $vsel_events->have_posts() ): $vsel_events->the_post(); 
			
			// DC 24 mai 2017
			if ( ! $titleEvents  ) {
				$output .= "<h3>Événements en cours et à venir</h3>";
				$titleEvents = true;
			}
	
			// get event meta
			$event_start_date = get_post_meta( get_the_ID(), 'event-start-date', true );
			$event_date = get_post_meta( get_the_ID(), 'event-date', true );
			$event_time = get_post_meta( get_the_ID(), 'event-time', true ); 
			$event_location = get_post_meta( get_the_ID(), 'event-location', true ); 
			$event_link = get_post_meta( get_the_ID(), 'event-link', true ); 
			$event_link_label = get_post_meta( get_the_ID(), 'event-link-label', true ); 
			$event_link_target = get_post_meta( get_the_ID(), 'event-link-target', true ); 
			$event_summary = get_post_meta( get_the_ID(), 'event-summary', true ); 

			// get setting to show excerpt
			$event_excerpt = esc_attr(get_option('vsel-setting-1'));

			// get setting to link title to single event
			$event_link_title = esc_attr(get_option('vsel-setting-9'));

			// get setting to hide date
			$event_date_hide = esc_attr(get_option('vsel-setting-8'));

			// get settings to hide elements in widget
			$widget_date = esc_attr(get_option('vsel-setting-2'));
			$widget_time = esc_attr(get_option('vsel-setting-3'));
			$widget_location = esc_attr(get_option('vsel-setting-4'));
			$widget_image = esc_attr(get_option('vsel-setting-5'));
			$widget_link = esc_attr(get_option('vsel-setting-6'));
			$widget_info = esc_attr(get_option('vsel-setting-7'));

			// link label
			if (empty($event_link_label)) {
				$event_link_label = esc_attr__( 'More info', 'very-simple-event-list' );
			}
 
			// link target
			if ($event_link_target == 'yes') {
				$link_target = ' target="_blank"';
			} else {
				$link_target = ' target="_self"';
			}

			// display the event list
			$output .= '<div class="vsel-content">'; 
				$output .= '<div class="vsel-meta">';
					/* if ($event_link_title != 'yes') {
						$output .= '<h4 class="vsel-meta-title">' . get_the_title() . '</h4>';
					} else {
						$output .=  '<h4 class="vsel-meta-title"><a href="'. get_permalink() .'" rel="bookmark" title="'. get_the_title() .'">'. get_the_title() .'</a></h4>';
					} */
					// error in case of wrong date
					if (!empty($event_start_date)) {
						if ($event_start_date > $event_date) {
							$output .= '<p class="vsel-meta-date">';
							$output .= esc_attr__( 'Error: please reset date', 'very-simple-event-list' ); 
							$output .= '</p>';
						}
					}
					if ($event_date_hide != 'yes') {
						
						$o = "<p class=\"vsel-meta-date\"></p><div class='cal'>";
						$mois = "";
						$jours = "";
						
						if (!empty($event_start_date)) {
							if ($event_date > $event_start_date) {
								/* if ($widget_date == 'yes') {
									$output .= '<p class="vsel-meta-date vsel-hide">';
								} else {
									$output .= '<p class="vsel-meta-date">';
								}
								$output .= sprintf(esc_attr($vsel_atts['start_label']), date_i18n( get_option( 'date_format' ), esc_attr($event_start_date) ) ); 
								$output .= '</p>'; */
								list($j, $m, $a) = explode(" ", sprintf("%s",date_i18n( get_option( 'date_format' ), esc_attr($event_start_date) ) ) );
								$mois = "<div class='mois'>".$m."</div>";
								$jours = $j;
							}
						} 
						if (!empty($event_start_date)) {
							if ($event_date > $event_start_date) {
								/* if ($widget_date == 'yes') {
									$output .= '<p class="vsel-meta-date vsel-hide">';
								} else {
									$output .= '<p class="vsel-meta-date">';
								}
								$output .= sprintf(esc_attr($vsel_atts['end_label']), date_i18n( get_option( 'date_format' ), esc_attr($event_date) ) ); 
								$output .= '</p>'; */
								list($j, $m, $a) = explode(" ", sprintf("%s",date_i18n( get_option( 'date_format' ), esc_attr($event_date) ) ) );
								$jours .= " &ndash; ".$j;
							}
						} 
						if (!empty($event_start_date)) {
							if ($event_date == $event_start_date) {
								/* if ($widget_date == 'yes') {
									$output .= '<p class="vsel-meta-date vsel-hide">';
								} else {
									$output .= '<p class="vsel-meta-date">';
								}
								$output .= sprintf(esc_attr($vsel_atts['date_label']), date_i18n( get_option( 'date_format' ), esc_attr($event_date) ) ); 
								$output .= '</p>'; */
								list($j, $m, $a) = explode(" ", sprintf("%s",date_i18n( get_option( 'date_format' ), esc_attr($event_date) ) ) );
								$mois = "<div class='mois'>".$m."</div>";
								$jours = $j;
							}
						} 
						// support old plugin versions
						if (empty($event_start_date)) {
							if ($widget_date == 'yes') {
								$output .= '<p class="vsel-meta-date vsel-hide">';
							} else {
								$output .= '<p class="vsel-meta-date">';
							}
							$output .= sprintf(esc_attr($vsel_atts['date_label']), date_i18n( get_option( 'date_format' ), esc_attr($event_date) ) ); 
							$output .= '</p>';
						}
					}
					
					// DC 24 mai 2017
					$o .= $mois . "<div class='jours'>" . $jours . "</div></div>";
					$output .= $o;
					
					if (!empty($event_time)){
						if ($widget_time == 'yes') {
							$output .= '<p class="vsel-meta-time vsel-hide">';
						} else {
							$output .= '<p class="vsel-meta-time">';
						}
						$output .= sprintf(esc_attr($vsel_atts['time_label']), esc_attr($event_time) ); 
						$output .= '</p>';
					}
					if (!empty($event_location)){
						if ($widget_location == 'yes') {
							$output .= '<p class="vsel-meta-location vsel-hide">';
						} else {
							$output .= '<p class="vsel-meta-location">';
						}
						// $output .= sprintf(esc_attr($vsel_atts['location_label']), esc_attr($event_location) ); 
						// DC 23 mai 2017 
						$output .= twentyseventeen_get_svg( array( 'icon' => 'balloon' ) ) .esc_attr($event_location) ; 
						$output .= '</p>';
					}
					if (!empty($event_link)){
						if ($widget_link == 'yes') {
							$output .= '<p class="vsel-meta-link vsel-hide">';
						} else {
							$output .= '<p class="vsel-meta-link">';
						}
						// DC 23 mai 2017 
						$output .= twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ); 
						$output .= sprintf( '<a href="%1$s"'. $link_target .'>%2$s</a>', esc_url($event_link), esc_attr($event_link_label) ); 
						$output .= '</p>';
					}
				$output .= '</div>';

				$output .= '<div class="vsel-image-info">';
					if ( has_post_thumbnail() ) { 
						if ($widget_image == 'yes') {
							$output .= get_the_post_thumbnail( null, 'post-thumbnail', array('class' => 'vsel-image vsel-hide') ); 
						} else {
							$output .= get_the_post_thumbnail( null, 'post-thumbnail', array('class' => 'vsel-image') ); 
						}
					}
					if ($widget_info == 'yes') {
						$output .= '<div class="vsel-info vsel-hide">';
					} else {
						$output .= '<div class="vsel-info">';
					}
					
					// DC 23 mai 2017 - déplacement du H4 dans vsel-info
					if ($event_link_title != 'yes') {
						$output .= '<h4 class="vsel-meta-title">' . get_the_title() . '</h4>';
					} else {
						$output .=  '<h4 class="vsel-meta-title"><a href="'. get_permalink() .'" rel="bookmark" title="'. get_the_title() .'">'. get_the_title() .'</a></h4>';
					}
					
					if ($event_excerpt != 'yes') {
						$output .= $content = apply_filters( 'the_content', get_the_content() ); 
					} else if (!empty($event_summary)) {
						$output .= apply_filters( 'the_excerpt', $event_summary ); 
					}  else {
						$output .= $content = apply_filters( 'the_excerpt', get_the_excerpt() ); 
					}	
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';
	
			endwhile; 
		
			// pagination
			$output .= '<div class="vsel-nav vsel-hide">';
			$output .= get_next_posts_link(  __( 'Next &raquo;', 'very-simple-event-list' ), $vsel_events->max_num_pages ); 
			$output .= get_previous_posts_link( __( '&laquo; Previous', 'very-simple-event-list' ) ); 
			$output .= '</div>';

			wp_reset_postdata(); 

			else:
 
			$output .= '<p>';
			$output .= esc_attr__('Il n\'y a pas d\'événement pour le moment.', 'very-simple-event-list');
			$output .= '</p>';
		endif; 

	$output .= '</div>';

	return $output;
} 
add_shortcode('vsel', 'vsel_shortcode');

?>